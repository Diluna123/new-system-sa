<?php
session_start();
require_once __DIR__ . '/connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user']) || (int) ($_SESSION['user']['u_id'] ?? 0) !== 1) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$uid = isset($_POST['uid']) ? (int) $_POST['uid'] : 0;
$status = isset($_POST['status']) ? (int) $_POST['status'] : 0;

if ($uid <= 0 || !in_array($status, [1, 2], true)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Invalid user data.']);
    exit;
}

if ($uid === 1) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Super admin account cannot be blocked.']);
    exit;
}

Database::setupConnection();
$db = Database::$connection;

if (!$db || $db->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

$uidEsc = (int) $uid;
$statusEsc = (int) $status;

$exists = $db->query("SELECT `u_id` FROM `users` WHERE `u_id` = '{$uidEsc}' LIMIT 1");
if (!$exists || $exists->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'User not found.']);
    exit;
}

$update = $db->query("UPDATE `users` SET `user_State_id` = '{$statusEsc}' WHERE `u_id` = '{$uidEsc}' LIMIT 1");
if (!$update) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to update user status.']);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => $statusEsc === 1 ? 'User account activated.' : 'User account blocked.'
]);
