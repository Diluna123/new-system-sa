<?php

include '../connection.php';
session_start();

$uid = $_SESSION['afuser']['u_id'];

// Sanitize inputs
$fname = trim($_POST['fname'] ?? '');
$lname = trim($_POST['lname'] ?? '');
$contact = trim($_POST['contact'] ?? '');
$nic = trim($_POST['nic'] ?? ''); // Only sanitized, not validated
$afPlane = trim($_POST['afPlane'] ?? '');
$amount = trim($_POST['amount'] ?? '');

// Validate inputs
$errors = [];

// Validate first name
if (empty($fname) || !preg_match("/^[a-zA-Z\s'-]{2,50}$/", $fname)) {
    $errors[] = "Invalid first name.";
}

// Validate last name
if (empty($lname) || !preg_match("/^[a-zA-Z\s'-]{2,50}$/", $lname)) {
    $errors[] = "Invalid last name.";
}

// Validate contact number (assuming 10 digits for a phone number)
if (empty($contact) || !preg_match("/^\d{10}$/", $contact)) {
    $errors[] = "Invalid contact number.";
}

// Validate affiliate plan (assuming it's an integer or specific list)
if (empty($afPlane) || !preg_match("/^\d+$/", $afPlane)) {
    $errors[] = "Invalid affiliate plan.";
}

// Validate amount (must be a positive number)
if (empty($amount) || !is_numeric($amount) || $amount <= 0) {
    $errors[] = "Invalid amount.";
}

// Check if there are errors
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo " $error |";
    }
    exit; // Stop the script if validation fails
}


// Insert data into the database
$searchContact = Database::search("SELECT * FROM `afcustomers` WHERE `af_contact` = '$contact'");
$searchContactCount = $searchContact->num_rows;

if ($searchContactCount > 0) {
    echo "Contact number already exists!";
    exit; // Stop the script if contact number already exists
}else{
    //current date and time in sri lanka time zone

    date_default_timezone_set("Asia/Colombo");
    $date = date("Y-m-d");
    

    Database::iud("INSERT INTO `afcustomers` (`af_fname`, `af_lname`, `af_contact`, `af_nic`,`af_jdate`, `plans_p_id`, `af_amount`,`afStatus_afSid`, `af_users_af_id`) VALUES ('$fname', '$lname', '$contact', '$nic', '$date', '$afPlane', '$amount', '1', '$uid')");
    echo "success"; // Indicate success
    exit; // Stop the script after successful insertion
}

// If no errors, continue with the next steps (e.g., database insert)

?>
