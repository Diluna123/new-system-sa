<?php
session_start();
require_once __DIR__ . '/connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$email = isset($_POST['email']) ? trim((string) $_POST['email']) : '';
$password = isset($_POST['password']) ? trim((string) $_POST['password']) : '';

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Enter a valid email address.']);
    exit;
}

if ($password === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Password is required.']);
    exit;
}

Database::setupConnection();
$db = Database::$connection;

if (!$db || $db->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

$emailEsc = $db->real_escape_string($email);
$result = $db->query("SELECT * FROM `users` WHERE `email` = '{$emailEsc}' LIMIT 1");

if (!$result || $result->num_rows === 0) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Invalid login credentials.']);
    exit;
}

$userData = $result->fetch_assoc();
$storedPassword = (string) ($userData['password'] ?? '');
$matched = false;

if (password_verify($password, $storedPassword)) {
    $matched = true;
} elseif ($password === $storedPassword) {
    $matched = true;
}

if (!$matched) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Invalid login credentials.']);
    exit;
}

if ((int) ($userData['user_State_id'] ?? 2) === 2) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Account is blocked. Please contact administrator.']);
    exit;
}

if ((int) ($userData['u_id'] ?? 0) !== 1) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Only super users can log in here.']);
    exit;
}

$_SESSION['user'] = $userData;

echo json_encode([
    'success' => true,
    'message' => 'Super user login successful.'
]);
