<?php
include 'connection.php';

session_start();
$uid = $_SESSION['user']['u_id'];

$cname = $_POST['cname'];
$contact = $_POST['contact'];
$sname = $_POST['sname'];
$loc = $_POST['loc_cl'];


function validateSriLankanPhone($contact)
{
    // Remove spaces & non-numeric characters (except "+")
    $contact = trim($contact);

    // Pattern for Local (07XXXXXXXX) or International (+947XXXXXXXX)
    $pattern = "/^(?:\+94[1-9]\d{8}|0[1-9]\d{8})$/";

    if (preg_match($pattern, $contact)) {
        return true; // Valid Sri Lankan number
    } else {
        return false; // Invalid number
    }
}

// Get user input






if (empty($cname)) {
    echo "Please Enter Customer Name";
} else if (empty($contact)) {
    echo "Please Enter Contact Number";
} else if (!empty($contact)) {
    if (validateSriLankanPhone($contact)) {
        if (empty($sname)) {
            $sname = "N/A";
        } else if (empty($loc)) {
            $loc = "N/A";
        }
        $bData = Database::search("SELECT * FROM `c_leads` WHERE `contact_cl` = '$contact'");

        if ($bData->num_rows > 0) {
            echo "already exist";
        } else {

            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $udate = $d->format("Y-m-d");


            Database::iud("INSERT INTO `c_leads`(`cname`, `contact_cl`,`date_cl`, `sh_name`, `loc_cl`,`status_s_id`,`users_u_id`) VALUES('$cname','$contact','$udate','$sname','$loc','4','$uid')");

            echo "success";
        }
    } else {
        echo "Invalid phone number. Please enter a valid number.";
    }
}
