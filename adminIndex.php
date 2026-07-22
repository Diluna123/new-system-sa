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
    <link rel="icon" type="image/png" href="com.png">



    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">
    <link rel="manifest" href="manifest.json">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <?php include "connection.php";
    session_start();

    $uid = $_SESSION['user']['u_id'];

    $totammount = 0;

    // Fetch data from the database




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

        .progress {
            /* height: 3px; */
            border-radius: 50px;
            box-shadow: 0 0 10px rgba(73, 87, 80, 0.5);
            overflow: hidden;
            margin-left: 2px;
            width: 3px;
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
        <?php include "logos.php"; ?>

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
                <?php include "sideMenu.php"; ?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="main-dev">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">TL Admin Panel</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <button class="btn btn-sm btn-outline-warning mt-2" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSpoModal">SPO <i class="fas fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <h5>Your SPOs</h5>
                        <?php
                        $spos = Database::search("SELECT * FROM `users` WHERE `teams_tid` = '" . $_SESSION['user']['teams_tid'] . "' AND `position_pid` = '1'");

                        if ($spos && $spos->num_rows > 0) {
                            while ($sposData = $spos->fetch_assoc()) {

                                $totammount = 0;

                                date_default_timezone_set("Asia/Colombo");
                                $currentMonth = date("m"); // Get current month (e.g., 03 for March)
                                $currentYear = date("Y");  // Get current year (e.g., 2025)

                                // Query to select only incomplete targets from the current month
                                $targets = Database::search("
    SELECT * FROM `targets` 
    WHERE `users_u_id` = '" . $sposData['u_id'] . "' 
    AND MONTH(`date`) = '$currentMonth' 
    AND YEAR(`date`) = '$currentYear' 
    AND `status_s_id` = '2'
");



                                if ($targets && $targets->num_rows > 0) {
                                    $targetsData = $targets->fetch_assoc();
                                    $maxValue = $targetsData['target'];
                                    $targetStId = $targetsData['status_s_id'];
                                } else {
                                    $targetStId = 0;


                                    $maxValue = 5000;
                                }


                                $result = Database::search("SELECT * FROM `police_t` 
    WHERE `users_u_id` = '" . $sposData['u_id'] . "' 
    AND `status_s_id` = '1' 
    AND YEAR(`date`) = '$currentYear' 
    AND MONTH(`date`) = '$currentMonth'");


                                if ($result && $result->num_rows > 0) {
                                    while ($totammountData = $result->fetch_assoc()) {
                                        $totammount += (float) $totammountData['ammount'];
                                    }
                                }

                                if ($maxValue <= $totammount) {
                                    Database::iud("UPDATE `targets` SET `status_s_id` = '1' WHERE `users_u_id` = '" . $sposData['u_id'] . "' AND MONTH(`date`) = '$currentMonth' AND YEAR(`date`) = '$currentYear'");
                                }




                                $totprestage = ($totammount > 0) ? floor($totammount * 100 / $maxValue) : 0; // Calculate percentage
                        ?>
                                <div class="col-6 mb-2">
                                    <div class="card border-warning-subtle">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="mb-2">

                                                    <?php
                                                    if ($targets && $targets->num_rows > 0) {

                                                        if ($targetStId == 1) {
                                                    ?>
                                                            <span class="badge text-bg-success">Completed</span>

                                                        <?php
                                                        } else if ($targetStId == 2) {
                                                        ?>
                                                            <small><span class="badge  text-bg-secondary">Incomplete</span></small>


                                                        <?php
                                                        }
                                                    } else {

                                                        if ($totammount >= $maxValue) {
                                                        ?>
                                                            <small><span class="badge text-bg-success">Completed</span></small>

                                                        <?php
                                                        } else {
                                                        ?>
                                                            <small><span class="badge  text-bg-secondary">Incomplete</span></small>


                                                    <?php
                                                        }
                                                    }

                                                    ?>



                                                </div>
                                                <div>
                                                    <h6 class="text-warning">
                                                        <?= empty($sposData['code']) ? 'N/A' : '#' . $sposData['code']; ?>
                                                    </h6>
                                                </div>
                                                <div>
                                                    <label for="" class="form-label"><?= $sposData['u_fname'] . " " . $sposData['u_lname']; ?></label>
                                                </div>
                                                <div class="mt-2">
                                                    <small>Target: </small>
                                                    <div>
                                                        <span class="text-secondary">Rs. <?php echo $maxValue ?> /= </span>
                                                    </div>


                                                </div>
                                                <div>
                                                    <small>Achivment: <span class="badge text-bg-info"><?php echo $result->num_rows; ?></span> </small>
                                                    <div>
                                                        <span class="text-secondary">Rs. <?php echo $totammount ?> /= (<?= $totprestage; ?>%)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column align-items-center">
                                                <small></small>
                                                <div class="progress bg-dark" style="width: 10px; height: 100px; position: relative;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                                        role="progressbar"
                                                        style="width: 100%; height: <?= $totprestage; ?>%; position: absolute; bottom: 0;"
                                                        aria-valuenow="<?= $totprestage; ?>" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <h5 class="text-secondary fw-bold">You have no SPOs to display.</h5>
                                
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="row mt-5" id="targets">
                        <h5>SPO Targets</h5>
                        <div class="table-responsive small table-scroll" style="max-height: 150px; overflow-y: auto;">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Month</th>
                                        <th scope="col">SPO</th>
                                        <th scope="col">Target</th>
                                        <th scope="col">Achievement</th>
                                        <th scope="col">Due</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $targetss = Database::search("SELECT * FROM `users` JOIN `targets` ON `users`.`u_id` = `targets`.`users_u_id` WHERE `users`.`teams_tid` = '" . $_SESSION['user']['teams_tid'] . "' AND `users`.`u_id` != '" . $_SESSION['user']['u_id'] . "'");

                                    if ($targetss->num_rows > 0) {
                                        for ($i = 0; $i < $targetss->num_rows; $i++) {
                                            $dataT = $targetss->fetch_assoc();
                                            $totammount = 0; // Reset total amount for each user

                                            $result = Database::search("SELECT * FROM `police_t` 
                                            WHERE `users_u_id` = '" . $dataT['u_id'] . "' 
                                            AND `status_s_id` = '1' 
                                            AND YEAR(`date`) = '$currentYear' 
                                            AND MONTH(`date`) = '$currentMonth'");
                                            if ($result && $result->num_rows > 0) {
                                                while ($totammountData = $result->fetch_assoc()) {
                                                    $totammount += (float) $totammountData['ammount'];
                                                }
                                            }
                                    ?>
                                            <tr>
                                                <th scope="row"><?= $i + 1; ?></th>
                                                <td><?= date("F", strtotime($dataT['date'])); ?></td>
                                                <!-- Extract Year and Month -->
                                                <td><?= $dataT['u_fname']; ?></td>
                                                <td>Rs. <?= $dataT['target']; ?></td>
                                                <?php
                                                if ($dataT['status_s_id'] == 4) {
                                                    $totammount = 0;
                                                }


                                                ?>
                                                <td>Rs. <?= $totammount; ?></td>
                                                <td>Rs. <?= $dataT['target'] - $totammount; ?></td>


                                                <td>
                                                    <?php if ($dataT['status_s_id'] == 1) { ?>
                                                        <span class="badge text-bg-success">Completed</span>
                                                    <?php } else if ($dataT['status_s_id'] == 2) { ?>
                                                        <span class="badge text-bg-secondary">Incomplete</span>
                                                    <?php
                                                    } else if ($dataT['status_s_id'] == 4) {
                                                    ?>
                                                        <span class="badge text-bg-warning">Pending</span>




                                                    <?php

                                                    }



                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr class="text-center">
                                            <td colspan="7" class="fw-bold text-muted mt-2">NO TARGETS ADDED</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Centered "Add Target" Button Outside the Table -->
                        <div class="text-center mt-3 mb-5">
                            <button class="btn btn-sm btn-outline-warning" onclick="openAddTargetModal();">Add Target</button>
                        </div>

                    </div>
                </main>

                <div class="modal fade" id="addTargetModal" tabindex="-1" aria-labelledby="addTargetModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTargetModalLabel">Add Target</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="targetAmount" class="form-label">Target Amount:</label>
                                        <input type="number" class="form-control" id="targetAmount" placeholder="Enter target amount">
                                    </div>
                                    <div class="mb-3">
                                        <label for="monthSelect" class="form-label">Month:</label>
                                        <input type="month" class="form-control" id="monthSelect">
                                    </div>
                                    <div class="mb-3">
                                        <label for="spoSelect" class="form-label">SPO:</label>
                                        <select id="spoSelect" class="form-control form-control-sm">
                                            <option value="00">--Select SPO--</option>
                                            <?php
                                            $sposList = Database::search("SELECT * FROM `users` WHERE `teams_tid` = '" . $_SESSION['user']['teams_tid'] . "' AND `u_id` != '" . $_SESSION['user']['u_id'] . "'");
                                            while ($spoData2 = $sposList->fetch_assoc()) {
                                                echo "<option value='" . $spoData2['u_id'] . "'>" . $spoData2['u_fname'] . " " . $spoData2['u_lname'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning btn-sm" onclick="addTarget();">Assign Target</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class=" fixed-bottom" style="height: 30px; width: 100%;">
                <p class="text-center text-secondary">Copyright &copy; 2025 D. Sithija Sulakshana</p>
            </div>
        </div>



        </div>

        <div class="modal fade" id="addSpoModal" tabindex="-1" aria-labelledby="addSpoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSpoModalLabel">New Sales Promotion Officer (SPO)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control form-control-sm" id="fName_sp" required>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control form-control-sm" id="lName_sp" required>
                                </div>

                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label">Code </label>
                            <input type="text" class="form-control form-control-sm" id="code_sp" >
                        </div>



                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" id="email_sp" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-sm" id="pwd_sp" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control form-control-sm" id="cpwd_sp" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                       
                        <button type="button" class="btn btn-warning btn-sm" onclick="addNewSpo()">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.querySelector('a[href="#targets"]').addEventListener("click", function(event) {
                event.preventDefault();
                document.getElementById("targets").scrollIntoView({
                    behavior: "smooth"
                });
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
