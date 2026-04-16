<?php
session_start(); // Needed to store OTP

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendOTP($userEmail, $userName)
{
    // 1️⃣ Generate a 6-digit OTP
    $otp = rand(100000, 999999);

    // Store OTP in session (or you can store in DB)
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_email'] = $userEmail; // optional: store email linked to OTP
    $_SESSION['otp_time'] = time(); // timestamp to expire OTP after some minutes

    // 2️⃣ Email content
    $subject = "Your OTP Code";
    $message = "
        <h2>Hello $userName,</h2>
        <p>Your OTP code is: <b>$otp</b></p>
        <p>This code is valid for 5 minutes.</p>
    ";

    // 3️⃣ Send email using PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPDebug = 2; // Use 0 on production, 2 for debugging
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sadikshyanepal454@gmail.com';        // 🔑 Replace with your Gmail
        $mail->Password   = 'zqeripybjijsaxxs';          // 🔑 Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('yourgmail@gmail.com', 'Your Website Name');
        $mail->addAddress($userEmail, $userName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = "Hello $userName, Your OTP code is: $otp";

        $mail->send();
        return "OTP has been sent to $userEmail";

    } catch (Exception $e) {
        return "OTP could not be sent. Mailer Error: " . $mail->ErrorInfo;
    }
}

// 4️⃣ Example usage
$email = "mvaravinda@gmail.com";
$name = "Raj Kiran";

echo sendOTP($email, $name);
?>