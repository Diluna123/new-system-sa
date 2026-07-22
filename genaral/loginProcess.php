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

$mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$rememberMe = isset($_POST['rememberMe']) ? (int)$_POST['rememberMe'] : 0;

$errors = [];

if ($mobile === '') {
    $errors[] = 'Mobile number is required.';
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
$mobileEsc = $db->real_escape_string($mobile);

$query = "SELECT * FROM `points` WHERE `contact` = '$mobileEsc' LIMIT 1";
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
        'message' => 'Mobile number or password is incorrect.'
    ]);
    exit;
}

$pointData = $result->fetch_assoc();
$storedPassword = (string) $pointData['psw'];
$pointId = (int) $pointData['point_id'];
$shopName = trim((string) $pointData['shop_name']);
$pointContact = (string) $pointData['contact'];

$isPointBlocked = false;
$statusColumns = ['point_state_id', 'point_status', 'status_s_id', 'status', 'state_id', 'is_active', 'is_blocked'];
foreach ($statusColumns as $column) {
    if (!array_key_exists($column, $pointData)) {
        continue;
    }

    $rawValue = trim((string) $pointData[$column]);
    if ($rawValue === '') {
        continue;
    }

    $numericValue = (int) $rawValue;

    if ($column === 'is_blocked' && $numericValue === 1) {
        $isPointBlocked = true;
        break;
    }

    if ($column === 'is_active' && $numericValue === 0) {
        $isPointBlocked = true;
        break;
    }

    if (($column === 'point_state_id' || $column === 'point_status' || $column === 'status_s_id' || $column === 'status' || $column === 'state_id') && $numericValue === 2) {
        $isPointBlocked = true;
        break;
    }
}

if ($isPointBlocked) {
    http_response_code(403);
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => 'POINT ACCOUNT BLOCKED. PLEASE CONTACT ADMINISTRATOR.'
    ]);
    exit;
}

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
        'message' => 'Mobile number or password is incorrect.'
    ]);
    exit;
}

$_SESSION['point_id'] = $pointId;
$_SESSION['user_id'] = $pointId;
$_SESSION['user_name'] = $shopName !== '' ? $shopName : ('Point #' . $pointId);
$_SESSION['user_mobile'] = $pointContact;
$_SESSION['user_email'] = $pointContact;
$_SESSION['login_time'] = time();

if ($rememberMe === 1) {
    setcookie('user_mobile', $pointContact, time() + (30 * 24 * 60 * 60), '/');
}

ob_clean();
echo json_encode([
    'success' => true,
    'message' => 'Login successful.',
    'user' => [
        'id' => $pointId,
        'mobile' => $pointContact,
        'name' => $_SESSION['user_name']
    ]
]);
