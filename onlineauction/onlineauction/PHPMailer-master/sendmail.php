<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailerAutoload.php'; // or vendor/autoload.php

function sendmail($to, $name, $subject, $message)
{
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 2;

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'sadikshyanepal454@gmail.com'; // 🔴 CHANGE THIS
        $mail->Password = 'zqeripybjijsaxxs';     // 🔴 CHANGE THIS

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('sadikshyanepal454@gmail.com', 'Online Auction');
        $mail->addAddress($to, $name);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        if(!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

    } catch (Exception $e) {
        echo "Error: " . $mail->ErrorInfo;
    }
    
}
?>