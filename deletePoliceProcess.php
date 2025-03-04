<?php
session_start();
$uid = $_SESSION['user']['u_id'];
include 'connection.php';

$cid = $_GET['cid'];

Database::iud("UPDATE `police_t` SET `status_s_id`='3' WHERE `customers_id` ='$cid' AND `users_u_id`= '$uid'");
echo "success";




?>