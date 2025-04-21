<?php
include 'connection.php';
session_start();

$fname= $_POST['fname'];
$lname= $_POST['lname'];
$code = $_POST['code'];
$contact = $_POST['contact'];

if(empty($fname) || empty($lname) || empty($code) || empty($contact)) {
    echo "Please fill in all fields.";
   
 
}else{
    $userId = $_SESSION['user']['u_id'];
  
    Database::iud("UPDATE users SET u_fname='$fname', u_lname='$lname', code='$code', con_num='$contact' WHERE u_id='$userId'");
    echo "success";


    

}


?>