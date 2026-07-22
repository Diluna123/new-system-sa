<?php

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

include '../connection.php';

header('Content-Type: application/json');
ob_clean();

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
    exit;
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$rememberMe = isset($_POST['rememberMe']) ? (int) $_POST['rememberMe'] : 0;

$errors = [];

if ($email === '') {
    $errors[] = 'Email is required.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}

if ($password === '') {
    $errors[] = 'Password is required.';
}

if (!empty($errors)) {
    http_response_code(422);
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => 'Validation failed.',
        'errors' => $errors
    ]);
    exit;
}

if (!isset(Database::$connection) || Database::$connection === null) {
    Database::setupConnection();
}

if (Database::$connection && Database::$connection->connect_error) {
    http_response_code(500);
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed.'
    ]);
    exit;
}

$db = Database::$connection;
$emailEsc = $db->real_escape_string($email);

$query = "SELECT `u_id`, `u_fname`, `u_lname`, `email`, `password`, `user_State_id` FROM `users` WHERE `email` = '$emailEsc' LIMIT 1";
$result = $db->query($query);

if (!$result) {
    http_response_code(500);
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred.'
    ]);
    exit;
}

if ($result->num_rows === 0) {
    http_response_code(401);
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => 'Email or password is incorrect.'
    ]);
    exit;
}

$userData = $result->fetch_assoc();
$storedPassword = (string) $userData['password'];

$matched = false;
if (password_verify($password, $storedPassword)) {
    $matched = true;
} elseif ($password === $storedPassword) {
    $matched = true;
}

if (!$matched) {
    http_response_code(401);
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => 'Email or password is incorrect.'
    ]);
    exit;
}

if ((int) $userData['user_State_id'] === 2) {
    http_response_code(403);
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => 'ACCOUNT DEACTIVATED PLEASE CONTACT ADMINISTRATOR'
    ]);
    exit;
}

$fullName = trim((($userData['u_fname'] ?? '') . ' ' . ($userData['u_lname'] ?? '')));
if ($fullName === '') {
    $fullName = (string) $userData['email'];
}

$_SESSION['user_id'] = (int) $userData['u_id'];
$_SESSION['user_name'] = $fullName;
$_SESSION['user_email'] = (string) $userData['email'];
$_SESSION['login_time'] = time();

if ($rememberMe === 1) {
    setcookie('user_email', (string) $userData['email'], time() + (30 * 24 * 60 * 60), '/');
} else {
    setcookie('user_email', '', time() - 3600, '/');
}

ob_clean();
echo json_encode([
    'success' => true,
    'message' => 'Login successful.',
    'user' => [
        'id' => $_SESSION['user_id'],
        'name' => $_SESSION['user_name'],
        'email' => $_SESSION['user_email']
    ]
]);
