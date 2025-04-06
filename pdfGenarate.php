<?php
session_start();
require "./fpdf/fpdf.php";
include 'connection.php';

// Get POST data with fallback values
$planType = $_POST['planTy'] ?? '';
$fdate = $_POST['fdate'] ?? '';
$tdate = $_POST['tdate'] ?? '';

// Extend FPDF with custom header
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

        // Get the current date and time
        
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

// Query Builder Function
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

// PDF Init
$pdf = new PDF();
$pdf->SetMargins(5, 10, 5); // Minimal margins (left, top, right)
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9); // Smaller font size for fitting data

// Data Processing
$userId = $_SESSION["user"]["u_id"];
$statusId = 1;

$query = buildQuery($userId, $statusId, $planType, $fdate, $tdate);
$result = Database::search($query);

$totalMCFP = 0;
$totalFP = 0;

if ($result->num_rows == 0) {
    $pdf->Cell(0, 10, 'No data found.', 0, 1, 'C');
} else {
    $entriesByMonth = [];

    // Group rows by month
    while ($row = $result->fetch_assoc()) {
        $month = date('F Y', strtotime($row['date'])); // e.g., "April 2025"
        $entriesByMonth[$month][] = $row;
    }

    // Iterate through each month
    foreach ($entriesByMonth as $month => $entries) {
        // Add month header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, $month, 0, 1, 'C');
        $pdf->SetFont('Arial', '', 9);

        // Table Header for each month
        $pdf->Cell(40, 8, 'Proposal Number', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Policy Number', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Date', 1, 0, 'C');
        $pdf->Cell(40, 8, 'MCFP Amount', 1, 0, 'C');
        $pdf->Cell(40, 8, 'FP Amount', 1, 1, 'C');

        $monthlyTotalMCFP = 0;
        $monthlyTotalFP = 0;

        // Process each entry
        foreach ($entries as $row) {
            $isMCFP = in_array($row['payments_pay_id'], [1, 2, 4]);
            $amount = $row['ammount'];

            if ($isMCFP) {
                $totalMCFP += $amount;
                $monthlyTotalMCFP += $amount;
                $mcfpAmount = 'Rs. ' . number_format($amount, 2);
                $fpAmount = '';
            } else {
                $totalFP += $amount;
                $monthlyTotalFP += $amount;
                $mcfpAmount = '';
                $fpAmount = 'Rs. ' . number_format($amount, 2);
            }

            // Output each row in the table
            $pdf->Cell(40, 7, $row['pro_num'], 1, 0, 'C');
            $pdf->Cell(40, 7, $row['pol_num'], 1, 0, 'C');
            $pdf->Cell(40, 7, $row['date'], 1, 0, 'C');
            $pdf->Cell(40, 7, $mcfpAmount, 1, 0, 'C');
            $pdf->Cell(40, 7, $fpAmount, 1, 1, 'C');
        }

        // Add totals for MCFP and FP for the month (aligned to right)
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(170, 8, 'Total MCFP for ' . $month . ':', 0, 0, 'R');
        $pdf->Cell(30, 8, 'Rs. ' . number_format($monthlyTotalMCFP, 2), 0, 1, 'R');
        $pdf->Cell(170, 8, 'Total FP for ' . $month . ':', 0, 0, 'R');
        $pdf->Cell(30, 8, 'Rs. ' . number_format($monthlyTotalFP, 2), 0, 1, 'R');
        $pdf->Ln(4); // Add space after each month
    }

    // Output the grand totals (aligned to right)
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(170, 8, 'Total MCFP:', 0, 0, 'R');
    $pdf->Cell(30, 8, 'Rs. ' . number_format($totalMCFP, 2), 0, 1, 'R');

    $pdf->Cell(170, 8, 'Total FP:', 0, 0, 'R');
    $pdf->Cell(30, 8, 'Rs. ' . number_format($totalFP, 2), 0, 1, 'R');

    $pdf->Cell(170, 8, 'Grand Total:', 0, 0, 'R');
    $pdf->Cell(30, 8, 'Rs. ' . number_format($totalMCFP + $totalFP, 2), 0, 1, 'R');
}

// Output the PDF
$pdf->Output();
