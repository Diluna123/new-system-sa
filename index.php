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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <?php include "connection.php";
  session_start(); ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="manifest" href="manifest.json">
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
      height: 12px;
      border-radius: 50px;
      box-shadow: 0 0 10px rgba(8, 8, 8, 0.77);
      overflow: hidden;
    }

    .progress-bar {
      animation: progressAnimation 2s ease-in-out;
    }

    .progress-bar2 {
      animation: progressAnimation2 2s ease-in-out;
    }

    .progress-bar3 {
      animation: progressAnimation3 2s ease-in-out;
    }

    #myChart {
      height: 30px;
      width: 100%;
      /* Adjust height as needed */
    }

    @media (max-width: 767px) {
      #myChart {
        height: 500px;
        /* Adjust height as needed */
      }
    }

    @keyframes progressAnimation {
      from {
        width: 0%;
      }

      to {
        width: 25%;
      }
    }

    @keyframes progressAnimation2 {
      from {
        width: 0%;
      }

      to {
        width: 55%;
      }
    }

    @keyframes progressAnimation3 {
      from {
        width: 0%;
      }

      to {
        width: 75%;
      }
    }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="dashboard.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/kute.js@2.2.4/dist/kute.min.js"></script>
</head>

<body>
  <?php if (isset($_SESSION['user'])) {



  ?>
    <?php include 'logos.php'; ?>

    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
      <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">SANASA LIFE &nbsp; <small class="text-secondary fw-light"> version 2.0.5</small></a>
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
    </header>

    <div class="container-fluid">
      <div class="row">
        <?php include 'sideMenu.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="main-dev">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
          </div>

          <div class="row mb-3">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="card">
                <div class="card-title">
                  <h6 class="card-header">Monthly Progress Chart</h6>
                </div>
                <div class="card-body">
                  <canvas class="my-4 w-100" id="myChart" style="width: 100%; height: 350px"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-6 mt-sm-2 mt-lg-0 mt-md-0 mt-2">
              <div class="card">
                <div class="card-body">
                  <canvas id="pieChart" width="100%" height="100"></canvas>

                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-6 mt-sm-2 mt-lg-0 mt-md-0 mt-2">
              <div class="card">
                <div class="card-body">

                </div>
              </div>
            </div>
          </div>

          <h2>Monthly Progress</h2>
          <div class="table-responsive small">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Month</th>
                  <th scope="col">MCFP</th>
                  <th scope="col">FP</th>
                  <th scope="col">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $summeryDataQ = Database::search("SELECT * FROM `summery_t` WHERE `users_u_id` = " . $_SESSION['user']['u_id']);
                if ($summeryDataQ->num_rows > 0) {
                  $i = 1;
                  while ($summeryData = $summeryDataQ->fetch_assoc()) {
                ?>
                    <tr>
                      <td><?php echo $i++; ?></td>
                      <td><?php echo $summeryData['month']; ?></td>
                      <td><?php echo $summeryData['mcfp']; ?></td>
                      <td><?php echo $summeryData['fp']; ?></td>
                      <td><?php echo $summeryData['total']; ?></td>
                    </tr>
                  <?php }
                } else { ?>
                  <tr>
                    <td colspan="5">No Data Found</td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>


        </main>
      </div>
    </div>


    <div class="mt-5">
      <?php include 'footer.php'; ?>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script src="dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>

    <script>
      let months = [];
      let mcfpTotals = [];
      let fpTotals = [];
      let grandTotals = [];

      <?php
      $summeryDataQ = Database::search("SELECT * FROM `summery_t` WHERE `users_u_id` = " . $_SESSION['user']['u_id']);
      if ($summeryDataQ->num_rows > 0) {
        while ($summeryData = $summeryDataQ->fetch_assoc()) {
      ?>
          months.push("<?php echo $summeryData['month']; ?>");
          mcfpTotals.push(<?php echo $summeryData['mcfp']; ?>);
          fpTotals.push(<?php echo $summeryData['fp']; ?>);
          grandTotals.push(<?php echo $summeryData['total']; ?>);
      <?php
        }
      }
      ?>

      const ctx = document.getElementById('myChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: months,
          datasets: [{
              label: 'MCFP Total',
              data: mcfpTotals,
              backgroundColor: 'rgba(72, 158, 240, 0.11)',
              borderColor: 'rgba(36, 163, 248, 0.78)',
              borderWidth: 1
            },

            {
              label: 'Grand Total',
              data: grandTotals,
              backgroundColor: 'rgba(75, 192, 192, 0.2)',
              borderColor: 'rgba(75, 192, 192, 1)',
              borderWidth: 1
            },
            {
              label: 'FP Total',
              data: fpTotals,
              backgroundColor: 'rgba(255, 159, 64, 0.2)',
              borderColor: 'rgba(255, 159, 64, 1)',
              borderWidth: 1
            }
          ]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Total Amount (Rs.)'
              }
            },
            x: {
              title: {
                display: true,
                text: 'Month'
              }
            }
          },
          responsive: true,
          plugins: {
            legend: {
              display: true,
              position: 'top'
            }
          }
        }
      });

      const toastTrigger = document.getElementById('liveToastBtn')
      const toastLiveExample = document.getElementById('liveToast')

      if (toastTrigger) {
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        toastTrigger.addEventListener('click', () => {
          toastBootstrap.show()
        })
      }
    </script>

    <script>
      const pieCtx = document.getElementById('pieChart').getContext('2d');
      <?php
      // ✅ MODIFIED: Get last month's date
      $lastMonth = date('Y-m', strtotime('first day of last month'));

      // ✅ MODIFIED: Fetch last month's summary instead of current month
      $lastMonthDataQ = Database::search("SELECT * FROM `summery_t` WHERE `users_u_id` = " . $_SESSION['user']['u_id'] . " AND `month` = '" . $lastMonth . "'");
      $lastMonthData = $lastMonthDataQ->fetch_assoc();
      $lastMCFP = $lastMonthData['mcfp'] ?? 0;
      $lastFP = $lastMonthData['fp'] ?? 0;
      ?>

      new Chart(pieCtx, {
        type: 'pie',
        data: {
          labels: ['MCFP', 'FP'],
          datasets: [{
            data: [<?php echo $lastMCFP; ?>, <?php echo $lastFP; ?>],
            backgroundColor: [
              'rgba(90, 178, 236, 0.7)', // Soft Blue for MCFP
              'rgba(252, 204, 133, 0.7)' // Soft Red for FP
            ],
            borderColor: [
              'rgb(26, 156, 243)',
              'rgb(233, 155, 38)'
            ],
            hoverBackgroundColor: [
              'rgba(54, 162, 235, 0.9)',
              'rgba(255, 174, 99, 0.9)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                color: '#f0f0f0' // Light font color for dark background
              }
            },
            title: {
              display: true,
              // ✅ MODIFIED: Update chart title to reflect last month
              text: 'MCFP vs FP - <?php echo $lastMonth; ?>',
              color: '#ffffff',
              font: {
                size: 14
              }
            }
          }
        }
      });
    </script>

  <?php } else {

  ?>
    <script>
      window.location = "login.php";
    </script>

  <?php
  }


  ?>
</body>

</html>