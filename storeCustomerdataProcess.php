<?php

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

include "connection.php";
include "email_send/Exception.php";
include "email_send/SMTP.php";
include "email_send/PHPMailer.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

header("Content-Type: application/json");
ob_clean();

if (!isset(Database::$connection) || Database::$connection === null) {
    Database::setupConnection();
}

if (Database::$connection && Database::$connection->connect_error) {
    http_response_code(500);
    ob_clean();
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed."
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    ob_clean();
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
    exit;
}

function postValue($key)
{
    return isset($_POST[$key]) ? trim($_POST[$key]) : "";
}

$customerName = postValue("customerName");
$vehicleNumber = postValue("vehicleNumber");
$chassisNumber = postValue("chassisNumber");
$contactNumber = postValue("contactNumber");
$vehicleType = postValue("vehicleType");
$nic = postValue("nic");
$premium = postValue("premium");
$sessionPointId = (int) ($_SESSION['point_id'] ?? 0);

$errors = [];

if ($customerName === "") {
    $errors[] = "Customer name is required.";
}

if ($vehicleNumber === "") {
    $errors[] = "Vehicle number is required.";
}

if ($chassisNumber === "") {
    $errors[] = "Chassis number is required.";
}

if ($contactNumber === "") {
    $errors[] = "Contact number is required.";
}

if ($vehicleType === "") {
    $errors[] = "Vehicle type is required.";
} elseif (!ctype_digit($vehicleType)) {
    $errors[] = "Vehicle type is invalid.";
}

if ($nic === "") {
    $errors[] = "NIC is required.";
}

if ($premium === "") {
    $errors[] = "Premium is required.";
}

if ($sessionPointId <= 0) {
    $errors[] = "Point ID is missing from session.";
}

function saveUploadedFile($fieldName, $uploadDir, &$errors, $required = true)
{
    if (!isset($_FILES[$fieldName])) {
        if ($required) {
            $errors[] = "Missing file: " . $fieldName;
        }
        return "";
    }

    $file = $_FILES[$fieldName];

    if ((int) $file["error"] === UPLOAD_ERR_NO_FILE && !$required) {
        return "";
    }

    if ((int) $file["error"] !== UPLOAD_ERR_OK) {
        $errors[] = "File upload failed for: " . $fieldName;
        return "";
    }

    $allowedExtensions = ["pdf", "jpg", "jpeg", "png"];
    $extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedExtensions, true)) {
        $errors[] = "Invalid file type for: " . $fieldName;
        return "";
    }

    $safeName = preg_replace('/[^A-Za-z0-9_-]/', '_', pathinfo($file["name"], PATHINFO_FILENAME));
    $newName = $fieldName . "_" . $safeName . "_" . uniqid() . "." . $extension;
    $destination = $uploadDir . DIRECTORY_SEPARATOR . $newName;

    if (!move_uploaded_file($file["tmp_name"], $destination)) {
        $errors[] = "Could not save uploaded file: " . $fieldName;
        return "";
    }

    return "uploads/customer_docs/" . $newName;
}

