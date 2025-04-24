<!DOCTYPE html>
<html lang="en">

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

<body>
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
                    <a href="afDashboard.php">Dashboard</a>
                    <a href="affiliate.php">Affiliates</a>
                    <a href="#">Commissions</a>
                    <a href="#">Payouts</a>
                    <a href="#">Settings</a>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto px-md-4 py-4">
                <h2 class="mb-4">Dashboard</h2>

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card p-4">
                            <h5>Total Affiliates</h5>
                            <h3>120</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-4">
                            <h5>Pending Payouts</h5>
                            <h3>$1,250</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-4">
                            <h5>Monthly Earnings</h5>
                            <h3>$3,400</h3>
                        </div>
                    </div>
                </div>

                <div>
                    <h4>Recent Affiliates</h4>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover rounded">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Joined Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#001</td>
                                    <td>John Doe</td>
                                    <td>john@example.com</td>
                                    <td>2025-04-01</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                </tr>
                                <tr>
                                    <td>#002</td>
                                    <td>Jane Smith</td>
                                    <td>jane@example.com</td>
                                    <td>2025-04-10</td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
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
</body>

</html>
