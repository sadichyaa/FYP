<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailerAutoload.php'; // or vendor/autoload.php

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = 'sadikshyanepal454@gmail.com'; // YOUR EMAIL
    $mail->Password = 'zqeripybjijsaxxs';     // APP PASSWORD (no spaces)

    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('yourgmail@gmail.com', 'OTP Service');
    $mail->addAddress('receiver@gmail.com'); // user email

    // OTP generation
    $otp = rand(100000, 999999);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Your OTP Code';
    $mail->Body    = "Your OTP is: <b>$otp</b>";

    $mail->send();
    echo "OTP Sent Successfully: $otp";

} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>