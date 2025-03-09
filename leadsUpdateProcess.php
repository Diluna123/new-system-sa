<?php


include 'connection.php';



$clid = $_POST['clid'];
$sOrD = $_POST['sOrD'];


if ($sOrD == 1) {
    Database::iud("UPDATE `c_leads` SET `status_s_id` = '1' WHERE `c_leads`.`clid` = $clid ");
    echo "success";
} else {
    Database::iud("UPDATE `c_leads` SET `status_s_id` = '3' WHERE `c_leads`.`clid` = $clid ");
    echo "success";
}




?>