<?php
session_start();
require_once __DIR__ . '/connection.php';

if (!isset($_SESSION['user'])) {
    header('Location: super-login.php');
    exit;
}

if ((int) ($_SESSION['user']['u_id'] ?? 0) !== 1) {
    header('Location: index.php');
    exit;
}

Database::setupConnection();
$db = Database::$connection;

if (!$db || $db->connect_error) {
    die('Database connection failed.');
}

function esc(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$pointColumns = [];
$pointColsRs = $db->query("SHOW COLUMNS FROM `points`");
if ($pointColsRs) {
    while ($col = $pointColsRs->fetch_assoc()) {
        $pointColumns[] = $col['Field'];
    }
}

$pointStatusColumn = null;
$candidatePointStatusColumns = ['point_state_id', 'point_status', 'status_s_id', 'status', 'state_id', 'is_active', 'is_blocked'];
foreach ($candidatePointStatusColumns as $candidate) {
    if (in_array($candidate, $pointColumns, true)) {
        $pointStatusColumn = $candidate;
        break;
    }
}

function isPointBlocked(array $point, ?string $statusColumn): bool
{
    if ($statusColumn === null || !array_key_exists($statusColumn, $point)) {
        return false;
    }

    $raw = trim((string) $point[$statusColumn]);
    if ($raw === '') {
        return false;
    }

    $numeric = (int) $raw;

    if ($statusColumn === 'is_blocked') {
        return $numeric === 1;
    }

    if ($statusColumn === 'is_active') {
        return $numeric === 0;
    }

    if (stripos($statusColumn, 'status') !== false || stripos($statusColumn, 'state') !== false) {
        return $numeric === 2;
    }

    return false;
}

$users = [];
$userRs = $db->query("SELECT `u_id`, `u_fname`, `u_lname`, `email`, `user_State_id`, `position_pid`, `teams_tid` FROM `users` ORDER BY `u_id` ASC");
if ($userRs) {
    while ($row = $userRs->fetch_assoc()) {
        $users[] = $row;
    }
}

$points = [];
$pointsSql = "SELECT p.*, u.u_fname, u.u_lname FROM `points` p LEFT JOIN `users` u ON u.`u_id` = p.`users_u_id` ORDER BY p.`point_id` ASC";
$pointRs = $db->query($pointsSql);
if ($pointRs) {
    while ($row = $pointRs->fetch_assoc()) {
        $points[] = $row;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Super Admin Panel</title>
    <link rel="icon" type="image/png" href="com.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --bg: #0e1118;
            --panel: #171c26;
            --line: #2a3444;
            --text: #e8edf5;
            --soft: #9ba8bc;
            --ok: #18c37e;
            --danger: #ff6767;
            --accent: #5db4ff;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at 20% 10%, rgba(93, 180, 255, 0.16), transparent 32%),
                radial-gradient(circle at 80% 85%, rgba(24, 195, 126, 0.14), transparent 30%),
                var(--bg);
            color: var(--text);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .shell {
            max-width: 1200px;
            margin: 24px auto;
            padding: 0 14px;
        }

        .panel {
            background: linear-gradient(180deg, #1a2130 0%, #141b28 100%);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.24);
        }

        .section-title {
            font-size: 1.1rem;
            letter-spacing: 0.3px;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--text);
            --bs-table-border-color: #2a3444;
        }

        .table thead th {
            color: #d3dbea;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .search-box {
            background-color: #101623;
            border: 1px solid #2a3444;
            color: var(--text);
        }

        .search-box:focus {
            background-color: #111a2a;
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(93, 180, 255, 0.2);
            color: var(--text);
        }

        .badge-soft {
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 0.78rem;
            color: var(--soft);
            background: #111825;
        }

        .state-active {
            color: var(--ok);
        }

        .state-blocked {
            color: var(--danger);
        }

        .footer-note {
            color: #8a96ab;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="shell">
        <div class="panel p-4 mb-4">
            <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between">
                <div>
                    <h1 class="h4 mb-1">Super Admin Panel</h1>
                    <div class="footer-note">Manage user accounts and point access from one place.</div>
                </div>
                <div class="d-flex gap-2">
                    <a href="aindex.php" class="btn btn-outline-light btn-sm"><i class="bi bi-shield-lock me-1"></i>Old Admin View</a>
                    <a href="signoutProcess.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Sign Out</a>
                </div>
            </div>
        </div>

        <div class="panel p-4 mb-4">
            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
                <h2 class="section-title mb-0">User Accounts</h2>
                <input id="userSearch" class="form-control search-box" style="max-width: 260px;" type="text" placeholder="Search user..." onkeyup="filterRows('userSearch', 'userTableBody')">
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Team</th>
                            <th>Status</th>
                            <th>Block / Unblock</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        <?php foreach ($users as $user): ?>
                            <?php
                                $userId = (int) ($user['u_id'] ?? 0);
                                $isCurrentSuper = ($userId === 1);
                                $active = ((int) ($user['user_State_id'] ?? 2) === 1);
                            ?>
                            <tr>
                                <td><?php echo $userId; ?></td>
                                <td><?php echo esc(trim(($user['u_fname'] ?? '') . ' ' . ($user['u_lname'] ?? ''))); ?></td>
                                <td><?php echo esc((string) ($user['email'] ?? '')); ?></td>
                                <td><span class="badge-soft">Team <?php echo (int) ($user['teams_tid'] ?? 0); ?></span></td>
                                <td>
                                    <?php if ($active): ?>
                                        <span class="state-active">Active</span>
                                    <?php else: ?>
                                        <span class="state-blocked">Blocked</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="form-check form-switch d-flex justify-content-center m-0">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            <?php echo $active ? 'checked' : ''; ?>
                                            <?php echo $isCurrentSuper ? 'disabled' : ''; ?>
                                            onchange="toggleUserStatus(this, <?php echo $userId; ?>)">
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel p-4 mb-3">
            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
                <h2 class="section-title mb-0">Point Accounts</h2>
                <input id="pointSearch" class="form-control search-box" style="max-width: 260px;" type="text" placeholder="Search point..." onkeyup="filterRows('pointSearch', 'pointTableBody')">
            </div>
            <?php if ($pointStatusColumn === null): ?>
                <div class="alert alert-warning py-2">
                    Point status column not detected yet. It will be created automatically on first point toggle.
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead>
                        <tr>
                            <th>Point ID</th>
                            <th>Shop Name</th>
                            <th>Contact</th>
                            <th>Assigned User</th>
                            <th>Status</th>
                            <th>Block / Unblock</th>
                        </tr>
                    </thead>
                    <tbody id="pointTableBody">
                        <?php foreach ($points as $point): ?>
                            <?php
                                $pointId = (int) ($point['point_id'] ?? 0);
                                $assignedName = trim((string) (($point['u_fname'] ?? '') . ' ' . ($point['u_lname'] ?? '')));
                                if ($assignedName === '') {
                                    $assignedName = 'Unassigned';
                                }
                                $pointBlocked = isPointBlocked($point, $pointStatusColumn);
                            ?>
                            <tr>
                                <td><?php echo $pointId; ?></td>
                                <td><?php echo esc((string) ($point['shop_name'] ?? '')); ?></td>
                                <td><?php echo esc((string) ($point['contact'] ?? '')); ?></td>
                                <td><?php echo esc($assignedName); ?></td>
                                <td>
                                    <?php if (!$pointBlocked): ?>
                                        <span class="state-active">Active</span>
                                    <?php else: ?>
                                        <span class="state-blocked">Blocked</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="form-check form-switch d-flex justify-content-center m-0">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            <?php echo !$pointBlocked ? 'checked' : ''; ?>
                                            onchange="togglePointStatus(this, <?php echo $pointId; ?>)">
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <p class="footer-note">Super admin account is protected and cannot be blocked from this page.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function filterRows(searchInputId, tableBodyId) {
            const input = document.getElementById(searchInputId);
            const filter = (input.value || '').toLowerCase();
            const rows = document.querySelectorAll('#' + tableBodyId + ' tr');

            rows.forEach((row) => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        }

        async function postStatus(url, payload) {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams(payload)
            });

            let data = {};
            try {
                data = await response.json();
            } catch (e) {
                data = { success: false, message: 'Invalid server response.' };
            }

            return {
                ok: response.ok && data.success,
                message: data.message || 'Action failed.'
            };
        }

        async function toggleUserStatus(el, userId) {
            const previous = !el.checked;
            const status = el.checked ? 1 : 2;
            const result = await postStatus('superToggleUserProcess.php', { uid: userId, status: status });

            if (!result.ok) {
                el.checked = previous;
                Swal.fire({ icon: 'error', title: 'Update failed', text: result.message });
                return;
            }

            Swal.fire({ icon: 'success', title: 'Updated', text: result.message, timer: 1100, showConfirmButton: false }).then(() => {
                window.location.reload();
            });
        }

        async function togglePointStatus(el, pointId) {
            const previous = !el.checked;
            const status = el.checked ? 1 : 2;
            const result = await postStatus('superTogglePointProcess.php', { pointId: pointId, status: status });

            if (!result.ok) {
                el.checked = previous;
                Swal.fire({ icon: 'error', title: 'Update failed', text: result.message });
                return;
            }

            Swal.fire({ icon: 'success', title: 'Updated', text: result.message, timer: 1100, showConfirmButton: false }).then(() => {
                window.location.reload();
            });
        }
    </script>
</body>
</html>
