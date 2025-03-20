<?php

include 'connection.php';


$uid = $_POST['uid'];
$st = $_POST['status'];

Database::iud("UPDATE `users` SET `user_State_id` = '$st' WHERE `u_id` = '$uid'");
echo "success";




?>