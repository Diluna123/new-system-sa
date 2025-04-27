<?php

include '../connection.php';
session_start();

// Helper function to sanitize input
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

// Sanitize inputs
$nic = sanitize($_POST['nic']);
$psw = sanitize($_POST['password']);
$cpsw = sanitize($_POST['confirmPassword']);
$bankName = sanitize($_POST['bankName']);
$branch = sanitize($_POST['branch']);
$accountHolder = sanitize($_POST['accountHolder']);
$accountNumber = sanitize($_POST['accountNumber']);

// Validate required fields
if (empty($nic) || empty($psw) || empty($cpsw) || empty($bankName) || empty($branch) || empty($accountHolder) || empty($accountNumber)) {
    echo "All fields are required!";
    exit();
}

// Validate NIC format (Sri Lankan format example)
if (!preg_match("/^([0-9]{9}[vVxX]|[0-9]{12})$/", $nic)) {
    echo "Invalid NIC format!";
    exit();
}

// Validate passwords match
if ($psw !== $cpsw) {
    echo "Passwords do not match!";
    exit();
}

// Password length check
if (strlen($psw) < 6) {
    echo "Password must be at least 6 characters!";
    exit();
}

// Validate account number (example: only digits, 8-12 length)
if (!preg_match("/^[0-9]{8,12}$/", $accountNumber)) {
    echo "Invalid account number!";
    exit();
}

// Validate account holder name (only letters and spaces)
if (!preg_match("/^[a-zA-Z ]+$/", $accountHolder)) {
    echo "Invalid account holder name!";
    exit();
}

// Proceed if valid
$checkCustomer = Database::search("SELECT * FROM `customers` WHERE `nic` = '$nic'");
$checkCustomerCount = $checkCustomer->num_rows;
if ($checkCustomerCount == 0) {
    echo "No customer found with this NIC!";
    exit();
} else {
    $olderData = $checkCustomer->fetch_assoc();
    $customerId = $olderData["id"];
}

$checkAf = Database::search("SELECT * FROM `af_users` WHERE `customers_id` = '$customerId'");
$checkAfCount = $checkAf->num_rows;

if ($checkAfCount > 0) {
    echo "Already registered as an affiliate!";
} else {
    Database::iud("INSERT INTO `af_users`(`customers_id`, `af_psw`, `users_u_id`) VALUES ('$customerId','$cpsw','14')");

    $lastaddedCus = Database::search("SELECT * FROM `af_users` ORDER BY `af_id` DESC LIMIT 1");
    $lastAddedAf = $lastaddedCus->fetch_assoc();
    $afId = $lastAddedAf["af_id"];

    Database::iud("INSERT INTO `afbank`(`hName`,`accNum`,`af_users_af_id`,`Banks_idBanks`,`branch`) VALUES ('$accountHolder','$accountNumber','$afId','$bankName','$branch')");
    echo "success";
}
?>
