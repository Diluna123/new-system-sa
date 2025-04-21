<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
  <script src="/assets/js/color-modes.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sanasa Easy</title>
  <link rel="icon" type="image/png" href="sansalogo.png">

  <?php include "connection.php";
  session_start();
  ?>

  <!-- Bootstrap & Plugins -->
  <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" />
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="dashboard.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
  <link rel="stylesheet" href="css/border.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/kute.js@2.2.4/dist/kute.min.js"></script>

  <style>
    .card-body small {
      font-weight: bold;
    }

    /* Card hover effects */
    .myCard,
    .card.border-info-subtle,
    .card.border-danger-subtle,
    .card.border-warning-subtle {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
      overflow: hidden;
      position: relative;
    }

    .myCard:hover,
    .card.border-info-subtle:hover,
    .card.border-danger-subtle:hover,
    .card.border-warning-subtle:hover {
      transform: scale(1.05);
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
      z-index: 1;
    }

    /* Hidden details initially */
    .card-details {
      display: none;
      font-size: 0.8rem;
      color: #bbb;
    }

    /* Show on hover */
    .myCard:hover .card-details,
    .card.border-info-subtle:hover .card-details,
    .card.border-danger-subtle:hover .card-details,
    .card.border-warning-subtle:hover .card-details {
      display: block;
      animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(5px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }


    @media (max-width: 768px) {

      .card-body input,
      .card-body select {
        font-size: 0.9rem;
      }

      .table-responsive {
        font-size: 0.85rem;
      }

      .form-label {
        font-size: 0.85rem;
      }



    }
  </style>
</head>

<body>
  <?php

  if (isset($_SESSION['user'])) {
  ?>

    <?php include 'logos.php'; ?>

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
        <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search">
      </div>
    </header>

    <div class="container-fluid">
      <div class="row">
        <?php include 'sideMenu.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
          <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
            <h1 class="h2">Mobile Day</h1>
          </div>

          <!-- PHP: Fetch Totals for Today -->
          <?php
          $today = (new DateTime('now', new DateTimeZone('Asia/Colombo')))->format('Y-m-d');

          // Get today's MCFP total (Assuming plans_p_id = 1)
          $mcfpResult = Database::search("SELECT SUM(`ammount`) AS total FROM `mobiled` WHERE `m_date` = '$today' AND (`payments_pay_id`='1'OR `payments_pay_id`='2' OR `payments_pay_id`='4')");
          $mcfp = $mcfpResult->fetch_assoc()["total"] ?? 0;

          // Get today's FP total (Assuming plans_p_id = 2)
          $fpResult = Database::search("SELECT SUM(`ammount`) AS total FROM `mobiled` WHERE `m_date` = '$today' AND (`payments_pay_id`='3'OR `payments_pay_id`='5') ");
          $fp = $fpResult->fetch_assoc()["total"] ?? 0;

          // Get total number of policies today
          $nopsResult = Database::search("SELECT COUNT(*) AS count FROM `mobiled` WHERE `m_date` = '$today'");
          $nops = $nopsResult->fetch_assoc()["count"] ?? 0;

          // Grand total
          $grandTotal = $mcfp + $fp;
          ?>

          <!-- Cards Section -->
          <!-- Cards Section -->
          <div class="row g-3 mb-3">
            <!-- MCFP Card -->
            <div class="col-6 col-sm-4 col-lg-3">
              <div class="card myCard border-left-success h-100">
                <div class="card-body">
                  <small>MCFP:</small>
                  <div><label><?= number_format($mcfp, 2) ?> /=</label></div>
                  <div class="card-details mt-2">
                    <small><i class="bi bi-cash-stack me-1"></i>Types: 1, 2, 4</small><br>
                    <small><i class="bi bi-calendar3 me-1"></i>Date: <?= $today ?></small>
                  </div>
                </div>
              </div>
            </div>

            <!-- FP Card -->
            <div class="col-6 col-sm-4 col-lg-3">
              <div class="card myCard  border-left-info h-100">
                <div class="card-body">
                  <small>FP:</small>
                  <div><label><?= number_format($fp, 2) ?> /=</label></div>
                  <div class="card-details mt-2">
                    <small><i class="bi bi-cash-coin me-1"></i>Types: 3, 5</small><br>
                    <small><i class="bi bi-calendar3 me-1"></i>Date: <?= $today ?></small>
                  </div>
                </div>
              </div>
            </div>

            <!-- Nops Card -->
            <div class="col-6 col-sm-4 col-lg-3">
              <div class="card myCard border-left-danger h-100">
                <div class="card-body">
                  <small>Nops:</small>
                  <div><label><?= $nops ?></label></div>
                  <div class="card-details mt-2">
                    <small><i class="bi bi-person-lines-fill me-1"></i>Total policies added</small><br>
                    <small><i class="bi bi-calendar3 me-1"></i>Date: <?= $today ?></small>
                  </div>
                </div>
              </div>
            </div>

            <!-- Grand Total Card -->
            <div class="col-6 col-sm-12 col-lg-3">
              <div class="card myCard  border-left-warning h-100">
                <div class="card-body">
                  <small>Total:</small>
                  <div><label><?= number_format($grandTotal, 2) ?> /=</label></div>
                  <div class="card-details mt-2">
                    <small><i class="bi bi-graph-up me-1"></i>MCFP + FP</small><br>
                    <small><i class="bi bi-calendar3 me-1"></i>Date: <?= $today ?></small>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Form & Table Section -->
          <div class="row g-4">
            <div class="col-lg-6">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row g-2 mb-2">
                    <div class="col-6">
                      <label class="form-label">First Name:</label>
                      <input type="text" class="form-control form-control-sm" id="Mfname" placeholder="First Name">
                    </div>
                    <div class="col-6">
                      <label class="form-label">Last Name:</label>
                      <input type="text" class="form-control form-control-sm" id="Mlname" placeholder="Last Name">
                    </div>
                  </div>
                  <div class="mb-2">
                    <label class="form-label">Contact Number:</label>
                    <input type="number" class="form-control form-control-sm" id="Mcnum" placeholder="Contact Number">
                  </div>
                  <div class="mb-2">
                    <label class="form-label">Amount:</label>
                    <input type="number" class="form-control form-control-sm" id="Mammount" placeholder="Amount" min="0" step="0.01">
                  </div>
                  <div class="mb-2">
                    <label class="form-label">Plan:</label>
                    <select class="form-control form-control-sm" id="Mplan">
                      <option value="">Select Plan</option>
                      <?php
                      $getPlanes = Database::search("SELECT * FROM `plans`");
                      while ($dataPlanes = $getPlanes->fetch_assoc()) {
                        echo "<option value='{$dataPlanes['p_id']}'>{$dataPlanes['plane']}</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="row mb-2">
                    <div>
                      <label for="" class="form-label">Payment Type : <span class="text-danger">*</span></label>

                      <select class="form-control form-control-sm" id="Mpayment">
                        <?php
                        $padata = Database::search("SELECT * FROM `payments`");
                        for ($i = 0; $i < $padata->num_rows; $i++) {
                          $row2 = $padata->fetch_assoc();
                        ?>
                          <option value="<?php echo $row2['pay_id']; ?>"><?php echo $row2['payment_ty']; ?></option>


                        <?php
                        }


                        ?>

                      </select>
                    </div>

                  </div>
                  <div class="mb-3">
                    <label class="form-label">Location:</label>
                    <input type="text" class="form-control form-control-sm" id="Mloc" onclick="getLocation('Mloc');" placeholder="Location">
                  </div>
                  <div class="text-end">
                    <button class="btn btn-sm btn-warning col-4" onclick="addMCustomer();">Submit</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Mobile Day Poicy Table -->
            <div class="col-lg-6">
              <input type="date" class="form-control form-control-sm mb-3" id="searchInputMD" placeholder="Search" onchange="searchMD();">
              <div class="table-responsive small">
                <table class="table table-striped table-sm table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>C.Name</th>
                      <th>Contact</th>
                      <th>Date</th>
                      <th>plane</th>
                      <th>Ammount</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody id="searchResultsMD">
                    <?php
                    $datetime = new DateTime('now', new DateTimeZone('Asia/Colombo'));
                    $today = $datetime->format('Y-m-d');

                    $getMDPolicys = Database::search("SELECT * FROM `mobiled` JOIN `plans` ON `mobiled`.`plans_p_id`=`plans`.`p_id` WHERE `m_date` = '$today'  ORDER BY `mobiled`.`m_date` DESC");
                    if ($getMDPolicys->num_rows > 0) {
                      for ($counter = 0; $counter < $getMDPolicys->num_rows; $counter++) {
                        $dataMDPolicys = $getMDPolicys->fetch_assoc();

                    ?>
                        <tr onclick="getMDPolicysDetails(<?php echo $dataMDPolicys['m_id']; ?>);">
                          <td><?php echo ($counter + 1); ?></td>
                          <td><?php echo $dataMDPolicys["M_fname"] . " " . $dataMDPolicys["M_lname"]; ?></td>
                          <td><?php echo $dataMDPolicys["M_contact"]; ?></td>
                          <td><?php echo $dataMDPolicys["m_date"]; ?></td>
                          <td><?php echo $dataMDPolicys["plane"]; ?></td>
                          <td><?php echo $dataMDPolicys["ammount"]; ?></td>
                          <?php if ($dataMDPolicys["assignStatus"] == 0) {
                            echo "<td><span class='badge text-bg-danger'>Not Assigned</span></td>";
                          } else if ($dataMDPolicys["assignStatus"] == 1) {
                            echo "<td><span class='badge text-bg-success'>Assigned</span></td>";
                          } ?>

                        </tr>




                    <?php



                      }
                    } else {
                      echo "<tr><td colspan='7' class='text-center text-muted fw-bold'>NO CUSTOMER LEADS</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="detailsViewCanvasMobile" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasRightLabel">More Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body" id="detailsViewCanvasMobileBody">
            </div>
          </div>
          <div class="toast-container position-fixed bottom-0 end-0 p-3">

            <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="d-flex">
                <div class="toast-body" id="toastBody">

                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
            </div>
          </div>



        </main>
      </div>
    </div>

    <div class="mt-5"><?php include 'footer.php'; ?></div>

    <!-- Scripts -->
    <script src="dashboard.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  <?php
  } else { ?>
    <script>
      window.location.href = "login.php";
    </script>
  <?php } ?>
</body>

</html>