function sendCustomerSavedNotification(
    $toEmail,
    $toName,
    $customerName,
    $vehicleNumber,
    $chassisNumber,
    $dateIssued,
    $dateExpere,
    $pointName,
    $insertedId
)
{
    if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'affinitysoft.solutions@gmail.com';
        $mail->Password = 'yvotplnieooqifhx';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('affinitysoft.solutions@gmail.com', 'Sanasa Easy General');
        $mail->addAddress($toEmail, $toName !== '' ? $toName : null);

        $safeCustomerName = htmlspecialchars($customerName, ENT_QUOTES, 'UTF-8');
        $safeVehicleNumber = htmlspecialchars($vehicleNumber, ENT_QUOTES, 'UTF-8');
        $safeChassisNumber = htmlspecialchars($chassisNumber, ENT_QUOTES, 'UTF-8');
        $safeDateIssued = htmlspecialchars($dateIssued, ENT_QUOTES, 'UTF-8');
        $safeDateExpere = htmlspecialchars($dateExpere, ENT_QUOTES, 'UTF-8');
        $safePointName = htmlspecialchars($pointName !== '' ? $pointName : 'N/A', ENT_QUOTES, 'UTF-8');
        $safeToName = htmlspecialchars($toName !== '' ? $toName : 'User', ENT_QUOTES, 'UTF-8');

        $mail->isHTML(true);
        $mail->Subject = 'New customer data stored successfully';
        $mail->Body = "
        <div style='background:#f4f7fb;padding:28px 14px;font-family:Segoe UI,Arial,sans-serif;color:#1f2937;'>
            <div style='max-width:680px;margin:0 auto;background:#ffffff;border:1px solid #dbe4f0;border-radius:14px;overflow:hidden;'>
                <div style='padding:18px 22px;background:linear-gradient(135deg,#0f4c81,#1b6ca8);color:#ffffff;'>
                    <h2 style='margin:0;font-size:20px;font-weight:700;'>Customer Data Saved</h2>
                    <p style='margin:6px 0 0 0;font-size:13px;opacity:0.92;'>Sanasa Easy General Notification</p>
                </div>
                <div style='padding:22px;'>
                    <p style='margin:0 0 14px 0;'>Dear <strong>{$safeToName}</strong>,</p>
                    <p style='margin:0 0 16px 0;'>A new customer record was added successfully. Details are below.</p>
                    <table style='width:100%;border-collapse:collapse;border:1px solid #e5e7eb;'>
                        <tr>
                            <td style='padding:10px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:600;width:36%;'>Customer Name</td>
                            <td style='padding:10px;border:1px solid #e5e7eb;'>{$safeCustomerName}</td>
                        </tr>
                        <tr>
                            <td style='padding:10px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:600;'>Vehicle Number</td>
                            <td style='padding:10px;border:1px solid #e5e7eb;'>{$safeVehicleNumber}</td>
                        </tr>
                        <tr>
                            <td style='padding:10px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:600;'>Chassis Number</td>
                            <td style='padding:10px;border:1px solid #e5e7eb;'>{$safeChassisNumber}</td>
                        </tr>
                        <tr>
                            <td style='padding:10px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:600;'>Issue Date</td>
                            <td style='padding:10px;border:1px solid #e5e7eb;'>{$safeDateIssued}</td>
                        </tr>
                        <tr>
                            <td style='padding:10px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:600;'>Expiry Date</td>
                            <td style='padding:10px;border:1px solid #e5e7eb;'>{$safeDateExpere}</td>
                        </tr>
                        <tr>
                            <td style='padding:10px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:600;'>Point Name</td>
                            <td style='padding:10px;border:1px solid #e5e7eb;'>{$safePointName}</td>
                        </tr>
                        <tr>
                            <td style='padding:10px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:600;'>Record ID</td>
                            <td style='padding:10px;border:1px solid #e5e7eb;'>#{$insertedId}</td>
                        </tr>
                    </table>
                    <p style='margin:16px 0 0 0;font-size:13px;color:#6b7280;'>This is an automated message from Sanasa Easy General.</p>
                </div>
            </div>
        </div>";

        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}

$uploadDirectory = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "customer_docs";

if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0777, true) && !is_dir($uploadDirectory)) {
    http_response_code(500);
    ob_clean();
    echo json_encode([
        "success" => false,
        "message" => "Failed to create upload directory."
    ]);
    exit;
}

$uploadCrPath = saveUploadedFile("uploadCr", $uploadDirectory, $errors);
$uploadNicPath = saveUploadedFile("uploadNic", $uploadDirectory, $errors);
$uploadExpiredCardPath = saveUploadedFile("uploadExpiredCard", $uploadDirectory, $errors, false);

if (!empty($errors)) {
    http_response_code(422);
    ob_clean();
    echo json_encode([
        "success" => false,
        "message" => "Validation failed.",
        "errors" => $errors
    ]);
    exit;
}

