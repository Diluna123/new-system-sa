<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sanasa Easy – Salary</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">

    <?php
    include "connection.php";
    session_start();

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }

    $userId = $_SESSION['user']['u_id'];
    ?>
</head>

<body>

    <?php include 'logos.php'; ?>

    <header class="navbar sticky-top bg-dark shadow">
        <a class="navbar-brand px-3 text-white" href="#">SANASA LIFE</a>
    </header>

    <div class="container-fluid">
        <div class="row">
            <?php include 'sideMenu.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Salary / Commission</h1>
                </div>

                <?php
                /* --------------------------------------------------------
               FETCH ONLY MONTHS THAT HAVE POLICIES
            -------------------------------------------------------- */
                $monthsResult = Database::search("
                SELECT DISTINCT DATE_FORMAT(date, '%Y-%m') AS ym
                FROM police_t
                WHERE users_u_id = '$userId'
                  AND status_s_id = 1
                ORDER BY ym ASC
            ");

                $cumulativeCommission = 0;
                ?>

                <div class="accordion" id="commissionAccordion">

                    <?php while ($monthRow = $monthsResult->fetch_assoc()): ?>

                        <?php
                        $monthStart = $monthRow['ym'] . '-01';
                        $monthEnd   = date('Y-m-t', strtotime($monthStart));
                        $monthName  = date('F Y', strtotime($monthStart));

                        // Convert YYYY-MM to numeric month index
                        list($year, $month) = explode('-', $monthRow['ym']);
                        $startYM   = ((int)$year * 12) + (int)$month;
                        $currentYM = ((int)date('Y') * 12) + (int)date('m');

                        // Months passed (including start month)
                        $monthsPassed = ($currentYM - $startYM) - 1;






                        // 30% Plan
                        $type1 = Database::search("
                        SELECT SUM(ammount) AS total
                        FROM police_t
                        WHERE users_u_id = '$userId'
                          AND plans_p_id = 1
                          AND status_s_id = 1
                          AND date BETWEEN '$monthStart' AND '$monthEnd'
                    ")->fetch_assoc();

                        $type1Total = $type1['total'] ?? 0;
                        $comID = 1;
                        if ($monthsPassed >= 12) {
                            $comID = 2;
                        } elseif ($monthsPassed >= 24) {
                            $comID = 3;
                        } elseif ($monthsPassed >= 36) {
                            $comID = 4;
                        }elseif ($monthsPassed >= 48) {
                            $comID = 5;
                        }

                        if($comID == 1) {
                            $type1Commission = $type1Total * 0.30;
                        } elseif ($comID == 2) {
                            $cq = Database::search("SELECT `c_rate` FROM `31_table` WHERE `id_c31` = '$comID' ");
                            $cr = $cq->fetch_assoc();
                            $rate = $cr["c_rate"];
                            $type1Commission = $type1Total * $rate ;
                        } elseif ($comID == 3) {
                            $cq = Database::search("SELECT `c_rate` FROM `31_table` WHERE `id_c31` = '$comID' ");
                            $cr = $cq->fetch_assoc();
                            $rate = $cr["c_rate"];
                            $type1Commission = $type1Total * $rate ;
                        } elseif ($comID == 4) {
                            $cq = Database::search("SELECT `c_rate` FROM `31_table` WHERE `id_c31` = '$comID' ");
                            $cr = $cq->fetch_assoc();
                            $rate = $cr["c_rate"];
                            $type1Commission = $type1Total * $rate ;
                        } else {
                            $cq = Database::search("SELECT `c_rate` FROM `31_table` WHERE `id_c31` = '$comID' ");
                            $cr = $cq->fetch_assoc();
                            $rate = $cr["c_rate"];
                            $type1Commission = $type1Total * $rate ;
                        }

                        // if ($monthsPassed >= 9) {
                        //     $type1Commission = $type1Total * 0.20;
                        // } else {
                        //     $type1Commission = $type1Total * 0.30;
                        // }

                        // 15% Plan
                        $type2 = Database::search("
                        SELECT SUM(ammount) AS total
                        FROM police_t
                        WHERE users_u_id = '$userId'
                          AND plans_p_id = 2
                          AND status_s_id = 1
                          AND payments_pay_id NOT IN (3,5)
                          AND date BETWEEN '$monthStart' AND '$monthEnd'
                    ")->fetch_assoc();

                        $type2Total = $type2['total'] ?? 0;
                        if($comID == 1) {
                            $type2Commission = $type2Total * 0.15;
                        } elseif ($comID == 2) {
                            $cq = Database::search("SELECT `c_rate_p` FROM `18_table` WHERE `id_c18` = '$comID' ");
                            $cr = $cq->fetch_assoc();
                            $rate = $cr["c_rate_p"];
                            $type2Commission = $type2Total * $rate ;
                        } elseif ($comID == 3) {
                            $cq = Database::search("SELECT `c_rate_p` FROM `18_table` WHERE `id_c18` = '$comID' ");
                            $cr = $cq->fetch_assoc();
                            $rate = $cr["c_rate_p"];
                            $type2Commission = $type2Total * $rate ;
                        } else{
                            $type2Commission = $type2Total * 0 ;


                        }

                        $monthlyTotal = $type1Commission + $type2Commission;
                        $cumulativeCommission += $monthlyTotal;

                        // Policies of this month
                        $policyResult = Database::search("
                        SELECT pro_num, pol_num, date, ammount,
                               (SELECT plane FROM plans WHERE p_id = police_t.plans_p_id) AS plan_name
                        FROM police_t
                        WHERE users_u_id = '$userId'
                          AND status_s_id = 1
                          AND date BETWEEN '$monthStart' AND '$monthEnd'
                        ORDER BY date DESC
                    ");

                        $accordionId = str_replace('-', '', $monthRow['ym']);
                        ?>

                        <div class="accordion-item bg-dark border border-info mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-info fw-bold"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#m<?= $accordionId ?>">
                                    <?= $monthName ?> – Commission Summary
                                </button>
                            </h2>

                            <div id="m<?= $accordionId ?>" class="accordion-collapse collapse">
                                <div class="accordion-body">

                                    <div class="row text-secondary fw-semibold border-bottom pb-2 mb-3">
                                        <div class="col-4">Description</div>
                                        <div class="col-4 text-end">Business</div>
                                        <div class="col-4 text-end">Commission</div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-4">31 Plan </div>
                                        <div class="col-4 text-end"><?= number_format($type1Total, 2) ?></div>
                                        <div class="col-4 text-end text-warning"><?= number_format($type1Commission, 2) ?></div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-4">Pension Plan </div>
                                        <div class="col-4 text-end"><?= number_format($type2Total, 2) ?></div>
                                        <div class="col-4 text-end text-warning"><?= number_format($type2Commission, 2) ?></div>
                                    </div>

                                    <div class="row border-top pt-2 mt-3">
                                        <div class="col-8 fw-bold">
                                            Cumulative Commission (up to <?= $monthName ?>)
                                        </div>
                                        <div class="col-4 text-end text-success fw-bold">
                                            <?= number_format($cumulativeCommission, 2) ?>
                                        </div>
                                    </div>

                                    <div class="table-responsive mt-4">
                                        <table class="table table-dark table-bordered table-striped">
                                            <thead class="table-info text-dark">
                                                <tr>
                                                    <th>Proposal No</th>
                                                    <th>Policy No</th>
                                                    <th>Date</th>
                                                    <th>Plan</th>
                                                    <th class="text-end">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($p = $policyResult->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?= $p['pro_num'] ?></td>
                                                        <td><?= $p['pol_num'] ?></td>
                                                        <td><?= date('Y-m-d', strtotime($p['date'])) ?></td>
                                                        <td><?= $p['plan_name'] ?></td>
                                                        <td class="text-end"><?= number_format($p['ammount'], 2) ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                </div>

                <div class="col-md-8 mx-auto mt-5 mb-5">
                    <div class="card bg-dark border-success">
                        <div class="card-header text-success fw-bold">
                            TOTAL COMMISSION
                        </div>
                        <div class="card-body text-end">
                            <h2 class="text-success">
                                <?= number_format($cumulativeCommission, 2) ?> Rs
                            </h2>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>