<?php
session_start();
include 'connection.php';
$clid = $_POST['clid'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$contact = $_POST['contact'];
$apDate = $_POST['date'];
$apTime = $_POST['time'];
$note = $_POST['note'];
$loc = $_POST['loc'];
$uid = $_SESSION['user']['u_id'];


Database::iud("INSERT INTO `appointments` (`fname`,`lname`,`contact`,`ap_date`,`ap_time`,`apLocation`,`note`,`users_u_id`,`ap_status_ap_s_id`) VALUES ('$fname', '$lname', '$contact', '$apDate', '$apTime','$loc', '$note', '$uid', 1)");
Database::iud("UPDATE `c_leads` SET `status_s_id` = '1' WHERE `clid` = $clid ");
echo "success";




?>