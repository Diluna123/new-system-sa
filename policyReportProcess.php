<?php
include 'connection.php';
session_start();

$planType = $_POST['planTy'];
$fdate = $_POST['fdate'];
$tdate = $_POST['tdate'];

function formatNumber($num)
{
    return number_format($num, 2, '.', ',');
}

echo '<div class="card bg-dark border-0 shadow-sm rounded-3 mt-3">';
echo '<div class="card-body">';
echo '<div class="table-responsive">';
?>

<table class="table table-dark table-striped align-middle table-hover rounded-3 overflow-hidden">
    <thead class="bg-warning bg-opacity-25">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Proposal / Policy</th>
            <th scope="col">Date</th>
            <?php if ($planType == "MCFP") { ?>
                <th scope="col" class="text-end">MCFP</th>
            <?php } elseif ($planType == "FP") { ?>
                <th scope="col" class="text-end">FP</th>
            <?php } else { ?>
                <th scope="col" class="text-end">MCFP</th>
                <th scope="col" class="text-end">FP</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php

        // 🔹 Filter logic
        $uid = $_SESSION['user']['u_id'];
        $baseQuery = "SELECT * FROM `police_t` WHERE `users_u_id`='$uid' AND `status_s_id`='1'";

        if (!empty($fdate)) {
            if (!empty($tdate)) {
                $baseQuery .= " AND DATE_FORMAT(`date`, '%Y-%m') BETWEEN '$fdate' AND '$tdate'";
            } else {
                $baseQuery .= " AND `date` LIKE '%$fdate%'";
            }
        }

        if ($planType == "MCFP") {
            $baseQuery .= " AND (`payments_pay_id`='1' OR `payments_pay_id`='2' OR `payments_pay_id`='4')";
        } elseif ($planType == "FP") {
            $baseQuery .= " AND (`payments_pay_id`='3' OR `payments_pay_id`='5')";
        }

        $rDataP = Database::search($baseQuery);
        $rCount = $rDataP->num_rows;
        $totalMCFP = 0;
        $totalFP = 0;

        if ($rCount == 0) {
            echo '<tr><td colspan="5" class="text-center text-secondary py-4">No data found</td></tr>';
        } else {
            for ($i = 0; $i < $rCount; $i++) {
                $row = $rDataP->fetch_assoc();
                echo '<tr>';
                echo '<th scope="row">' . ($i + 1) . '</th>';
                echo '<td>' . $row['pro_num'] . ' / ' . $row['pol_num'] . '</td>';
                echo '<td>' . $row['date'] . '</td>';

                if ($planType == "MCFP") {
                    $totalMCFP += $row['ammount'];
                    echo '<td class="text-end text-warning">' . formatNumber($row['ammount']) . '</td>';
                } elseif ($planType == "FP") {
                    $totalFP += $row['ammount'];
                    echo '<td class="text-end text-info">' . formatNumber($row['ammount']) . '</td>';
                } else {
                    if (in_array($row['payments_pay_id'], ['1', '2', '4'])) {
                        $totalMCFP += $row['ammount'];
                        echo '<td class="text-end text-warning">' . formatNumber($row['ammount']) . '</td><td></td>';
                    } else {
                        $totalFP += $row['ammount'];
                        echo '<td></td><td class="text-end text-info">' . formatNumber($row['ammount']) . '</td>';
                    }
                }
                echo '</tr>';
            }
        }
        ?>
    </tbody>
    <tfoot class="border-top">
        <tr class="fw-semibold">
            <td colspan="<?php echo ($planType == 'all') ? 3 : 3; ?>" class="text-warning-emphasis">Sub Total</td>
            <?php if ($planType == "MCFP") { ?>
                <td class="text-end text-warning"><?php echo formatNumber($totalMCFP); ?></td>
            <?php } elseif ($planType == "FP") { ?>
                <td class="text-end text-info"><?php echo formatNumber($totalFP); ?></td>
            <?php } else { ?>
                <td class="text-end text-warning"><?php echo formatNumber($totalMCFP); ?></td>
                <td class="text-end text-info"><?php echo formatNumber($totalFP); ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="<?php echo ($planType == 'all') ? 4 : 3; ?>" class="text-warning-emphasis fw-bold">Total</td>
            <td class="bg-warning-subtle text-dark fw-bold text-end">
                <?php echo formatNumber($totalMCFP + $totalFP); ?>
            </td>
        </tr>
    </tfoot>
</table>

<?php
echo '</div></div></div>';
?>
