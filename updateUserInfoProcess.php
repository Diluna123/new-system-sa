<?php
include 'connection.php';
session_start();

$fname= $_POST['fname'];
$lname= $_POST['lname'];
$code = $_POST['code'];

if(empty($fname) || empty($lname) || empty($code)) {
    echo "Please fill in all fields.";
   
 
}else{
    $userId = $_SESSION['user']['u_id'];
  
    Database::iud("UPDATE users SET u_fname='$fname', u_lname='$lname', code='$code' WHERE u_id='$userId'");
    echo "success";


    

}


?>