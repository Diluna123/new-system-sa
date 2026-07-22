<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['user_id'])) {
	http_response_code(403);
	echo "Unauthorized access.";
	exit;
}

$loggedUserId = (int) $_SESSION['user_id'];
$userName = htmlspecialchars($_SESSION['user_name'] ?? 'User');

try {
	require_once __DIR__ . '/../fpdf/fpdf.php';

	// Fetch all assigned points for the logged-in user
	$pointColumns = [];
	$pointColsRs = Database::search("SHOW COLUMNS FROM `points`");
	if ($pointColsRs && $pointColsRs->num_rows > 0) {
		while ($col = $pointColsRs->fetch_assoc()) {
			$pointColumns[] = $col['Field'];
		}
	}

	$addressColumn = in_array('address', $pointColumns, true)
		? 'address'
		: (in_array('adress', $pointColumns, true) ? 'adress' : null);

	$pointSelect = "`point_id`, `shop_name`, `contact`";
	$pointSelect .= $addressColumn !== null
		? ", `{$addressColumn}` AS `point_address`"
		: ", '' AS `point_address`";

	$assignedPoints = Database::search("SELECT {$pointSelect} FROM `points` WHERE `users_u_id` = '$loggedUserId' ORDER BY `point_id` ASC");

	if (!$assignedPoints || $assignedPoints->num_rows === 0) {
		echo "No assigned points found.";
		exit;
	}

	// Create PDF
	$pdf = new FPDF();
	$pdf->AddPage();
	
	// Add logo to top right corner
	$logoPath = __DIR__ . '/../com.png';
	if (file_exists($logoPath)) {
		$pdf->Image($logoPath, 170, 8, 30);
	}

	// Left-aligned header section
	$pdf->SetFont('Arial', 'B', 18);
	$pdf->SetTextColor(52, 73, 94);
	$pdf->SetXY(10, 10);
	$pdf->Cell(0, 12, 'Assigned Points Report', 0, 1, 'L');
	
	$pdf->SetFont('Arial', '', 10);
	$pdf->SetTextColor(80, 80, 80);
	$pdf->SetXY(10, 25);
	$pdf->Cell(0, 8, 'Generated on: ' . date('F d, Y \a\t H:i'), 0, 1, 'L');
	$pdf->SetXY(10, 33);
	$pdf->Cell(0, 8, 'User: ' . $userName, 0, 1, 'L');
	$pdf->Ln(8);

	// Calculate table width and starting position for centering
	$pageWidth = $pdf->GetPageWidth();
	$tableWidth = 160; // 20 + 50 + 40 + 50
	$startX = ($pageWidth - $tableWidth) / 2;

	// Table header
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->SetFillColor(52, 73, 94);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->SetXY($startX, $pdf->GetY());
	$pdf->Cell(20, 10, 'ID', 1, 0, 'C', true);
	$pdf->Cell(50, 10, 'Shop Name', 1, 0, 'L', true);
	$pdf->Cell(40, 10, 'Contact', 1, 0, 'L', true);
	$pdf->Cell(50, 10, 'Address', 1, 1, 'L', true);

	// Table data
	$pdf->SetFont('Arial', '', 11);
	$pdf->SetTextColor(0, 0, 0);
	$rowCount = 0;

	while ($point = $assignedPoints->fetch_assoc()) {
		$isAlternate = $rowCount % 2 === 0;
		if ($isAlternate) {
			$pdf->SetFillColor(240, 245, 250);
		} else {
			$pdf->SetFillColor(255, 255, 255);
		}

		$pointId = (int) ($point['point_id'] ?? 0);
		$shopName = substr((string) ($point['shop_name'] ?? 'N/A'), 0, 35);
		$contact = substr((string) ($point['contact'] ?? 'N/A'), 0, 25);
		$address = substr((string) ($point['point_address'] ?? 'N/A'), 0, 35);

		$pdf->SetXY($startX, $pdf->GetY());
		$pdf->Cell(20, 9, $pointId, 1, 0, 'C', true);
		$pdf->Cell(50, 9, $shopName, 1, 0, 'L', true);
		$pdf->Cell(40, 9, $contact, 1, 0, 'L', true);
		$pdf->Cell(50, 9, $address, 1, 1, 'L', true);

		$rowCount++;
	}

	// Add summary
	$pdf->Ln(10);
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->SetTextColor(52, 73, 94);
	$pdf->Cell(0, 10, 'Total Assigned Points: ' . $rowCount, 0, 1, 'L');

	// Footer
	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'I', 9);
	$pdf->SetTextColor(150, 150, 150);
	$pdf->Cell(0, 8, 'This is an auto-generated report. For official use only.', 0, 1, 'C');

	// Output PDF
	$filename = 'Assigned_Points_Report_' . date('Y-m-d_H-i-s') . '.pdf';
	$pdf->Output('D', $filename);
	exit;
} catch (Exception $e) {
	http_response_code(500);
	echo "Error generating PDF: " . htmlspecialchars($e->getMessage());
	exit;
}
?>

	// Add summary
	$pdf->Ln(10);
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->SetTextColor(52, 73, 94);
	$pdf->Cell(0, 10, 'Total Assigned Points: ' . $rowCount, 0, 1, 'L');

	// Footer
	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'I', 9);
	$pdf->SetTextColor(150, 150, 150);
	$pdf->Cell(0, 8, 'This is an auto-generated report. For official use only.', 0, 1, 'C');

	// Output PDF
	$filename = 'Assigned_Points_Report_' . date('Y-m-d_H-i-s') . '.pdf';
	$pdf->Output('D', $filename);
	exit;
} catch (Exception $e) {
	http_response_code(500);
	echo "Error generating PDF: " . htmlspecialchars($e->getMessage());
	exit;
}
?>
