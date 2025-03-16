<?php


include 'connection.php';
session_start();
$uid = $_SESSION['user']['u_id'];

$clid = $_GET['clid'];


$data = Database::search("SELECT * FROM `c_leads` WHERE `clid` = '$clid'");

if ($data->num_rows > 0) {
    $data = $data->fetch_assoc();

    if($data['status_s_id'] == 5){
        Database::iud("UPDATE `c_leads` SET `status_s_id` = '4' WHERE `c_leads`.`clid` = $clid ");


    }

?>
    <div class="mb-2">
        <?php

        if ($data['status_s_id'] == 4 OR $data['status_s_id'] == 5) {
        ?>
            <span class="badge text-bg-warning">Pending</span>
        <?php
        }else if($data['status_s_id'] == 1){
            ?>
            <span class="badge text-bg-success">Closed</span>
        <?php
            
        }
        
        
        ?>
        
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <div>
                <label for="" class="form-label">Contact Number: </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><a href="tel:<?php echo $data['contact_cl']; ?>" class="text-warning text-decoration-none"><?php echo $data['contact_cl']; ?></a></label>
            </div>
        </div>



    </div>
    <div class="row mb-2">
        <div class="col-6">
            <div>
                <label for="" class="form-label">Cutomer Name: </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><?php echo $data['cname']; ?></label>
            </div>
        </div>
        <div class="col-6">
            <div>
                <label for="" class="form-label">Shop Name: </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><?php echo $data['sh_name']; ?></label>
            </div>


        </div>

    </div>
    <div class="row mb-2">
        <div class="col-12">
            <div>
                <label for="" class="form-label">Location : </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><?php echo $data['loc_cl']; ?></label>
            </div>
        </div>



    </div>
    <div class="row mb-2">
        <div class="col-12">
            <div>
                <label for="" class="form-label">Date : </label>

            </div>
            <div>
                <label for="" class="form-label text-secondary"><?php echo $data['date_cl']; ?></label>
            </div>
        </div>



    </div>

    <div class="row mt-4">
        <div class="col-6">
            <div class="d-grid">
                <button class="btn btn-sm btn-danger" data-bs-dismiss="offcanvas" onclick="leadsUpdate('<?php echo $clid; ?>','2');">Delete</button>
            </div>
        </div>
        <div class="col-6">
            <div class="d-grid">
                <button class="btn btn-sm btn-success" data-bs-dismiss="offcanvas" onclick="leadsUpdate('<?php echo $clid; ?>','1');">Success</button>
            </div>
        </div>
    </div>




<?php






} else {
?>




<?php



}




?>