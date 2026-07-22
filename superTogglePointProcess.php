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

$pointId = isset($_POST['pointId']) ? (int) $_POST['pointId'] : 0;
$status = isset($_POST['status']) ? (int) $_POST['status'] : 0;

if ($pointId <= 0 || !in_array($status, [1, 2], true)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Invalid point data.']);
    exit;
}

Database::setupConnection();
$db = Database::$connection;

if (!$db || $db->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

$pointIdEsc = (int) $pointId;
$exists = $db->query("SELECT `point_id` FROM `points` WHERE `point_id` = '{$pointIdEsc}' LIMIT 1");
if (!$exists || $exists->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Point account not found.']);
    exit;
}

$pointColumns = [];
$pointColsRs = $db->query("SHOW COLUMNS FROM `points`");
if (!$pointColsRs) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Unable to read points table structure.']);
    exit;
}

while ($col = $pointColsRs->fetch_assoc()) {
    $pointColumns[] = $col['Field'];
}

$statusColumn = null;
$candidateColumns = ['point_state_id', 'point_status', 'status_s_id', 'status', 'state_id', 'is_active', 'is_blocked'];
foreach ($candidateColumns as $candidate) {
    if (in_array($candidate, $pointColumns, true)) {
        $statusColumn = $candidate;
        break;
    }
}

if ($statusColumn === null) {
    $alter = $db->query("ALTER TABLE `points` ADD COLUMN `point_state_id` TINYINT(1) NOT NULL DEFAULT 1");
    if (!$alter) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to create point status column.']);
        exit;
    }
    $statusColumn = 'point_state_id';
}

$storeValue = $status;
if ($statusColumn === 'is_blocked') {
    $storeValue = ($status === 2) ? 1 : 0;
} elseif ($statusColumn === 'is_active') {
    $storeValue = ($status === 1) ? 1 : 0;
}

$storeValueEsc = (int) $storeValue;
$update = $db->query("UPDATE `points` SET `{$statusColumn}` = '{$storeValueEsc}' WHERE `point_id` = '{$pointIdEsc}' LIMIT 1");
if (!$update) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to update point status.']);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => $status === 1 ? 'Point account activated.' : 'Point account blocked.'
]);
