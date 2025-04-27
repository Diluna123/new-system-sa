<?php

include '../connection.php';



$uid = $_POST['uid'];
$actCode = $_POST['actCode'];

$searchAgent = Database::search("SELECT * FROM `users` WHERE `referalCode` = '$actCode' ");

$searchAgentCount = $searchAgent->num_rows;
if($searchAgentCount == 0){
    echo "activation code not found";

}else{
    $sdata = $searchAgent->fetch_assoc();
    $agentId = $sdata['u_id'];
    Database::iud("UPDATE `af_users` SET `users_u_id` = '$agentId' WHERE `af_id` = '$uid' ");
    echo "success";

}





?>