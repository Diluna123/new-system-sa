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

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transition: all 0.3s ease-in-out;
        }

        .input-glass {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: 0.3s ease;
        }

        .input-glass:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .profile-img-wrapper:hover img {
            transform: scale(1.05);
            transition: 0.3s ease;
        }

        .edit-btn {
            width: 40px;
            height: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        .stat-card {
    border-radius: 1rem;
    transition: transform 0.3s ease-in-out;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 255, 255, 0.2);
}
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #28a745, #1e7e34);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107, #e0a800);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8, #117a8b);
}
.icon {
    display: flex;
    justify-content: center;
    align-items: center;
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
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2 mb-0"></h1>
                        <div class="btn-toolbar mb-2 mb-md-0 dropdown">
                            <button class="btn btn-sm border-0 d-flex align-items-center text-white px-2"
                                type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="me-2 d-none d-md-inline"><?php echo $_SESSION['user']['u_fname'] . " " . $_SESSION['user']['u_lname']; ?></span>
                                <div class="proPic bg-secondary d-flex justify-content-center align-items-center"
                                    style="width: 32px; height: 32px; border-radius: 50%;">
                                    <span class="text-white  fw-bold"> <img src="my.JPG" class="rounded-circle border border-3 border-light shadow" style="width: 40px; height: 40px; object-fit: cover;" alt=""></span>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow rounded border-0" aria-labelledby="userDropdown" style="min-width: 200px;">
                                <li class="px-3 py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-secondary d-flex justify-content-center align-items-center rounded-circle me-2" style="width: 40px; height: 40px;">
                                            <span class="text-white fw-bold"> <img src="my.JPG" class="rounded-circle border border-3 border-light shadow" style="width: 40px; height: 40px; object-fit: cover;" alt=""></span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold"><?php echo $_SESSION['user']['u_fname'] . " " . $_SESSION['user']['u_lname']; ?></div>
                                            <small class="text-muted">
                                                <?php
                                                $positionD = Database::search("SELECT * FROM `position` WHERE `pid` = '" . $_SESSION['user']['position_pid'] . "'");
                                                $positionData = $positionD->fetch_assoc();


                                                ?>
                                                <?php echo $positionData['position']; ?>
                                            </small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider my-1">
                                </li>
                                <li><a class="dropdown-item py-2" href="usreProfile.php">Profile</a></li>
                                <li><a class="dropdown-item py-2" href="settings.php">Settings</a></li>
                                <li><a class="dropdown-item py-2 text-danger" href="#" onclick="signOut();">Logout</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row justify-content-center">

                        <div class="col-xl-10">
                            <div class="glass-card p-4 rounded-4 shadow-lg position-relative mt-2">
                                <div class="row align-items-center g-4">
                                    <!-- Profile Picture -->
                                    <div class="col-lg-3 text-center position-relative">
                                        <div class="profile-img-wrapper position-relative mx-auto">
                                            <img src="my.JPG" alt="Profile" class="rounded-circle border border-3 border-light shadow" style="width: 180px; height: 180px; object-fit: cover;">
                                            <button class="edit-btn btn btn-sm btn-light position-absolute bottom-0 end-0 rounded-circle" style="transform: translate(20%, 20%);">
                                                <i class="fa fa-camera text-dark"></i>
                                            </button>
                                        </div>
                                        <?php
                                        $UData = Database::search("SELECT * FROM `users` WHERE `u_id` = '" . $_SESSION['user']['u_id'] . "'");
                                        $UData = $UData->fetch_assoc();


                                        if ($_SESSION['user']['position_pid'] == 1) {
                                            $position = 'SPO';
                                        } else if ($_SESSION['user']['position_pid'] == 2) {
                                            $position = 'TL';
                                        }




                                        ?>
                                        <h5 class="mt-3 mb-0 fw-bold"><?php echo $UData['u_fname'] . " " . $UData['u_lname']; ?></h5>
                                        <p class="text-secondary mb-0"><?php echo $position; ?> - Sanasa Life</p>
                                    </div>

                                    <!-- Profile Form -->
                                    <div class="col-lg-9">
                                        <h3 class="mb-4 border-bottom pb-2 fw-semibold">Profile Information</h3>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">First Name</label>
                                                <input type="text" class="form-control input-glass" placeholder="Diluna" id="SfirstName" value="<?php echo $UData['u_fname']; ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" class="form-control input-glass" placeholder="Perera" id="SlastName" value="<?php echo $UData['u_lname']; ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control input-glass" placeholder="you@email.com" value="<?php echo $UData['email']; ?>" disabled>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Contact Number</label>
                                                <input type="tel" id="contactNum" class="form-control input-glass" placeholder="+94xxxxxxxxx" value="<?php echo $UData['con_num']; ?>">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">Code </label>
                                                <input type="tel" class="form-control input-glass" id="Scode" placeholder="SPO2000xxx" value="<?php echo $UData['code']; ?>">
                                            </div>
                                        </div>
                                        <div class="text-end mt-4">
                                            <button onclick="updateUserInfo();" class="btn btn-warning px-4 py-2 rounded-3">
                                                <i class="fa fa-floppy-disk me-2"></i>Save Changes
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12">
                            <h4 class="mb-4 border-bottom border-secondary pb-2 text-info">📊 Policy / Agent Stats</h4>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card stat-card text-center bg-gradient-primary text-light border-0 shadow-lg">
                                <div class="card-body">
                                    <div class="icon mb-3">
                                        <i class="fa-solid fa-file-shield fa-2x"></i>
                                    </div>
                                    <h6>Total Policies</h6>
                                    <h3 class="fw-bold count">154</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card stat-card text-center bg-gradient-success text-light border-0 shadow-lg">
                                <div class="card-body">
                                    <div class="icon mb-3">
                                        <i class="fa-solid fa-check-double fa-2x"></i>
                                    </div>
                                    <h6>Active Policies</h6>
                                    <h3 class="fw-bold count">121</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card stat-card text-center bg-gradient-warning text-dark border-0 shadow-lg">
                                <div class="card-body">
                                    <div class="icon mb-3">
                                        <i class="fa-solid fa-calendar-week fa-2x"></i>
                                    </div>
                                    <h6>Policies This Month</h6>
                                    <h3 class="fw-bold count">18</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card stat-card text-center bg-gradient-info text-light border-0 shadow-lg">
                                <div class="card-body">
                                    <div class="icon mb-3">
                                        <i class="fa-solid fa-coins fa-2x"></i>
                                    </div>
                                    <h6>Commission Earned</h6>
                                    <h3 class="fw-bold count">Rs. 74,500</h3>
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