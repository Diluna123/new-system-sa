<?php
require_once 'connection.php'; // make sure this path is correct

// Get last month's range
$start_date = date("Y-m-01", strtotime("first day of last month"));
$end_date = date("Y-m-t", strtotime("last day of last month"));
$month = date("Y-m", strtotime($start_date));

// Get all users who had sales last month
$users = Database::search("SELECT DISTINCT users_u_id FROM `police_t` WHERE `date` BETWEEN '$start_date' AND '$end_date'");

while ($user = $users->fetch_assoc()) {
    $user_id = $user['users_u_id'];

    // Check if summary for this user already exists
    $check = Database::search("SELECT * FROM summery_t WHERE month = '$month' AND users_u_id = '$user_id'");
    if ($check->num_rows == 0) {

        // Get summary for this user
        $summary = Database::search("
            SELECT 
                COUNT(*) AS nope,
                SUM(CASE WHEN payments_pay_id IN ('1', '2', '4') THEN ammount ELSE 0 END) AS mcfp,
                SUM(CASE WHEN payments_pay_id IN ('3', '5') THEN ammount ELSE 0 END) AS fp
            FROM `police_t`
            WHERE users_u_id = '$user_id' AND date BETWEEN '$start_date' AND '$end_date'
        ");
        $data = $summary->fetch_assoc();

        // Extract values from the query result
        $nope = $data['nope'];
        $mcfp = $data['mcfp'] ?: 0;  // Set to 0 if NULL
        $fp = $data['fp'] ?: 0;      // Set to 0 if NULL
        $total = $mcfp + $fp;        // Calculate total as sum of mcfp and fp

        // Insert summary into the database
        Database::iud("
            INSERT INTO summery_t (month, nope, mcfp, fp, total, users_u_id)
            VALUES ('$month', '$nope', '$mcfp', '$fp', '$total', '$user_id')
        ");

        echo "✅ Inserted summary for user $user_id ($month)<br>";
    } else {
        echo "⚠️ Summary already exists for user $user_id ($month)<br>";
    }
}
?>
