<?php

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();
require_once __DIR__ . '/../connection.php';

header('Content-Type: application/json');

function completeBillingResponse(int $statusCode, bool $success, string $message, array $extra = []): void
{
    http_response_code($statusCode);
    if (ob_get_length()) {
        ob_clean();
    }

    echo json_encode(array_merge([
        'success' => $success,
        'message' => $message
    ], $extra));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    completeBillingResponse(405, false, 'Invalid request method.');
}

$rawBody = file_get_contents('php://input');
$payload = json_decode((string) $rawBody, true);

$customerIds = [];
if (is_array($payload) && isset($payload['customerIds']) && is_array($payload['customerIds'])) {
    $customerIds = array_map('intval', $payload['customerIds']);
}

$discountAmount = is_array($payload) ? (float) ($payload['discountAmount'] ?? 0) : 0;
$taxPercent = is_array($payload) ? (float) ($payload['taxPercent'] ?? 0) : 0;
$serviceCharge = is_array($payload) ? (float) ($payload['serviceCharge'] ?? 0) : 0;
$paymentMethod = is_array($payload) ? trim((string) ($payload['paymentMethod'] ?? 'cash')) : 'cash';
$note = is_array($payload) ? trim((string) ($payload['note'] ?? '')) : '';

if ($discountAmount < 0) {
    $discountAmount = 0;
}
if ($taxPercent < 0) {
    $taxPercent = 0;
}
if ($taxPercent > 100) {
    $taxPercent = 100;
}
if ($serviceCharge < 0) {
    $serviceCharge = 0;
}

$allowedMethods = ['cash', 'card', 'bank_transfer', 'cheque'];
if (!in_array($paymentMethod, $allowedMethods, true)) {
    $paymentMethod = 'cash';
}

$customerIds = array_values(array_unique(array_filter($customerIds, function ($id) {
    return (int) $id > 0;
})));

if (count($customerIds) === 0) {
    completeBillingResponse(422, false, 'No customers selected for billing completion.');
}

$sessionPointId = (int) ($_SESSION['point_id'] ?? 0);
$sessionUserId = (int) ($_SESSION['user_id'] ?? 0);

if ($sessionPointId <= 0 && $sessionUserId <= 0) {
    completeBillingResponse(401, false, 'Unauthorized session. Please login again.');
}

Database::setupConnection();
$db = Database::$connection;

if (!$db || $db->connect_error) {
    completeBillingResponse(500, false, 'Database connection failed.');
}

$scopeFilter = '';
if ($sessionPointId > 0) {
    $scopeFilter = " AND vc.`Points_point_id` = '{$sessionPointId}'";
} elseif ($sessionUserId > 0) {
    $scopeFilter = " AND vc.`Points_point_id` IN (SELECT `point_id` FROM `points` WHERE `users_u_id` = '{$sessionUserId}')";
}

$idsSql = implode(',', array_map('intval', $customerIds));
$pendingQuery = "SELECT vc.`vh_cid`, vc.`vc_name`, vc.`v_number`, vc.`vc_contact`, vc.`Points_point_id`, vt.`v_type`, vt.`price` FROM `v_customers` vc LEFT JOIN `vehical_typs` vt ON vc.`vehical_typs_vty_id` = vt.`vty_id` WHERE vc.`vh_cid` IN ({$idsSql}) AND vc.`v_status_cs_id` = '1' {$scopeFilter}";
$pendingRs = $db->query($pendingQuery);

if (!$pendingRs) {
    completeBillingResponse(500, false, 'Failed to load selected pending customers.');
}

$selectedCustomers = [];
while ($row = $pendingRs->fetch_assoc()) {
    $selectedCustomers[] = $row;
}

if (count($selectedCustomers) !== count($customerIds)) {
    completeBillingResponse(409, false, 'Some selected customers are invalid or not pending in your scope.');
}

function ensureBillingMasterColumn(mysqli $db, string $column, string $definition): bool
{
    $check = $db->query("SHOW COLUMNS FROM `billing_master` LIKE '{$column}'");
    if ($check && $check->num_rows > 0) {
        return true;
    }

    return (bool) $db->query("ALTER TABLE `billing_master` ADD COLUMN {$definition}");
}

function ensureBillingItemsColumn(mysqli $db, string $column, string $definition): bool
{
    $check = $db->query("SHOW COLUMNS FROM `billing_items` LIKE '{$column}'");
    if ($check && $check->num_rows > 0) {
        return true;
    }

    return (bool) $db->query("ALTER TABLE `billing_items` ADD COLUMN {$definition}");
}

