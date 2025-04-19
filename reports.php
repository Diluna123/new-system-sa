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
                <?php include 'sideMenu.php';?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="main-dev">
                    <div class="row ">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2">Reports</h1>
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

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="policy-tab" data-bs-toggle="tab" data-bs-target="#policyReport" type="button" role="tab">Policy Report</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="leads-tab" data-bs-toggle="tab" data-bs-target="#leadsReport" type="button" role="tab">Monthly Summery</button>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="myTabContent">
                            <div class="tab-pane fade show active" id="policyReport" role="tabpanel">
                                <div class="row mt-3">
                                    <div class="col-4">
                                        <div>
                                            <label for="type" class="form-label mb-1">Type :</label>
                                            <select name="type" id="PlanType" class="form-control form-control-sm" onchange="searchPolicyReport();">
                                                <option value="all">ALL</option>
                                                <option value="MCFP">MCFP</option>
                                                <option value="FP">FP</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <label for="fromDate" class="form-label mb-1">From :</label>
                                            <input type="month" class="form-control form-control-sm" id="fromDate" value="" onchange="searchPolicyReport();">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <label for="toDate" class="form-label mb-1">To :</label>
                                            <input type="month" class="form-control form-control-sm" id="toDate" onchange="searchPolicyReport();">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div id="reportSearchPre">
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
                                                $rDataP = Database::search("SELECT * FROM `police_t` WHERE `users_u_id` = '" . $_SESSION['user']['u_id'] . "' AND `status_s_id` = '1'");
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
                                    </div>


                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button class="btn btn-sm btn-warning col-3" onclick="printReport();">Get Report</button>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="leadsReport" role="tabpanel">
                                <h2>Monthlty Summery</h2>
                                <p>Details about the leads report go here.</p>
                                <button class="btn btn-sm btn-warning" onclick="window.location.href='salesAnalizeReport.php';">Get Monthly Summery Report</button>
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