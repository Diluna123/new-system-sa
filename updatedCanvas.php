<?php
include 'connection.php';
$cid = $_GET['cid'];

$policies = Database::search("SELECT * FROM `customers` JOIN `police_t` ON `customers`.`id` = `police_t`.`customers_id` JOIN `plans` ON `plans`.`p_id` = `police_t`.`plans_p_id` JOIN `payments` ON `payments`.`pay_id` = `police_t`.`payments_pay_id` WHERE `customers`.`id` = $cid ");

$cAllData = $policies->fetch_assoc();

?>

<div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">Customer Details <button class="btn btn-sm btn-warning border-0" onclick="editCustomer(<?php echo $cAllData['id']; ?>);"> <i class="bi bi-pencil-square"></i></button> </h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body" id="customerDetailsCanvasBody">
    
    <div class="mb-2">
        <?php
        if ($cAllData['payments_pay_id'] == 3) {
        ?>
            <span class="badge text-bg-success">FP</span>

        <?php
        } else {
        ?>
            <span class="badge text-bg-warning">MCFP</span>

        <?php
        }



        ?>
        <?php
        if ($cAllData['status_s_id'] == 1) {
        ?>
            <span class="badge text-bg-primary">Closed</span>
        <?php
        } else {
        ?>
            <span class="badge text-bg-secondary">Incomplete</span>

        <?php
        }
        ?>

        <!--  -->

    </div>
    <div class="row">
        <div class="col-12">
            <div>
                <label for="" class="form-label">Date : </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><?php echo $cAllData['date']; ?> </label>

            </div>


        </div>

    </div>
    <div class="row">

        <div class="col-6">
            <div>
                <label for="" class="form-label">Proposel Number :</label>
            </div>
            <div>
                <?php
                if ($cAllData['pro_num'] == '') {
                ?>
                    <label for="" class="form-label text-secondary"></label>
                <?php

                } else {
                ?>
                    <label for="" class="form-label text-secondary"><?php echo $cAllData['pro_num']; ?></label>
                <?php
                }

                ?>

            </div>
        </div>
        <div class="col-6">
            <div>
                <label for="" class="form-label">Police Number :</label>
            </div>
            <div>
                <?php
                if ($cAllData['pol_num'] == '') {
                ?>
                    <label for="" class="form-label text-secondary"></label>
                <?php

                } else {
                ?>
                    <label for="" class="form-label text-secondary"><?php echo $cAllData['pol_num']; ?></label>
                <?php
                }

                ?>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div>
                <label for="" class="form-label">Full name : </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><?php echo $cAllData['fname']; ?> <?php echo $cAllData['lname']; ?></label>

            </div>


        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <div>
                <label for="" class="form-label">DOB : </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><?php echo $cAllData['dob']; ?></label>

            </div>


        </div>

    </div>
    <div class="row">
        <div class="col-6">
            <div>
                <label for="" class="form-label">NIC Numebr : <button class="btn btn-sm btn-outline-warning" onclick="nicModalOpen(<?php echo $cAllData['id']; ?>);"><i class="fas fa-eye"></i></button></label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><?php echo $cAllData['nic']; ?> </label>

            </div>

        </div>
        <div class="col-6">
            <div>
                <label for="" class="form-label">Age : </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><?php echo $cAllData['age']; ?></label>

            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <div>
                <label for="" class="form-label">Contact Numebr : </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><a href="tel:<?php echo $cAllData['contact']; ?>"><?php echo $cAllData['contact']; ?></a> </label>

            </div>

        </div>


    </div>
    <div class="row">
        <div class="col-6">
            <div>
                <label for="" class="form-label">Plane : </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><?php echo $cAllData['plane']; ?> </label>

            </div>

        </div>
        <div class="col-6">
            <div>
                <label for="" class="form-label">Payment Type : </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><?php echo $cAllData['payment_ty']; ?> </label>

            </div>

        </div>


    </div>
    <div class="row">
        <div class="col-6">
            <div>
                <label for="" class="form-label">Ammount : </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary">Rs. <?php echo $cAllData['ammount']; ?> /=</label>

            </div>

        </div>
        <div class="col-6">
            <div>
                <label for="" class="form-label">Time Period : </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><?php echo $cAllData['time_p']; ?></label>

            </div>

        </div>



    </div>
    <div class="row">
        <div class="col-12">
            <div>
                <label for="" class="form-label">Address : </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><?php echo $cAllData['addres']; ?></label>

            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div>
                <label for="" class="form-label">Location : </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><a href="<?php echo $cAllData['location']; ?>"><?php echo $cAllData['location']; ?></a></label>

            </div>

        </div>



    </div>
    <div class="row">
        <div class="col-12">
            <div>
                <label for="" class="form-label">Notes : </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><?php echo $cAllData['notes']; ?></label>

            </div>

        </div>



    </div>
    <div class="row">
        <div>
            <label for="" class="form-label">NIC PDF :</label>
        </div>
        <div class="col-10">
            <input type="file" class="form-control form-control-sm" accept=".pdf" id="nicP">
            <small class="form-text text-muted">Only PDF files are allowed.</small>


        </div>
        <div class="col-2">
            <div class="d-grid">
                <button class="btn btn-sm btn-outline-warning" onclick="uploadNic(<?php echo $cAllData['id']; ?>);"><i class="fas fa-upload"></i></button>

            </div>
            
        </div>

    </div>
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
            <?php
            if ($cAllData['status_s_id'] == 2) {
            ?>
                <button class="btn btn-sm btn-warning col-3" onclick="showCModal(<?php echo $cAllData['id']; ?>, 1);">Close</button>
                <button class="btn btn-sm btn-outline-success col-3 ms-2">Send</button>
                <button class="btn btn-sm btn-danger col-3 ms-2" onclick="deletePol(<?php echo $cAllData['id']; ?>);">Delete</button>
            <?php


            } else {
            ?>
                <button class="btn btn-sm btn-danger col-3" onclick="deletePol(<?php echo $cAllData['id']; ?>);">Delete</button>
                <button class="btn btn-sm btn-outline-success col-3 ms-2">Send</button>

            <?php
            }


            ?>


        </div>
    </div>




</div>







<?php






?>