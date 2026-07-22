<?php
include '../connection.php';
include './authGuard.php';

$loggedUserId = (int) ($_SESSION['user_id'] ?? 0);
$customerScope = " `Points_point_id` IN (SELECT `point_id` FROM `points` WHERE `users_u_id` = '{$loggedUserId}') ";

$statsRs = Database::search("SELECT COUNT(*) AS total_count, COALESCE(SUM(CASE WHEN `v_status_cs_id` = '1' THEN 1 ELSE 0 END), 0) AS pending_count, COALESCE(SUM(CASE WHEN `v_status_cs_id` = '2' THEN 1 ELSE 0 END), 0) AS completed_count FROM `v_customers` WHERE {$customerScope}");
$stats = ($statsRs && $statsRs->num_rows > 0)
	? $statsRs->fetch_assoc()
	: ['total_count' => 0, 'pending_count' => 0, 'completed_count' => 0];

$pendingCustomers = Database::search("SELECT vc.*, vt.`v_type`, p.`shop_name` AS `point_name` FROM `v_customers` vc LEFT JOIN `vehical_typs` vt ON vc.`vehical_typs_vty_id` = vt.`vty_id` LEFT JOIN `points` p ON vc.`Points_point_id` = p.`point_id` WHERE vc.`v_status_cs_id` = '1' AND vc.`Points_point_id` IN (SELECT `point_id` FROM `points` WHERE `users_u_id` = '{$loggedUserId}') ORDER BY vc.`vh_cid` DESC");
$completedCustomers = Database::search("SELECT vc.*, vt.`v_type`, p.`shop_name` AS `point_name` FROM `v_customers` vc LEFT JOIN `vehical_typs` vt ON vc.`vehical_typs_vty_id` = vt.`vty_id` LEFT JOIN `points` p ON vc.`Points_point_id` = p.`point_id` WHERE vc.`v_status_cs_id` = '2' AND vc.`Points_point_id` IN (SELECT `point_id` FROM `points` WHERE `users_u_id` = '{$loggedUserId}') ORDER BY vc.`vh_cid` DESC");
$vehicleTypes = Database::search("SELECT `v_type`, `price` FROM `vehical_typs` ORDER BY `v_type` ASC");

$renewalAlerts = Database::search("SELECT x.`vh_cid`, x.`vc_name`, x.`v_number`, x.`vc_contact`, x.`date_expere`, x.`v_type`, x.`point_name`, DATEDIFF(x.`expiry_date`, CURDATE()) AS `days_left` FROM (SELECT vc.`vh_cid`, vc.`vc_name`, vc.`v_number`, vc.`vc_contact`, vc.`date_expere`, vt.`v_type`, p.`shop_name` AS `point_name`, STR_TO_DATE(REPLACE(TRIM(vc.`date_expere`), '-', '/'), '%Y/%c/%e') AS `expiry_date` FROM `v_customers` vc LEFT JOIN `vehical_typs` vt ON vc.`vehical_typs_vty_id` = vt.`vty_id` LEFT JOIN `points` p ON vc.`Points_point_id` = p.`point_id` WHERE vc.`Points_point_id` IN (SELECT `point_id` FROM `points` WHERE `users_u_id` = '{$loggedUserId}')) x WHERE x.`expiry_date` IS NOT NULL AND DATEDIFF(x.`expiry_date`, CURDATE()) <= 30 ORDER BY `days_left` ASC, x.`vh_cid` DESC LIMIT 100");

$renewalSummary = [
	'overdue' => 0,
	'd7' => 0,
	'd15' => 0,
	'd30' => 0,
];

$renewalRows = [];
if ($renewalAlerts && $renewalAlerts->num_rows > 0) {
	while ($ra = $renewalAlerts->fetch_assoc()) {
		$daysLeft = (int) ($ra['days_left'] ?? 9999);
		if ($daysLeft < 0) {
			$renewalSummary['overdue']++;
		} elseif ($daysLeft <= 7) {
			$renewalSummary['d7']++;
		} elseif ($daysLeft <= 15) {
			$renewalSummary['d15']++;
		} elseif ($daysLeft <= 30) {
			$renewalSummary['d30']++;
		}
		$renewalRows[] = $ra;
	}
}

$duplicateVehicleMap = [];
$duplicateChassisMap = [];

$duplicateVehicleRs = Database::search("SELECT UPPER(TRIM(`v_number`)) AS `v_number_key`, COUNT(*) AS `dup_count` FROM `v_customers` WHERE {$customerScope} GROUP BY UPPER(TRIM(`v_number`)) HAVING COUNT(*) > 1");
if ($duplicateVehicleRs && $duplicateVehicleRs->num_rows > 0) {
	while ($dv = $duplicateVehicleRs->fetch_assoc()) {
		$key = (string) ($dv['v_number_key'] ?? '');
		if ($key !== '') {
			$duplicateVehicleMap[$key] = (int) ($dv['dup_count'] ?? 2);
		}
	}
}

$duplicateChassisRs = Database::search("SELECT UPPER(TRIM(`ch_number`)) AS `ch_number_key`, COUNT(*) AS `dup_count` FROM `v_customers` WHERE {$customerScope} GROUP BY UPPER(TRIM(`ch_number`)) HAVING COUNT(*) > 1");
if ($duplicateChassisRs && $duplicateChassisRs->num_rows > 0) {
	while ($dc = $duplicateChassisRs->fetch_assoc()) {
		$key = (string) ($dc['ch_number_key'] ?? '');
		if ($key !== '') {
			$duplicateChassisMap[$key] = (int) ($dc['dup_count'] ?? 2);
		}
	}
}

$followUpRows = [];
$followUpSource = Database::search("SELECT vc.`vh_cid`, vc.`vc_name`, vc.`v_number`, vc.`ch_number`, vc.`vc_contact`, vc.`date_issued`, vc.`date_expere`, vt.`v_type`, p.`shop_name` AS `point_name` FROM `v_customers` vc LEFT JOIN `vehical_typs` vt ON vc.`vehical_typs_vty_id` = vt.`vty_id` LEFT JOIN `points` p ON vc.`Points_point_id` = p.`point_id` WHERE vc.`v_status_cs_id` = '1' AND vc.`Points_point_id` IN (SELECT `point_id` FROM `points` WHERE `users_u_id` = '{$loggedUserId}') ORDER BY vc.`vh_cid` DESC LIMIT 150");
if ($followUpSource && $followUpSource->num_rows > 0) {
	while ($fr = $followUpSource->fetch_assoc()) {
		$issueRaw = trim((string) ($fr['date_issued'] ?? ''));
		$expiryRaw = trim((string) ($fr['date_expere'] ?? ''));
		$issueTs = strtotime(str_replace('/', '-', $issueRaw));
		$expiryTs = strtotime(str_replace('/', '-', $expiryRaw));
		$pendingDays = $issueTs ? (int) floor((time() - $issueTs) / 86400) : 0;
		$expiryDays = $expiryTs ? (int) floor(($expiryTs - time()) / 86400) : 999;

		if ($pendingDays >= 3 || $expiryDays <= 7) {
			$fr['pending_days'] = $pendingDays;
			$fr['expiry_days'] = $expiryDays;
			$followUpRows[] = $fr;
		}
	}
}

