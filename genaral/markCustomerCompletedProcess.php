<?php

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();
include '../connection.php';

header('Content-Type: application/json');
ob_clean();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access.'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
    exit;
}

$customerId = isset($_POST['customerId']) ? (int) $_POST['customerId'] : 0;
if ($customerId <= 0) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid customer id.'
    ]);
    exit;
}

if (!isset(Database::$connection) || Database::$connection === null) {
    Database::setupConnection();
}

if (Database::$connection && Database::$connection->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed.'
    ]);
    exit;
}

$db = Database::$connection;

$checkRs = $db->query("SELECT `vh_cid` FROM `v_customers` WHERE `vh_cid` = '$customerId' LIMIT 1");
if (!$checkRs || $checkRs->num_rows === 0) {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => 'Customer not found.'
    ]);
    exit;
}

$updateRs = $db->query("UPDATE `v_customers` SET `v_status_cs_id` = '2' WHERE `vh_cid` = '$customerId' LIMIT 1");
if (!$updateRs) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update customer status.'
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Customer marked as completed.'
]);
