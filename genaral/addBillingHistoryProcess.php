<?php

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();
require_once __DIR__ . '/../connection.php';

header('Content-Type: application/json');

function billingResponse(int $statusCode, bool $success, string $message): void
{
    http_response_code($statusCode);
    if (ob_get_length()) {
        ob_clean();
    }

    echo json_encode([
        'success' => $success,
        'message' => $message
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    billingResponse(405, false, 'Invalid request method.');
}

$sessionPointId = (int) ($_SESSION['point_id'] ?? 0);
$sessionUserId = (int) ($_SESSION['user_id'] ?? 0);
$customerId = isset($_POST['customerId']) ? (int) $_POST['customerId'] : 0;

if ($customerId <= 0) {
    billingResponse(422, false, 'Invalid customer selection.');
}

if ($sessionPointId <= 0 && $sessionUserId <= 0) {
    billingResponse(401, false, 'Unauthorized session. Please login again.');
}

Database::setupConnection();
$db = Database::$connection;

if (!$db || $db->connect_error) {
    billingResponse(500, false, 'Database connection failed.');
}

$scopeFilter = '';
if ($sessionPointId > 0) {
    $scopeFilter = " AND vc.`Points_point_id` = '{$sessionPointId}'";
} elseif ($sessionUserId > 0) {
    $scopeFilter = " AND vc.`Points_point_id` IN (SELECT `point_id` FROM `points` WHERE `users_u_id` = '{$sessionUserId}')";
}

$customerIdEsc = (int) $customerId;
$pendingRs = $db->query("SELECT vc.`vh_cid`, vc.`vc_name`, vc.`v_number`, vc.`vc_contact`, vc.`Points_point_id`, vt.`v_type` FROM `v_customers` vc LEFT JOIN `vehical_typs` vt ON vc.`vehical_typs_vty_id` = vt.`vty_id` WHERE vc.`vh_cid` = '{$customerIdEsc}' AND vc.`v_status_cs_id` = '1' {$scopeFilter} LIMIT 1");

if (!$pendingRs || $pendingRs->num_rows === 0) {
    billingResponse(404, false, 'Pending customer not found for your account scope.');
}

$pendingCustomer = $pendingRs->fetch_assoc();
$pointId = (int) ($pendingCustomer['Points_point_id'] ?? 0);
$customerName = $db->real_escape_string((string) ($pendingCustomer['vc_name'] ?? ''));
$vehicleNumber = $db->real_escape_string((string) ($pendingCustomer['v_number'] ?? ''));
$contact = $db->real_escape_string((string) ($pendingCustomer['vc_contact'] ?? ''));
$vehicleType = $db->real_escape_string((string) ($pendingCustomer['v_type'] ?? 'N/A'));

$assignedUserId = 0;
if ($pointId > 0) {
    $pointOwner = $db->query("SELECT `users_u_id` FROM `points` WHERE `point_id` = '{$pointId}' LIMIT 1");
    if ($pointOwner && $pointOwner->num_rows > 0) {
        $pointOwnerData = $pointOwner->fetch_assoc();
        $assignedUserId = (int) ($pointOwnerData['users_u_id'] ?? 0);
    }
}

$createTableSql = "CREATE TABLE IF NOT EXISTS `billing_history` (
    `bh_id` INT NOT NULL AUTO_INCREMENT,
    `v_customer_id` INT NOT NULL,
    `point_id` INT NOT NULL,
    `user_id` INT NOT NULL DEFAULT 0,
    `customer_name` VARCHAR(150) NOT NULL,
    `vehicle_number` VARCHAR(80) NOT NULL,
    `contact` VARCHAR(40) NOT NULL,
    `vehicle_type` VARCHAR(80) NOT NULL,
    `billing_status` VARCHAR(20) NOT NULL DEFAULT 'pending',
    `billed_date` DATE NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`bh_id`),
    KEY `idx_billing_customer` (`v_customer_id`),
    KEY `idx_billing_point` (`point_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!$db->query($createTableSql)) {
    billingResponse(500, false, 'Failed to prepare billing history table.');
}

$duplicateRs = $db->query("SELECT `bh_id` FROM `billing_history` WHERE `v_customer_id` = '{$customerIdEsc}' LIMIT 1");
if ($duplicateRs && $duplicateRs->num_rows > 0) {
    billingResponse(409, false, 'This customer is already added to billing history.');
}

$assignedUserEsc = (int) $assignedUserId;
$pointIdEsc = (int) $pointId;
$insertSql = "INSERT INTO `billing_history` (`v_customer_id`, `point_id`, `user_id`, `customer_name`, `vehicle_number`, `contact`, `vehicle_type`, `billing_status`, `billed_date`) VALUES ('{$customerIdEsc}', '{$pointIdEsc}', '{$assignedUserEsc}', '{$customerName}', '{$vehicleNumber}', '{$contact}', '{$vehicleType}', 'pending', CURDATE())";

if (!$db->query($insertSql)) {
    billingResponse(500, false, 'Failed to add customer to billing history.');
}

billingResponse(200, true, 'Customer added to billing history.');
