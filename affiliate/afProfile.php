<?php
include '../connection.php';
session_start();

if (!isset($_SESSION['afuser'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Affiliate Profile | Sanasa Easy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #e0f2f7, #bbdefb);
            color: #333;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #007bff;
            color: #fff;
        }

        .sidebar a {
            color: #fff;
            padding: 15px;
            display: block;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #0056b3;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        .upload-label {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: #007bff;
            color: #fff;
            border-radius: 50%;
            padding: 6px;
            cursor: pointer;
        }

        .upload-label:hover {
            background-color: #0056b3;
        }

        .table-dark {
            background-color: #1f1f1f;
        }

        .table-dark thead th,
        .table-dark tbody td {
            color: #ddd;
        }

        .table-dark tbody tr:hover {
            background-color: #2d2d2d;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .sidebar a i {
            width: 20px;
        }

        @media (max-width: 768px) {
            body {
                background-attachment: fixed;
                /* Disable fixed background for mobile */
            }

            #sidebarMenu {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                height: 100vh;
                background-color: #007bff;
                z-index: 1050;
                transition: left 0.3s ease;
            }

            #sidebarMenu.show {
                left: 0;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1049;
                display: none;
            }

            .overlay.show {
                display: block;
            }

            .menu-toggle,
            .sidebar .close-btn {
                font-size: 1.5rem;
                cursor: pointer;
                display: block;
            }
        }
    </style>
</head>

<body>
    <!-- Overlay for sidebar on mobile -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <div class="container-fluid">
        <div class="row">
            <!-- Toggle for mobile -->
            <div class="d-md-none p-3">
                <i class="fas fa-bars menu-toggle" onclick="toggleSidebar()"></i>
            </div>

            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-2 sidebar d-md-block">
                <div class="p-3">
                    <div class="d-md-none close-btn text-white" onclick="toggleSidebar()">
                        <i class="fas fa-times"></i>
                    </div>
                    <h4 class="text-white text-center mb-4">Affiliate Admin</h4>
                    <a href="afDashboard.php"><i class="fas fa-chart-line me-2"></i> Dashboard</a>
                    <a href="affiliate.php"><i class="fas fa-users me-2"></i> Affiliates</a>
                    <a href="#"><i class="fas fa-coins me-2"></i> Commissions</a>
                    <a href="#"><i class="fas fa-money-check-alt me-2"></i> Payouts</a>
                    <a href="#"><i class="fas fa-cogs me-2"></i> Settings</a>
                    <a href="#" onclick="afsignOut();"><i class="fas fa-sign-out-alt me-2"></i> Sign Out</a>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4 py-4">
                <div class="card p-4">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img src="../sansa.png" alt="Profile Image" class="rounded-circle profile-img" id="profileImage">
                            <label for="uploadImage" class="upload-label">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="uploadImage" class="d-none" onchange="previewProfileImage(event)">
                        </div>
                        <h4 class="mt-3"><?php echo $_SESSION['afuser']['fname']; ?> <?php echo $_SESSION['afuser']['lname']; ?></h4>
                        <small class="text-muted mt-0"><?php echo $_SESSION['afuser']['nic']; ?></small>
                        <div>
                            <span class="badge bg-success">Active</span>
                        </div>
                    </div>

                    <div>
                        <h5 class="mb-3">Profile Information</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION['afuser']['fname']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION['afuser']['lname']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="email" class="form-control" value="<?php echo $_SESSION['afuser']['dob']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION['afuser']['address']; ?>" readonly>

                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION['afuser']['contact']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Joinned Date:</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION['afuser']['jdate']; ?>" readonly>
                            </div>

                        </div>

                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-primary">Edit Profile</button>
                            <button type="button" class="btn btn-outline-secondary">Change Password</button>
                        </div>
                    </div>
                    <hr class="mt-4 mb-4">
                    <div>
                        <h5 class="mb-3">Bank Account Information</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Bank Name</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION['afuser']['bank']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Account Number</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION['afuser']['accNo']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Branch</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION['afuser']['branch']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Account Holder</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION['afuser']['accHolder']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4 mt-3">
                    <div>
                        <h5 class="mb-3">Agent Information</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <?php

                                $agentD = Database::search("SELECT * FROM `users` WHERE `u_id` = '" . $_SESSION['afuser']['agentId'] . "';");
                                $agentdetils = $agentD->fetch_assoc();
                                $agentName = $agentdetils["u_fname"] . " " . $agentdetils["u_lname"];
                                $agentContact = $agentdetils["con_num"];

                                ?>
                                <label class="form-label">Agent Name</label>
                                <input type="text" class="form-control" value="<?php echo $agentName; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Agent Contact</label>
                                <input type="text" class="form-control" value="<?php echo $agentContact; ?>" readonly>
                            </div>

                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS & JS for toggling sidebar -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarMenu');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        function previewProfileImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('profileImage').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <script src="script.js"></script>
</body>

</html>