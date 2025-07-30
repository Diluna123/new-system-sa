<?php
include 'connection.php';
session_start();

$uid = $_SESSION['user']['u_id'];
$searchTerm = $_POST['searchTerm'];

// Build the WHERE clause for search
$whereConditions = [];
if (!empty($searchTerm)) {
    $searchTerm = '%' . $searchTerm . '%';
    $whereConditions[] = "(
        `customers`.`fname` LIKE '$searchTerm' OR 
        `customers`.`nic` LIKE '$searchTerm' OR 
        `customers`.`contact` LIKE '$searchTerm' OR 
        `police_t`.`pol_num` LIKE '$searchTerm' OR 
        `police_t`.`pro_num` LIKE '$searchTerm'
    )";
}

$whereClause = "WHERE `police_t`.`users_u_id` = '$uid' AND `police_t`.`status_s_id` = '1'";
if (!empty($whereConditions)) {
    $whereClause .= " AND " . implode(" AND ", $whereConditions);
}

$policies = Database::search("
    SELECT * FROM `customers` 
    JOIN `police_t` ON `customers`.`id` = `police_t`.`customers_id` 
    JOIN `plans` ON `plans`.`p_id` = `police_t`.`plans_p_id` 
    JOIN `payments` ON `payments`.`pay_id` = `police_t`.`payments_pay_id` 
    JOIN `users` ON `users`.`u_id` = `police_t`.`users_u_id` 
    $whereClause 
    ORDER BY `customers`.`id` DESC
");

if ($policies->num_rows > 0) {
    for ($i = 0; $i < $policies->num_rows; $i++) {
        $data = $policies->fetch_assoc();
?>
        <tr onclick="showCanvasModal(<?php echo $data['id'] ?>);">
            <td>0<?php echo $i + 1 ?></td>
            <td><?php echo $data['fname'] ?></td>
            <td><?php echo $data['nic'] ?></td>
            <td><?php echo $data['contact'] ?></td>
            <td><?php echo $data['plane'] ?></td>
            <td>Rs. <?php echo $data['ammount'] ?></td>
            <td><?php echo $data['pol_num'] ?? 'N/A' ?></td>
            <td><?php echo $data['pro_num'] ?? 'N/A' ?></td>
        </tr>
<?php
    }
} else {
?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>No Previous Policies Found</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
<?php
}
?>