<?php

include 'connection.php';
session_start();

$planType = $_POST['planTy'];
$fdate = $_POST['fdate'];
$tdate = $_POST['tdate'];


if ($planType == "MCFP") {

?>

    <table class="table table-striped table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Proposal/ Policy</th>
                <th scope="col">Date</th>
                <th scope="col">MCFP</th>

            </tr>
        </thead>
        <tbody>
            <?php

            if (!empty($fdate)) {

                if (!empty($tdate)) {
                    $rDataP = Database::search("SELECT * FROM `police_t` 
                    WHERE `users_u_id` = '" . $_SESSION['user']['u_id'] . "' 
                    AND `status_s_id` = '1' AND (`payments_pay_id`='1'OR `payments_pay_id`='2' OR `payments_pay_id`='4')  
                    AND DATE_FORMAT(`date`, '%Y-%m') BETWEEN '$fdate' AND '$tdate'");




                } else {
                    $rDataP = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '" . $_SESSION['user']['u_id'] . "' AND `status_s_id` = '1' AND (`payments_pay_id`='1'OR `payments_pay_id`='2' OR `payments_pay_id`='4') AND `date` LIKE '%$fdate%'");
                }
            } else {
                $rDataP = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '" . $_SESSION['user']['u_id'] . "' AND `status_s_id` = '1' AND (`payments_pay_id`='1'OR `payments_pay_id`='2' OR `payments_pay_id`='4')");
            }

            $rDataPCount = $rDataP->num_rows;
            $totalMCFP = 0;
            $totalFP = 0;

            if ($rDataPCount == 0) {
                echo '<tr><td colspan="5" class="text-center">No data found</td></tr>';
            } else {
                for ($i = 0; $i < $rDataPCount; $i++) {
                    $rDataPData = $rDataP->fetch_assoc();
            ?>
                    <tr>
                        <th scope="row"><?php echo $i + 1; ?></th>
                        <td> <?php echo $rDataPData['pro_num']; ?> / <?php echo $rDataPData['pol_num']; ?></td>
                        <td><?php echo $rDataPData['date']; ?></td>
                        <?php
                        if ($rDataPData['payments_pay_id'] == '1' || $rDataPData['payments_pay_id'] == '2' || $rDataPData['payments_pay_id'] == '4') {
                            $totalMCFP += $rDataPData['ammount'];
                        ?>
                            <td class="text-end"><?php echo $rDataPData['ammount']; ?></td>

                        <?php
                        } else {
                            $totalFP += $rDataPData['ammount'];
                        ?>


                        <?php
                        }
                        ?>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-start text-warning-emphasis">Sub Total:</th>
                <th class="text-warning text-end"><?php echo $totalMCFP; ?></th>

            </tr>
            <tr>
                <th colspan="3" class="text-start text-warning-emphasis">Total:</th>

                <th class="bg-warning-subtle text-end "><?php echo $totalMCFP + $totalFP; ?></th>

            </tr>
        </tfoot>
    </table>



<?php




} else if ($planType == "all") {
?>
    <table class="table table-striped table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Proposal/ Policy</th>
                <th scope="col">Date</th>
                <th scope="col">MCFP</th>
                <th scope="col">FP</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($fdate)) {
                if (!empty($tdate)) {
                    $rDataP = Database::search("SELECT * FROM `police_t` 
                    WHERE `users_u_id` = '" . $_SESSION['user']['u_id'] . "' 
                    AND `status_s_id` = '1' 
                    AND DATE_FORMAT(`date`, '%Y-%m') BETWEEN '$fdate' AND '$tdate'");
                } else {
                    $rDataP = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '" . $_SESSION['user']['u_id'] . "' AND `status_s_id` = '1' AND `date` LIKE '%$fdate%'");
                }
            } else {
                $rDataP = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '" . $_SESSION['user']['u_id'] . "' AND `status_s_id` = '1'");
            }

            $rDataPCount = $rDataP->num_rows;
            $totalMCFP = 0;
            $totalFP = 0;

            if ($rDataPCount == 0) {
                echo '<tr><td colspan="5" class="text-center">No data found</td></tr>';
            } else {
                for ($i = 0; $i < $rDataPCount; $i++) {
                    $rDataPData = $rDataP->fetch_assoc();
            ?>
                    <tr>
                        <th scope="row"><?php echo $i + 1; ?></th>
                        <td> <?php echo $rDataPData['pro_num']; ?> / <?php echo $rDataPData['pol_num']; ?></td>
                        <td><?php echo $rDataPData['date']; ?></td>
                        <?php
                        if ($rDataPData['payments_pay_id'] == '1' || $rDataPData['payments_pay_id'] == '2' || $rDataPData['payments_pay_id'] == '4') {
                            $totalMCFP += $rDataPData['ammount'];
                        ?>
                            <td class="text-end"><?php echo $rDataPData['ammount']; ?></td>
                            <td></td>
                        <?php
                        } else {
                            $totalFP += $rDataPData['ammount'];
                        ?>
                            <td></td>
                            <td class="text-end"><?php echo $rDataPData['ammount']; ?></td>
                        <?php
                        }
                        ?>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-start text-warning-emphasis">Sub Total:</th>
                <th class="text-warning text-end"><?php echo $totalMCFP; ?></th>
                <th class="text-warning text-end"><?php echo $totalFP; ?></th>
            </tr>
            <tr>
                <th colspan="3" class="text-start text-warning-emphasis">Total:</th>
                <th></th>
                <th class="bg-warning-subtle text-end "><?php echo $totalMCFP + $totalFP; ?></th>

            </tr>
        </tfoot>
    </table>


<?php
} else if ($planType == "FP") {

?>
    <table class="table table-striped table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Proposal/ Policy</th>
                <th scope="col">Date</th>
                <th scope="col">FP</th>

            </tr>
        </thead>
        <tbody>

            <?php
            if (!empty($fdate)) {
                if (!empty($tdate)) {
                    $rDataP = Database::search("SELECT * FROM `police_t` 
                    WHERE `users_u_id` = '" . $_SESSION['user']['u_id'] . "' 
                    AND `status_s_id` = '1' AND (`payments_pay_id`='3'OR `payments_pay_id`='5')   
                    AND DATE_FORMAT(`date`, '%Y-%m') BETWEEN '$fdate' AND '$tdate'");




                } else {
                $rDataP = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '" . $_SESSION['user']['u_id'] . "' AND `status_s_id` = '1' AND (`payments_pay_id`='3'OR `payments_pay_id`='5') AND `date` LIKE '%$fdate%'");
                    
                }


            } else {
                $rDataP = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '" . $_SESSION['user']['u_id'] . "' AND `status_s_id` = '1' AND (`payments_pay_id`='3'OR `payments_pay_id`='5')");
            }

            $rDataPCount = $rDataP->num_rows;
            $totalMCFP = 0;
            $totalFP = 0;

            if ($rDataPCount == 0) {
                echo '<tr><td colspan="5" class="text-center">No data found</td></tr>';
            } else {
                for ($i = 0; $i < $rDataPCount; $i++) {
                    $rDataPData = $rDataP->fetch_assoc();
            ?>
                    <tr>
                        <th scope="row"><?php echo $i + 1; ?></th>
                        <td> <?php echo $rDataPData['pro_num']; ?> / <?php echo $rDataPData['pol_num']; ?></td>
                        <td><?php echo $rDataPData['date']; ?></td>
                        <?php
                        if ($rDataPData['payments_pay_id'] == '1' || $rDataPData['payments_pay_id'] == '2' || $rDataPData['payments_pay_id'] == '4') {
                            $totalMCFP += $rDataPData['ammount'];
                        ?>
                            <td class="text-end"><?php echo $rDataPData['ammount']; ?></td>

                        <?php
                        } else {
                            $totalFP += $rDataPData['ammount'];

                        ?>
                            <td class="text-end"><?php echo $rDataPData['ammount']; ?></td>



                        <?php
                        }
                        ?>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-start text-warning-emphasis">Sub Total:</th>

                <th class="text-warning text-end"><?php echo $totalFP; ?></th>

            </tr>
            <tr>
                <th colspan="3" class="text-start text-warning-emphasis">Total:</th>

                <th class="bg-warning-subtle text-end "><?php echo $totalMCFP + $totalFP; ?></th>

            </tr>
        </tfoot>
    </table>


<?php
}

?>



<?php







?>