$createMasterSql = "CREATE TABLE IF NOT EXISTS `billing_master` (
    `bill_id` INT NOT NULL AUTO_INCREMENT,
    `point_id` INT NOT NULL DEFAULT 0,
    `user_id` INT NOT NULL DEFAULT 0,
    `total_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `status` VARCHAR(20) NOT NULL DEFAULT 'completed',
    `completed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`bill_id`),
    KEY `idx_billing_master_point` (`point_id`),
    KEY `idx_billing_master_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

$createItemsSql = "CREATE TABLE IF NOT EXISTS `billing_items` (
    `item_id` INT NOT NULL AUTO_INCREMENT,
    `bill_id` INT NOT NULL,
    `v_customer_id` INT NOT NULL,
    `customer_name` VARCHAR(150) NOT NULL,
    `vehicle_number` VARCHAR(80) NOT NULL,
    `contact` VARCHAR(40) NOT NULL,
    `vehicle_type` VARCHAR(80) NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    PRIMARY KEY (`item_id`),
    KEY `idx_billing_items_bill` (`bill_id`),
    KEY `idx_billing_items_customer` (`v_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!$db->query($createMasterSql) || !$db->query($createItemsSql)) {
    completeBillingResponse(500, false, 'Failed to prepare billing tables.');
}

$migrationsOk = true;
$migrationsOk = $migrationsOk && ensureBillingMasterColumn($db, 'point_id', "`point_id` INT NOT NULL DEFAULT 0 AFTER `bill_id`");
$migrationsOk = $migrationsOk && ensureBillingMasterColumn($db, 'user_id', "`user_id` INT NOT NULL DEFAULT 0 AFTER `point_id`");
$migrationsOk = $migrationsOk && ensureBillingMasterColumn($db, 'total_amount', "`total_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `user_id`");
$migrationsOk = $migrationsOk && ensureBillingMasterColumn($db, 'status', "`status` VARCHAR(20) NOT NULL DEFAULT 'completed' AFTER `total_amount`");
$migrationsOk = $migrationsOk && ensureBillingMasterColumn($db, 'completed_at', "`completed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `status`");
$migrationsOk = $migrationsOk && ensureBillingMasterColumn($db, 'invoice_no', "`invoice_no` VARCHAR(40) NULL AFTER `bill_id`");
$migrationsOk = $migrationsOk && ensureBillingMasterColumn($db, 'sub_total', "`sub_total` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `user_id`");
$migrationsOk = $migrationsOk && ensureBillingMasterColumn($db, 'discount_amount', "`discount_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `sub_total`");
$migrationsOk = $migrationsOk && ensureBillingMasterColumn($db, 'tax_percent', "`tax_percent` DECIMAL(5,2) NOT NULL DEFAULT 0.00 AFTER `discount_amount`");
$migrationsOk = $migrationsOk && ensureBillingMasterColumn($db, 'tax_amount', "`tax_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `tax_percent`");
$migrationsOk = $migrationsOk && ensureBillingMasterColumn($db, 'service_charge', "`service_charge` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `tax_amount`");
$migrationsOk = $migrationsOk && ensureBillingMasterColumn($db, 'payment_method', "`payment_method` VARCHAR(30) NOT NULL DEFAULT 'cash' AFTER `status`");
$migrationsOk = $migrationsOk && ensureBillingMasterColumn($db, 'note', "`note` TEXT NULL AFTER `payment_method`");

$migrationsOk = $migrationsOk && ensureBillingItemsColumn($db, 'bill_id', "`bill_id` INT NOT NULL AFTER `item_id`");
$migrationsOk = $migrationsOk && ensureBillingItemsColumn($db, 'v_customer_id', "`v_customer_id` INT NOT NULL AFTER `bill_id`");
$migrationsOk = $migrationsOk && ensureBillingItemsColumn($db, 'customer_name', "`customer_name` VARCHAR(150) NOT NULL AFTER `v_customer_id`");
$migrationsOk = $migrationsOk && ensureBillingItemsColumn($db, 'vehicle_number', "`vehicle_number` VARCHAR(80) NOT NULL AFTER `customer_name`");
$migrationsOk = $migrationsOk && ensureBillingItemsColumn($db, 'contact', "`contact` VARCHAR(40) NOT NULL AFTER `vehicle_number`");
$migrationsOk = $migrationsOk && ensureBillingItemsColumn($db, 'vehicle_type', "`vehicle_type` VARCHAR(80) NOT NULL AFTER `contact`");
$migrationsOk = $migrationsOk && ensureBillingItemsColumn($db, 'amount', "`amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `vehicle_type`");

if (!$migrationsOk) {
    completeBillingResponse(500, false, 'Failed to update billing master schema.');
}

$pointId = 0;
$userId = 0;
$subTotal = 0.0;
$firstPointId = 0;

