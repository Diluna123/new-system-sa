<?php
session_start();
include '../connection.php';
require_once __DIR__ . '/../fpdf/fpdf.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo 'Unauthorized access.';
    exit;
}

class SnapshotPDF extends FPDF
{
    public function Footer()
    {
        $this->SetY(-12);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(130, 130, 130);
        $this->Cell(0, 8, 'Page ' . $this->PageNo(), 0, 0, 'R');
    }
}

$loggedUserId = (int) ($_SESSION['user_id'] ?? 0);
$userName = (string) ($_SESSION['user_name'] ?? 'Agent');

try {
    $scope = " vc.`Points_point_id` IN (SELECT `point_id` FROM `points` WHERE `users_u_id` = '{$loggedUserId}') ";

    $summaryRs = Database::search("SELECT
        COALESCE(SUM(CASE WHEN DATE(STR_TO_DATE(REPLACE(TRIM(vc.`date_issued`), '-', '/'), '%Y/%c/%e')) = CURDATE() THEN 1 ELSE 0 END), 0) AS today_new,
        COALESCE(SUM(CASE WHEN DATE(STR_TO_DATE(REPLACE(TRIM(vc.`date_issued`), '-', '/'), '%Y/%c/%e')) BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND CURDATE() THEN 1 ELSE 0 END), 0) AS week_new,
        COALESCE(SUM(CASE WHEN vc.`v_status_cs_id` = '1' THEN 1 ELSE 0 END), 0) AS pending_total,
        COALESCE(SUM(CASE WHEN vc.`v_status_cs_id` = '2' THEN 1 ELSE 0 END), 0) AS completed_total,
        COALESCE(SUM(CASE WHEN DATEDIFF(STR_TO_DATE(REPLACE(TRIM(vc.`date_expere`), '-', '/'), '%Y/%c/%e'), CURDATE()) BETWEEN 0 AND 7 THEN 1 ELSE 0 END), 0) AS expiring_7,
        COALESCE(SUM(CASE WHEN DATEDIFF(STR_TO_DATE(REPLACE(TRIM(vc.`date_expere`), '-', '/'), '%Y/%c/%e'), CURDATE()) BETWEEN 0 AND 30 THEN 1 ELSE 0 END), 0) AS expiring_30
        FROM `v_customers` vc
        WHERE {$scope}");

    $summary = ($summaryRs && $summaryRs->num_rows > 0) ? $summaryRs->fetch_assoc() : [
        'today_new' => 0,
        'week_new' => 0,
        'pending_total' => 0,
        'completed_total' => 0,
        'expiring_7' => 0,
        'expiring_30' => 0,
    ];

    $pendingByPoint = Database::search("SELECT p.`shop_name`, COUNT(*) AS pending_count
        FROM `v_customers` vc
        INNER JOIN `points` p ON vc.`Points_point_id` = p.`point_id`
        WHERE vc.`v_status_cs_id` = '1'
          AND p.`users_u_id` = '{$loggedUserId}'
        GROUP BY p.`point_id`, p.`shop_name`
        ORDER BY pending_count DESC, p.`shop_name` ASC");

    $pdf = new SnapshotPDF('P', 'mm', 'A4');
    $pdf->SetMargins(12, 12, 12);
    $pdf->SetAutoPageBreak(true, 14);
    $pdf->AddPage();

    // Header block
    $pdf->SetFillColor(26, 35, 50);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Rect(12, 12, 186, 24, 'F');

    $pdf->SetXY(16, 16);
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(130, 8, 'Performance Snapshot', 0, 1, 'L');

    $pdf->SetX(16);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(130, 6, 'Generated for: ' . $userName . '  |  ' . date('F d, Y H:i'), 0, 1, 'L');

    $logoPath = __DIR__ . '/../com.png';
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 173, 14, 20);
    }

    $pdf->SetY(42);
    $pdf->SetTextColor(39, 39, 39);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 7, 'KPI Snapshot', 0, 1, 'L');

    $cards = [
        ['Today New', (int) ($summary['today_new'] ?? 0), [46, 134, 193]],
        ['Last 7 Days', (int) ($summary['week_new'] ?? 0), [52, 152, 219]],
        ['Pending', (int) ($summary['pending_total'] ?? 0), [241, 196, 15]],
        ['Completed', (int) ($summary['completed_total'] ?? 0), [39, 174, 96]],
        ['Expiring 7 Days', (int) ($summary['expiring_7'] ?? 0), [230, 126, 34]],
        ['Expiring 30 Days', (int) ($summary['expiring_30'] ?? 0), [155, 89, 182]],
    ];

    $startX = 12;
    $startY = $pdf->GetY() + 1;
    $cardW = 58;
    $cardH = 24;
    $gapX = 6;
    $gapY = 6;

    foreach ($cards as $idx => $card) {
        $row = (int) floor($idx / 3);
        $col = $idx % 3;
        $x = $startX + ($cardW + $gapX) * $col;
        $y = $startY + ($cardH + $gapY) * $row;

        $color = $card[2];
        $pdf->SetFillColor($color[0], $color[1], $color[2]);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Rect($x, $y, $cardW, $cardH, 'F');

        $pdf->SetXY($x + 3, $y + 4);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($cardW - 6, 5, $card[0], 0, 1, 'L');

        $pdf->SetX($x + 3);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell($cardW - 6, 10, (string) $card[1], 0, 1, 'L');
    }

    $pdf->SetY($startY + ($cardH + $gapY) * 2 + 2);
    $pdf->SetTextColor(39, 39, 39);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 7, 'Pending By Point', 0, 1, 'L');

    // Table header
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(44, 62, 80);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(140, 9, 'Point Name', 1, 0, 'L', true);
    $pdf->Cell(46, 9, 'Pending Count', 1, 1, 'C', true);

    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(15, 15, 15);

    $pointRowCount = 0;
    if ($pendingByPoint && $pendingByPoint->num_rows > 0) {
        while ($row = $pendingByPoint->fetch_assoc()) {
            $pdf->SetFillColor($pointRowCount % 2 === 0 ? 245 : 255, $pointRowCount % 2 === 0 ? 247 : 255, $pointRowCount % 2 === 0 ? 250 : 255);

            $pointName = substr((string) ($row['shop_name'] ?? 'N/A'), 0, 70);
            $count = (int) ($row['pending_count'] ?? 0);

            $pdf->Cell(140, 8, $pointName, 1, 0, 'L', true);
            $pdf->Cell(46, 8, (string) $count, 1, 1, 'C', true);
            $pointRowCount++;
        }
    } else {
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(186, 8, 'No pending customers by point.', 1, 1, 'L', true);
    }

    $pdf->Ln(4);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->SetTextColor(120, 120, 120);
    $pdf->Cell(0, 6, 'Auto-generated report for daily and weekly operational monitoring.', 0, 1, 'L');

    $filename = 'Performance_Snapshot_' . date('Y-m-d_H-i-s') . '.pdf';
    $pdf->Output('D', $filename);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo 'Error generating performance snapshot PDF.';
    exit;
}
