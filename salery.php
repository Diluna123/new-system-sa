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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="manifest" href="manifest.json">


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
        <?php include 'logos.php'; ?>

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
            <div class="row ">
                <?php include 'sideMenu.php'; ?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 " id="main-dev">
                    <div class="row ">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2">Salary</h1>
                            <div class="btn-toolbar mb-2 mb-md-0">
                                <!-- <div class="btn-group me-2">
                  <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                  <svg class="bi">
                    <use xlink:href="#calendar3" />
                  </svg>
                  This week
                </button> -->
                            </div>
                        </div>
                        <div class="row ">
                            <?php
                            $userId = $_SESSION['user']['u_id'];
                            $totalCommissionAll = 0;

                            // Get unique month count
                            $monthCountResult = Database::search("
    SELECT COUNT(DISTINCT DATE_FORMAT(date, '%Y-%m')) AS month_count 
    FROM police_t 
    WHERE users_u_id = '$userId' AND status_s_id = 1
");
                            $monthCountRow = $monthCountResult->fetch_assoc();
                            
                            $monthCount = $monthCountRow['month_count'] ?? 0;
                            if($monthCount >1 ){
                                $monthCount = $monthCount -1;

                            }else{
                                $monthCount = $monthCount+1;
                            }
                    


                         
                            ?>

                            <div class="accordion" id="commissionAccordion">
                                <?php
                                $cumulativeCommission = 0;

                                for ($i = $monthCount; $i >= 0; $i--):
                                    $monthStart = date('Y-m-01', strtotime("-$i months"));
                                    $monthEnd = date('Y-m-t', strtotime("-$i months"));
                                    $monthName = date('F Y', strtotime($monthStart));

                                    // Type 1 (30%)
                                    $type1Result = Database::search("SELECT SUM(ammount) AS total FROM police_t 
            WHERE users_u_id = '$userId' AND plans_p_id = 1 AND status_s_id = 1 
            AND date BETWEEN '$monthStart' AND '$monthEnd'");
                                    $type1Row = $type1Result->fetch_assoc();
                                    $type1Total = $type1Row['total'] ?? 0;
                                    $type1Commission = $type1Total * 0.30;

                                    // Type 2 (15%)
                                    $type2Result = Database::search("SELECT SUM(ammount) AS total FROM police_t 
            WHERE users_u_id = '$userId' AND plans_p_id = 2 AND status_s_id = 1 
            AND date BETWEEN '$monthStart' AND '$monthEnd'");
                                    $type2Row = $type2Result->fetch_assoc();
                                    $type2Total = $type2Row['total'] ?? 0;
                                    $type2Commission = $type2Total * 0.15;

                                    $monthlyTotal = $type1Commission + $type2Commission;
                                    $cumulativeCommission += $monthlyTotal;

                                    // Fetch all policies for the month
                                    $policyResult = Database::search("SELECT pro_num, pol_num, date, ammount, 
            (SELECT plane FROM plans WHERE p_id = police_t.plans_p_id) AS plan_name 
            FROM police_t 
            WHERE users_u_id = '$userId' AND status_s_id = 1 
            AND date BETWEEN '$monthStart' AND '$monthEnd'
            ORDER BY date DESC");
                                ?>
                                    <div class="accordion-item bg-dark text-light border border-info mb-3 ms-3">
                                        <h2 class="accordion-header" id="heading<?php echo $i; ?>">
                                            <button class="accordion-button collapsed bg-dark text-info fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i; ?>" aria-expanded="false"
                                                aria-controls="collapse<?php echo $i; ?>">
                                                <?php echo $monthName; ?> Commission Summary (Cumulative)
                                            </button>
                                        </h2>
                                        <div id="collapse<?php echo $i; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $i; ?>"
                                            data-bs-parent="#commissionAccordion">
                                            <div class="accordion-body">

                                                <!-- Commission Breakdown -->
                                                <div class="row text-secondary fw-semibold border-bottom pb-2 mb-3">
                                                    <div class="col-4">Description</div>
                                                    <div class="col-4 text-end">T.Amount (Rs.)</div>
                                                    <div class="col-4 text-end">Commission (Rs.)</div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col-4">Total 31 Plan Business <span class="text-secondary">(30%)</span></div>
                                                    <div class="col-4 text-end"><?php echo number_format($type1Total, 2); ?> x 30%</div>
                                                    <div class="col-4 text-end text-warning"><?php echo number_format($type1Commission, 2); ?></div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col-4">Total Pension Plan Business <span class="text-secondary">(15%)</span></div>
                                                    <div class="col-4 text-end"><?php echo number_format($type2Total, 2); ?> x 15%</div>
                                                    <div class="col-4 text-end text-warning"><?php echo number_format($type2Commission, 2); ?></div>
                                                </div>

                                                <div class="row border-top pt-2 mt-3">
                                                    <div class="col-8 fw-bold">Cumulative Commission up to <?php echo $monthName; ?></div>
                                                    <div class="col-4 text-end text-success fw-bold"><?php echo number_format($cumulativeCommission, 2); ?></div>
                                                </div>

                                                <!-- Policy Table -->
                                                <div class="table-responsive mt-4">
                                                    <table class="table table-dark table-striped table-bordered text-light">
                                                        <thead class="table-info text-dark">
                                                            <tr>
                                                                <th>Proposal No</th>
                                                                <th>Policy No</th>
                                                                <th>Date</th>
                                                                <th>Plan</th>
                                                                <th>Amount (Rs.)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php while ($policy = $policyResult->fetch_assoc()): ?>
                                                                <tr>
                                                                    <td><?php echo $policy['pro_num']; ?></td>
                                                                    <td><?php echo $policy['pol_num']; ?></td>
                                                                    <td><?php echo date('Y-m-d', strtotime($policy['date'])); ?></td>
                                                                    <td><?php echo $policy['plan_name']; ?></td>
                                                                    <td class="text-end"><?php echo number_format($policy['ammount'], 2); ?></td>
                                                                </tr>
                                                            <?php endwhile; ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>


                            <!-- Grand Total Display -->
                            <?php
                            $currentMonthStart = date('Y-m-01');
                            $currentMonthEnd = date('Y-m-t');

                            // Get current month commissions
                            // Plan 1 (30%)
                            $currentType1 = Database::search("SELECT SUM(ammount) AS total FROM police_t 
    WHERE users_u_id = '$userId' AND plans_p_id = 1 AND status_s_id = 1 
    AND date BETWEEN '$currentMonthStart' AND '$currentMonthEnd'");
                            $currentType1Row = $currentType1->fetch_assoc();
                            $currentType1Total = $currentType1Row['total'] ?? 0;
                            $currentType1Commission = $currentType1Total * 0.30;

                            // Plan 2 (15%)
                            $currentType2 = Database::search("SELECT SUM(ammount) AS total FROM police_t 
    WHERE users_u_id = '$userId' AND plans_p_id = 2 AND status_s_id = 1 
    AND date BETWEEN '$currentMonthStart' AND '$currentMonthEnd'");
                            $currentType2Row = $currentType2->fetch_assoc();
                            $currentType2Total = $currentType2Row['total'] ?? 0;
                            $currentType2Commission = $currentType2Total * 0.15;

                            $currentMonthCommission = $currentType1Commission + $currentType2Commission  ;
                            $grandTotalCommission =  $cumulativeCommission;
                            ?>

                            <div class="col-12 col-md-10 mx-auto mt-5 mb-5">
                                <div class="card bg-dark text-light shadow border-success ms-sm-3 ms-3 ms-lg-0 ms-md-0">
                                    <div class="card-header border-success">
                                        <h4 class="text-success mb-0">
                                            <?php echo date('F Y'); ?> Commission
                                        </h4>
                                    </div>
                                    <div class="card-body text-end">
                                        <h3 class="text-success fw-bold">
                                            <?php echo number_format($grandTotalCommission, 2); ?> Rs
                                        </h3>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>


                </main>
            </div>
        </div>
        <div class="mt-5">
            <?php include 'footer.php'; ?>
        </div>

        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
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