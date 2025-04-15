<?php

include "connection.php";
session_start();

$indate = $_POST["indate"];

$getMDPolicys = Database::search("SELECT * FROM `mobiled` 
    JOIN `plans` ON `mobiled`.`plans_p_id` = `plans`.`p_id` 
    WHERE `m_date` = '$indate' 
    ORDER BY `mobiled`.`m_date` DESC");

if ($getMDPolicys->num_rows > 0) {
    for ($counter = 0; $dataMDPolicys = $getMDPolicys->fetch_assoc(); $counter++) {
        echo "<tr onclick='getMDPolicysDetails({$dataMDPolicys['m_id']});'>";
        echo "<td>" . ($counter + 1) . "</td>";
        echo "<td>" . $dataMDPolicys["M_fname"] . " " . $dataMDPolicys["M_lname"] . "</td>";
        echo "<td>" . $dataMDPolicys["M_contact"] . "</td>";
        echo "<td>" . $dataMDPolicys["m_date"] . "</td>";
        echo "<td>" . $dataMDPolicys["plane"] . "</td>";
        echo "<td>" . $dataMDPolicys["ammount"] . "</td>";
        if($dataMDPolicys["assignStatus"] == 0){
            echo "<td><span class='badge text-bg-danger'>Not Assigned</span></td>";
          }else if($dataMDPolicys["assignStatus"] == 1){
            echo "<td><span class='badge text-bg-success'>Assigned</span></td>";
          }
        echo "</tr>";
    }

    // Fetch totals for the selected date
    $mcfpResult = Database::search("SELECT SUM(`ammount`) AS total FROM `mobiled` WHERE `m_date` = '$indate' AND `plans_p_id` IN (1,2,4)");
    $mcfp = $mcfpResult->fetch_assoc()["total"] ?? 0;

    $fpResult = Database::search("SELECT SUM(`ammount`) AS total FROM `mobiled` WHERE `m_date` = '$indate' AND `plans_p_id` IN (3,5)");
    $fp = $fpResult->fetch_assoc()["total"] ?? 0;

    $nopsResult = Database::search("SELECT COUNT(*) AS count FROM `mobiled` WHERE `m_date` = '$indate'");
    $nops = $nopsResult->fetch_assoc()["count"] ?? 0;

    $grandTotal = $mcfp + $fp;

    $datetime = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$today = $datetime->format('Y-m-d');

if($indate !== $today){
    echo "<tr class='table-active fw-bold text-end'>";
    echo "<td colspan='7'>";
    echo "MCFP: " . number_format($mcfp, 2) . " /= &nbsp;&nbsp; | ";
    echo "FP: " . number_format($fp, 2) . " /= &nbsp;&nbsp; | ";
    echo "NOPS: " . $nops . " &nbsp;&nbsp; | ";
    echo "Total: " . number_format($grandTotal, 2) . " /=";
    echo "</td>";
    echo "</tr>";


}



    
} else {
    echo "<tr><td colspan='7' class='text-center text-muted fw-bold'>NO CUSTOMER LEADS</td></tr>";
}