$recentPending = Database::search("SELECT `vc_name`, `v_number`, `date_issued` FROM `v_customers` WHERE `v_status_cs_id` = '1' AND {$customerScope} ORDER BY `vh_cid` DESC LIMIT 5");

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

$locationColumn = in_array('location', $pointColumns, true)
	? 'location'
	: (in_array('loca', $pointColumns, true) ? 'loca' : null);

$pointSelect = "`point_id`, `shop_name`, `contact`";
$pointSelect .= $addressColumn !== null
	? ", `{$addressColumn}` AS `point_address`"
	: ", '' AS `point_address`";

$pointSelect .= $locationColumn !== null
	? ", `{$locationColumn}` AS `point_location`"
	: ", '' AS `point_location`";

$assignedPoints = Database::search("SELECT {$pointSelect} FROM `points` WHERE `users_u_id` = '$loggedUserId' ORDER BY `point_id` DESC");
$pointFilterOptions = Database::search("SELECT `point_id`, `shop_name` FROM `points` WHERE `users_u_id` = '{$loggedUserId}' ORDER BY `shop_name` ASC");
?>
<!doctype html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="../com.png">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#0f1115">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="apple-mobile-web-app-title" content="Sanasa Easy">
	<title>Insurance Agents Panel</title>
	<link rel="manifest" href="manifest.webmanifest">
	<link rel="apple-touch-icon" href="../com.png">

	<link
		href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
		rel="stylesheet"
		integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
		crossorigin="anonymous">
	<link
		rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

	<style>
		:root {
			--bg-main: #0f1115;
			--bg-panel: #171a21;
			--bg-panel-soft: #1e232c;
			--line: #2d3440;
			--text-main: #f1f5f9;
			--text-soft: #9aa4b2;
			--accent: #00c2ff;
			--success: #17b26a;
		}

		body {
			min-height: 100vh;
			font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
			color: var(--text-main);
			background:
				radial-gradient(circle at 10% 10%, rgba(0, 194, 255, 0.08), transparent 35%),
				radial-gradient(circle at 90% 90%, rgba(0, 255, 179, 0.08), transparent 30%),
				var(--bg-main);
		}

		.page-shell {
			min-height: 100vh;
			padding: 18px;
		}

		.panel-card {
			background: var(--bg-panel);
			border: 1px solid var(--line);
			border-radius: 16px;
			box-shadow: 0 14px 30px rgba(0, 0, 0, 0.25);
		}

		.topbar {
			display: flex;
			justify-content: space-between;
			align-items: center;
			gap: 10px;
			margin-bottom: 14px;
		}

		.tab-nav .nav-link {
			color: var(--text-soft);
			border: 1px solid transparent;
			border-radius: 12px;
			text-align: left;
		}

		.tab-nav .nav-link:hover {
			color: var(--text-main);
			border-color: var(--line);
			background-color: rgba(255, 255, 255, 0.03);
		}

		.tab-nav .nav-link.active {
			color: var(--text-main);
			background: rgba(0, 194, 255, 0.14);
			border-color: rgba(0, 194, 255, 0.45);
		}

		.stat-card {
			border: 1px solid #2f3a48;
			border-radius: 14px;
			background: linear-gradient(180deg, #1a212c 0%, #141b24 100%);
			padding: 16px;
			height: 100%;
		}

		.stat-label {
			color: #9fb0c5;
			font-size: 0.85rem;
			text-transform: uppercase;
			letter-spacing: 0.7px;
			margin-bottom: 8px;
		}

		.stat-value {
			font-size: 1.8rem;
			font-weight: 800;
			line-height: 1;
		}

		.customer-card {
			background: linear-gradient(180deg, #1a1f28 0%, #141923 100%);
			border: 1px solid #314055;
			border-radius: 16px;
			padding: 15px;
			height: 100%;
		}

		.customer-card.completed {
			border-color: #2f624f;
			background: linear-gradient(180deg, #17221d 0%, #111914 100%);
		}

		.status-badge {
			display: inline-block;
			font-size: 0.72rem;
			letter-spacing: 0.7px;
			text-transform: uppercase;
			padding: 3px 9px;
			border-radius: 999px;
			margin-bottom: 8px;
		}

		.status-badge.pending {
			color: #8de9ff;
			background: rgba(11, 88, 106, 0.4);
			border: 1px solid #35677b;
		}

		.status-badge.completed {
			color: #98f3bf;
			background: rgba(23, 110, 67, 0.35);
			border: 1px solid #2f7f58;
		}

		.dup-badge {
			display: inline-block;
			font-size: 0.68rem;
			letter-spacing: 0.55px;
			text-transform: uppercase;
			padding: 2px 8px;
			border-radius: 999px;
			margin-left: 6px;
			border: 1px solid #7b5e1d;
			color: #ffd98a;
			background: rgba(123, 94, 29, 0.3);
		}

		.vehicle-title {
			font-size: 1.1rem;
			font-weight: 800;
			margin-bottom: 2px;
			color: #eaffff;
		}

		.customer-name {
			color: #a9bbcf;
			margin-bottom: 10px;
			font-size: 0.92rem;
		}

		.meta {
			font-size: 0.9rem;
			color: #d4dde9;
			margin-bottom: 4px;
		}

		.meta span {
			color: #9fb0c5;
			margin-right: 6px;
		}

		.check-btn {
			margin-top: 12px;
			border: none;
			width: 100%;
			min-height: 40px;
			border-radius: 10px;
			font-weight: 600;
			color: #051018;
			background: linear-gradient(135deg, var(--accent) 0%, var(--success) 120%);
		}

		.check-btn:disabled {
			opacity: 0.7;
		}

		.recent-list .list-group-item {
			background: #1b222d;
			border: 1px solid #2d3745;
			color: #dbe6f2;
		}

		.empty-note {
			color: var(--text-soft);
			margin: 0;
		}

		.developer-hero {
			background:
				radial-gradient(circle at 85% 0%, rgba(0, 194, 255, 0.18), transparent 42%),
				linear-gradient(135deg, #1e2633 0%, #141b26 100%);
			border: 1px solid #344356;
			border-radius: 16px;
			padding: 20px;
			margin-bottom: 16px;
		}

		.developer-kicker {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			font-size: 0.75rem;
			letter-spacing: 0.7px;
			text-transform: uppercase;
			color: #98e6ff;
			border: 1px solid #2d5c72;
			background: rgba(0, 194, 255, 0.12);
			border-radius: 999px;
			padding: 5px 10px;
			margin-bottom: 10px;
		}

		.developer-title {
			margin: 0;
			font-size: 1.45rem;
			font-weight: 700;
		}

		.developer-subtitle {
			margin: 8px 0 0;
			color: #a9bbcf;
			font-size: 0.92rem;
		}

		.developer-grid {
			display: grid;
			grid-template-columns: repeat(12, minmax(0, 1fr));
			gap: 12px;
		}

		.developer-card {
			grid-column: span 12;
			background: linear-gradient(180deg, #1a202b 0%, #141a23 100%);
			border: 1px solid #2e3848;
			border-radius: 14px;
			padding: 14px;
		}

		.developer-card.span-6 {
			grid-column: span 6;
		}

		.developer-card h6 {
			margin: 0 0 10px 0;
			font-size: 0.92rem;
			font-weight: 700;
			letter-spacing: 0.6px;
			text-transform: uppercase;
			color: #a8d8e7;
		}

		.developer-row {
			display: flex;
			justify-content: space-between;
			gap: 10px;
			padding: 8px 0;
			border-bottom: 1px dashed #2f3947;
		}

		.developer-row:last-child {
			border-bottom: none;
			padding-bottom: 0;
		}

		.developer-label {
			color: #8ea0b7;
			font-size: 0.9rem;
		}

		.developer-value {
			color: #e4eef7;
			font-size: 0.9rem;
			font-weight: 600;
			text-align: right;
		}

		.account-box {
			margin-top: 14px;
			padding: 14px;
			border: 1px solid #334052;
			border-radius: 12px;
			background: rgba(255, 255, 255, 0.02);
		}

		.account-email {
			margin-bottom: 0;
			color: #9fb0c5;
		}

		.point-card {
			background: linear-gradient(180deg, #1a202b 0%, #141a23 100%);
			border: 1px solid #2e3848;
			border-radius: 14px;
			padding: 14px;
			height: 100%;
		}

		.point-title {
			font-size: 1rem;
			font-weight: 700;
			margin-bottom: 6px;
		}

		.point-meta {
			font-size: 0.9rem;
			color: #c9d6e7;
			margin-bottom: 4px;
		}

		.point-meta span {
			color: #8ea0b7;
			margin-right: 6px;
		}

		.btn-point {
			border: none;
			color: #051018;
			font-weight: 700;
			border-radius: 10px;
			background: linear-gradient(135deg, var(--accent) 0%, var(--success) 120%);
		}

		.btn-point:hover {
			color: #051018;
			filter: brightness(1.05);
		}

		.search-control {
			min-height: 38px;
			background-color: #1e232c;
			border: 1px solid #2d3440;
			color: #f1f5f9;
			border-radius: 10px;
		}

		.search-control:focus {
			background-color: #252b36;
			border-color: #00c2ff;
			color: #f1f5f9;
			box-shadow: 0 0 0 0.2rem rgba(0, 194, 255, 0.18);
		}

		.customer-docs {
			display: flex;
			flex-wrap: wrap;
			gap: 8px;
			margin-top: 10px;
		}

		.doc-link {
			display: inline-flex;
			align-items: center;
			gap: 5px;
			font-size: 0.8rem;
			color: #b5ecff;
			border: 1px solid #365067;
			border-radius: 999px;
			padding: 4px 9px;
			text-decoration: none;
			background: rgba(0, 194, 255, 0.08);
		}

		.doc-link:hover {
			color: #e7f9ff;
			border-color: #4a6f90;
		}

		.price-table-card {
			background: linear-gradient(180deg, #1a202b 0%, #141a23 100%);
			border: 1px solid #2e3848;
			border-radius: 14px;
			overflow: hidden;
		}

		.price-table {
			margin-bottom: 0;
			color: #dce7f5;
		}

		.price-table thead th {
			background: #1f2835;
			border-bottom-color: #334155;
			color: #a8d8e7;
			font-weight: 700;
			letter-spacing: 0.4px;
			text-transform: uppercase;
			font-size: 0.78rem;
		}

		.price-table tbody td {
			background: transparent;
			border-color: #2c3746;
		}

		.price-table .price-col {
			font-weight: 700;
			color: #9bf4c2;
		}

		.alert-stat {
			border: 1px solid #2f3a48;
			border-radius: 12px;
			padding: 12px;
			background: linear-gradient(180deg, #1a212c 0%, #141b24 100%);
		}

		.alert-stat .label {
			font-size: 0.78rem;
			text-transform: uppercase;
			letter-spacing: 0.6px;
			color: #9fb0c5;
		}

		.alert-stat .value {
			font-size: 1.35rem;
			font-weight: 800;
			line-height: 1.1;
		}

		.renewal-card {
			background: linear-gradient(180deg, #1a1f28 0%, #141923 100%);
			border: 1px solid #314055;
			border-radius: 14px;
			padding: 13px;
			height: 100%;
		}

		.renewal-head {
			display: flex;
			justify-content: space-between;
			align-items: center;
			gap: 8px;
			margin-bottom: 8px;
		}

		.renewal-title {
			margin: 0;
			font-size: 1rem;
			font-weight: 700;
			color: #eaffff;
		}

		.renewal-tag {
			display: inline-block;
			font-size: 0.72rem;
			letter-spacing: 0.6px;
			text-transform: uppercase;
			padding: 3px 8px;
			border-radius: 999px;
			border: 1px solid #35506a;
			color: #8de9ff;
			background: rgba(11, 88, 106, 0.35);
		}

		.renewal-tag.warn {
			border-color: #7b5e1d;
			color: #ffd98a;
			background: rgba(123, 94, 29, 0.35);
		}

		.renewal-tag.danger {
			border-color: #7c3d4c;
			color: #ffb3c3;
			background: rgba(124, 61, 76, 0.35);
		}

		.followup-item {
			border: 1px solid #2f3d4e;
			border-radius: 12px;
			padding: 12px;
			background: linear-gradient(180deg, #1a202b 0%, #141a23 100%);
			height: 100%;
		}

		.followup-priority-banner {
			display: flex;
			align-items: center;
			gap: 8px;
			border: 1px solid #7b5e1d;
			border-radius: 12px;
			padding: 10px 12px;
			margin-bottom: 12px;
			color: #ffe2a7;
			background: linear-gradient(180deg, rgba(123, 94, 29, 0.35) 0%, rgba(123, 94, 29, 0.14) 100%);
			font-size: 0.92rem;
			font-weight: 700;
		}

		.followup-priority-banner i {
			color: #ffd98a;
		}

		.followup-item.done {
			opacity: 0.6;
		}

		.followup-item.done .vehicle-title,
		.followup-item.done .meta {
			text-decoration: line-through;
		}

		.dup-summary-box {
			border: 1px solid #3a3a2f;
			border-radius: 12px;
			padding: 12px;
			background: rgba(123, 94, 29, 0.12);
		}

		.log-item {
			border: 1px solid #2f3d4e;
			border-radius: 10px;
			padding: 10px;
			background: #1a202b;
			margin-bottom: 8px;
		}

		.log-meta {
			font-size: 0.76rem;
			color: #9fb0c5;
			margin-bottom: 4px;
		}

		@media (max-width: 767.98px) {
			.developer-card.span-6 {
				grid-column: span 12;
			}

			.followup-priority-banner {
				font-size: 0.86rem;
			}
		}
	</style>
</head>

<body>
	<div class="container-fluid page-shell">
		<div class="topbar">
			<div>
				<h4 class="mb-0">Insurance Agents Panel</h4>
				<small class="text-secondary">Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Agent'); ?></small>
			</div>
			<a href="./userLogoutProcess.php" class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
		</div>

		<div class="row g-3">
			<aside class="col-12 col-lg-3">
				<div class="panel-card p-3">
					<div class="nav nav-pills tab-nav flex-column gap-2" id="agent-tabs" role="tablist">
						<button class="nav-link active" id="dashboard-tab" data-bs-toggle="pill" data-bs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">
							<i class="bi bi-speedometer2 me-2"></i>Dashboard
						</button>
						<button class="nav-link" id="new-customers-tab" data-bs-toggle="pill" data-bs-target="#new-customers" type="button" role="tab" aria-controls="new-customers" aria-selected="false">
							<i class="bi bi-hourglass-split me-2"></i>New Customers
						</button>
						<button class="nav-link" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false">
							<i class="bi bi-check2-circle me-2"></i>Completed
						</button>
						<button class="nav-link" id="renewal-alerts-tab" data-bs-toggle="pill" data-bs-target="#renewal-alerts" type="button" role="tab" aria-controls="renewal-alerts" aria-selected="false">
							<i class="bi bi-bell me-2"></i>Renewal Alerts
						</button>
						<button class="nav-link" id="followup-tab" data-bs-toggle="pill" data-bs-target="#followup" type="button" role="tab" aria-controls="followup" aria-selected="false">
							<i class="bi bi-list-check me-2"></i>Follow-up
						</button>
						<button class="nav-link" id="points-tab" data-bs-toggle="pill" data-bs-target="#points" type="button" role="tab" aria-controls="points" aria-selected="false">
							<i class="bi bi-diagram-3 me-2"></i>Assigned Points
						</button>
						<button class="nav-link" id="price-table-tab" data-bs-toggle="pill" data-bs-target="#price-table" type="button" role="tab" aria-controls="price-table" aria-selected="false">
							<i class="bi bi-tags me-2"></i>Price Table
						</button>
						<button class="nav-link" id="developer-tab" data-bs-toggle="pill" data-bs-target="#developer" type="button" role="tab" aria-controls="developer" aria-selected="false">
							<i class="bi bi-code-slash me-2"></i>Developer Details
						</button>
					</div>
				</div>
			</aside>

			<main class="col-12 col-lg-9">
				<div class="tab-content">
					<section class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab" tabindex="0">
						<div class="panel-card p-3 p-md-4">
							<div class="d-flex justify-content-between align-items-center gap-2 mb-3 flex-wrap">
								<h5 class="mb-0">Dashboard</h5>
								<button class="btn btn-sm btn-point" onclick="generatePerformanceSnapshotReport()">
									<i class="bi bi-file-earmark-pdf me-1"></i>Performance Snapshot PDF
								</button>
							</div>
							<div class="row g-3 mb-3">
								<div class="col-12 col-md-4">
									<div class="stat-card">
										<div class="stat-label">Total Customers</div>
										<div class="stat-value"><?php echo (int) ($stats['total_count'] ?? 0); ?></div>
									</div>
								</div>
								<div class="col-12 col-md-4">
									<div class="stat-card">
										<div class="stat-label">Pending</div>
										<div class="stat-value text-warning"><?php echo (int) ($stats['pending_count'] ?? 0); ?></div>
									</div>
								</div>
								<div class="col-12 col-md-4">
									<div class="stat-card">
										<div class="stat-label">Completed</div>
										<div class="stat-value text-success"><?php echo (int) ($stats['completed_count'] ?? 0); ?></div>
									</div>
								</div>
							</div>

							<h6 class="mb-2">Latest Pending Customers</h6>
							<div class="list-group recent-list">
								<?php if ($recentPending && $recentPending->num_rows > 0) {
									while ($r = $recentPending->fetch_assoc()) { ?>
										<div class="list-group-item d-flex justify-content-between align-items-center gap-2">
											<div>
												<div class="fw-semibold"><?php echo htmlspecialchars($r['vc_name']); ?></div>
												<small class="text-secondary"><?php echo htmlspecialchars($r['v_number']); ?></small>
											</div>
											<small class="text-secondary"><?php echo htmlspecialchars($r['date_issued']); ?></small>
										</div>
									<?php }
								} else { ?>
									<div class="list-group-item">No pending customers.</div>
								<?php } ?>
							</div>

							<div class="dup-summary-box mt-3">
								<h6 class="mb-2"><i class="bi bi-shield-exclamation me-1"></i>Duplicate Prevention Watch</h6>
								<div class="row g-2">
									<div class="col-6 col-md-3">
										<div class="meta mb-0"><span>Dup Vehicles:</span><?php echo count($duplicateVehicleMap); ?></div>
									</div>
									<div class="col-6 col-md-3">
										<div class="meta mb-0"><span>Dup Chassis:</span><?php echo count($duplicateChassisMap); ?></div>
									</div>
									<div class="col-12 col-md-6">
										<div class="meta mb-0"><span>Action:</span>Review badges in customer cards before processing.</div>
									</div>
								</div>
							</div>
						</div>
					</section>

					<section class="tab-pane fade" id="new-customers" role="tabpanel" aria-labelledby="new-customers-tab" tabindex="0">
						<div class="panel-card p-3 p-md-4">
							<div class="d-flex justify-content-between align-items-center gap-2 mb-3 flex-wrap">
								<h5 class="mb-0">New Customers (Pending)</h5>
								<div class="d-flex gap-2 ms-auto" style="min-width:280px;">
									<input type="text" id="newCustomerSearch" class="form-control form-control-sm search-control" placeholder="Search customer or vehicle">
									<select id="pointFilter" class="form-select form-select-sm search-control" style="max-width:190px;">
										<option value="">Select Point</option>
										<?php if ($pointFilterOptions && $pointFilterOptions->num_rows > 0) {
											while ($pointOption = $pointFilterOptions->fetch_assoc()) { ?>
												<option value="<?php echo (int) ($pointOption['point_id'] ?? 0); ?>"><?php echo htmlspecialchars($pointOption['shop_name'] ?? 'Point'); ?></option>
										<?php }
										} ?>
									</select>
								</div>
							</div>
							<div class="row g-3">
								<?php if ($pendingCustomers && $pendingCustomers->num_rows > 0) {
									while ($p = $pendingCustomers->fetch_assoc()) {
										$cid = (int) $p['vh_cid'];
										$pointId = (int) ($p['Points_point_id'] ?? 0);
										$pointName = htmlspecialchars($p['point_name'] ?? 'N/A');
										$vehicleKey = strtoupper(trim((string) ($p['v_number'] ?? '')));
										$chassisKey = strtoupper(trim((string) ($p['ch_number'] ?? '')));
										$isDupVehicle = isset($duplicateVehicleMap[$vehicleKey]);
										$isDupChassis = isset($duplicateChassisMap[$chassisKey]);
										$timelinePayload = json_encode([
											'id' => $cid,
											'customer' => (string) ($p['vc_name'] ?? ''),
											'vehicle' => (string) ($p['v_number'] ?? ''),
											'chassis' => (string) ($p['ch_number'] ?? ''),
											'contact' => (string) ($p['vc_contact'] ?? ''),
											'type' => (string) ($p['v_type'] ?? ''),
											'point' => (string) ($p['point_name'] ?? ''),
											'issue' => (string) ($p['date_issued'] ?? ''),
											'expiry' => (string) ($p['date_expere'] ?? ''),
											'status' => 'Pending'
										], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
										$crCopy = trim((string) ($p['cr_copy'] ?? ''));
										$nicCopy = trim((string) ($p['nic_copy'] ?? ''));
										$exICopy = trim((string) ($p['ex_i'] ?? ''));
										$searchBlob = strtolower(trim(($p['vc_name'] ?? '') . ' ' . ($p['v_number'] ?? '') . ' ' . ($p['ch_number'] ?? '') . ' ' . ($p['vc_contact'] ?? '') . ' ' . ($p['point_name'] ?? '')));
								?>
										<div class="col-12 col-md-6 pending-item" data-search="<?php echo htmlspecialchars($searchBlob); ?>" data-point-id="<?php echo $pointId; ?>">
											<div class="customer-card" id="customer-card-<?php echo $cid; ?>">
												<span class="status-badge pending">Pending</span>
												<?php if ($isDupVehicle) { ?><span class="dup-badge">Duplicate Vehicle</span><?php } ?>
												<?php if ($isDupChassis) { ?><span class="dup-badge">Duplicate Chassis</span><?php } ?>
												<h6 class="vehicle-title"><?php echo htmlspecialchars($p['v_number']); ?></h6>
												<p class="customer-name"><?php echo htmlspecialchars($p['vc_name']); ?></p>
												<div class="meta"><span>Chassis:</span><?php echo htmlspecialchars($p['ch_number']); ?></div>
												<div class="meta"><span>Type:</span><?php echo htmlspecialchars($p['v_type'] ?? 'N/A'); ?></div>
												<div class="meta"><span>Contact:</span><?php echo htmlspecialchars($p['vc_contact']); ?></div>
												<div class="meta"><span>Point:</span><?php echo $pointName; ?></div>
												<div class="meta"><span>Issue:</span><?php echo htmlspecialchars($p['date_issued']); ?></div>
												<div class="customer-docs">
													<?php if ($crCopy !== '') { ?>
														<a class="doc-link" href="../<?php echo htmlspecialchars($crCopy); ?>" target="_blank" download><i class="bi bi-download"></i>CR</a>
													<?php } ?>
													<?php if ($nicCopy !== '') { ?>
														<a class="doc-link" href="../<?php echo htmlspecialchars($nicCopy); ?>" target="_blank" download><i class="bi bi-download"></i>NIC</a>
													<?php } ?>
													<?php if ($exICopy !== '') { ?>
														<a class="doc-link" href="../<?php echo htmlspecialchars($exICopy); ?>" target="_blank" download><i class="bi bi-download"></i>Ex Card</a>
													<?php } ?>
												</div>
												<button class="check-btn" onclick="markAsCompleted(<?php echo $cid; ?>, this)">
													<i class="bi bi-check2-circle me-1"></i>Check and Complete
												</button>
												<button class="btn btn-sm btn-outline-info w-100 mt-2" onclick='openCustomerTimeline(<?php echo $timelinePayload; ?>)'>
													<i class="bi bi-clock-history me-1"></i>Timeline & Logs
												</button>
											</div>
										</div>
									<?php }
								} else { ?>
									<div class="col-12">
										<p class="empty-note">No pending customers found.</p>
									</div>
								<?php } ?>
							</div>
						</div>
					</section>

					<section class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab" tabindex="0">
						<div class="panel-card p-3 p-md-4">
							<h5 class="mb-3">Completed</h5>
							<div class="row g-3">
								<?php if ($completedCustomers && $completedCustomers->num_rows > 0) {
									while ($c = $completedCustomers->fetch_assoc()) { ?>
										<?php
										$cid = (int) ($c['vh_cid'] ?? 0);
										$vehicleKey = strtoupper(trim((string) ($c['v_number'] ?? '')));
										$chassisKey = strtoupper(trim((string) ($c['ch_number'] ?? '')));
										$isDupVehicle = isset($duplicateVehicleMap[$vehicleKey]);
										$isDupChassis = isset($duplicateChassisMap[$chassisKey]);
										$timelinePayload = json_encode([
											'id' => $cid,
											'customer' => (string) ($c['vc_name'] ?? ''),
											'vehicle' => (string) ($c['v_number'] ?? ''),
											'chassis' => (string) ($c['ch_number'] ?? ''),
											'contact' => (string) ($c['vc_contact'] ?? ''),
											'type' => (string) ($c['v_type'] ?? ''),
											'point' => (string) ($c['point_name'] ?? ''),
											'issue' => (string) ($c['date_issued'] ?? ''),
											'expiry' => (string) ($c['date_expere'] ?? ''),
											'status' => 'Completed'
										], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
										?>
										<div class="col-12 col-md-6">
											<div class="customer-card completed">
												<span class="status-badge completed">Completed</span>
													<?php if ($isDupVehicle) { ?><span class="dup-badge">Duplicate Vehicle</span><?php } ?>
													<?php if ($isDupChassis) { ?><span class="dup-badge">Duplicate Chassis</span><?php } ?>
												<h6 class="vehicle-title"><?php echo htmlspecialchars($c['v_number']); ?></h6>
												<p class="customer-name"><?php echo htmlspecialchars($c['vc_name']); ?></p>
												<div class="meta"><span>Chassis:</span><?php echo htmlspecialchars($c['ch_number']); ?></div>
												<div class="meta"><span>Type:</span><?php echo htmlspecialchars($c['v_type'] ?? 'N/A'); ?></div>
												<div class="meta"><span>Contact:</span><?php echo htmlspecialchars($c['vc_contact']); ?></div>
												<div class="meta"><span>Issue:</span><?php echo htmlspecialchars($c['date_issued']); ?></div>
												<button class="btn btn-sm btn-outline-info w-100 mt-2" onclick='openCustomerTimeline(<?php echo $timelinePayload; ?>)'>
													<i class="bi bi-clock-history me-1"></i>Timeline & Logs
												</button>
											</div>
										</div>
									<?php }
								} else { ?>
									<div class="col-12">
										<p class="empty-note">No completed customers found.</p>
									</div>
								<?php } ?>
							</div>
						</div>
					</section>

					<section class="tab-pane fade" id="renewal-alerts" role="tabpanel" aria-labelledby="renewal-alerts-tab" tabindex="0">
						<div class="panel-card p-3 p-md-4">
							<div class="d-flex justify-content-between align-items-center gap-2 mb-3 flex-wrap">
								<h5 class="mb-0">Smart Renewal Alerts</h5>
								<span class="status-chip"><i class="bi bi-lightning-charge"></i>Expiry window: 30 days</span>
							</div>

							<div class="row g-2 mb-3">
								<div class="col-6 col-md-3">
									<div class="alert-stat">
										<div class="label">Overdue</div>
										<div class="value text-danger"><?php echo (int) $renewalSummary['overdue']; ?></div>
									</div>
								</div>
								<div class="col-6 col-md-3">
									<div class="alert-stat">
										<div class="label">Within 7 Days</div>
										<div class="value text-warning"><?php echo (int) $renewalSummary['d7']; ?></div>
									</div>
								</div>
								<div class="col-6 col-md-3">
									<div class="alert-stat">
										<div class="label">Within 15 Days</div>
										<div class="value text-info"><?php echo (int) $renewalSummary['d15']; ?></div>
									</div>
								</div>
								<div class="col-6 col-md-3">
									<div class="alert-stat">
										<div class="label">Within 30 Days</div>
										<div class="value text-primary"><?php echo (int) $renewalSummary['d30']; ?></div>
									</div>
								</div>
							</div>

							<div class="row g-3">
								<?php if (!empty($renewalRows)) {
									foreach ($renewalRows as $row) {
										$daysLeft = (int) ($row['days_left'] ?? 9999);
										$tagClass = 'renewal-tag';
										$tagText = $daysLeft . ' days left';
										if ($daysLeft < 0) {
											$tagClass = 'renewal-tag danger';
											$tagText = abs($daysLeft) . ' days overdue';
										} elseif ($daysLeft <= 7) {
											$tagClass = 'renewal-tag warn';
										}
								?>
										<div class="col-12 col-md-6">
											<div class="renewal-card">
												<div class="renewal-head">
													<h6 class="renewal-title"><?php echo htmlspecialchars($row['v_number'] ?? 'N/A'); ?></h6>
													<span class="<?php echo $tagClass; ?>"><?php echo htmlspecialchars($tagText); ?></span>
												</div>
												<div class="meta"><span>Customer:</span><?php echo htmlspecialchars($row['vc_name'] ?? 'N/A'); ?></div>
												<div class="meta"><span>Type:</span><?php echo htmlspecialchars($row['v_type'] ?? 'N/A'); ?></div>
												<div class="meta"><span>Contact:</span><?php echo htmlspecialchars($row['vc_contact'] ?? 'N/A'); ?></div>
												<div class="meta"><span>Point:</span><?php echo htmlspecialchars($row['point_name'] ?? 'N/A'); ?></div>
												<div class="meta"><span>Expiry:</span><?php echo htmlspecialchars($row['date_expere'] ?? 'N/A'); ?></div>
											</div>
										</div>
								<?php }
								} else { ?>
									<div class="col-12">
										<p class="empty-note">No renewals due within the next 30 days.</p>
									</div>
								<?php } ?>
							</div>
						</div>
					</section>

					<section class="tab-pane fade" id="followup" role="tabpanel" aria-labelledby="followup-tab" tabindex="0">
						<div class="panel-card p-3 p-md-4">
							<div class="followup-priority-banner">
								<i class="bi bi-exclamation-triangle-fill"></i>
								<span>Priority: expiry &lt;= 7d or pending &gt;= 3d</span>
							</div>

							<div class="d-flex justify-content-between align-items-center gap-2 mb-3 flex-wrap">
								<h5 class="mb-0">Daily Follow-up Checklist</h5>
								<span class="status-chip"><i class="bi bi-list-check"></i>Priority: expiry <= 7d or pending >= 3d</span>
							</div>

							<div class="row g-3">
								<?php if (!empty($followUpRows)) {
									foreach ($followUpRows as $fu) {
										$taskKey = 'fu-' . (int) ($fu['vh_cid'] ?? 0);
										$timelinePayload = json_encode([
											'id' => (int) ($fu['vh_cid'] ?? 0),
											'customer' => (string) ($fu['vc_name'] ?? ''),
											'vehicle' => (string) ($fu['v_number'] ?? ''),
											'chassis' => (string) ($fu['ch_number'] ?? ''),
											'contact' => (string) ($fu['vc_contact'] ?? ''),
											'type' => (string) ($fu['v_type'] ?? ''),
											'point' => (string) ($fu['point_name'] ?? ''),
											'issue' => (string) ($fu['date_issued'] ?? ''),
											'expiry' => (string) ($fu['date_expere'] ?? ''),
											'status' => 'Pending'
										], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
								?>
										<div class="col-12 col-md-6">
											<div class="followup-item" data-task-key="<?php echo htmlspecialchars($taskKey); ?>">
												<div class="d-flex justify-content-between align-items-start gap-2 mb-1">
													<div>
														<h6 class="vehicle-title mb-0"><?php echo htmlspecialchars($fu['v_number'] ?? 'N/A'); ?></h6>
														<p class="customer-name mb-1"><?php echo htmlspecialchars($fu['vc_name'] ?? 'N/A'); ?></p>
													</div>
													<div class="form-check">
														<input class="form-check-input followup-done" type="checkbox" value="1" data-task-key="<?php echo htmlspecialchars($taskKey); ?>">
													</div>
												</div>
												<div class="meta"><span>Pending Days:</span><?php echo (int) ($fu['pending_days'] ?? 0); ?></div>
												<div class="meta"><span>Expiry In:</span><?php echo (int) ($fu['expiry_days'] ?? 999); ?> days</div>
												<div class="meta"><span>Contact:</span><?php echo htmlspecialchars($fu['vc_contact'] ?? 'N/A'); ?></div>
												<div class="mt-2 d-flex gap-2">
													<button class="btn btn-sm btn-outline-info" onclick='openCustomerTimeline(<?php echo $timelinePayload; ?>)'><i class="bi bi-clock-history me-1"></i>Timeline & Logs</button>
													<a class="btn btn-sm btn-outline-success" href="tel:<?php echo htmlspecialchars((string) ($fu['vc_contact'] ?? '')); ?>"><i class="bi bi-telephone me-1"></i>Call</a>
												</div>
											</div>
										</div>
								<?php }
								} else { ?>
									<div class="col-12"><p class="empty-note">No follow-up tasks for today.</p></div>
								<?php } ?>
							</div>
						</div>
					</section>

					<section class="tab-pane fade" id="developer" role="tabpanel" aria-labelledby="developer-tab" tabindex="0">
						<div class="panel-card p-3 p-md-4">
							<div class="developer-hero">
								<span class="developer-kicker"><i class="bi bi-stars"></i> Developer Desk</span>
								<h3 class="developer-title">Developer Details</h3>
								<p class="developer-subtitle">This panel is dedicated for insurance agents to track pending and completed customers quickly.</p>
							</div>

							<div class="developer-grid">
								<div class="developer-card span-6">
									<h6><i class="bi bi-person-badge me-1"></i>Profile</h6>
									<div class="developer-row">
										<div class="developer-label">Developer</div>
										<div class="developer-value">Diluna Sithija</div>
									</div>
									<div class="developer-row">
										<div class="developer-label">Company</div>
										<div class="developer-value">Affinity Software Solutions</div>
									</div>
									<div class="developer-row">
										<div class="developer-label">Version</div>
										<div class="developer-value">1.0.0</div>
									</div>
								</div>

								<div class="developer-card span-6">
									<h6><i class="bi bi-person-check me-1"></i>Logged User</h6>
									<div class="developer-row">
										<div class="developer-label">Name</div>
										<div class="developer-value"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Unknown'); ?></div>
									</div>
									<div class="developer-row">
										<div class="developer-label">Email / Mobile</div>
										<div class="developer-value"><?php echo htmlspecialchars($_SESSION['user_email'] ?? ($_SESSION['user_mobile'] ?? 'N/A')); ?></div>
									</div>
									<div class="developer-row">
										<div class="developer-label">User ID</div>
										<div class="developer-value"><?php echo htmlspecialchars((string) ($_SESSION['user_id'] ?? 'N/A')); ?></div>
									</div>
								</div>
							</div>

							<div class="account-box">
								<p class="mb-1"><strong>Logged in as:</strong> <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Unknown'); ?></p>
								<p class="account-email"><small><?php echo htmlspecialchars($_SESSION['user_email'] ?? ($_SESSION['user_mobile'] ?? 'N/A')); ?></small></p>
								<a href="./userLogoutProcess.php" class="btn btn-sm btn-outline-danger mt-2"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
							</div>
						</div>
					</section>

					<section class="tab-pane fade" id="points" role="tabpanel" aria-labelledby="points-tab" tabindex="0">
						<div class="panel-card p-3 p-md-4">
							<div class="d-flex justify-content-between align-items-center gap-2 mb-3">
								<h5 class="mb-0">Assigned Point List</h5>
								<div class="d-flex gap-2">
									<button class="btn btn-sm btn-point" onclick="generatePointsReport()">
										<i class="bi bi-printer me-1"></i>Print Report
									</button>
									<button class="btn btn-sm btn-point" data-bs-toggle="modal" data-bs-target="#addPointModal">
										<i class="bi bi-plus-circle me-1"></i>Add New Point
									</button>
								</div>
							</div>

							<div class="row g-3">
								<?php if ($assignedPoints && $assignedPoints->num_rows > 0) {
									while ($point = $assignedPoints->fetch_assoc()) { ?>
										<div class="col-12 col-md-6">
											<div class="point-card">
												<div class="point-title"><?php echo htmlspecialchars($point['shop_name'] ?? 'N/A'); ?></div>
												<div class="point-meta"><span>Point ID:</span><?php echo (int) ($point['point_id'] ?? 0); ?></div>
												<div class="point-meta"><span>Contact:</span><?php echo htmlspecialchars($point['contact'] ?? 'N/A'); ?></div>
												<div class="point-meta"><span>Address:</span><?php echo htmlspecialchars($point['point_address'] ?? 'N/A'); ?></div>
												<div class="point-meta"><span>Location:</span><?php echo htmlspecialchars($point['point_location'] ?? 'N/A'); ?></div>
											</div>
										</div>
									<?php }
								} else { ?>
									<div class="col-12">
										<p class="empty-note">No assigned points found.</p>
									</div>
								<?php } ?>
							</div>
						</div>
					</section>

					<section class="tab-pane fade" id="price-table" role="tabpanel" aria-labelledby="price-table-tab" tabindex="0">
						<div class="panel-card p-3 p-md-4">
							<h5 class="mb-3">Vehicle Type Price Table</h5>
							<div class="price-table-card">
								<div class="table-responsive">
									<table class="table table-dark table-hover align-middle price-table">
										<thead>
											<tr>
												<th style="width: 80px;">#</th>
												<th>Vehicle Type</th>
												<th class="text-end">Price (LKR)</th>
											</tr>
										</thead>
										<tbody>
											<?php if ($vehicleTypes && $vehicleTypes->num_rows > 0) {
												$index = 1;
												while ($typeRow = $vehicleTypes->fetch_assoc()) {
													$priceValue = is_numeric($typeRow['price'] ?? null)
														? number_format((float) $typeRow['price'], 2)
														: htmlspecialchars((string) ($typeRow['price'] ?? '0.00'));
											?>
													<tr>
														<td><?php echo $index++; ?></td>
														<td><?php echo htmlspecialchars($typeRow['v_type'] ?? 'N/A'); ?></td>
														<td class="text-end price-col"><?php echo $priceValue; ?></td>
													</tr>
											<?php }
											} else { ?>
												<tr>
													<td colspan="3" class="text-center py-4 text-secondary">No vehicle types found.</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</section>
				</div>
			</main>
		</div>
	</div>

	<div class="offcanvas offcanvas-end" tabindex="-1" id="customerTimelineDrawer" aria-labelledby="customerTimelineDrawerLabel">
		<div class="offcanvas-header" style="background:#171a21;color:#f1f5f9;border-bottom:1px solid #2d3440;">
			<h5 class="offcanvas-title" id="customerTimelineDrawerLabel"><i class="bi bi-clock-history me-1"></i>Customer Timeline</h5>
			<button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body" style="background:#12161d;color:#e5edf7;">
			<div class="mb-3" id="timelineSummary"></div>

			<div class="mb-3 p-2" style="border:1px solid #2f3d4e;border-radius:10px;background:#171d27;">
				<h6 class="mb-2">Timeline Events</h6>
				<div id="timelineEvents" class="small text-secondary"></div>
			</div>

			<div class="p-2" style="border:1px solid #2f3d4e;border-radius:10px;background:#171d27;">
				<h6 class="mb-2">Notes & Call Logs</h6>
				<div class="row g-2 mb-2">
					<div class="col-12">
						<select id="callResult" class="form-select form-select-sm">
							<option value="Call Attempted">Call Attempted</option>
							<option value="No Answer">No Answer</option>
							<option value="Interested">Interested</option>
							<option value="Requested Callback">Requested Callback</option>
							<option value="Docs Sent">Docs Sent</option>
							<option value="Closed">Closed</option>
						</select>
					</div>
					<div class="col-12">
						<textarea id="customerLogNote" class="form-control form-control-sm" rows="3" placeholder="Add note..."></textarea>
					</div>
					<div class="col-12 d-grid">
						<button type="button" class="btn btn-sm btn-point" onclick="saveCustomerLog()"><i class="bi bi-journal-plus me-1"></i>Save Log</button>
					</div>
				</div>
				<div id="customerLogsList"></div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="addPointModal" tabindex="-1" aria-labelledby="addPointModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content" style="background:#171a21;border:1px solid #2d3440;color:#f1f5f9;">
				<div class="modal-header" style="border-bottom:1px solid #2d3440;">
					<h5 class="modal-title" id="addPointModalLabel">Add New Point</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="addPointForm" class="row g-3" novalidate>
						<div class="col-12">
							<label class="form-label">Shop Name</label>
							<input type="text" id="shopName" class="form-control" placeholder="Enter shop name" required>
						</div>
						<div class="col-12">
							<label class="form-label">Contact Number</label>
							<input type="text" id="pointContact" class="form-control" placeholder="Enter contact number" required>
						</div>
						<div class="col-12">
							<label class="form-label">Address</label>
							<input type="text" id="pointAddress" class="form-control" placeholder="Enter address" required>
						</div>
						<div class="col-12">
							<label class="form-label">Location</label>
							<input type="text" id="pointLocation" class="form-control" placeholder="Enter location" required>
						</div>
						<div class="col-12">
							<label class="form-label">Password</label>
							<input type="password" id="pointPassword" class="form-control" placeholder="Enter password" required>
						</div>
					</form>
				</div>
				<div class="modal-footer" style="border-top:1px solid #2d3440;">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-point" id="savePointBtn" onclick="addNewPoint()">Save Point</button>
				</div>
			</div>
		</div>
	</div>

	<script
		src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
		crossorigin="anonymous"></script>
	<script>
		async function markAsCompleted(customerId, btn) {
			const originalText = btn.innerHTML;
			btn.disabled = true;
			btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Updating...';

			try {
				const res = await fetch('./markCustomerCompletedProcess.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					body: `customerId=${encodeURIComponent(customerId)}`
				});

				const data = await res.json();

				if (!res.ok || !data.success) {
					throw new Error(data.message || 'Failed to update status.');
				}

				window.location.reload();
			} catch (error) {
				alert(error.message || 'An error occurred.');
				btn.disabled = false;
				btn.innerHTML = originalText;
			}
		}

		async function addNewPoint() {
			const shopName = document.getElementById('shopName').value.trim();
			const pointContact = document.getElementById('pointContact').value.trim();
			const pointAddress = document.getElementById('pointAddress').value.trim();
			const pointLocation = document.getElementById('pointLocation').value.trim();
			const pointPassword = document.getElementById('pointPassword').value.trim();
			const saveBtn = document.getElementById('savePointBtn');

			if (!shopName) {
				alert('Shop name is required.');
				return;
			}

			if (!pointContact) {
				alert('Contact number is required.');
				return;
			}

			if (!pointAddress) {
				alert('Address is required.');
				return;
			}

			if (!pointLocation) {
				alert('Location is required.');
				return;
			}

			if (!pointPassword || pointPassword.length < 4) {
				alert('Password must be at least 4 characters.');
				return;
			}

			const originalText = saveBtn.innerHTML;
			saveBtn.disabled = true;
			saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';

			try {
				const res = await fetch('./addAssignedPointProcess.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					body: `shopName=${encodeURIComponent(shopName)}&pointContact=${encodeURIComponent(pointContact)}&pointAddress=${encodeURIComponent(pointAddress)}&pointLocation=${encodeURIComponent(pointLocation)}&pointPassword=${encodeURIComponent(pointPassword)}`
				});

				const raw = await res.text();
				let data = null;

				try {
					data = raw ? JSON.parse(raw) : null;
				} catch (parseError) {
					throw new Error('Server returned an invalid response while adding point.');
				}

				if (!data || !res.ok || !data.success) {
					throw new Error((data && data.message) ? data.message : 'Failed to add point.');
				}

				window.location.reload();
			} catch (error) {
				alert(error.message || 'An error occurred.');
				saveBtn.disabled = false;
				saveBtn.innerHTML = originalText;
			}
		}

		function filterNewCustomers() {
			const searchInput = document.getElementById('newCustomerSearch');
			const pointSelect = document.getElementById('pointFilter');
			if (!searchInput || !pointSelect) {
				return;
			}

			const searchText = searchInput.value.trim().toLowerCase();
			const selectedPoint = pointSelect.value;
			const items = document.querySelectorAll('.pending-item');

			items.forEach(function(item) {
				const blob = (item.getAttribute('data-search') || '').toLowerCase();
				const pointId = item.getAttribute('data-point-id') || '';
				const textMatch = searchText === '' || blob.includes(searchText);
				const pointMatch = selectedPoint === '' || pointId === selectedPoint;
				item.style.display = textMatch && pointMatch ? '' : 'none';
			});
		}

		function generatePointsReport() {
			const link = document.createElement('a');
			link.href = './generatePointsPdfReport.php';
			link.target = '_blank';
			link.click();
		}

		function generatePerformanceSnapshotReport() {
			const link = document.createElement('a');
			link.href = './generatePerformanceSnapshotPdfReport.php';
			link.target = '_blank';
			link.click();
		}

		const CUSTOMER_LOGS_KEY = 'agent_customer_logs_v1';
		const FOLLOWUP_DONE_KEY = 'agent_followup_done_v1';
		let activeTimelineCustomerId = null;

		function readJsonStorage(key) {
			try {
				const raw = localStorage.getItem(key);
				if (!raw) return {};
				const parsed = JSON.parse(raw);
				return (parsed && typeof parsed === 'object') ? parsed : {};
			} catch (e) {
				return {};
			}
		}

		function writeJsonStorage(key, value) {
			localStorage.setItem(key, JSON.stringify(value));
		}

		function renderCustomerLogs(customerId) {
			const wrap = document.getElementById('customerLogsList');
			if (!wrap) return;
			const allLogs = readJsonStorage(CUSTOMER_LOGS_KEY);
			const logs = Array.isArray(allLogs[customerId]) ? allLogs[customerId] : [];
			if (logs.length === 0) {
				wrap.innerHTML = '<p class="text-secondary mb-0">No notes yet.</p>';
				return;
			}
			wrap.innerHTML = logs.slice().reverse().map(function(item) {
				const result = String(item.result || 'Call Attempted');
				const note = String(item.note || '');
				const time = String(item.time || '');
				return '<div class="log-item">' +
					'<div class="log-meta">' + time + ' â€¢ ' + result + '</div>' +
					'<div>' + note.replace(/</g, '&lt;').replace(/>/g, '&gt;') + '</div>' +
					'</div>';
			}).join('');
		}

		function saveCustomerLog() {
			if (!activeTimelineCustomerId) {
				return;
			}

			const noteInput = document.getElementById('customerLogNote');
			const resultInput = document.getElementById('callResult');
			if (!noteInput || !resultInput) {
				return;
			}

			const note = noteInput.value.trim();
			const result = resultInput.value;
			if (!note) {
				alert('Please enter a note before saving.');
				return;
			}

			const allLogs = readJsonStorage(CUSTOMER_LOGS_KEY);
			const key = String(activeTimelineCustomerId);
			if (!Array.isArray(allLogs[key])) {
				allLogs[key] = [];
			}

			allLogs[key].push({
				result: result,
				note: note,
				time: new Date().toLocaleString()
			});

			writeJsonStorage(CUSTOMER_LOGS_KEY, allLogs);
			noteInput.value = '';
			renderCustomerLogs(key);
		}

		function openCustomerTimeline(payload) {
			if (!payload || !payload.id) {
				return;
			}

			activeTimelineCustomerId = String(payload.id);

			const summary = document.getElementById('timelineSummary');
			const events = document.getElementById('timelineEvents');
			if (summary) {
				summary.innerHTML =
					'<h6 class="mb-1">' + (payload.vehicle || 'N/A') + ' - ' + (payload.customer || 'N/A') + '</h6>' +
					'<div class="meta"><span>Status:</span>' + (payload.status || 'N/A') + '</div>' +
					'<div class="meta"><span>Point:</span>' + (payload.point || 'N/A') + '</div>' +
					'<div class="meta"><span>Contact:</span>' + (payload.contact || 'N/A') + '</div>';
			}

			if (events) {
				events.innerHTML =
					'<div class="meta mb-1"><span>Created:</span>' + (payload.issue || 'N/A') + '</div>' +
					'<div class="meta mb-1"><span>Expiry:</span>' + (payload.expiry || 'N/A') + '</div>' +
					'<div class="meta mb-0"><span>Current Status:</span>' + (payload.status || 'N/A') + '</div>';
			}

			renderCustomerLogs(activeTimelineCustomerId);

			const drawerElement = document.getElementById('customerTimelineDrawer');
			if (drawerElement) {
				const drawer = bootstrap.Offcanvas.getOrCreateInstance(drawerElement);
				drawer.show();
			}
		}

		function initFollowUpChecklistState() {
			const doneMap = readJsonStorage(FOLLOWUP_DONE_KEY);
			document.querySelectorAll('.followup-done').forEach(function(chk) {
				const key = chk.getAttribute('data-task-key') || '';
				const item = chk.closest('.followup-item');
				const isDone = key !== '' && doneMap[key] === true;
				chk.checked = isDone;
				if (item) item.classList.toggle('done', isDone);

				chk.addEventListener('change', function() {
					const latest = readJsonStorage(FOLLOWUP_DONE_KEY);
					if (key !== '') {
						latest[key] = chk.checked;
					}
					writeJsonStorage(FOLLOWUP_DONE_KEY, latest);
					if (item) item.classList.toggle('done', chk.checked);
				});
			});
		}

		document.addEventListener('DOMContentLoaded', function() {
			const searchInput = document.getElementById('newCustomerSearch');
			const pointSelect = document.getElementById('pointFilter');
			if (searchInput) {
				searchInput.addEventListener('input', filterNewCustomers);
			}
			if (pointSelect) {
				pointSelect.addEventListener('change', filterNewCustomers);
			}
			initFollowUpChecklistState();
		});

		if ('serviceWorker' in navigator) {
			window.addEventListener('load', function() {
				navigator.serviceWorker.register('service-worker.js').catch(function() {
					// Keep install flow uninterrupted even if SW registration fails.
				});
			});
		}
	</script>
</body>

</html>