foreach ($selectedCustomers as $customer) {
    $pointId = (int) ($customer['Points_point_id'] ?? 0);
    if ($firstPointId === 0) {
        $firstPointId = $pointId;
    }
    if ($firstPointId !== $pointId) {
        completeBillingResponse(409, false, 'Please complete bills with customers from the same point.');
    }

    $amount = (float) ($customer['price'] ?? 0);
    $subTotal += $amount;

    if ($userId === 0 && $pointId > 0) {
        $ownerRs = $db->query("SELECT `users_u_id` FROM `points` WHERE `point_id` = '{$pointId}' LIMIT 1");
        if ($ownerRs && $ownerRs->num_rows > 0) {
            $ownerData = $ownerRs->fetch_assoc();
            $userId = (int) ($ownerData['users_u_id'] ?? 0);
        }
    }
}

if ($discountAmount > $subTotal) {
    $discountAmount = $subTotal;
}

$taxableBase = ($subTotal - $discountAmount) + $serviceCharge;
$taxAmount = $taxableBase * ($taxPercent / 100);
$netTotal = $taxableBase + $taxAmount;

$db->begin_transaction();

try {
    $pointIdEsc = (int) $pointId;
    $userIdEsc = (int) $userId;
    $subTotalEsc = number_format($subTotal, 2, '.', '');
    $discountEsc = number_format($discountAmount, 2, '.', '');
    $taxPercentEsc = number_format($taxPercent, 2, '.', '');
    $taxAmountEsc = number_format($taxAmount, 2, '.', '');
    $serviceEsc = number_format($serviceCharge, 2, '.', '');
    $netTotalEsc = number_format($netTotal, 2, '.', '');
    $paymentMethodEsc = $db->real_escape_string($paymentMethod);
    $noteEsc = $db->real_escape_string($note);
    $noteSql = ($noteEsc !== '') ? "'{$noteEsc}'" : "NULL";

    $insertMasterSql = "INSERT INTO `billing_master` (`point_id`, `user_id`, `sub_total`, `discount_amount`, `tax_percent`, `tax_amount`, `service_charge`, `total_amount`, `status`, `payment_method`, `note`) VALUES ('{$pointIdEsc}', '{$userIdEsc}', '{$subTotalEsc}', '{$discountEsc}', '{$taxPercentEsc}', '{$taxAmountEsc}', '{$serviceEsc}', '{$netTotalEsc}', 'completed', '{$paymentMethodEsc}', {$noteSql})";
    if (!$db->query($insertMasterSql)) {
        throw new Exception('Failed to save bill master record.');
    }

    $billId = (int) $db->insert_id;
    $invoiceNo = 'INV-' . date('Ymd') . '-' . str_pad((string) $billId, 5, '0', STR_PAD_LEFT);
    $invoiceEsc = $db->real_escape_string($invoiceNo);
    if (!$db->query("UPDATE `billing_master` SET `invoice_no` = '{$invoiceEsc}' WHERE `bill_id` = '{$billId}' LIMIT 1")) {
        throw new Exception('Failed to generate invoice number.');
    }

    foreach ($selectedCustomers as $customer) {
        $customerId = (int) ($customer['vh_cid'] ?? 0);
        $customerName = $db->real_escape_string((string) ($customer['vc_name'] ?? ''));
        $vehicleNumber = $db->real_escape_string((string) ($customer['v_number'] ?? ''));
        $contact = $db->real_escape_string((string) ($customer['vc_contact'] ?? ''));
        $vehicleType = $db->real_escape_string((string) ($customer['v_type'] ?? 'N/A'));
        $amount = number_format((float) ($customer['price'] ?? 0), 2, '.', '');

        $insertItemSql = "INSERT INTO `billing_items` (`bill_id`, `v_customer_id`, `customer_name`, `vehicle_number`, `contact`, `vehicle_type`, `amount`) VALUES ('{$billId}', '{$customerId}', '{$customerName}', '{$vehicleNumber}', '{$contact}', '{$vehicleType}', '{$amount}')";
        if (!$db->query($insertItemSql)) {
            throw new Exception('Failed to save bill item record.');
        }
    }

    $db->commit();

    completeBillingResponse(200, true, 'Billing completed and saved to bill history.', [
        'billId' => $billId,
        'invoiceNo' => $invoiceNo,
        'subTotal' => $subTotalEsc,
        'discountAmount' => $discountEsc,
        'taxAmount' => $taxAmountEsc,
        'serviceCharge' => $serviceEsc,
        'totalAmount' => $netTotalEsc,
        'count' => count($selectedCustomers)
    ]);
} catch (Throwable $e) {
    $db->rollback();
    completeBillingResponse(500, false, 'Failed to complete billing: ' . $e->getMessage());
}
