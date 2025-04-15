<!doctype html>
<html lang="en" data-bs-theme="dark">
<?php

session_start();
$uid = $_SESSION['user']['u_id'];
include 'connection.php';


?>

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
                <?php include 'sideMenu.php' ?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="main-dev">

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Cutomer Leads</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <!-- <div class="btn-group me-2">

                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" id="dateButton" onclick="searchLeadas();">
                                <svg class="bi">
                                    <use xlink:href="#calendar3" />
                                </svg>
                                <span id="selectedDate">This week</span>
                            </button> -->

                            <!-- Hidden Date Input -->
                            <!-- <input type="date" id="dateInput" class="d-none"> -->

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-warning">New Lead</h5>
                        </div>
                    </div>
                    <div class="newLeadForm">
                        <div class="row mt-3 mb-2">
                            <div class="col-12">
                                <div>
                                    <label for="" class="form-label">Cutomer Name : <span class="text-danger">*</span></label>
                                </div>
                                <div>
                                    <input type="text" id="cName" class="form-control form-control-sm" placeholder="Ex: Jone Due">
                                </div>
                            </div>

                        </div>
                        <div class="row mb-2">

                            <div class="col-6">
                                <div>
                                    <label for="" class="form-label">Contact Number : <span class="text-danger">*</span></label>
                                </div>
                                <div>
                                    <input type="tel" id="contact_cl" class="form-control form-control-sm" placeholder="Ex: 0771234567">
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <label for="" class="form-label">Shop Name :</label>
                                </div>
                                <div>
                                    <input type="text" id="shopName" class="form-control form-control-sm" placeholder="Ex: Salon due">
                                </div>

                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div>
                                    <label for="" class="form-label">Location :</label>
                                </div>
                                <div onclick="getLocation('loc_cl');">
                                    <input type="text" class="form-control form-control-sm" id="loc_cl" placeholder="location link will be auto genarate">
                                </div>
                            </div>

                        </div>
                        <div class="row mb-4">
                            <div class="col-12 d-flex justify-content-center">
                                <div class="col-4 d-grid">
                                    <button class="btn btn-sm btn-warning  " onclick="getCustomerLeads();">Submit</button>
                                </div>
                            </div>
                        </div>
                        <hr class="border-warning">




                    </div>
                    <div class="row justify-content-end mb-4">
                        <div class="col-md-6">
                            <div class="input-group shadow-sm rounded-3">
                                <!-- Date Picker with Calendar Icon -->


                                <!-- Contact Number Input -->
                                <span class="input-group-text bg-transparent border-0">
                                    <i class="bi bi-telephone"></i>
                                </span>

                                <input type="tel" class="form-control border-0" id="contactInput" placeholder="Enter Contact" pattern="07[0-9]{8}" aria-label="Search Contact" onkeyup="performSearch();">

                                <span class="input-group-text bg-transparent border-0">
                                    <i class="bi bi-calendar3"></i>
                                </span>
                                <input type="date" class="form-control border-0" id="dateInput" aria-label="Select Date" onchange="performSearch();">

                                <!-- Search Button -->
                                <button class="btn btn-dark px-4" type="button" onclick="performSearch()">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>




                    <div class="table-responsive small">
    <table class="table table-striped table-sm table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">C.Name</th>
                <th scope="col">Contact</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <!-- <th scope="col">Total</th> -->
            </tr>
        </thead>
        <tbody id="searchResults">

            <?php
            $teamid = $_SESSION['user']['teams_tid'];
            $limit = 4; // number of records per page
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $start = ($page - 1) * $limit;

            // Get total row count for pagination
            $totalResult = Database::search("SELECT COUNT(*) as total FROM `c_leads` WHERE `teams_tid` = '$teamid' AND `status_s_id` != '3'");
            $totalRow = $totalResult->fetch_assoc()['total'];
            $totalPages = ceil($totalRow / $limit);

            // Main data query with LIMIT
            $getLData = Database::search("SELECT * FROM `c_leads` WHERE `teams_tid` = '$teamid' AND `status_s_id` != '3' ORDER BY `date_cl` DESC LIMIT $start, $limit");

            if ($getLData->num_rows > 0) {
                for ($i = 0; $i < $getLData->num_rows; $i++) {
                    $dataCl = $getLData->fetch_assoc();
            ?>
                    <tr onclick="leadsOffcanvas(<?php echo $dataCl['clid']; ?>);">
                        <td><?php echo $start + $i + 1 ?></td>
                        <td><?php echo $dataCl['cname']; ?></td>
                        <td><?php echo $dataCl['contact_cl']; ?></td>
                        <td><?php echo $dataCl['date_cl']; ?></td>
                        <td>
                            <?php
                            if ($dataCl['status_s_id'] == 5) {
                                echo "<span class='badge text-bg-primary'>New</span> ";
                            } else if ($dataCl['status_s_id'] == 4) {
                                echo "<span class='badge text-bg-warning'>Pending</span> ";
                            } else if ($dataCl['status_s_id'] == 1) {
                                echo "<span class='badge text-bg-success'>Closed</span> ";
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr class="text-center">
                    <td colspan="5" class="fw-bold text-muted">NO CUSTOMER LEADS</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <li class="page-item <?php echo $p == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $p; ?>"><?php echo $p; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>







                </main>
            </div>
        </div>
        <div class="mt-5">
            <?php include 'footer.php'; ?>
        </div>

        </div>

        <!-- leads full details offcanvass -->

        <div class="offcanvas offcanvas-end" tabindex="-1" id="leadsOff" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasRightLabel">Customer Leads</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body" id="leadsOffBody">


            </div>
        </div>

        <script>
            document.getElementById("dateButton").addEventListener("click", function() {
                document.getElementById("dateInput").showPicker(); // Opens native date picker
            });

            document.getElementById("dateInput").addEventListener("change", function() {
                document.getElementById("selectedDate").innerText = this.value; // Update button text
            });
        </script>


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