<?php
session_start();
include 'connection.php';

/* ----------------- SESSION VALIDATION ----------------- */
if (!isset($_SESSION['user']['u_id'])) {
    http_response_code(401);
    echo "unauthorized";
    exit;
}

$uid = (int)$_SESSION['user']['u_id'];

/* ----------------- REQUIRED FIELD VALIDATION ----------------- */
$required = [
    'date', 'fname', 'age', 'dob', 'contact', 'address',
    'plane', 'payment', 'ammount', 'timep'
];

foreach ($required as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        http_response_code(400);
        echo "missing_$field";
        exit;
    }
}

/* ----------------- SANITIZATION ----------------- */
$date     = $_POST['date'];
$fname    = trim($_POST['fname']);
$lname    = trim($_POST['lname'] ?? '');
$nic      = trim($_POST['nic'] ?? '');
$age      = (int)$_POST['age'];
$dob      = $_POST['dob'];
$contact  = trim($_POST['contact']);
$address  = trim($_POST['address']);
$locText  = trim($_POST['locText'] ?? '');
$plane    = (int)$_POST['plane'];
$payment  = (int)$_POST['payment'];
$ammount  = (float)$_POST['ammount'];
$timep    = (int)$_POST['timep'];
$note     = trim($_POST['note'] ?? '');

/* ----------------- BASIC DATA RULES ----------------- */
if ($age < 1 || $age > 120) {
    echo "invalid_age";
    exit;
}

if ($ammount <= 0) {
    echo "invalid_amount";
    exit;
}

if ($timep < 1) {
    echo "invalid_time_period";
    exit;
}

/* ----------------- SERVER TIME ----------------- */
$tz = new DateTimeZone("Asia/Colombo");
$dt = new DateTime("now", $tz);
$udate = $dt->format("Y-m-d");
$utime = $dt->format("H:i:s");

/* ----------------- INSERT CUSTOMER ----------------- */
Database::iud("
    INSERT INTO customers 
    (nic, fname, lname, age, dob, contact, location, addres, user_date, user_time)
    VALUES
    (
        '$nic',
        '$fname',
        '$lname',
        '$age',
        '$dob',
        '$contact',
        '$locText',
        '$address',
        '$udate',
        '$utime'
    )
");

/* ----------------- GET LAST INSERT ID (SAFE) ----------------- */
$cidResult = Database::search("SELECT LAST_INSERT_ID() AS cid");
$cid = (int)$cidResult->fetch_assoc()['cid'];

if ($cid <= 0) {
    echo "customer_insert_failed";
    exit;
}

/* ----------------- INSERT POLICY ----------------- */
Database::iud("
    INSERT INTO police_t
    (customers_id, plans_p_id, payments_pay_id, ammount, time_p, notes, date, status_s_id, users_u_id)
    VALUES
    (
        '$cid',
        '$plane',
        '$payment',
        '$ammount',
        '$timep',
        '$note',
        '$date',
        '2',
        '$uid'
    )
");

echo "success";
