<?php
include 'connection.php';
$cid = $_GET['cid'];
$policies2 = Database::search("SELECT * FROM `customers` JOIN `police_t` ON `customers`.`id` = `police_t`.`customers_id` JOIN `plans` ON `plans`.`p_id` = `police_t`.`plans_p_id` JOIN `payments` ON `payments`.`pay_id` = `police_t`.`payments_pay_id` WHERE `customers`.`id` = $cid ");

$cAllData2 = $policies2->fetch_assoc();
?>

<!-- <div class="row h-100">
    <div class="col-12 d-flex flex-column justify-content-center align-items-center  ">
        <div class="" role="">
            <i class="fas fa-check fs-5 text-success"></i>
           
            
        </div>
        <div>
        <small class="text-success">Update Success</small>


        </div>
    </div>

</div> -->
<div class="row mb-2">

    <div class="col-6">
        <div>
            <label for="" class="form-label">Proposel Number :</label>
        </div>
        <div>
            <?php
            if ($cAllData2['pro_num'] == '') {
            ?>
                <input type="text" id="pro_numU" class="form-control form-control-sm">
            <?php

            } else {
            ?>

                <input type="text" id="pro_numU" class="form-control form-control-sm" value="<?php echo $cAllData2['pro_num']; ?>">
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
            if ($cAllData2['pol_num'] == '') {
            ?>
                <input type="text" id="pol_numU" class="form-control form-control-sm">
            <?php

            } else {
            ?>

                <input type="text" id="pol_numU" class="form-control form-control-sm" value="<?php echo $cAllData2['pol_num']; ?>">
            <?php
            }

            ?>
        </div>
    </div>

</div>

<div class="row mb-2">
    <small class="text-danger mb-1">**Edite and update customer details**</small>
    <div class="col-6">
        <label for="" class="form-label">First Name : <span class="text-danger">*</span></label>
        <input type="text" id="fnameU" class="form-control form-control-sm" value="<?php echo $cAllData2['fname']; ?>">

    </div>
    <div class="col-6">
        <label for="" class="form-label">Last Name :</label>
        <input type="text" id="lnameU" class="form-control form-control-sm" value="<?php echo $cAllData2['lname']; ?>">

    </div>

</div>
<div class="row mb-2">
    <div class="col-12">
        <div>
            <label for="" class="form-label">DOB : </label>

        </div>
        <div>

            <input type="date" id="dobU" class="form-control form-control-sm" value="<?php echo $cAllData2['dob']; ?>">



        </div>


    </div>

</div>
<div class="row mb-2">
    <div class="col-6">
        <div>
            <label for="" class="form-label">NIC Numebr : </label>

        </div>
        <div>
            <!-- <label for="" class="form-label text-secondary">200425502467</label> -->
            <input type="text" id="nicU" class="form-control form-control-sm" value="<?php echo $cAllData2['nic']; ?>">


        </div>

    </div>
    <div class="col-6">
        <div>
            <label for="" class="form-label">Age : </label>

        </div>
        <div>
            <input type="number" id="ageU" class="form-control form-control-sm" value="<?php echo $cAllData2['age']; ?>">
            <!-- <label for="" class="form-label text-secondary">20</label> -->

        </div>

    </div>

</div>
<div class="row mb-2">
    <div class="col-12">
        <div>
            <label for="" class="form-label">Contact Numebr : </label>

        </div>
        <div>
            <!-- <label for="" class="form-label text-secondary">0764393083</label> -->
            <input type="number" id="contactU" class="form-control form-control-sm" value="<?php echo $cAllData2['contact']; ?>">

        </div>

    </div>


</div>
<div class="row mb-2">
    <div class="col-6">
        <div>
            <label for="" class="form-label">Plane : </label>

        </div>
        <div>
            <select class="form-control form-control-sm" id="planeU">
                <?php
                $pldata = Database::search("SELECT * FROM `plans`");
                $planOps = '';
                for ($i = 0; $i < $pldata->num_rows; $i++) {
                    $row = $pldata->fetch_assoc();

                    $selected = ($cAllData2["plans_p_id"] == $row["p_id"]) ? 'selected' : '';
                    $planOps .= "<option value='{$row["p_id"]}' {$selected}>{$row["plane"]}</option>";
                ?>



                <?php
                }



                ?>
                <?php echo $planOps; ?>


            </select>

        </div>

    </div>
    <div class="col-6">
        <div>
            <label for="" class="form-label">Payment Type : </label>

        </div>
        <div>
            <select class="form-control form-control-sm" id="paymentU">
                <?php
                $padata = Database::search("SELECT * FROM `payments`");
                $paymentsOps = '';
                for ($i = 0; $i < $padata->num_rows; $i++) {
                    $row2 = $padata->fetch_assoc();

                    $selected = ($cAllData2["payments_pay_id"] == $row2["pay_id"]) ? 'selected' : '';
                    $paymentsOps .= "<option value='{$row2["pay_id"]}' {$selected}>{$row2["payment_ty"]}</option>";
                ?>



                <?php
                }



                ?>
                <?php echo $paymentsOps; ?>

            </select>

        </div>

    </div>


</div>
<div class="row mb-2">
    <div class="col-6">
        <div>
            <label for="" class="form-label">Ammount : </label>

        </div>
        <div>
            <!-- <label for="" class="form-label text-secondary">Rs. 500 /=</label> -->
            <div class="input-group input-group-sm">
                <span class="input-group-text">Rs.</span>
                <input type="number" class="form-control form-control-sm" id="ammountU" value="<?php echo $cAllData2['ammount']; ?>">

            </div>

        </div>

    </div>
    <div class="col-6">
        <div>
            <label for="" class="form-label">Time Period : </label>

        </div>
        <div>
            <!-- <label for="" class="form-label text-secondary">10 years</label> -->
            <input type="text" class="form-control form-control-sm" id="timepU" value="<?php echo $cAllData2['time_p']; ?>">

        </div>

    </div>



</div>
<div class="row mb-2">
    <div class="col-12">
        <div>
            <label for="" class="form-label">Address : </label>

        </div>
        <div>
            <input type="text" id="addresU" class="form-control form-control-sm" value="<?php echo $cAllData2['addres']; ?>">


        </div>

    </div>
</div>
<div class="row">
    <div class="col-12">
        <div>
            <label for="" class="form-label">Location : </label>

        </div>
        <div>
            <label for="" class="form-label text-secondary"><?php echo $cAllData2['location']; ?></label>

        </div>

    </div>



</div>
<div class="row mb-2">
    <div class="col-12">
        <div>
            <label for="" class="form-label">Notes : </label>

        </div>
        <div>
            <!-- <label for="" class="form-label text-secondary">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Rem, vel.</label> -->
            <textarea type="text" class="form-control form-control-sm" cols="5" rows="5" id="noteU"><?php echo $cAllData2['notes']; ?></textarea>

        </div>

    </div>



</div>
<!-- <div class="row">
    <div>
        <label for="" class="form-label">NIC PDF :</label>
    </div>
    <div class="col-12">
        <input type="file" class="form-control form-control-sm" accept=".pdf">
        <small class="form-text text-muted">Only PDF files are allowed.</small>


    </div>

</div> -->
<div class="row mt-4">
    <div class="col-12 d-flex justify-content-center">
        <button class="btn btn-sm btn-warning col-5" onclick="updateCustomer(<?php echo $cAllData2['id']; ?>);">Update</button>


    </div>
</div>






<?php




















?>