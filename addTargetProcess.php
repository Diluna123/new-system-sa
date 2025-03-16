<?php

include "connection.php";

$targetAmmount = $_POST['targetAmount'];
$targetMonth = $_POST['monthSelect'];
$targetSpo = $_POST['spoSelect'];

$currentYear = date("Y");
$currentMonth = date("Y-m");




// Create the first date of the selected month
$firstDate = new DateTime("$targetMonth-01"); // Ensuring the year is correct
$finalDay = $firstDate->format('Y-m-d'); // First day of the selected month

// Query to check if the target already exists for the given user, month, and year
$beforeR = Database::search("SELECT * FROM `targets` WHERE `users_u_id` = '$targetSpo' AND DATE_FORMAT(`date`, '%Y-%m') = '$targetMonth' AND (`status_s_id` = '2' OR `status_s_id` = '4')");

if ($beforeR->num_rows > 0) {
    // If a record exists, update the target amount
    $beforeRData = $beforeR->fetch_assoc();
    Database::iud("UPDATE `targets` SET `target`='$targetAmmount' WHERE `tr_id` = {$beforeRData['tr_id']} AND `users_u_id` = $targetSpo");
    echo "success";
} else {
    // If no record exists, insert a new one
    if($targetMonth == $currentMonth){
        Database::iud("INSERT INTO `targets`(`target`, `users_u_id`, `date`, `status_s_id`) VALUES ('$targetAmmount', '$targetSpo', '$finalDay', 2)");

    
    
    }else{
        Database::iud("INSERT INTO `targets`(`target`, `users_u_id`, `date`, `status_s_id`) VALUES ('$targetAmmount', '$targetSpo', '$finalDay', 4)");



    }
    
    echo "success";
}

?>
