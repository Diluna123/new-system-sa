<?php


session_start();

include 'connection.php';

$code = rand(1000, 9999);
$code = strval($code);
$code = str_pad($code, 4, '0', STR_PAD_LEFT);

Database::iud("UPDATE `users` SET `referalCode`='$code' WHERE `email`='" . $_SESSION['user']['email'] . "'");
echo $code;




?>