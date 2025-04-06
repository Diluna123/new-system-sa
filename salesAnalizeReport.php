<?php
session_start();
require "./fpdf/fpdf.php";
include 'connection.php';

$planType = $_POST['planTy'] ?? '';
$fdate = $_POST['fdate'] ?? '';
$tdate = $_POST['tdate'] ?? '';

if (isset($_SESSION['user'])) {
    class PDF extends FPDF
    {
        function Header()
        {
            $this->SetFont('Arial', '', 10);
            $this->SetY(8);
            $lineHeight = 5;
            $labelWidth = 25;
            $valueWidth = 60;
            $this->Image('sansa.png', 170, 5, 30);

            $positionId = $_SESSION["user"]["position_pid"] ?? 0;
            $designation = ($positionId == 1) ? "SPO" : (($positionId == 2) ? "TL" : "Staff");
            date_default_timezone_set('Asia/Colombo');

            $date = date('Y-m-d') . " " . date('h:i A');
            $name = $_SESSION["user"]["u_fname"] . " " . $_SESSION["user"]["u_lname"];
            $code = $_SESSION["user"]["code"];
            $branch = "Madampe";

            $this->Cell($labelWidth, $lineHeight, 'Designation:', 0, 0);
            $this->Cell($valueWidth, $lineHeight, $designation, 0, 1);

            $this->Cell($labelWidth, $lineHeight, 'Date:', 0, 0);
            $this->Cell($valueWidth, $lineHeight, $date, 0, 1);

            $this->Cell($labelWidth, $lineHeight, 'Name:', 0, 0);
            $this->Cell($valueWidth, $lineHeight, $name, 0, 1);

            $this->Cell($labelWidth, $lineHeight, 'Code:', 0, 0);
            $this->Cell($valueWidth, $lineHeight, $code, 0, 1);

            $this->Cell($labelWidth, $lineHeight, 'Branch:', 0, 0);
            $this->Cell($valueWidth, $lineHeight, $branch, 0, 1);

            $this->Ln(3);
        }

        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
        }
    }

    function buildQuery($userId, $statusId, $planType, $fdate, $tdate)
    {
        $base = "SELECT * FROM `police_t` WHERE `users_u_id` = '$userId' AND `status_s_id` = '$statusId'";
        $payIds = [];

        if ($planType === 'MCFP') {
            $payIds = [1, 2, 4];
        } elseif ($planType === 'FP') {
            $payIds = [3, 5];
        }

        if (!empty($payIds)) {
            $payIn = implode(",", $payIds);
            $base .= " AND `payments_pay_id` IN ($payIn)";
        }

        if (!empty($fdate)) {
            if (!empty($tdate)) {
                $base .= " AND DATE_FORMAT(`date`, '%Y-%m') BETWEEN '$fdate' AND '$tdate'";
            } else {
                $base .= " AND `date` LIKE '$fdate%'";
            }
        }

        return $base;
    }

    $pdf = new PDF();
    $pdf->SetMargins(5, 10, 5);
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 9);

    $userId = $_SESSION["user"]["u_id"];
    $statusId = 1;

    $query = buildQuery($userId, $statusId, $planType, $fdate, $tdate);
    $result = Database::search($query);

    $totalMCFP = 0;
    $totalFP = 0;
    $monthlyStats = [];

    if ($result->num_rows == 0) {
        $pdf->Cell(0, 10, 'No data found.', 0, 1, 'C');
    } else {
        while ($row = $result->fetch_assoc()) {
            $monthKey = date('Y-m', strtotime($row['date']));
            $isMCFP = in_array($row['payments_pay_id'], [1, 2, 4]);
            $amount = $row['ammount'];

            if (!isset($monthlyStats[$monthKey])) {
                $monthlyStats[$monthKey] = ['mcfp' => 0, 'fp' => 0];
            }

            if ($isMCFP) {
                $monthlyStats[$monthKey]['mcfp'] += $amount;
                $totalMCFP += $amount;
            } else {
                $monthlyStats[$monthKey]['fp'] += $amount;
                $totalFP += $amount;
            }
        }

        ksort($monthlyStats);

        // Table Title (centered)
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, 'Monthly Summary Report', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 9);

        // Table headers
        $pdf->Cell(80, 8, 'Month', 1, 0, 'C');
        $pdf->Cell(55, 8, 'MCFP Total', 1, 0, 'C');
        $pdf->Cell(55, 8, 'FP Total', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 9);

        // Centered Table Content
        foreach ($monthlyStats as $monthKey => $stat) {
            $monthFormatted = date('F Y', strtotime($monthKey . '-01'));
            // Center each row based on the page width
            $pdf->Cell(80, 8, $monthFormatted, 1, 0, 'C');
            $pdf->Cell(55, 8, 'Rs. ' . number_format($stat['mcfp'], 2), 1, 0, 'R');
            $pdf->Cell(55, 8, 'Rs. ' . number_format($stat['fp'], 2), 1, 1, 'R');
        }

        if (count($monthlyStats) > 0) {
            $avgMCFP = array_sum(array_column($monthlyStats, 'mcfp')) / count($monthlyStats);
            $avgFP = array_sum(array_column($monthlyStats, 'fp')) / count($monthlyStats);

            // Get last month's totals
            $lastMonth = end($monthlyStats);
            $lastMonthMCFP = $lastMonth['mcfp'];
            $lastMonthFP = $lastMonth['fp'];

            // Estimated next month = last month + average
            $estimatedMCFP = $lastMonthMCFP + $avgMCFP;
            $estimatedFP = $lastMonthFP + $avgFP;

            // Estimated next month (centered)
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(80, 8, 'Estimated Next Month', 1, 0, 'C');
            $pdf->Cell(55, 8, 'Rs. ' . number_format($estimatedMCFP, 2), 1, 0, 'R');
            $pdf->Cell(55, 8, 'Rs. ' . number_format($estimatedFP, 2), 1, 1, 'R');
        }

        // Total calculations (centered)
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(170, 8, 'Total MCFP:', 0, 0, 'R');
        $pdf->Cell(30, 8, 'Rs. ' . number_format($totalMCFP, 2), 0, 1, 'R');

        $pdf->Cell(170, 8, 'Total FP:', 0, 0, 'R');
        $pdf->Cell(30, 8, 'Rs. ' . number_format($totalFP, 2), 0, 1, 'R');

        $pdf->Cell(170, 8, 'Grand Total:', 0, 0, 'R');
        $pdf->Cell(30, 8, 'Rs. ' . number_format($totalMCFP + $totalFP, 2), 0, 1, 'R');
    }

    $pdf->Output();
} else {
    echo "<script>alert('Please login to access this page.');</script>";
    echo "<script>window.location = 'index.php';</script>";
    exit();
}
