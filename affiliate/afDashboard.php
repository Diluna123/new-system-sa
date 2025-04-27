<!DOCTYPE html>
<html lang="en">

<?php include '../connection.php';
session_start();

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanasa Easy Affiliate Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #0056b3;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .card h5 {
            font-weight: 600;
        }

        .table-dark {
            background-color: #1f1f1f;
        }

        .table-dark thead th {
            color: #fff;
        }

        .table-dark tbody td {
            color: #ddd;
        }

        .table-dark tbody tr:hover {
            background-color: #2d2d2d;
        }

        .sidebar a i {
            width: 20px;
        }


        @media (max-width: 768px) {
            #sidebarMenu {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                height: 100vh;
                background-color: #007bff;
                transition: left 0.3s ease;
                z-index: 1050;
            }

            #sidebarMenu.show {
                left: 0;
            }

            .menu-toggle {
                display: inline-block;
                margin-bottom: 1rem;
                font-size: 1.5rem;
                cursor: pointer;
            }

            .sidebar .close-btn {
                display: block;
                text-align: right;
                padding: 1rem;
                font-size: 1.5rem;
                cursor: pointer;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1049;
                display: none;
            }

            .overlay.show {
                display: block;
            }
        }
    </style>
</head>

<body onload="userAorIcheck('<?php echo $_SESSION['afuser']['u_id']; ?>');">
    <?php

    if (!isset($_SESSION['afuser'])) {
        header("Location: login.php");
        exit();
    }

    ?>
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
    <div class="container-fluid">
        <div class="row">
            <!-- Toggle button for small screens -->
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

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto px-md-4 py-4">

                <div class="row">
                    <div class="col-8"><h2 class="mb-4">Dashboard</h2></div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end align-items-center mb-3">
                            <div class="dropdown">
                                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="../sansalogo.png" alt="profile" width="40" height="40" class="rounded-circle me-2">
                                    <strong><?php echo $_SESSION['afuser']['fname']; ?></strong>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="profileDropdown">
                                    <li><a class="dropdown-item" href="afProfile.php">My Profile</a></li>
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="#" onclick="afsignOut();">Sign out</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card p-4">
                            <h5>Total Businesses</h5>
                            <h3>5</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-4">
                            <h5>Pending Payouts</h5>
                            <h3>1,250 LKR</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-4">
                            <h5>Monthly Earnings</h5>
                            <h3>3,400 LKR</h3>
                        </div>
                    </div>
                </div>

                <div>
                    <h4>Recent Affiliates</h4>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover rounded">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>F.Name</th>
                                    <th>Joined</th>
                                    <th>Plane</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Earnings</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#001</td>
                                    <td>John Doe</td>
                                    <td>2025-04-01</td>
                                    <td>31</td>
                                    <td>5000 LKR</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>1500 LKR</td>
                                </tr>
                                <tr>
                                    <td>#002</td>
                                    <td>John Doe</td>
                                    <td>2025-04-01</td>
                                    <td>31</td>
                                    <td>5000 LKR</td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    <td>1500 LKR</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>

        <!-- modal -->
        <div class="modal fade" id="modalActive" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Activate Your Account</h1>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div>
                                <label for="" class="form-label">Activation code</label>
                                <input type="number" name="" id="actCode" class="form-control" placeholder="Enter your activation code" aria-describedby="helpId">
                                <div class="mt-2">
                                    <small>Get Your Activation code from your agent</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="afsignOut();">Sign Out</button>

                        <button type="button" class="btn btn-primary" onclick="afActivate(<?php echo $_SESSION['afuser']['u_id']; ?>); ">Activate</button>
                    </div>
                </div>
            </div



                </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                function toggleSidebar() {
                    const sidebar = document.getElementById('sidebarMenu');
                    const overlay = document.getElementById('overlay');
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                }
            </script>
            <script src="script.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>