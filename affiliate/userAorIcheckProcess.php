<?php
include '../connection.php';


$uid = $_GET['uid'];


$search = Database::search("SELECT * FROM `af_users` WHERE `af_id` = '$uid'");

$searchCount = $search->num_rows;
if ($searchCount == 0) {
    echo "notfound";

} else {
    $sdata = $search->fetch_assoc();

    if ($sdata['users_u_id'] == 14) {
        echo "inactive";
    } else {
        echo "activated";
    }
}
