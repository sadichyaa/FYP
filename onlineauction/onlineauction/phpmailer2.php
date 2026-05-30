<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendmail($tomail, $totmailname, $subject, $message)
{
    $loginid    = "sadikshyanepal454@gmail.com"; // your Gmail address
    $password   = "fwbmzjdfpxwuxuhx";                  // your Gmail App Password
    $mailsender = "OnlineAuction";

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';       // Gmail SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = $loginid;
        $mail->Password   = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;                    // TLS port
        $mail->SMTPDebug  = 2;                      // debug output

        // Recipients
        $mail->setFrom($loginid, $mailsender);
        $mail->addAddress($tomail, $totmailname);
        $mail->addReplyTo($loginid, $mailsender);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = strip_tags($message);

        $mail->send();
        echo "Mail sent successfully to $tomail";

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
    }
}

// Test it
sendmail("studentprojects.live@gmail.com", "Student Projects", "My subject title", "My message");
?>