<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// --------------------
// Get URL parameters
// --------------------
$toaddress = isset($_GET['toaddress']) ? $_GET['toaddress'] : '';
$subject   = isset($_GET['subject']) ? $_GET['subject'] : 'No Subject';
$message   = isset($_GET['message']) ? $_GET['message'] : '';
$name      = isset($_GET['name']) ? $_GET['name'] : 'Customer';

// --------------------
// Validate required fields
// --------------------
if (empty($toaddress) || empty($subject) || empty($message)) {
    die('Error: toaddress, subject, and message are required.');
}

// --------------------
// sendmail function
// --------------------
function sendmail($toaddress, $subject, $message, $name)
{
    $loginid    = "onlineauctionprojectmail@myprojectcoding.xyz";
    $password   = "h?eeL$9e0lp6";
    $smtpserver = "mail.myprojectcoding.xyz";
    $smtpport   = 26; // try 587 if 26 fails
    $mailsender = "OnlineAuction";

    $mail = new PHPMailer(true);

    try {
        // SMTP setup
        $mail->isSMTP();
        $mail->Host       = $smtpserver;
        $mail->SMTPAuth   = true;
        $mail->Username   = $loginid;
        $mail->Password   = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $smtpport;

        // Debugging
        $mail->SMTPDebug  = 2; // 0=off, 2=full debug
        $mail->Debugoutput = 'html';

        // SSL options for self-signed certificates
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        // Recipients
        $mail->setFrom($loginid, $mailsender);
        $mail->addAddress($toaddress, $name);
        $mail->addReplyTo($loginid, $mailsender);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = strip_tags($message);

        $mail->send();
        echo "Mail sent successfully to $toaddress";

    } catch (Exception $e) {
        echo "Message could not be sent. PHPMailer Exception: " . $e->getMessage();
    }
}

// --------------------
// Send the mail
// --------------------
sendmail($toaddress, $subject, $message, $name);
?>