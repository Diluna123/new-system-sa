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

  <!-- Core CSS -->
  <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="dashboard.css" rel="stylesheet">
  <link rel="stylesheet" href="css/border.css">

  <!-- Icons and Extras -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
  <!-- Bootstrap CSS & Icons (make sure included in layout) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom Styles -->
  <style>
    .card-body {
      min-height: 80px;
    }

    .accordion-button {
      font-weight: 500;
    }

    <style>.table thead th {
      vertical-align: middle;
      text-align: center;
      background-color: #1f1f1f !important;
      color: #fff;
      border-color: #2a2a2a;
    }

    .table tbody td,
    .table tbody th {
      vertical-align: middle;
      text-align: center;
      border-color: #333;
      color: #e0e0e0;
    }

    .table tbody tr {
      transition: all 0.2s ease-in-out;
      cursor: pointer;
    }

    .table tbody tr:hover {
      background-color: #2c2c2c;
      transform: scale(1.01);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .badge {
      font-size: 0.85rem;
      padding: 0.4em 0.7em;
      border-radius: 0.6rem;
    }

    .table-container {
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
      background-color: #121212;
      padding: 20px;
    }

    .no-data-message {
      color: #999;
      font-size: 1.1rem;
      padding: 20px;
      text-align: center;
    }
  </style>

  </style>

  <?php include "connection.php"; ?>
</head>

<body>
  <?php
  session_start();
  if (isset($_SESSION['user'])) {
    include 'logos.php';
  ?>

    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">SANASA LIFE</a>
      <ul class="navbar-nav flex-row d-md-none">
        <li class="nav-item text-nowrap">
          <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch">
            <i class="bi bi-search"></i>
          </button>
        </li>
        <li class="nav-item text-nowrap">
          <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
            <i class="bi bi-list"></i>
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

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Affiliate</h1>
          </div>

          <div class="row mt-3 mb-3">
            <?php for ($i = 0; $i < 3; $i++) { ?>
              <div class="col-4 col-sm-4 col-md-4 col-lg-3">
                <div class="card border-left-success shadow-sm">
                  <div class="card-body text-center">
                    <i class="bi bi-people" style="font-size: 24px;"></i>
                    <p class="mb-0">Pendings</p>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>

          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane">New Affiliates</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane">Affiliate Users</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link text-danger-emphasis" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane">Banded Affiliates</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link text-warning" id="pay-tab" data-bs-toggle="tab" data-bs-target="#pay-tab-pane">Payments</button>
            </li>
          </ul>

          <div class="tab-content " id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane">


              <div class="card mt-4 ">
                <div class="card-header">New Affiliates - <span class="badge text-bg-warning">Pendings</span></div>
                <div class="card-body">
                  <div class="accordion " id="accordionExample">

                    <?php
                    $uid = $_SESSION['user']['u_id'];
                    $getAfData = Database::search("SELECT * FROM `afcustomers` JOIN `af_users` ON `afcustomers`.`af_users_af_id`=`af_users`.`af_id` JOIN `customers` ON `customers`.`id`=`af_users`.`customers_id` JOIN `plans` ON `afcustomers`.`plans_p_id`=`plans`.`p_id` JOIN `users` ON `af_users`.`users_u_id`=`users`.`u_id` WHERE `users`.`u_id` = '$uid' AND `afcustomers`.`afStatus_afSid` = '1' ORDER BY `id` DESC;");

                    $numAfData = $getAfData->num_rows;
                    if ($numAfData > 0) {
                      for ($i = 0; $i < $numAfData; $i++) {
                        $afData = $getAfData->fetch_assoc();

                    ?>
                        <div class="accordion-item border-left-warning mb-2">
                          <h2 class="accordion-header">
                            <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i; ?>">
                              <?php echo $afData['af_fname'] . ' ' . $afData['af_lname']; ?> - <?php echo $afData['af_contact']; ?> - <?php echo $afData['af_amount']; ?>
                            </button>
                          </h2>
                          <div id="collapse<?php echo $i; ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">

                            <div class="accordion-body">
                              <div class="mb-2">
                                <label class="form-label text-secondary">Date</label>
                                <input type="text" class="form-control form-control-sm" value="<?php echo $afData['af_jdate']; ?>" readonly>
                              </div>
                              <div class="row mb-2">
                                <div class="col-6">
                                  <label class="form-label text-secondary">Name</label>
                                  <input type="text" class="form-control form-control-sm" value="<?php echo $afData['af_fname'] . ' ' . $afData['af_lname']; ?> " readonly>
                                </div>
                                <div class="col-6">
                                  <label class="form-label text-secondary">Contact</label>
                                  <input type="text" class="form-control form-control-sm" value="<?php echo $afData['af_contact']; ?>" readonly>
                                </div>
                              </div>
                              <div class="row mb-2">
                                <div class="col-6">
                                  <label class="form-label text-secondary">Plan</label>
                                  <input type="text" class="form-control form-control-sm" value="<?php echo $afData['plane']; ?>" readonly>
                                </div>
                                <div class="col-6">
                                  <label class="form-label text-secondary">Amount</label>
                                  <input type="text" class="form-control form-control-sm" value="<?php echo $afData['af_amount']; ?>" readonly>
                                </div>
                              </div>
                              <div class="text-end">
                                <button class="btn btn-danger btn-sm border-0 bg-transparent text-danger" onclick="verifyAf(<?php echo $afData['afid']; ?>,'6');">Banded</button>
                                <button class="btn btn-warning btn-sm " onclick="verifyAf(<?php echo $afData['afid']; ?>,'3');">Verify</button>

                              </div>
                            </div>
                          </div>
                        </div>
                    <?php







                      }
                    } else {
                      echo '<div class="text-center text-secondary mt-2">No New Affiliates</div>';
                    }


                    ?>

                  </div>
                </div>
              </div>
              <div class="card mt-4 ">
                <div class="card-header">Verifyed Affiliates - <span class="badge text-bg-info">Verifyed</span></div>
                <div class="card-body">
                  <div class="accordion " id="accordionExampleV">

                    <?php
                    $uid = $_SESSION['user']['u_id'];
                    $getAfData = Database::search("SELECT * FROM `afcustomers` JOIN `af_users` ON `afcustomers`.`af_users_af_id`=`af_users`.`af_id` JOIN `customers` ON `customers`.`id`=`af_users`.`customers_id` JOIN `plans` ON `afcustomers`.`plans_p_id`=`plans`.`p_id` JOIN `users` ON `af_users`.`users_u_id`=`users`.`u_id` WHERE `users`.`u_id` = '$uid' AND `afcustomers`.`afStatus_afSid` = '3' ORDER BY `id` DESC;");

                    $numAfData = $getAfData->num_rows;
                    if ($numAfData > 0) {
                      for ($i = 0; $i < $numAfData; $i++) {
                        $afData = $getAfData->fetch_assoc();

                    ?>
                        <div class="accordion-item border-left-info mb-2">
                          <h2 class="accordion-header">
                            <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#Vcollapse<?php echo $i; ?>">
                              <?php echo $afData['af_fname'] . ' ' . $afData['af_lname']; ?> - <?php echo $afData['af_contact']; ?> - <?php echo $afData['af_amount']; ?>
                            </button>
                          </h2>
                          <div id="Vcollapse<?php echo $i; ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExampleV">

                            <div class="accordion-body">
                              <div class="mb-2">
                                <label class="form-label text-secondary">Date</label>
                                <input type="text" class="form-control form-control-sm" value="<?php echo $afData['af_jdate']; ?>" readonly>
                              </div>
                              <div class="row mb-2">
                                <div class="col-6">
                                  <label class="form-label text-secondary">Name</label>
                                  <input type="text" class="form-control form-control-sm" value="<?php echo $afData['af_fname'] . ' ' . $afData['af_lname']; ?> " readonly>
                                </div>
                                <div class="col-6">
                                  <label class="form-label text-secondary">Contact</label>
                                  <input type="text" class="form-control form-control-sm" value="<?php echo $afData['af_contact']; ?>" readonly>
                                </div>
                              </div>
                              <div class="row mb-2">
                                <div class="col-6">
                                  <label class="form-label text-secondary">Plan</label>
                                  <input type="text" class="form-control form-control-sm" value="<?php echo $afData['plane']; ?>" readonly>
                                </div>
                                <div class="col-6">
                                  <label class="form-label text-secondary">Amount</label>
                                  <input type="text" class="form-control form-control-sm" value="<?php echo $afData['af_amount']; ?>" readonly>
                                </div>
                              </div>
                              <div class="text-end">
                                <button class="btn btn-danger btn-sm border-0 bg-transparent text-danger" onclick="verifyAf(<?php echo $afData['afid']; ?>,'6');">Banded</button>
                                <button class="btn btn-primary btn-sm " onclick="verifyAf(<?php echo $afData['afid']; ?>,'3');">Transfer to Mypolicy</button>

                              </div>
                            </div>
                          </div>
                        </div>
                    <?php







                      }
                    } else {
                      echo '<div class="text-center text-secondary">No Verifed Affiliates</div>';
                    }


                    ?>

                  </div>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="profile-tab-pane">

              <?php




              ?>
              <!-- affiliate users section -->
              <div class="row">
                <div class="col-12">
                  <div class="card bg-dark text-white shadow-sm border-0 rounded-4 mt-4">
                    <div class="card-header border-0 bg-secondary text-white rounded-top-4">
                      <h5 class="mb-0">Affiliate Users</h5>
                    </div>
                    <div class="card-body table-responsive p-0">
                      <table class="table table-dark table-hover table-bordered mb-0 text-center align-middle">
                        <thead class="table-secondary text-dark">
                          <tr>
                            <th>#</th>
                            <th>F.Name</th>
                            <th>Contact</th>
                            <th>NIC</th>
                            <th>J.Date</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody id="afTableBody">
                          <?php
                          $uid = $_SESSION['user']['u_id'];
                          $getAfuData = Database::search("SELECT * FROM `af_users` JOIN `customers` ON `customers`.`id`=`af_users`.`customers_id` JOIN `users` ON `af_users`.`users_u_id`=`users`.`u_id` JOIN `police_t` ON `customers`.`id`=`police_t`.`customers_id` WHERE `af_users`.`users_u_id` = '$uid' ORDER BY `af_users`.`af_id` DESC;");
                          $numAfData = $getAfuData->num_rows;

                          if ($numAfData > 0) {
                            for ($i = 0; $i < $numAfData; $i++) {
                              $afuData = $getAfuData->fetch_assoc();
                              $afId = $afuData['af_id'];
                          ?>
                              <tr>
                                <td><?php echo ($i + 1); ?></td>
                                <td><?php echo $afuData['fname'] . ' ' . $afuData['lname']; ?></td>
                                <td><?php echo $afuData['contact']; ?></td>
                                <td><?php echo $afuData['nic']; ?></td>
                                <td><?php echo $afuData['user_date']; ?></td>
                                <td>
                                  <?php
                                  if ($afuData['status_s_id'] == 1) {
                                    echo '<span class="badge bg-success">Active</span>';
                                  } else if ($afuData['status_s_id'] == 3) {
                                    echo '<span class="badge bg-danger">Banned</span>';
                                  } else {
                                    echo '<span class="badge bg-secondary">Unknown</span>';
                                  }
                                  ?>
                                </td>
                              </tr>
                          <?php
                            }
                          } else {
                            echo '<tr><td colspan="6" class="text-muted py-3">No Affiliates</td></tr>';
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>



            </div>
            <div class="tab-pane fade" id="contact-tab-pane">
              <div class="card mt-4 border-0">

                <div class="card-body">
                  <div class="accordion " id="accordionExampleB">

                    <?php
                    $uid = $_SESSION['user']['u_id'];
                    $getAfData = Database::search("SELECT * FROM `afcustomers` JOIN `af_users` ON `afcustomers`.`af_users_af_id`=`af_users`.`af_id` JOIN `customers` ON `customers`.`id`=`af_users`.`customers_id` JOIN `plans` ON `afcustomers`.`plans_p_id`=`plans`.`p_id` JOIN `users` ON `af_users`.`users_u_id`=`users`.`u_id` WHERE `users`.`u_id` = '$uid' AND `afcustomers`.`afStatus_afSid` = '6' ORDER BY `id` DESC;");

                    $numAfData = $getAfData->num_rows;
                    if ($numAfData > 0) {
                      for ($i = 0; $i < $numAfData; $i++) {
                        $afData = $getAfData->fetch_assoc();

                    ?>
                        <div class="accordion-item border-left-danger mb-2">
                          <h2 class="accordion-header">
                            <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#Bcollapse<?php echo $i; ?>">
                              <?php echo $afData['af_fname'] . ' ' . $afData['af_lname']; ?> - <?php echo $afData['af_contact']; ?> - <?php echo $afData['af_amount']; ?>
                            </button>
                          </h2>
                          <div id="Bcollapse<?php echo $i; ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExampleB">

                            <div class="accordion-body">
                              <div class="mb-2">
                                <label class="form-label text-secondary">Date</label>
                                <input type="text" class="form-control form-control-sm" value="<?php echo $afData['af_jdate']; ?>" readonly>
                              </div>
                              <div class="row mb-2">
                                <div class="col-6">
                                  <label class="form-label text-secondary">Name</label>
                                  <input type="text" class="form-control form-control-sm" value="<?php echo $afData['af_fname'] . ' ' . $afData['af_lname']; ?> " readonly>
                                </div>
                                <div class="col-6">
                                  <label class="form-label text-secondary">Contact</label>
                                  <input type="text" class="form-control form-control-sm" value="<?php echo $afData['af_contact']; ?>" readonly>
                                </div>
                              </div>
                              <div class="row mb-2">
                                <div class="col-6">
                                  <label class="form-label text-secondary">Plan</label>
                                  <input type="text" class="form-control form-control-sm" value="<?php echo $afData['plane']; ?>" readonly>
                                </div>
                                <div class="col-6">
                                  <label class="form-label text-secondary">Amount</label>
                                  <input type="text" class="form-control form-control-sm" value="<?php echo $afData['af_amount']; ?>" readonly>
                                </div>
                              </div>
                              <div class="text-end">

                                <button class="btn btn-warning btn-sm " onclick="verifyAf(<?php echo $afData['afid']; ?>,'3');">Re-Verify</button>

                              </div>
                            </div>
                          </div>
                        </div>
                    <?php







                      }
                    } else {
                      echo '<div class="text-center text-secondary">No Banded Affiliates</div>';
                    }


                    ?>

                  </div>
                </div>
              </div>
            </div>

            <!-- payments tab section -->
            <div class="tab-pane fade" id="pay-tab-pane">
              <div class="row mt-2 g-4">
                <!-- Pending Payments Card -->
                <div class="col-md-6">
                  <div class="card bg-dark text-white shadow rounded-4 h-100 border-left-warning">
                    <div class="card-body d-flex align-items-center justify-content-between">
                      <div>
                        <h6 class="text-warning fw-semibold mb-1">Pending Payments</h6>
                        <h3 class="fw-bold mb-0">Rs. 12,500</h3> <!-- Replace with PHP variable -->
                      </div>
                      <div class="icon  bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-hourglass-split fs-2 text-warning"></i>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Total to Pay This Month Card -->
                <div class="col-md-6">
                  <div class="card bg-dark text-white shadow rounded-4 h-100 border-left-success">
                    <div class="card-body d-flex align-items-center justify-content-between">
                      <div>
                        <h6 class="text-success fw-semibold mb-1">Total to Pay (This Month)</h6>
                        <h3 class="fw-bold mb-0">Rs. 45,000</h3> <!-- Replace with PHP variable -->
                      </div>
                      <div class="icon bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-cash-coin fs-2 text-success"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-12 d-flex flex-column flex-md-row">

                  <!-- Vertical Pills -->
                  <div class="nav flex-column nav-pills me-md-3 mb-3 mb-md-0" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
                      Unpaid
                    </button>
                    <button class="nav-link" id="v-pills-paid-tab" data-bs-toggle="pill" data-bs-target="#v-pills-paid" type="button" role="tab" aria-controls="v-pills-paid" aria-selected="false">
                      Paid
                    </button>
                  </div>

                  <!-- Tab Content -->
                  <div class="tab-content flex-grow-1" id="v-pills-tabContent">

                    <!-- Unpaid Tab -->
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                      <div class="card bg-dark text-white shadow-sm border-0 rounded-4">
                        <div class="card-header bg-secondary text-white rounded-top-4">
                          <h5 class="mb-0">Pending Payments</h5>
                        </div>
                        <div class="card-body table-responsive p-0">
                          <table class="table table-dark table-hover table-bordered mb-0 text-center align-middle">
                            <thead class="table-secondary text-dark">
                              <tr>
                                <th>#</th>
                                <th>Name / Contact</th>
                                <th>Bank</th>
                                <th>Account No</th>
                                <th>Amount</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $afPDataSearch = Database::search("SELECT * FROM `af_users` JOIN `customers` ON `af_users`.`customers_id`=`customers`.`id` ");
                              $numAfPDataSearch = $afPDataSearch->num_rows;

                              for ($i = 0; $i < $numAfPDataSearch; $i++) {
                                $afPData = $afPDataSearch->fetch_assoc();
                                $afId = $afPData['af_id'];
                                $currentMonth = date('Y-m');
                                $lastMonth = date('Y-m', strtotime('-1 month'));
                                $lastMonth = $lastMonth . '%';
                                $paymentSearch = Database::search("SELECT * FROM `afpayments` WHERE `af_users_af_id` = '$afId' AND  `month` LIKE '$lastMonth%' ");
                                $numPaymentSearch = $paymentSearch->num_rows;

                                if ($numPaymentSearch !== 0) {
                                } else {
                              ?>
                                  <tr onclick="afUserDetailsCanvas(1);">
                                    <td><?php echo ($i + 1); ?></td>
                                    <td class="text-start">
                                      <strong><?php echo $afPData['fname'] . ' ' . $afPData['lname']; ?></strong><br>
                                      <small class="text-muted"><i class="bi bi-telephone-fill me-1"></i><?php echo $afPData['contact']; ?></small>
                                    </td>
                                    <td>BOC</td>
                                    <td>123456789012</td>
                                    <td>Rs. 15,000.00</td>
                                  </tr>


                                <?php
                                }

                                ?>


                              <?php

                              }

                              ?>
                              <!-- Example Row -->

                              <!-- PHP Loop Goes Here -->
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                    <!-- Paid Tab -->
                    <div class="tab-pane fade" id="v-pills-paid" role="tabpanel" aria-labelledby="v-pills-paid-tab" tabindex="0">
                      <div class="card bg-dark text-white shadow-sm border-0 rounded-4">
                        <div class="card-header bg-success text-white rounded-top-4">
                          <h5 class="mb-0">Completed Payments</h5>
                        </div>
                        <div class="card-body table-responsive p-0">
                          <table class="table table-dark table-hover table-bordered mb-0 text-center align-middle">
                            <thead class="table-secondary text-dark">
                              <tr>
                                <th>#</th>
                                <th>Name / Contact</th>
                                <th>Bank</th>
                                <th>Account No</th>
                                <th>Amount</th>
                              </tr>
                            </thead>
                            <tbody>
                              <!-- PHP Loop for Paid Rows Goes Here -->
                            <tbody>
                              <?php
                              $afPDataSearch = Database::search("SELECT * FROM `af_users` JOIN `customers` ON `af_users`.`customers_id`=`customers`.`id` ");
                              $numAfPDataSearch = $afPDataSearch->num_rows;

                              for ($i = 0; $i < $numAfPDataSearch; $i++) {
                                $afPData = $afPDataSearch->fetch_assoc();
                                $afId = $afPData['af_id'];
                                $currentMonth = date('Y-m');
                                $lastMonth = date('Y-m', strtotime('-1 month'));
                                $lastMonth = $lastMonth . '%';
                                $paymentSearch = Database::search("SELECT * FROM `afpayments` WHERE `af_users_af_id` = '$afId' AND  `month` LIKE '$lastMonth%' AND `payment_status_payId` = 2 ");
                                $numPaymentSearch = $paymentSearch->num_rows;

                                if ($numPaymentSearch == 0) {
                                } else {
                              ?>
                                  <tr onclick="afUserDetailsCanvas(1);">
                                    <td><?php echo ($i + 1); ?></td>
                                    <td class="text-start">
                                      <strong><?php echo $afPData['fname'] . ' ' . $afPData['lname']; ?></strong><br>
                                      <small class="text-muted"><i class="bi bi-telephone-fill me-1"></i><?php echo $afPData['contact']; ?></small>
                                    </td>
                                    <td>BOC</td>
                                    <td>123456789012</td>
                                    <td>Rs. 15,000.00</td>
                                  </tr>


                                <?php
                                }

                                ?>


                              <?php

                              }

                              ?>
                              <!-- Example Row -->

                              <!-- PHP Loop Goes Here -->
                            </tbody>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>




            </div>



            <!-- Offcanvas with Modern Look and Wider Width -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offCanvasAf" aria-labelledby="offcanvasRightLabel" style="width: 500px;">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasRightLabel">Affiliate Details & Payments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <div class="row g-4">

                  <!-- Total Earnings Card -->
                  <div class="col-12 col-md-6">
                    <div class="card bg-gradient bg-dark text-light shadow rounded-4 border-0">
                      <div class="card-body d-flex align-items-center gap-3">
                        <div class="icon-box bg-success bg-opacity-25 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                          <i class="bi bi-currency-rupee fs-5"></i>
                        </div>
                        <div>
                          <div class="small text-muted">Total Earnings</div>
                          <div class="fw-bold fs-5">Rs. 45,000</div>
                          <div class="text-secondary small">Since Joining</div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Monthly Earnings Card -->
                  <div class="col-12 col-md-6">
                    <div class="card bg-gradient bg-dark text-light shadow rounded-4 border-0">
                      <div class="card-body d-flex align-items-center gap-3">
                        <div class="icon-box bg-primary bg-opacity-25 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                          <i class="bi bi-calendar-event fs-5"></i>
                        </div>
                        <div>
                          <div class="small text-muted">Earnings in <span class="text-light fw-semibold"><?php echo date('F'); ?></span></div>
                          <div class="fw-bold fs-5">Rs. 12,500</div>
                          <div class="text-secondary small">Up to <?php echo date('d M Y'); ?></div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="row mt-4">
                  <div class="accordion accordion-flush" id="afUserEarningMonths">
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseJan" aria-expanded="false" aria-controls="flush-collapseJan">
                          January
                        </button>
                      </h2>
                      <div id="flush-collapseJan" class="accordion-collapse collapse" data-bs-parent="#afUserEarningMonths">
                        <div class="accordion-body">Earnings content for January goes here.</div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFeb" aria-expanded="false" aria-controls="flush-collapseFeb">
                          February
                        </button>
                      </h2>
                      <div id="flush-collapseFeb" class="accordion-collapse collapse" data-bs-parent="#afUserEarningMonths">
                        <div class="accordion-body">Earnings content for February goes here.</div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseMar" aria-expanded="false" aria-controls="flush-collapseMar">
                          March
                        </button>
                      </h2>
                      <div id="flush-collapseMar" class="accordion-collapse collapse" data-bs-parent="#afUserEarningMonths">
                        <div class="accordion-body">Earnings content for March goes here.</div>
                      </div>
                    </div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="dashboard.js"></script>

  <?php } else { ?>
    <script>
      window.location.href = "login.php";
    </script>
  <?php } ?>

</body>

</html>