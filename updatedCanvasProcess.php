<?php

include 'connection.php';


$cid = $_POST['cid'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$nic = $_POST['nic'];
$age = $_POST['age'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$dob = $_POST['dob'];


$plane = $_POST['plane'];
$payment = $_POST['payment'];
$ammount = $_POST['ammount'];
$timep = $_POST['timep'];
$note = $_POST['note'];

$pronum = $_POST['pronum'];
$polnum = $_POST['polnum'];



Database::iud("UPDATE customers SET`nic`='$nic', `fname`='$fname', `lname`='$lname',`age`='$age',`dob` ='$dob', `contact`='$contact', `addres`='$address' WHERE `id` = '$cid'");


Database::iud("UPDATE police_t SET `plans_p_id`='$plane', `payments_pay_id`='$payment', `ammount`='$ammount', `time_p`='$timep', `notes`='$note', `pro_num`='$pronum', `pol_num`='$polnum'  WHERE `customers_id` = '$cid'");


echo "success";


?>