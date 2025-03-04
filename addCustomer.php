<?php
session_start();

$uid = $_SESSION['user']['u_id'];
include 'connection.php';


$date = $_POST['date'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$nic = $_POST['nic'];
$age = $_POST['age'];
$dob = $_POST['dob'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$locText = $_POST['locText'];

$plane = $_POST['plane'];
$payment = $_POST['payment'];
$ammount = $_POST['ammount'];
$timep = $_POST['timep'];
$note = $_POST['note'];

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$udate = $d->format("Y-m-d");
$utime = $d->format("H:i");
Database::iud("INSERT INTO customers( `nic`, `fname`, `lname`,`age`,`dob`, `contact`, `location`, `addres`,`user_date`,`user_time`) VALUES('$nic','$fname','$lname','$age','$dob','$contact','$locText','$address','$udate','$utime')");


$result = Database::search("SELECT * FROM customers ORDER BY id DESC LIMIT 1");
$lastAddedCustomer = $result->fetch_assoc();





Database::iud("INSERT INTO police_t( `customers_id`, `plans_p_id`, `payments_pay_id`, `ammount`, `time_p`, `notes`,`date`,`status_s_id`,`users_u_id`) VALUES('$lastAddedCustomer[id]','$plane','$payment','$ammount','$timep','$note','$date','2','$uid')");
echo "success";



?>