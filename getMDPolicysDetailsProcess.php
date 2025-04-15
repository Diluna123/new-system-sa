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

?>

        <div class="row mb-2">
            <div class="col-12">
                <div>
                    <label for="" class="form-label">Customer Name :</label>

                </div>
                <div>
                    <label for="" class="text-secondary"><?php echo $dataMDPolicysDetails['M_fname'] . ' ' . $dataMDPolicysDetails['M_lname']; ?></label>
                </div>

            </div>

        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div>
                    <label for="" class="form-label">Contact Number :</label>

                </div>
                <div>
                    <label for="" class="text-secondary"><a href="tel:<?php echo $dataMDPolicysDetails['M_contact'] ?>" class="text-decoration-none"><?php echo $dataMDPolicysDetails['M_contact'] ?></a></label>
                </div>

            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">
                <div>
                    <label for="" class="form-label">Plane Type :</label>

                </div>
                <div>
                    <label for="" class="text-secondary"><?php echo $dataMDPolicysDetails['plane'] ?></label>
                </div>

            </div>
            <div class="col-6">
                <div>
                    <label for="" class="form-label">Payment Type :</label>

                </div>
                <div>
                    <label for="" class="text-secondary"><?php echo $dataMDPolicysDetails['payment_ty'] ?></label>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div>
                    <label for="" class="form-label">Ammount :</label>

                </div>
                <div>
                    <label for="" class="text-secondary">Rs. <?php echo $dataMDPolicysDetails['ammount'] ?>.00</label>
                </div>

            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div>
                    <label for="" class="form-label">Location :</label>

                </div>
                <div>
                    <label for="" class="text-secondary"><a href="<?php echo $dataMDPolicysDetails['loca'] ?>" class="text-decoration-none"><?php echo $dataMDPolicysDetails['loca'] ?></a></label>
                </div>

            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-12 text-center">
                <div>
                    <label for="" class="form-label">Added User</label>

                </div>
                <div>
                    <label for="" class="text-secondary"><?php echo $dataMDPolicysDetails['u_fname'] . ' ' . $dataMDPolicysDetails['u_lname']; ?></label>
                </div>

            </div>
        </div>
        <hr>
        <div class="row mt-3">
            <?php if ($dataMDPolicysDetails['assignStatus'] == 0) {
            ?>
                <div class="col-12 text-center">
                    <button class="btn btn-outline-warning btn-sm" onclick="policyAssign(<?php echo $cid; ?>);">Transfer to My Policies</button>
                </div>
                

            <?php


            }else{
                ?>
                <div class="col-12 text-center">
                    <small class="text-danger-emphasis">** This Policy is already Assigned for another User **</small>
                </div>
                <?php
            }


            ?>
            



            </div>



    <?php










    } else {
        echo "No details found for the given ID";
    }
}









    ?>