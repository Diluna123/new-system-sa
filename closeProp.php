<?php



include 'connection.php';
$cid = $_POST['cid'];

$pro_num = $_POST['proNum'];
$pol_num = $_POST['polNum'];

if (empty($pro_num)) {
    echo "enter proposel number before close this";
} else {
    $data = Database::search("SELECT * FROM `police_t` WHERE `pro_num` = '$pro_num' AND `pol_num` = '$pol_num' ");
    if ($data->num_rows > 0) {
        echo "already exist";
    } else {
        Database::iud("UPDATE `police_t` SET `status_s_id` = '1', `pro_num`='$pro_num' ,`pol_num`= '$pol_num' WHERE `police_t`.`customers_id` = $cid ");
        echo "success";
    }
}
