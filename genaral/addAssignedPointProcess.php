<?php

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();
require_once __DIR__ . '/../connection.php';
mysqli_report(MYSQLI_REPORT_OFF);

header('Content-Type: application/json');

$responseSent = false;

function jsonResponse(int $statusCode, bool $success, string $message, array $extra = []): void
{
    $GLOBALS['responseSent'] = true;
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

register_shutdown_function(function () {
    if (!empty($GLOBALS['responseSent'])) {
        return;
    }

    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR], true)) {
        if (ob_get_length()) {
            ob_clean();
        }
        http_response_code(500);
        $payload = [
            'success' => false,
            'message' => 'Unexpected server error while adding point.'
        ];

        if (PHP_SAPI === 'cli') {
            $payload['debug'] = $error['message'] . ' at ' . basename((string) $error['file']) . ':' . (int) $error['line'];
        }

        echo json_encode($payload);
    }
});

if (!isset($_SESSION['user_id'])) {
    jsonResponse(401, false, 'Unauthorized access.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(405, false, 'Invalid request method.');
}

$shopName = isset($_POST['shopName']) ? trim($_POST['shopName']) : '';
$pointContact = isset($_POST['pointContact']) ? trim($_POST['pointContact']) : '';
$pointAddress = isset($_POST['pointAddress']) ? trim($_POST['pointAddress']) : '';
$pointLocation = isset($_POST['pointLocation']) ? trim($_POST['pointLocation']) : '';
$pointPassword = isset($_POST['pointPassword']) ? trim($_POST['pointPassword']) : '';
$userId = (int) $_SESSION['user_id'];

if ($shopName === '') {
    jsonResponse(422, false, 'Shop name is required.');
}

if ($pointContact === '') {
    jsonResponse(422, false, 'Contact number is required.');
}

if ($pointAddress === '') {
    jsonResponse(422, false, 'Address is required.');
}

if ($pointLocation === '') {
    jsonResponse(422, false, 'Location is required.');
}

if ($pointPassword === '' || strlen($pointPassword) < 4) {
    jsonResponse(422, false, 'Password must be at least 4 characters.');
}

if (!isset(Database::$connection) || Database::$connection === null) {
    Database::setupConnection();
}

if (Database::$connection && Database::$connection->connect_error) {
    jsonResponse(500, false, 'Database connection failed.');
}

$db = Database::$connection;
$shopNameEsc = $db->real_escape_string($shopName);
$pointContactEsc = $db->real_escape_string($pointContact);
$pointAddressEsc = $db->real_escape_string($pointAddress);
$pointLocationEsc = $db->real_escape_string($pointLocation);

$pointColumns = [];
$pointColumnTypes = [];
$pointColsRs = $db->query("SHOW COLUMNS FROM `points`");
if (!$pointColsRs) {
    jsonResponse(500, false, 'Unable to read points table structure.');
}

if ($pointColsRs && $pointColsRs->num_rows > 0) {
    while ($col = $pointColsRs->fetch_assoc()) {
        $pointColumns[] = $col['Field'];
        $pointColumnTypes[$col['Field']] = strtolower((string) ($col['Type'] ?? ''));
    }
}

$passwordToStore = $pointPassword;
$pswType = $pointColumnTypes['psw'] ?? '';

if ($pswType !== '') {
    $shouldHash = true;
    if (preg_match('/varchar\((\d+)\)/i', $pswType, $match)) {
        $maxLen = (int) ($match[1] ?? 0);
        if ($maxLen > 0 && $maxLen < 60) {
            $shouldHash = false;
        }
    }

    if ($shouldHash) {
        $passwordToStore = password_hash($pointPassword, PASSWORD_DEFAULT);
    }
}

$passwordEsc = $db->real_escape_string($passwordToStore);

$addressColumn = in_array('address', $pointColumns, true)
    ? 'address'
    : (in_array('adress', $pointColumns, true) ? 'adress' : null);

$locationColumn = in_array('location', $pointColumns, true)
    ? 'location'
    : (in_array('loca', $pointColumns, true) ? 'loca' : null);

$existsRs = $db->query("SELECT `point_id` FROM `points` WHERE `contact` = '$pointContactEsc' LIMIT 1");
if (!$existsRs) {
    jsonResponse(500, false, 'Failed to validate point contact.');
}

if ($existsRs && $existsRs->num_rows > 0) {
    jsonResponse(409, false, 'Point contact already exists.');
}

$insertCols = ['`shop_name`', '`contact`', '`psw`', '`users_u_id`'];
$insertVals = ["'$shopNameEsc'", "'$pointContactEsc'", "'$passwordEsc'", "'$userId'"];

if ($addressColumn !== null) {
    $insertCols[] = "`{$addressColumn}`";
    $insertVals[] = "'$pointAddressEsc'";
}

if ($locationColumn !== null) {
    $insertCols[] = "`{$locationColumn}`";
    $insertVals[] = "'$pointLocationEsc'";
}

$insertColsSql = implode(', ', $insertCols);
$insertValsSql = implode(', ', $insertVals);

$insertRs = $db->query("INSERT INTO `points` ({$insertColsSql}) VALUES ({$insertValsSql})");

if (!$insertRs) {
    jsonResponse(500, false, 'Failed to add point.');
}

jsonResponse(200, true, 'Point added successfully.');
