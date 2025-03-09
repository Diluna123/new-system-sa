<?php
include 'connection.php';
session_start();
$uid = $_SESSION['user']['u_id'];
$teamid = $_SESSION['user']['teams_tid'];

$date = "";


$cont = $_POST['contact'];
$date = $_POST['date'];


if (empty($date)) {
    $getLData = Database::search("SELECT * FROM `c_leads` WHERE `contact_cl` LIKE '%$cont%' AND  `teams_tid` = '$teamid' AND  `status_s_id` != '3'  ORDER BY `date_cl` DESC");
} else {
    $getLData = Database::search("SELECT * FROM `c_leads` WHERE `contact_cl` LIKE '%$cont%' AND  `teams_tid` = '$teamid' AND `date_cl` = '$date' AND  `status_s_id` != '3'  ORDER BY `date_cl` DESC");
}




if ($getLData->num_rows > 0) {
    for ($i = 0; $i < $getLData->num_rows; $i++) {
        $dataCl = $getLData->fetch_assoc();

?>

        <tr onclick="leadsOffcanvas(<?php echo $dataCl['clid']; ?>);">
            <td><?php echo $i + 1 ?></td>
            <td><?php echo $dataCl['cname']; ?></td>
            <td><?php echo $dataCl['contact_cl']; ?></td>
            <td><?php echo $dataCl['date_cl']; ?></td>
            <td>
                <?php

                if ($dataCl['status_s_id'] == 5) {
                    echo "<span class='badge text-bg-primary'>New</span> ";
                } else if ($dataCl['status_s_id'] == 4) {
                    echo "<span class='badge text-bg-warning'>Pending</span> ";
                } else if ($dataCl['status_s_id'] == 1) {
                    echo "<span class='badge text-bg-success'>Closed</span> ";
                }

                ?>

            </td>

        </tr>

    <?php

    }
} else {

    ?>
    <tr class="text-center">
        <td colspan="5" class="fw-bold text-muted">NO CUSTOMER LEADS</td>
    </tr>


<?php
}
?>