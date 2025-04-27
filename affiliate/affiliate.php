<!DOCTYPE html>
<html lang="en">
<?php
include '../connection.php';
session_start();
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Affiliates - Sanasa Easy</title>
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

            <!-- Main -->
            <main class="col-md-10 ms-sm-auto px-md-4 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Affiliates</h2>
                    <!-- Add New Business Button -->
                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addBusinessModal">
                        <i class="fas fa-plus me-2"></i>Add New Business
                    </button>
                </div>

                <div class="mb-4">
                    <input type="text" class="form-control form-control-lg" placeholder="Search affiliates by name or email...">
                </div>

                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>F. Name</th>
                                <th>Joined</th>
                                <th>Plane</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Earnings</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            // Fetch affiliate data from the database
                            $uid = $_SESSION["afuser"]["u_id"];
                            $searchAf = Database::search("SELECT * FROM `afcustomers` JOIN `plans` ON `afcustomers`.`plans_p_id` = `plans`.`p_id` JOIN `afstatus` ON `afcustomers`.`afStatus_afSid` = `afstatus`.`afSid` WHERE `af_users_af_id` = '$uid'");
                            $searchAfCount = $searchAf->num_rows;
                            if ($searchAfCount > 0) {
                                for ($i = 0; $i < $searchAfCount; $i++) {
                                    $searchAfData = $searchAf->fetch_assoc();
                            ?>
                                    <tr>
                                        <td><?php echo $i + 1; ?></td>
                                        <td><?php echo $searchAfData["af_fname"]; ?></td>
                                        <td><?php echo $searchAfData["af_jdate"]; ?></td>
                                        <td><?php echo $searchAfData["plane"]; ?></td>
                                        <td><?php echo $searchAfData["af_amount"]; ?> LKR</td>
                                        <td><span class="badge bg-<?php echo ($searchAfData["afStatuses"] == 'Active') ? 'success' : (($searchAfData["afStatuses"] == 'Pending') ? 'warning text-black' : (($searchAfData["afStatuses"] == 'Verify') ? 'info' : 'danger')); ?> "><?php echo ucfirst($searchAfData["afStatuses"]); ?></span></td>
                                        <td>0 LKR</td>
                                    </tr>
                            <?php



                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center">No affiliates found.</td></tr>';
                            }

                            ?>
                            


                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Business Modal -->
    <div class="modal fade" id="addBusinessModal" tabindex="-1" aria-labelledby="addBusinessModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="addBusinessModalLabel">Add New Business</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info p-2 mb-3" role="alert">
                        <small><span class="text-danger">*</span> සහිත ක්ෂේත්‍ර අනිවාර්ය වේ.</small>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="afFname" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="afFname" placeholder="මුල් නම" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="afLname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="afLname" placeholder="අවසන් නම" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="afCnum" class="form-label">Contact<span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="afCnum" placeholder="දුරකථන අංකය" required>
                    </div>
                    <div class="mb-3">
                        <label for="afPlane" class="form-label">Plan<span class="text-danger">*</span></label>
                        <select class="form-select" id="afPlane" required>
                            <option value="">-- යෝජනාව තෝරන්න --</option>

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


                    <div class="mb-3">
                        <label for="afAmount" class="form-label">Amount<span class="text-danger">*</span> </label>
                        <input type="number" class="form-control" id="afAmount" placeholder="මුදල" min="0" required>
                    </div>



                    <div class="mb-3">
                        <label for="afNic" class="form-label">NIC <span class="text-secondary">(Optional)</span></label>
                        <input type="text" class="form-control" id="afNic" placeholder="හැඳුනුම්පත් අංකය">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" onclick="addNewAfBusiness();">Add Business</button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarMenu');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
    </script>

</body>

</html>