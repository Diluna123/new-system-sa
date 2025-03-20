<?php
include 'connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pwd = trim($_POST['pwd'] ?? '');
    $cpwd = trim($_POST['cpwd'] ?? '');
    $code = trim($_POST['code'] ?? ''); // 'code' is optional

    // Check if required fields are empty (exclude 'code' from the required fields)
    if (empty($fname) || empty($lname) || empty($email) || empty($pwd) || empty($cpwd)) {
        echo "All Fields are Required";
        exit();
    }

    // Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid Email Format";
        exit();
    }

    // Check if password and confirm password match
    if ($pwd !== $cpwd) {
        echo "Password and Confirm Password do not match";
        exit();
    }

    // Check if the email already exists
    $exd = Database::search("SELECT * FROM `users` WHERE `email` = '$email'");
    if ($exd->num_rows > 0) {
        echo "Email Already Exists";
        exit();
    }

    // Hash the password before storing (should hash the password, not the plain one)
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT);

    // If the code is empty, set it to "N/A" (you can set it to NULL as well if required)
    if (empty($code)) {
        $code = "N/A"; // Optional: set code to "N/A" if not provided
    }

    // Insert the user into the database
    Database::iud("INSERT INTO `users` (`u_fname`, `u_lname`, `code`, `email`, `password`, `user_State_id`, `teams_tid`, `position_pid`) 
    VALUES ('$fname', '$lname', '$code', '$email', '$cpwd', 1, '" . $_SESSION['user']['teams_tid'] . "', 1);");

    echo "success";
}
?>
