<?php
session_start();
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendTestOTP($email, $name) {
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_email'] = $email;
    $_SESSION['otp_time'] = time();

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPDebug = 2; // Shows errors in browser
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sadikshyanepal454@gmail.com'; // Your Gmail
        $mail->Password = 'zqeripybjijsaxxs';   // Your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('yourgmail@gmail.com', 'Test OTP');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "Your OTP Code";
        $mail->Body = "<h2>Hello $name</h2><p>Your OTP is <b>$otp</b></p>";
        $mail->AltBody = "Your OTP is $otp";

        $mail->send();
        echo "OTP sent successfully to $email. Check your inbox!";
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}

// Test
sendTestOTP('YOUR_EMAIL@gmail.com', 'Your Name');
?>