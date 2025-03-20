<?php
include "connection.php";
include "email_send/Exception.php";
include "email_send/SMTP.php";
include "email_send/PHPMailer.php";

session_start();

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_SESSION['user']['email'])) {
    $email = $_SESSION['user']['email'];




    $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

    Database::iud("UPDATE `users` SET `verification_code` ='" . $code . "' WHERE `email` ='" . $email . "'");

    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'dilunasithija111@gmail.com';
    $mail->Password = 'zuutgguqzhyaylpj';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('dilunasithija111@gmail.com', 'Reset Password');
    $mail->addReplyTo('dilunasithija111@gmail.com', 'Reset Password');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Sanasa Easy Change Password Email Verification Code';
    $bodyContent = '<div style="width: 100%; max-width: 800px; margin: auto; font-family: Arial, sans-serif; border: 1px solid #ddd; padding: 20px; background-color: #f9f9f9;">
        
    <!-- Letterhead with Logo -->
    <div style="background-color: #ffffff; padding: 15px; text-align: center; border-bottom: 2px solid #3d498a;">
        <img src="https://sicl.lk/demo/content_images/logo-sanasa-life.png" alt="Sanasa Life Logo" style="height: 60px;">
    </div>

    <!-- Email Content -->
    <div style="padding: 20px; background-color: #ffffff;">
        <h2 style="color: #3d498a; text-align: center;">Sanasa Easy</h2>
        <h3 style="color: rgb(139, 139, 139); text-align: center;">Change Your Password Verification Code</h3>
        <p style="width: 80%; margin: auto; text-align: center;">
            We received a request to reset your password. Use the verification code below to proceed.
            If you didn\'t request a reset, please ignore this email.
        </p>
        
        <!-- Right-Aligned Code -->
        <div style="width: 200px; height: 50px; background-color: #3d498a; border-radius: 10px; 
            color: white; font-size: 22px; font-weight: bold; display: flex; 
            justify-content: center; align-items: center; text-align: center; 
            margin: 20px auto 0 auto; text-align: center;">
    <div>' . $code . '</div>
</div>

        
        <p style="text-align: center;">If you have any issues, please contact our support team.</p>
        <p style="text-align: center;">
            <a href="https://www.sanasaeasy.infinityfreeapp.com/login.php" style="color: #3d498a; text-decoration: none; font-weight: bold;">Click here to login</a>
        </p>
    </div>

    <!-- Footer -->
    <div style="background-color: #f1f1f1; padding: 10px; text-align: center; font-size: 14px; color: #666;">
        <p>© 2025 Sanasa Easy | All Rights Reserved</p>
    </div>

</div>';
    $mail->Body    = $bodyContent;

    if (!$mail->send()) {
        echo ('verfication code sending failed');
    } else {
        echo ('verfication code sent, check your email');
    }
} else {

    echo ('email not found');
}
