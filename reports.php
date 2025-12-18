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


    <?php
    session_start();


    include "connection.php"; ?>
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
            <div class="row">
                <?php include 'sideMenu.php'; ?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="main-dev">
                    <div class="row">
                        <!-- Header -->
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                            <h1 class="h2 fw-bold text-warning"><i class="bi bi-bar-chart-line me-2"></i> Reports</h1>
                            <div class="btn-toolbar mb-2 mb-md-0">
                                <div class="btn-group me-2">
                                    <button type="button" class="btn btn-sm btn-outline-warning"><i class="bi bi-share"></i> Share</button>
                                    <button type="button" class="btn btn-sm btn-outline-warning"><i class="bi bi-download"></i> Export</button>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-light dropdown-toggle d-flex align-items-center gap-1">
                                    <i class="bi bi-calendar3"></i>
                                    This week
                                </button>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-semibold" id="policy-tab" data-bs-toggle="tab" data-bs-target="#policyReport" type="button" role="tab">
                                    <i class="bi bi-file-earmark-text me-1"></i> Policy Report
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthlyReport" type="button" role="tab">
                                    <i class="bi bi-calendar-month me-1"></i> Monthly Summary
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold" id="plan31-tab" data-bs-toggle="tab" data-bs-target="#plan31Report" type="button" role="tab">
                                    <i class="bi bi-graph-up me-1"></i> 31 Plans
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold" id="plan18-tab" data-bs-toggle="tab" data-bs-target="#plan18Report" type="button" role="tab">
                                    <i class="bi bi-graph-down me-1"></i> 18 Plans
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content mt-4" id="myTabContent">

                            <!-- Policy Report -->
                            <div class="tab-pane fade show active" id="policyReport" role="tabpanel">
                                <div class="card bg-dark border-0 shadow-sm rounded-4 p-3">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="PlanType" class="form-label mb-1 text-light">Type :</label>
                                            <select name="type" id="PlanType" class="form-select form-select-sm bg-body-secondary border-0 text-light" onchange="searchPolicyReport();">
                                                <option value="all">ALL</option>
                                                <option value="MCFP">MCFP</option>
                                                <option value="FP">FP</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="fromDate" class="form-label mb-1 text-light">From :</label>
                                            <input type="month" class="form-control form-control-sm bg-body-secondary border-0 text-light" id="fromDate" onchange="searchPolicyReport();">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="toDate" class="form-label mb-1 text-light">To :</label>
                                            <input type="month" class="form-control form-control-sm bg-body-secondary border-0 text-light" id="toDate" onchange="searchPolicyReport();">
                                        </div>
                                    </div>

                                    <div class="table-responsive mt-4" id="reportSearchPre">
                                        <table class="table table-dark table-striped table-hover align-middle text-center">
                                            <thead class="table-secondary text-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Proposal / Policy</th>
                                                    <th>Date</th>
                                                    <th>MCFP</th>
                                                    <th>FP</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $rDataP = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '" . $_SESSION['user']['u_id'] . "' AND `status_s_id` = '1'");
                                                $rDataPCount = $rDataP->num_rows;
                                                $totalMCFP = 0;
                                                $totalFP = 0;

                                                if ($rDataPCount == 0) {
                                                    echo '<tr><td colspan="5" class="text-center text-muted py-4">No data found</td></tr>';
                                                } else {
                                                    for ($i = 0; $i < $rDataPCount; $i++) {
                                                        $rDataPData = $rDataP->fetch_assoc();
                                                ?>
                                                        <tr>
                                                            <td><?php echo $i + 1; ?></td>
                                                            <td><?php echo $rDataPData['pro_num']; ?> / <?php echo $rDataPData['pol_num']; ?></td>
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
                                            <tfoot class="table-borderless">
                                                <tr>
                                                    <th colspan="3" class="text-start text-warning-emphasis">Sub Total:</th>
                                                    <th class="text-warning text-end"><?php echo $totalMCFP; ?></th>
                                                    <th class="text-warning text-end"><?php echo $totalFP; ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-start text-warning-emphasis">Total:</th>
                                                    <th></th>
                                                    <th class="bg-warning-subtle text-dark text-end fw-bold"><?php echo $totalMCFP + $totalFP; ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="d-flex justify-content-end mt-3">
                                        <button class="btn btn-warning px-4" onclick="printReport();">
                                            <i class="bi bi-printer-fill me-1"></i> Get Report
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Monthly Summary -->
                            <div class="tab-pane fade" id="monthlyReport" role="tabpanel">
                                <div class="card bg-dark border-0 shadow-sm rounded-4 p-4">
                                    <h3 class="fw-semibold text-warning"><i class="bi bi-bar-chart me-2"></i> Monthly Summary</h3>
                                    <p class="text-secondary">View and download your monthly summary reports.</p>
                                    <button class="btn btn-warning mt-2" onclick="window.location.href='salesAnalizeReport.php';">
                                        <i class="bi bi-download me-1"></i> Get Monthly Summary Report
                                    </button>
                                </div>
                            </div>

                            <!-- 31 Plans -->
                            <div class="tab-pane fade" id="plan31Report" role="tabpanel">
                                <div class="card bg-dark border-0 shadow-sm rounded-4 p-4">
                                    <h3 class="fw-semibold text-warning"><i class="bi bi-graph-up-arrow me-2"></i> 31 Plans</h3>
                                    <p class="text-secondary">Detailed report for 31 Plan-related policies and performance.</p>
                                    <button class="btn btn-warning mt-2" onclick="window.location.href='plan31Report.php';">
                                        <i class="bi bi-file-earmark-bar-graph me-1"></i> Get 31 Plan Report
                                    </button>
                                </div>
                            </div>

                            <!-- 18 Plans -->
                            <div class="tab-pane fade" id="plan18Report" role="tabpanel">
                                <div class="card bg-dark border-0 shadow-sm rounded-4 p-4">
                                    <h3 class="fw-semibold text-warning"><i class="bi bi-graph-down-arrow me-2"></i> 18 Plans</h3>
                                    <p class="text-secondary">Detailed report for 18 Plan-related policies and summaries.</p>
                                    <button class="btn btn-warning mt-2" onclick="window.location.href='plan18Report.php';">
                                        <i class="bi bi-file-earmark-bar-graph me-1"></i> Get 18 Plan Report
                                    </button>
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
        <script>
            document.getElementById("fromDate").addEventListener("change", function() {
                let fromDate = this.value;
                let toDateInput = document.getElementById("toDate");

                // Set the minimum selectable date for "To" input
                toDateInput.min = fromDate;

                // Reset the value of "To" if it's before the selected "From" date
                if (toDateInput.value && toDateInput.value < fromDate) {
                    toDateInput.value = fromDate;
                }
            });
        </script>





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