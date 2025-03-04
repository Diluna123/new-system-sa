<?php
include "connection.php";
session_start();
$uid = $_SESSION['user']['u_id'];


$date = date('Y-m-d');
$dataForTot = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '$uid' AND `status_s_id`!='3' AND `date`= '$date'");
$dataForTotPending = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '$uid' AND `status_s_id`='2' AND `date`= '$date'");
$dataForTotClosed = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '$uid' AND `status_s_id`='1' AND `date`= '$date'");

$dateYearMonth = date('Y-m');
// $dataForTotMonth = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '$uid' AND `status_s_id`='1' AND  DATE_FORMAT(`date`, '%Y-%m') = '$dateYearMonth'");
$dataForTotMonth = Database::search("
    SELECT * FROM `police_t` 
    WHERE `users_u_id` = '$uid' 
    AND `status_s_id` = '1' 
    AND DATE_FORMAT(`date`, '%Y-%m') = '$dateYearMonth'
");


$dataForTotNum =$dataForTot->num_rows;
$dataForTotNumPending =$dataForTotPending->num_rows;
$dataForTotNumClosed =$dataForTotClosed->num_rows;

$dataForTotMonthNum = $dataForTotMonth->num_rows;




?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Policies</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
            <svg class="bi">
                <use xlink:href="#calendar3" />
            </svg>
            This week
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-4 col-4 mt-2">
        <div class="card bg-success">
            <div class="card-body">
                <small>D.Total: </small>
                <?php
                if($dataForTotNum > 0){
                    $totalDaily = 0;

                    for($i=0;$i<$dataForTotNum;$i++){

                        $dataFortot = $dataForTot->fetch_assoc();

                        $totalDaily += $dataFortot['ammount'];

                        
                    }

                    ?>
                    <div>
                        <label for="" class="form-labe fw-bold"> <?php echo $totalDaily?></label>

                    </div>

                    
                    <?php


                }
                else{

                    ?>
                    <div>
                        <label for="" class="form-labe fw-bold"> 0/=</label>

                    </div>
                    
                    <?php
                }
                
                ?>
              
                

            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-4 col-4 mt-2">
        <div class="card bg-danger">
            <div class="card-body">
                <small>Pandings: </small>
                <?php
                if($dataForTotNumPending > 0){
                    $totalDailypending = 0;

                    for($i=0;$i<$dataForTotNumPending;$i++){

                        $dataFortotpending = $dataForTotPending->fetch_assoc();

                        $totalDailypending += $dataFortotpending['ammount'];

                        
                    }

                    ?>
                    <div>
                        <label for="" class="form-labe fw-bold"> <?php echo $totalDailypending?></label>

                    </div>

                    
                    <?php


                }
                else{

                    ?>
                    <div>
                        <label for="" class="form-labe fw-bold"> 0/=</label>

                    </div>
                    
                    <?php
                }
                
                ?>
              
                
                
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-4 col-4 mt-2">
        <div class="card bg-info">
            <div class="card-body">
                <small>Closed: </small>
                <?php
                if($dataForTotNumClosed > 0){
                    $totalDailyclosed = 0;

                    for($i=0;$i<$dataForTotNumClosed;$i++){

                        $dataFortotclosed = $dataForTotClosed->fetch_assoc();

                        $totalDailyclosed += $dataFortotclosed['ammount'];

                        
                    }

                    ?>
                    <div>

                        <label for="" class="form-labe fw-bold"> <?php echo $totalDailyclosed?></label>
                    </div>

                    
                    <?php


                }
                else{

                    ?>
                    <div>
                        <label for="" class="form-labe fw-bold"> 0/=</label>

                    </div>
                    
                    <?php
                }
                
                ?>
            
                


            </div>
        </div>

    </div>
    <div class="col-lg-3 col-md-4 col-sm-4 col-4 mt-2">
        <div class="card bg-warning">
            <div class="card-body text-dark">
                <small>M. Total: </small>
                <?php
                $totalMonthly = 0;

                if($dataForTotMonthNum > 0){

                    for($i=0;$i<$dataForTotMonthNum;$i++){

                        $dataFortotMonth = $dataForTotMonth->fetch_assoc();

                        $totalMonthly += $dataFortotMonth['ammount'];


                    }
                    ?>
                    <div>
                        <label for="" class="form-labe fw-bold"> <?php echo $totalMonthly ?></label>

                    </div>

                    
                    <?php


                }
                else{
                    ?>
                    <div>
                        <label for="" class="form-labe fw-bold"> 0</label>

                    </div>
                    
                    <?php


                }
                


                
                ?>
               
                


            </div>
        </div>

    </div>
    <div class="col-lg-3 col-md-4 col-sm-4 col-4 mt-2">
        <div class="card">
            <div class="card-body">
                <small>MCFP: </small>
                
                <label for="" class="form-labe fw-bold"> 200000/=</label>

            </div>
        </div>

    </div>
    <div class="col-lg-3 col-md-4 col-sm-4 col-4 mt-2">
        <div class="card">
            <div class="card-body">
                <small>FP: </small>
               
                <label for="" class="form-labe fw-bold"> 200000/=</label>

            </div>
        </div>

    </div>

</div>
<button class="btn btn-sm btn-outline-secondary text-warning mt-2 mb-3" onclick="showModal();">Add New &nbsp<i class="fas fa-plus"></i></button>

<h2>Pending Policies</h2>
<div class="table-responsive small mb-3">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First N</th>
                <th scope="col">NIC</th>
                <th scope="col">Contact</th>
                <th scope="col">Plane</th>
                <th scope="col">Ammount</th>
            </tr>
        </thead>
        <tbody>
            <?php


            
            $ppolicies = Database::search("SELECT * FROM `customers` JOIN `police_t` ON `customers`.`id` = `police_t`.`customers_id` JOIN `plans` ON `plans`.`p_id` = `police_t`.`plans_p_id` JOIN `payments` ON `payments`.`pay_id` = `police_t`.`payments_pay_id` JOIN `users` ON `users`.`u_id` =`police_t`.`users_u_id` WHERE `police_t`.`users_u_id` ='$uid' AND `police_t`.`status_s_id`='2' ORDER BY `customers`.`id` DESC");
            if ($ppolicies->num_rows > 0) {
                for ($i = 0; $i < $ppolicies->num_rows; $i++) {
                    $datap = $ppolicies->fetch_assoc();
            ?>
                    <tr onclick="showCanvasModal(<?php echo $datap['id'] ?>);">
                        <td>0<?php echo $i + 1 ?></td>
                        <td><?php echo $datap['fname'] ?></td>
                        <td><?php echo $datap['nic'] ?></td>
                        <td><?php echo $datap['contact'] ?></td>
                        <td><?php echo $datap['plane'] ?></td>
                        <td>Rs. <?php echo $datap['ammount'] ?></td>
                    </tr>


                <?php



                }
            } else {
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>No Pending Policies</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>


            <?php
            }



            ?>

        </tbody>
    </table>
</div>

<h2>Previous Policies</h2>
<div id="policiesTable">
    <div class="table-responsive small">
        <table class="table table-striped table-sm table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First N</th>
                    <th scope="col">NIC</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Plane</th>
                    <th scope="col">Ammount</th>
                </tr>
            </thead>
            <tbody>
                <?php




                $policies = Database::search("SELECT * FROM `customers` JOIN `police_t` ON `customers`.`id` = `police_t`.`customers_id` JOIN `plans` ON `plans`.`p_id` = `police_t`.`plans_p_id` JOIN `payments` ON `payments`.`pay_id` = `police_t`.`payments_pay_id` JOIN `users` ON `users`.`u_id` =`police_t`.`users_u_id` WHERE `police_t`.`users_u_id` ='$uid' AND `police_t`.`status_s_id`='1' ORDER BY `customers`.`id` DESC");
                if ($policies->num_rows > 0) {
                    for ($i = 0; $i < $policies->num_rows; $i++) {
                        $data = $policies->fetch_assoc();
                ?>
                        <tr onclick="showCanvasModal(<?php echo $data['id'] ?>);">
                            <td>0<?php echo $i + 1 ?></td>
                            <td><?php echo $data['fname'] ?></td>
                            <td><?php echo $data['nic'] ?></td>
                            <td><?php echo $data['contact'] ?></td>
                            <td><?php echo $data['plane'] ?></td>
                            <td>Rs. <?php echo $data['ammount'] ?></td>


                        </tr>


                    <?php



                    }
                } else {
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>No Active Policies</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>



                <?php
                }




                ?>



            </tbody>
        </table>
    </div>
</div>



<!-- add new customr modal begin -->
<div class="modal fade" tabindex="-1" id="addNewModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="con ">
                    <div class="row mb-2">
                        <!-- personal info begin -->
                        <div class="col-12">
                            <label for="" class="form-label">Date : <span class="text-danger">*</span></label>
                            <input type="date" id="date" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>">

                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="" class="form-label">First Name : <span class="text-danger">*</span></label>
                            <input type="text" id="fname" class="form-control form-control-sm">

                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Last Name :</label>
                            <input type="text" id="lname" class="form-control form-control-sm">

                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col-8">
                            <label for="" class="form-label">NIC Number : </label>
                            <input type="text" id="nic" class="form-control form-control-sm">
                        </div>
                        <div class="col-4">
                            <label for="" class="form-label">Age : <span class="text-danger">*</span></label>
                            <input type="text" id="age" class="form-control form-control-sm">
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div>
                            <label for="" class="form-label">DOB: <span class="text-danger">*</span></label>
                            <input type="date" id="dob" class="form-control form-control-sm">
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div>
                            <label for="" class="form-label">Contact Number : <span class="text-danger">*</span></label>
                            <input type="number" id="contact" class="form-control form-control-sm">
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div>
                            <label for="" class="form-label">Address : <span class="text-danger">*</span></label>
                            <input type="text" id="address" class="form-control form-control-sm">
                        </div>
                        <!-- personal info end and plane info begin -->
                    </div>
                    <div class="row mb-2">
                        <div>
                            <label for="" class="form-label">Plane : <span class="text-danger">*</span></label>

                            <select class="form-control form-control-sm" id="plane">
                                <?php
                                $pldata = Database::search("SELECT * FROM `plans`");
                                for ($i = 0; $i < $pldata->num_rows; $i++) {
                                    $row = $pldata->fetch_assoc();
                                ?>
                                    <option value="<?php echo $row['p_id']; ?>"><?php echo $row['plane']; ?></option>


                                <?php
                                }


                                ?>


                            </select>
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div>
                            <label for="" class="form-label">Payment Type : <span class="text-danger">*</span></label>

                            <select class="form-control form-control-sm" id="payment">
                                <?php
                                $padata = Database::search("SELECT * FROM `payments`");
                                for ($i = 0; $i < $padata->num_rows; $i++) {
                                    $row2 = $padata->fetch_assoc();
                                ?>
                                    <option value="<?php echo $row2['pay_id']; ?>"><?php echo $row2['payment_ty']; ?></option>


                                <?php
                                }


                                ?>

                            </select>
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div>
                            <label for="" class="form-label">Ammount : <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Rs.</span>
                                <input type="number" id="ammount" class="form-control form-control-sm">

                            </div>

                        </div>

                    </div>
                    <div class="row mb-2">
                        <div>
                            <label for="" class="form-label">Time Period : <span class="text-danger">*</span></label>
                            <input type="number" id="timep" class="form-control form-control-sm" minimum="5">

                        </div>

                    </div>
                    <div class="row mb-2">
                        <div>
                            <label for="" class="form-label">Note : </label>
                            <textarea type="text" id="note" class="form-control form-control-sm" cols="5" rows="5"></textarea>
                        </div>

                    </div>
                    <div class="row mb-2">
                        <label for="" class="form-label">Location :<span class="text-danger"> *</span></label>
                        <div class="col-12" onclick="getLocation();">

                            <input type="text" class="form-control form-control-sm" id="locText">

                        </div>


                    </div>


                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-warning btn-sm" onclick="submitBtn();">Confirm</button>
            </div>
        </div>
    </div>
</div>
<!-- complete modal(police number and proposel number enter modal) -->

<div class="modal fade" id="proposalModal" data-bs-backdrop="modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Completion</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="" class="form-label d-none" id="cidStore"></label>
                <div class="row mt-3 mb-3">
                    <div class="col-6">
                        <label for="" class="form-label">Proposal Number : <span class="text-danger">*</span></label>
                        <input type="number" id="proNum" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">Police Number : </label>
                        <input type="number" id="polNum" class="form-control form-control-sm">
                    </div>
                </div>

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-warning" onclick="submitProposal(); ">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- complete modal -->

<!-- nic preview modal begin -->
<div class="modal fade" id="nicModal" tabindex="-1" aria-labelledby="nicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nicModalLabel">NIC PDF Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="nicPreviewFrame" src="" width="100%" height="500px"></iframe>
            </div>
        </div>
    </div>
</div>





<!-- offcanves begin -->

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" style="width: 400px">


</div>







<?php







































?>