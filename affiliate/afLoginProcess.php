<?php
include '../connection.php';
session_start();

// Sanitize and validate input
$contact = isset($_POST['contactNum']) ? trim($_POST['contactNum']) : '';
$psw = isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($contact) || empty($psw)) {
    echo "Contact number and password are required!";
    exit;
}

// Validate contact number (example: 10 digits, only numbers)
if (!preg_match("/^\d{10}$/", $contact)) {
    echo "Invalid contact number format!";
    exit;
}

// Optionally: Validate password length (min 6 chars)
if (strlen($psw) < 6) {
    echo "Password must be at least 6 characters!";
    exit;
}

// Proceed with DB search
$searchContact = Database::search("SELECT * FROM `customers` WHERE `contact` = '$contact'");
$searchContactCount = $searchContact->num_rows;

if ($searchContactCount > 0) {
    $data = $searchContact->fetch_assoc();
    $customerId = $data["id"];

    $searchAfUser = Database::search("SELECT * FROM `af_users` WHERE `customers_id` = '$customerId'");
    $searchAfUserCount = $searchAfUser->num_rows;

    if ($searchAfUserCount > 0) {
        $afData = $searchAfUser->fetch_assoc();
        $afId = $afData["af_id"];

        $afPassword = $afData["af_psw"];

        if ($psw == $afPassword) {
            $bankDetials = Database::search("SELECT * FROM `afbank` JOIN `banks` ON `afbank`.`Banks_idBanks`=`banks`.`idBanks` WHERE `afbank`.`af_users_af_id` = '$afId'");

            $bankDetailsCount = $bankDetials->num_rows;

            if ($bankDetailsCount > 0) {
                $bankData = $bankDetials->fetch_assoc();
            }else{
                $bankData = [
                    "bank" => "N/A",
                    "accNo" => "N/A",
                    "branch" => "N/A",
                    "accHolder" => "N/A"
                ];
            }



            $_SESSION['afuser'] = [
                "fname" => $data["fname"],
                "lname" => $data["lname"],
                "nic" => $data["nic"],
                "address" => $data["addres"],
                "jdate" => $data["user_date"],
                "jtime" => $data["user_time"],
                "u_id" => $afId,
                "dob" => $data["dob"],
                "bank" => $bankData["bank_name"],
                "accNo" => $bankData["accNum"],
                "branch" => $bankData["branch"],
                "accHolder" => $bankData["hName"],
                "customer_id" => $customerId,
                "contact" => $contact,
                "agentId" => $afData["users_u_id"],
            ];
            echo "success";
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "No affiliate user found for this contact number! Please register as an affiliate.";
    }
} else {
    echo "Contact number not found!";
}
