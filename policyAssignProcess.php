<?php

include "connection.php";
session_start();

$cid = $_GET["cid"] ?? null;

if ($cid === null) {
    echo "Invalid request";
    exit;
} else {
    $getMDPolicysDetails = Database::search("SELECT * FROM `mobiled` 
        JOIN `plans` ON `mobiled`.`plans_p_id` = `plans`.`p_id` JOIN `payments` ON `mobiled`.`payments_pay_id` = `payments`.`pay_id` JOIN `users` ON `mobiled`.`added_user` =`users`.`u_id` 
        WHERE `mobiled`.`m_id` = '$cid'");

    if ($getMDPolicysDetails->num_rows > 0) {
        $dataMDPolicysDetails = $getMDPolicysDetails->fetch_assoc();
        $fname = $dataMDPolicysDetails['M_fname'];
        $lname = $dataMDPolicysDetails['M_lname'];
        $contact = $dataMDPolicysDetails['M_contact'];
        $plan = $dataMDPolicysDetails['plans_p_id'];
        $ammount = $dataMDPolicysDetails['ammount'];
        $m_date = $dataMDPolicysDetails['m_date'];
        $payment = $dataMDPolicysDetails['payments_pay_id'];
        $location = $dataMDPolicysDetails['loca'];
        $user = $_SESSION["user"]["u_id"];


        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $utime = $d->format("H:i");
        Database::iud("INSERT INTO customers( `fname`, `lname`, `contact`, `location`,`user_date`,`user_time`) VALUES('$fname','$lname','$contact','$location','$m_date','$utime')");


        $result = Database::search("SELECT * FROM customers ORDER BY id DESC LIMIT 1");
        $lastAddedCustomer = $result->fetch_assoc();

        Database::iud("INSERT INTO police_t( `customers_id`, `plans_p_id`, `payments_pay_id`, `ammount`, `date`,`status_s_id`,`users_u_id`) VALUES('$lastAddedCustomer[id]','$plan','$payment','$ammount','$m_date','2','$user')");
        Database::iud("UPDATE `mobiled` SET `assignStatus` = '1' WHERE `m_id` = '$cid'");
        echo "success";
    }
}
