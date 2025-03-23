<?php
include 'connection.php';

session_start();

$vcode = $_POST['vcode'];
$npass = $_POST['npass'];

$res = Database::search("SELECT * FROM `users` WHERE `verification_code` = '" . $vcode . "' AND `email` = '" . $_SESSION['user']['email'] . "'");
if ($res->num_rows > 0) {
    Database::iud("UPDATE `users` SET `password` = '" . $npass . "' WHERE `email` = '" . $_SESSION['user']['email'] . "'");
    echo "success";
} else {
    echo "Verification code is incorrect";
}







?>