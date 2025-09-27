<?php

include 'connection.php';

$afid = $_POST['afuid'];
$afStatus = $_POST['status'];


if($afStatus == '6') {
    Database::iud("UPDATE `afcustomers` SET `afStatus_afSid` = '6' WHERE `afid` = '$afid'");
    echo "success"; 
    exit;
}else if($afStatus == '3') {
    Database::iud("UPDATE `afcustomers` SET `afStatus_afSid` = '3' WHERE `afid` = '$afid'");
    echo "success";
    exit;
}





?>