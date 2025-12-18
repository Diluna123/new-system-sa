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

    <link href="css/border.css" rel="stylesheet">


    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">
    <link rel="manifest" href="manifest.json">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <?php include "connection.php";
    session_start();

    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />




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

        /* Smooth hover effect */
        .clickable-row:hover {
            background-color: rgba(0, 123, 255, 0.15) !important;
            transform: scale(1.01);
        }

        /* Scrollbar styling for modern dark UI */
        #policiesTable .table-responsive::-webkit-scrollbar {
            width: 8px;
        }

        #policiesTable .table-responsive::-webkit-scrollbar-thumb {
            background: #555;
            border-radius: 10px;
        }

        #policiesTable .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #777;
        }

        /* Sticky header visual fix */
        thead.sticky-top th {
            background-color: #222 !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);
        }

        /* --- Modern Card & Animation Styles --- */
        .summary-card,
        .card.bg-dark {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .summary-card:hover,
        .card.bg-dark:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 25px rgba(255, 255, 255, 0.1);
        }

        /* Gradients */
        .gradient-green {
            background: linear-gradient(135deg, #00c851, #007e33);
        }

        .gradient-red {
            background: linear-gradient(135deg, #ff4444, #cc0000);
        }

        .gradient-blue {
            background: linear-gradient(135deg, #33b5e5, #0099cc);
        }

        .gradient-yellow {
            background: linear-gradient(135deg, #fbc02d, #f57f17);
            color: #212529;
        }

        /* Glowing borders */
        .glow-yellow {
            border: 1px solid #fdd835;
            box-shadow: 0 0 10px rgba(253, 216, 53, 0.5);
        }

        .glow-green {
            border: 1px solid #00e676;
            box-shadow: 0 0 10px rgba(0, 230, 118, 0.5);
        }

        /* Faster animation timing */
        .animate__animated {
            --animate-duration: 0.6s;
        }

        .animate__delay-1s {
            --animate-delay: 0.1s;
        }

        .animate__delay-2s {
            --animate-delay: 0.2s;
        }

        .animate__delay-3s {
            --animate-delay: 0.3s;
        }

        .animate__delay-4s {
            --animate-delay: 0.4s;
        }

        .animate__delay-5s {
            --animate-delay: 0.5s;
        }

        .card-body small {
            opacity: 0.85;
            letter-spacing: 0.5px;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/kute.js@2.2.4/dist/kute.min.js"></script>
</head>

<body>
    <?php


    if (isset($_SESSION['user'])) {

    ?>
        <?php include 'logos.php'; ?>

        <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">SANASA LIFE</a>

            <ul class="navbar-nav flex-row d-md-none">
                <li class="nav-item text-nowrap">
                    <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false"
                        aria-label="Toggle search">
                        <svg class="bi">
                            <use xlink:href="#search" />
                        </svg>
                    </button>
                </li>
                <li class="nav-item text-nowrap">
                    <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                        aria-label="Toggle navigation">
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
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">My Policies</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                            </div>
                            <button type="button"
                                class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                                <svg class="bi">
                                    <use xlink:href="#calendar3" />
                                </svg>
                                This week
                            </button>
                        </div>
                    </div>
                    <!-- ================== Monthly Target ================== -->
                    <div class="card bg-dark border-0 shadow-lg mb-3 rounded-4 animate__animated animate__fadeInDown">
                        <div class="card-body d-flex justify-content-between align-items-center px-4 py-3">
                            <?php
                            $dataForTotAll = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '$uid' AND `status_s_id`='1'");
                            $dataForTotAllNum = $dataForTotAll->num_rows;

                            $targetQ = Database::search("SELECT * FROM `targets` WHERE `users_u_id` = '$uid' AND `status_s_id`='2' AND DATE_FORMAT(`date`, '%Y-%m') = '$currentMonth'");
                            $targetQNum = $targetQ->num_rows;

                            $dataForTotMonth1 = Database::search("
        SELECT * FROM `police_t`
        WHERE `users_u_id` = '$uid'
        AND `status_s_id` = '1'
        AND DATE_FORMAT(`date`, '%Y-%m') = '$currentMonth'
    ");
                            $dataForTotMonthNum1 = $dataForTotMonth1->num_rows;

                            if ($targetQNum > 0) {
                                $targetQData = $targetQ->fetch_assoc();
                                $targetAmmount = $targetQData['target'];
                            } else {
                                $targetAmmount = 5000;
                            }

                            if ($dataForTotMonthNum1 > 0) {
                                $totalMonthly1 = 0;
                                for ($i = 0; $i < $dataForTotMonthNum1; $i++) {
                                    $dataFortotMonth1 = $dataForTotMonth1->fetch_assoc();
                                    $totalMonthly1 += $dataFortotMonth1['ammount'];
                                }
                            } else {
                                $totalMonthly1 = 0;
                            }
                            ?>
                            <h6 class="text-warning mb-0 fw-semibold">🎯 Monthly Target</h6>
                            <h6 class="mb-0 text-success fw-bold">
                                Rs. <?php echo number_format($totalMonthly1); ?> /
                                <span class="text-secondary"><?php echo number_format($targetAmmount); ?></span>
                            </h6>
                        </div>
                    </div>

                    <!-- ================== Summary Cards ================== -->
                    <div class="row g-3">
                        <!-- Daily Total -->
                        <div class="col-6 col-md-3">
                            <div class="summary-card gradient-green animate__animated animate__fadeInUp">
                                <div class="card-body text-center text-white">
                                    <small>Daily Total</small>
                                    <h5 class="fw-bold mt-2 mb-0">
                                        <?php
                                        if ($dataForTotNum > 0) {
                                            $totalDaily = 0;
                                            for ($i = 0; $i < $dataForTotNum; $i++) {
                                                $dataFortot = $dataForTot->fetch_assoc();
                                                $totalDaily += $dataFortot['ammount'];
                                            }
                                            echo "Rs. " . number_format($totalDaily);
                                        } else {
                                            echo "Rs. 0.00";
                                        }
                                        ?>
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <!-- Pending -->
                        <div class="col-6 col-md-3">
                            <div class="summary-card gradient-red animate__animated animate__fadeInUp animate__delay-1s">
                                <div class="card-body text-center text-white">
                                    <small>Pending</small>
                                    <h5 class="fw-bold mt-2 mb-0">
                                        <?php
                                        if ($dataForTotNumPending > 0) {
                                            $totalDailypending = 0;
                                            for ($i = 0; $i < $dataForTotNumPending; $i++) {
                                                $dataFortotpending = $dataForTotPending->fetch_assoc();
                                                $totalDailypending += $dataFortotpending['ammount'];
                                            }
                                            echo "Rs. " . number_format($totalDailypending);
                                        } else {
                                            echo "Rs. 0.00";
                                        }
                                        ?>
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <!-- Closed -->
                        <div class="col-6 col-md-3">
                            <div class="summary-card gradient-blue animate__animated animate__fadeInUp animate__delay-2s">
                                <div class="card-body text-center text-white">
                                    <small>Closed</small>
                                    <h5 class="fw-bold mt-2 mb-0">
                                        <?php
                                        if ($dataForTotNumClosed > 0) {
                                            $totalDailyclosed = 0;
                                            for ($i = 0; $i < $dataForTotNumClosed; $i++) {
                                                $dataFortotclosed = $dataForTotClosed->fetch_assoc();
                                                $totalDailyclosed += $dataFortotclosed['ammount'];
                                            }
                                            echo "Rs. " . number_format($totalDailyclosed);
                                        } else {
                                            echo "Rs. 0.00";
                                        }
                                        ?>
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <!-- Monthly Total -->
                        <div class="col-6 col-md-3">
                            <div class="summary-card gradient-yellow animate__animated animate__fadeInUp animate__delay-3s">
                                <div class="card-body text-center text-dark">
                                    <small>Monthly Total</small>
                                    <h5 class="fw-bold mt-2 mb-0">
                                        <?php
                                        $totalMonthly = 0;
                                        if ($dataForTotMonthNum > 0) {
                                            for ($i = 0; $i < $dataForTotMonthNum; $i++) {
                                                $dataFortotMonth = $dataForTotMonth->fetch_assoc();
                                                $totalMonthly += $dataFortotMonth['ammount'];
                                            }
                                            echo "Rs. " . number_format($totalMonthly);
                                        } else {
                                            echo "Rs. 0.00";
                                        }
                                        ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================== Breakdown (All Time) ================== -->
                    <div class="row g-3 mt-3">
                        <!-- MCFP -->
                        <div class="col-6 col-md-3">
                            <div class="summary-card glow-yellow animate__animated animate__fadeInUp animate__delay-4s">
                                <div class="card-body text-center text-warning">
                                    <small>MCFP (All Time)</small>
                                    <h5 class="fw-bold mt-2 mb-0">
                                        <?php
                                        $dataForTotMCFP = Database::search("
              SELECT * FROM `police_t`
              WHERE `users_u_id` = '$uid'
              AND `status_s_id` = '1'
              AND `payments_pay_id` IN (1, 2, 4)
          ");
                                        $totalMCFP = 0;
                                        if ($dataForTotMCFP->num_rows > 0) {
                                            while ($row = $dataForTotMCFP->fetch_assoc()) {
                                                $totalMCFP += $row['ammount'];
                                            }
                                            echo "Rs. " . number_format($totalMCFP);
                                        } else {
                                            echo "Rs. 0.00";
                                        }
                                        ?>
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <!-- FP -->
                        <div class="col-6 col-md-3">
                            <div class="summary-card glow-green animate__animated animate__fadeInUp animate__delay-5s">
                                <div class="card-body text-center text-success">
                                    <small>FP (All Time)</small>
                                    <h5 class="fw-bold mt-2 mb-0">
                                        <?php
                                        $dataForTotFP = Database::search("
              SELECT * FROM `police_t`
              WHERE `users_u_id` = '$uid'
              AND `status_s_id` = '1'
              AND `payments_pay_id` IN (3, 5)
          ");
                                        $totalFP = 0;
                                        if ($dataForTotFP->num_rows > 0) {
                                            while ($row = $dataForTotFP->fetch_assoc()) {
                                                $totalFP += $row['ammount'];
                                            }
                                            echo "Rs. " . number_format($totalFP);
                                        } else {
                                            echo "Rs. 0.00";
                                        }
                                        ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary text-warning mt-3 mb-3" onclick="showModal();">Add New
                        &nbsp<i class="fas fa-plus"></i></button>

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
                                        <td colspan="6" style="text-align: center; font-weight: bold; padding: 10px;">
                                            No Pending Policies
                                        </td>
                                    </tr>



                                <?php
                                }



                                ?>

                            </tbody>
                        </table>
                    </div>


                    <div id="policiesTable" class="mt-4">
                        <div
                            class="card bg-dark border-0 shadow-lg rounded-4 overflow-hidden animate__animated animate__fadeInUp">
                            <div class="card-header border-0 bg-gradient d-flex justify-content-between align-items-center px-4 py-3"
                                style="background: linear-gradient(135deg, #0d6efd, #6610f2);">
                                <h5 class="mb-0 text-white fw-semibold d-flex align-items-center">
                                    <i class="bi bi-file-earmark-text me-2"></i> Active Policies
                                </h5>
                                <div class="badge bg-light text-dark px-3 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-person-badge me-1"></i> User: <?php echo htmlspecialchars($uid); ?>
                                </div>
                            </div>

                            <div class="card-body p-0 position-relative">
                                <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                                    <table class="table table-dark table-hover align-middle mb-0">
                                        <thead class="sticky-top bg-secondary text-light">
                                            <tr>
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>NIC</th>
                                                <th>Contact</th>
                                                <th>Plan</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            <?php
                                            $policies = Database::search("
                SELECT * FROM `customers` 
                JOIN `police_t` ON `customers`.`id` = `police_t`.`customers_id`
                JOIN `plans` ON `plans`.`p_id` = `police_t`.`plans_p_id`
                JOIN `payments` ON `payments`.`pay_id` = `police_t`.`payments_pay_id`
                JOIN `users` ON `users`.`u_id` = `police_t`.`users_u_id`
                WHERE `police_t`.`users_u_id` = '$uid'
                AND `police_t`.`status_s_id` = '1'
                ORDER BY `customers`.`id` DESC
              ");

                                            $totalMCFP = 0;
                                            $totalFP = 0;

                                            if ($policies->num_rows > 0) {
                                                for ($i = 0; $i < $policies->num_rows; $i++) {
                                                    $data = $policies->fetch_assoc();
                                                    $phone = preg_replace('/^0/', '', $data['contact']);

                                                    // sum by plan type
                                                    if (strtoupper($data['plane']) === 'MCFP') {
                                                        $totalMCFP += (float)$data['ammount'];
                                                    } elseif (strtoupper($data['plane']) === 'FP') {
                                                        $totalFP += (float)$data['ammount'];
                                                    }
                                            ?>
                                                    <tr class="clickable-row animate__animated animate__fadeIn"
                                                        style="cursor:pointer; transition: all 0.3s ease;"
                                                        onclick="showCanvasModal(<?php echo $data['id']; ?>)">
                                                        <td class="fw-bold text-info">0<?php echo $i + 1; ?></td>
                                                        <td><?php echo htmlspecialchars($data['fname']); ?></td>
                                                        <td><?php echo htmlspecialchars($data['nic']); ?></td>
                                                        <td><?php echo htmlspecialchars($phone); ?></td>
                                                        <td class="fw-semibold"><?php echo htmlspecialchars($data['plane']); ?></td>
                                                        <td class="text-success fw-semibold">Rs.
                                                            <?php echo number_format($data['ammount'], 2); ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-4 fw-semibold">
                                                        <i class="bi bi-info-circle me-2"></i> No Active Policies
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Animated Total Footer -->
                                <div
                                    class="p-4 text-center border-top border-secondary bg-dark-subtle animate__animated animate__fadeInUp">
                                    <div class="d-flex justify-content-around flex-wrap text-light fw-semibold">
                                        <div class="fade-in-delay">
                                            <i class="bi bi-cash-stack text-info me-2"></i>
                                            Total MCFP:
                                            <span class="text-info">Rs. <?php echo number_format($totalMCFP, 2); ?></span>
                                        </div>
                                        <div class="fade-in-delay2">
                                            <i class="bi bi-cash-coin text-success me-2"></i>
                                            Total FP:
                                            <span class="text-success">Rs. <?php echo number_format($totalFP, 2); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>






                    <!-- add new customr modal begin -->
                    <div class="modal fade" tabindex="-1" id="addNewModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">New Customer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="con ">
                                        <div class="row mb-2">
                                            <!-- personal info begin -->
                                            <div class="col-12">
                                                <label for="" class="form-label">Date : <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" id="date" class="form-control form-control-sm"
                                                    value="<?php echo date('Y-m-d'); ?>">

                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label for="" class="form-label">First Name : <span
                                                        class="text-danger">*</span></label>
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
                                                <label for="" class="form-label">Age : <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="age" class="form-control form-control-sm">
                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div>
                                                <label for="" class="form-label">DOB: <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" id="dob" class="form-control form-control-sm">
                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div>
                                                <label for="" class="form-label">Contact Number : <span
                                                        class="text-danger">*</span></label>
                                                <input type="tel" id="contact" class="form-control form-control-sm">
                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div>
                                                <label for="" class="form-label">Address : <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="address" class="form-control form-control-sm">
                                            </div>
                                            <!-- personal info end and plane info begin -->
                                        </div>
                                        <div class="row mb-2">
                                            <div>
                                                <label for="" class="form-label">Plane : <span
                                                        class="text-danger">*</span></label>

                                                <select class="form-control form-control-sm" id="plane">
                                                    <?php
                                                    $pldata = Database::search("SELECT * FROM `plans`");
                                                    for ($i = 0; $i < $pldata->num_rows; $i++) {
                                                        $row = $pldata->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $row['p_id']; ?>"><?php echo $row['plane']; ?>
                                                        </option>


                                                    <?php
                                                    }


                                                    ?>


                                                </select>
                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div>
                                                <label for="" class="form-label">Payment Type : <span
                                                        class="text-danger">*</span></label>

                                                <select class="form-control form-control-sm" id="payment">
                                                    <?php
                                                    $padata = Database::search("SELECT * FROM `payments`");
                                                    for ($i = 0; $i < $padata->num_rows; $i++) {
                                                        $row2 = $padata->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $row2['pay_id']; ?>">
                                                            <?php echo $row2['payment_ty']; ?></option>


                                                    <?php
                                                    }


                                                    ?>

                                                </select>
                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div>
                                                <label for="" class="form-label">Ammount : <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">Rs.</span>
                                                    <input type="number" id="ammount" class="form-control form-control-sm">

                                                </div>

                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div>
                                                <label for="" class="form-label">Time Period : <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" id="timep" class="form-control form-control-sm"
                                                    minimum="5">

                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div>
                                                <label for="" class="form-label">Note : </label>
                                                <textarea type="text" id="note" class="form-control form-control-sm"
                                                    cols="5" rows="5"></textarea>
                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <label for="" class="form-label">Location :<span class="text-danger">
                                                    *</span></label>
                                            <div class="col-12" onclick="getLocation('locText');">

                                                <input type="text" class="form-control form-control-sm" id="locText">

                                            </div>


                                        </div>


                                    </div>
                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-warning btn-sm"
                                        onclick="submitBtn();">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- complete modal(police number and proposel number enter modal) -->

                    <div class="modal fade" id="proposalModal" data-bs-backdrop="modal" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Completion</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="" class="form-label d-none" id="cidStore"></label>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-6">
                                            <label for="" class="form-label">Proposal Number : <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" id="proNum" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-6">
                                            <label for="" class="form-label">Police Number : </label>
                                            <input type="number" id="polNum" class="form-control form-control-sm">
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-warning"
                                        onclick="submitProposal(); ">Submit</button>
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
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <iframe id="nicPreviewFrame" src="" width="100%" height="500px"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>





                    <!-- offcanves begin -->

                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                        aria-labelledby="offcanvasRightLabel" style="width: 400px">


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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
        <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
        <script src="script.js"></script>


        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"
            integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous">
        </script>
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