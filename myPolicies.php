<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <script src="/assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Sanasa Easy</title>
    <link rel="icon" type="image/png" href="sansalogo.png">



    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">
    <link rel="manifest" href="manifest.json">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <?php include "connection.php";
    session_start();

    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">




    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/kute.js@2.2.4/dist/kute.min.js"></script>
</head>

<body>
    <?php


    if (isset($_SESSION['user'])) {

    ?>
        <?php include 'logos.php';?>

        <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">SANASA LIFE</a>

            <ul class="navbar-nav flex-row d-md-none">
                <li class="nav-item text-nowrap">
                    <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
                        <svg class="bi">
                            <use xlink:href="#search" />
                        </svg>
                    </button>
                </li>
                <li class="nav-item text-nowrap">
                    <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <svg class="bi">
                            <use xlink:href="#list" />
                        </svg>
                    </button>
                </li>
            </ul>

            <div id="navbarSearch" class="navbar-search w-100 collapse">
                <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
            </div>
        </header>

        <div class="container-fluid">
            <div class="row">
                <?php include 'sideMenu.php'; ?>


                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="main-dev">
                    <?php

                    $uid = $_SESSION['user']['u_id'];


                    $d = new DateTime();
                    $tz = new DateTimeZone("Asia/Colombo");
                    $d->setTimezone($tz);
                    $currentdate = $d->format("Y-m-d");


                    $dataForTot = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '$uid' AND `status_s_id`!='3' AND `date`= '$currentdate'");
                    $dataForTotPending = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '$uid' AND `status_s_id`='2' AND `date`= '$currentdate'");
                    $dataForTotClosed = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '$uid' AND `status_s_id`='1' AND `date`= '$currentdate'");

                    $currentMonth = $d->format("Y-m");
                    // $dataForTotMonth = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '$uid' AND `status_s_id`='1' AND  DATE_FORMAT(`date`, '%Y-%m') = '$dateYearMonth'");
                    $dataForTotMonth = Database::search("
    SELECT * FROM `police_t` 
    WHERE `users_u_id` = '$uid' 
    AND `status_s_id` = '1' 
    AND DATE_FORMAT(`date`, '%Y-%m') = '$currentMonth'
");


                    $dataForTotNum = $dataForTot->num_rows;
                    $dataForTotNumPending = $dataForTotPending->num_rows;
                    $dataForTotNumClosed = $dataForTotClosed->num_rows;

                    $dataForTotMonthNum = $dataForTotMonth->num_rows;




                    ?>
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">My Policies</h1>
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
                                    if ($dataForTotNum > 0) {
                                        $totalDaily = 0;

                                        for ($i = 0; $i < $dataForTotNum; $i++) {

                                            $dataFortot = $dataForTot->fetch_assoc();

                                            $totalDaily += $dataFortot['ammount'];
                                        }

                                    ?>
                                        <div>
                                            <label for="" class="form-labe fw-bold"> <?php echo $totalDaily ?></label>

                                        </div>


                                    <?php


                                    } else {

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
                                    if ($dataForTotNumPending > 0) {
                                        $totalDailypending = 0;

                                        for ($i = 0; $i < $dataForTotNumPending; $i++) {

                                            $dataFortotpending = $dataForTotPending->fetch_assoc();

                                            $totalDailypending += $dataFortotpending['ammount'];
                                        }

                                    ?>
                                        <div>
                                            <label for="" class="form-labe fw-bold"> <?php echo $totalDailypending ?></label>

                                        </div>


                                    <?php


                                    } else {

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
                                    if ($dataForTotNumClosed > 0) {
                                        $totalDailyclosed = 0;

                                        for ($i = 0; $i < $dataForTotNumClosed; $i++) {

                                            $dataFortotclosed = $dataForTotClosed->fetch_assoc();

                                            $totalDailyclosed += $dataFortotclosed['ammount'];
                                        }

                                    ?>
                                        <div>

                                            <label for="" class="form-labe fw-bold"> <?php echo $totalDailyclosed ?></label>
                                        </div>


                                    <?php


                                    } else {

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


                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-4 mt-2">
                            <div class="card bg-warning">
                                <div class="card-body text-dark">
                                    <small>M. Total: </small>
                                    <?php
                                    $totalMonthly = 0;

                                    if ($dataForTotMonthNum > 0) {

                                        for ($i = 0; $i < $dataForTotMonthNum; $i++) {

                                            $dataFortotMonth = $dataForTotMonth->fetch_assoc();

                                            $totalMonthly += $dataFortotMonth['ammount'];
                                        }
                                    ?>
                                        <div>
                                            <label for="" class="form-labe fw-bold"> <?php echo $totalMonthly ?></label>

                                        </div>


                                    <?php


                                    } else {
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

                                    <?php

                                    $dataForTotMCFP = Database::search("
SELECT * FROM `police_t` 
WHERE `users_u_id` = '$uid' 
AND `status_s_id` = '1' 
AND DATE_FORMAT(`date`, '%Y-%m') = '$currentMonth'
");

                                    $dataForTotMCFPNum = $dataForTotMCFP->num_rows;

                                    if ($dataForTotMCFPNum > 0) {

                                        $totalMCFP = 0;
                                        for ($i = 0; $i < $dataForTotMCFPNum; $i++) {

                                            $dataFortotMCFP = $dataForTotMCFP->fetch_assoc();
                                            if ($dataFortotMCFP['payments_pay_id'] == 1 || $dataFortotMCFP['payments_pay_id'] == 2 || $dataFortotMCFP['payments_pay_id'] == 4) {

                                                $totalMCFP += $dataFortotMCFP['ammount'];
                                            }
                                        }
                                    ?>
                                        <div>

                                            <label for="" class="form-labe fw-bold"> <?php echo $totalMCFP; ?></label>
                                        </div>

                                    <?php

                                    } else {

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
                                    <small>FP: </small>
                                    <div>

                                        <?php

                                        $dataForTotFP = Database::search("
SELECT * FROM `police_t` 
WHERE `users_u_id` = '$uid' 
AND `status_s_id` = '1' 
AND DATE_FORMAT(`date`, '%Y-%m') = '$currentMonth'
");

                                        $dataForTotFPNum = $dataForTotFP->num_rows;

                                        if ($dataForTotFPNum > 0) {

                                            $totalFP = 0;
                                            for ($i = 0; $i < $dataForTotFPNum; $i++) {

                                                $dataFortotFP = $dataForTotFP->fetch_assoc();
                                                if ($dataFortotFP['payments_pay_id'] == 3 || $dataFortotFP['payments_pay_id'] == 5) {

                                                    $totalFP += $dataFortotFP['ammount'];
                                                }
                                            }
                                        ?>
                                            <div>

                                                <label for="" class="form-labe fw-bold"> <?php echo $totalFP; ?></label>
                                            </div>

                                        <?php

                                        } else {

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

                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-body text-warning">
                                    <?php

                                    $dataForTotAll = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '$uid' AND `status_s_id`='1'");
                                    $dataForTotAllNum = $dataForTotAll->num_rows;

                                    ?>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="" class="form-labe fw-bold">Full Total :</label>

                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            <?php
                                            if ($dataForTotAllNum > 0) {

                                                $totalAll = 0;
                                                for ($i = 0; $i < $dataForTotAllNum; $i++) {
                                                    $dataFortotAll = $dataForTotAll->fetch_assoc();
                                                    $totalAll += $dataFortotAll['ammount'];
                                                }
                                            ?>
                                                <label for="" class="form-labe fw-bold">Rs. <?php echo $totalAll; ?>.00/=</label>
                                            <?php

                                            } else {
                                            ?>
                                                <label for="" class="form-labe fw-bold">Rs. 00.00/=</label>
                                            <?php

                                            }

                                            ?>


                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <button class="btn btn-sm btn-outline-secondary text-warning mt-2 mb-3" onclick="showModal();">Add New &nbsp<i class="fas fa-plus"></i></button>

                    <h2>Pending Policies</h2>
                    <div class="table-responsive small mb-3 d-block" style="max-height: 250px; overflow-y: auto;">
                        <table class="table table-striped table-sm">
                            <thead class="sticky-top">
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
                        <div class="table-responsive small" style="max-height: 250px; overflow-y: auto;">
                            <table class="table table-striped table-sm table-hover">
                                <thead class="sticky-top">
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
                                                <input type="tel" id="contact" class="form-control form-control-sm">
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
                                            <div class="col-12" onclick="getLocation('locText');">

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




                </main>
            </div>
        </div>
        <div class="mt-5">
            <?php include 'footer.php'; ?>
        </div>

        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
        <script src="script.js"></script>


        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="dashboard.js"></script>





    <?php





    } else {

    ?>

        <script>
            window.location.href = "login.php";
        </script>

    <?php
    }

    ?>


</body>

</html>