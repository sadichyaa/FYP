<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = $_GET['emailid'] ?? '';
$name  = $_GET['cstname'] ?? '';

if($email == '' || $name == ''){
    echo "error";
    exit;
}

// Generate OTP
$otp = rand(100000, 999999);

// Store in session
$_SESSION['otp'] = $otp;
$_SESSION['otp_email'] = $email;
$_SESSION['otp_time'] = time();

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->SMTPDebug = 0; // IMPORTANT: set 0 in production
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'sadikshyanepal454@gmail.com';
    $mail->Password = 'zqeripybjijsaxxs';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('sadikshyanepal454@gmail.com', 'Secondchance');
    $mail->addAddress($email, $name);

    $mail->isHTML(true);
    $mail->Subject = "Your OTP Code";
    $mail->Body = "<h3>Hello $name</h3><p>Your OTP is <b>$otp</b></p>";

    $mail->send();

    echo "sent"; // ONLY status
} catch (Exception $e) {
    echo "error";
}
?>