$db = Database::$connection;

$customerNameEsc = $db->real_escape_string($customerName);
$vehicleNumberEsc = $db->real_escape_string($vehicleNumber);
$chassisNumberEsc = $db->real_escape_string($chassisNumber);
$contactNumberEsc = $db->real_escape_string($contactNumber);
$nicEsc = $db->real_escape_string($nic);
$uploadCrPathEsc = $db->real_escape_string($uploadCrPath);
$uploadNicPathEsc = $db->real_escape_string($uploadNicPath);
$uploadExpiredCardPathEsc = $db->real_escape_string($uploadExpiredCardPath);

$uploadExpiredCardValue = $uploadExpiredCardPathEsc !== "" ? "'" . $uploadExpiredCardPathEsc . "'" : "NULL";

$issueDateObj = new DateTime("today");
$expireDateObj = (clone $issueDateObj)->modify("+1 year")->modify("-1 day");

$dateIssued = $issueDateObj->format("Y/m/d");
$dateExpere = $expireDateObj->format("Y/m/d");

$insertQuery = "INSERT INTO `v_customers`
(`vc_name`, `date_issued`, `date_expere`, `vc_contact`, `v_number`, `ch_number`, `vehical_typs_vty_id`, `v_status_cs_id`, `Points_point_id`, `cr_copy`, `nic_copy`, `ex_i`)
VALUES
('$customerNameEsc', '$dateIssued', '$dateExpere', '$contactNumberEsc', '$vehicleNumberEsc', '$chassisNumberEsc', '$vehicleType', '1', '{$sessionPointId}', '$uploadCrPathEsc', '$uploadNicPathEsc', $uploadExpiredCardValue)";

if (!$db->query($insertQuery)) {
    http_response_code(500);
    ob_clean();
    echo json_encode([
        "success" => false,
        "message" => "Failed to save customer data.",
        "dbError" => $db->error
    ]);
    exit;
}

$insertedId = $db->insert_id;

$mailSent = false;

$pointResult = $db->query("SELECT `users_u_id`, `shop_name` FROM `points` WHERE `point_id` = '{$sessionPointId}' LIMIT 1");
if ($pointResult && $pointResult->num_rows > 0) {
    $pointData = $pointResult->fetch_assoc();
    $assignedUserId = (int) ($pointData['users_u_id'] ?? 0);
    $pointName = trim((string) ($pointData['shop_name'] ?? ''));

    if ($assignedUserId > 0) {
        $userResult = $db->query("SELECT `email`, `u_fname`, `u_lname` FROM `users` WHERE `u_id` = '$assignedUserId' LIMIT 1");
        if ($userResult && $userResult->num_rows > 0) {
            $userData = $userResult->fetch_assoc();
            $userEmail = trim((string) ($userData['email'] ?? ''));
            $userName = trim((string) (($userData['u_fname'] ?? '') . ' ' . ($userData['u_lname'] ?? '')));

            $mailSent = sendCustomerSavedNotification(
                $userEmail,
                $userName,
                $customerName,
                $vehicleNumber,
                $chassisNumber,
                $dateIssued,
                $dateExpere,
                $pointName,
                $insertedId
            );
        }
    }
}

$responseData = [
    "id" => $insertedId,
    "customerName" => $customerName,
    "vehicleNumber" => $vehicleNumber,
    "chassisNumber" => $chassisNumber,
    "contactNumber" => $contactNumber,
    "vehicleType" => $vehicleType,
    "pointId" => $sessionPointId,
    "nic" => $nic,
    "premium" => $premium,
    "uploadCr" => $uploadCrPath,
    "uploadNic" => $uploadNicPath,
    "uploadExpiredCard" => $uploadExpiredCardPath,
    "mailSent" => $mailSent
];

ob_clean();
echo json_encode([
    "success" => true,
    "message" => "Customer data received successfully.",
    "data" => $responseData
]);
