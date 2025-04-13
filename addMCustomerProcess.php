<?php

include "connection.php";
session_start();

// Validate session user
if (!isset($_SESSION["user"]["u_id"])) {
    echo "Unauthorized access";
    exit;
}

// Function to sanitize inputs
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Sanitize POST inputs
$fname    = clean_input($_POST["fname"] ?? '');
$lname    = clean_input($_POST["lname"] ?? '');
$contact  = clean_input($_POST["contact"] ?? '');
$plan     = clean_input($_POST["plan"] ?? '');
$ammount  = clean_input($_POST["ammount"] ?? '');
$location = clean_input($_POST["loc"] ?? '');
$payment  = clean_input($_POST["payId"] ?? '');

// Validate inputs
$errors = [];

if (empty($fname)) $errors[] = "First name is required.";
if (empty($lname)) $errors[] = "Last name is required.";
if (!preg_match("/^[0-9]{10}$/", $contact)) $errors[] = "Contact must be a 10-digit number.";
if (!is_numeric($plan) || (int)$plan <= 0) $errors[] = "Invalid plan selected.";
if (!is_numeric($ammount) || (float)$ammount <= 0) $errors[] = "Amount must be a positive number.";
if (empty($location)) $errors[] = "Location is required.";
if (empty($payment)) $errors[] = "Payment ID is required.";

if (!empty($errors)) {
    echo implode(" | ", $errors);
    exit;
}

// Set timezone and get today's date
$datetime = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$today = $datetime->format('Y-m-d');

// Get user ID from session
$uid = $_SESSION["user"]["u_id"];

// Check for duplicate entry for today
$beforeData = Database::search("SELECT * FROM `mobiled` WHERE `M_contact` = '$contact' AND `M_date` = '$today'");

if ($beforeData->num_rows == 0) {
    // Insert new record
    Database::iud("
        INSERT INTO `mobiled` (
            `M_fname`, `M_lname`, `M_contact`, `plans_p_id`, `ammount`, `M_date`, 
            `loca`, `added_user`, `payments_pay_id`,`assignStatus`
        ) VALUES (
            '$fname', '$lname', '$contact', '$plan', '$ammount', '$today', 
            '$location', '$uid', '$payment','0'
        )
    ");
    echo "success";
} else {
    echo "Already Added Today";
}
?>
