<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendmail($tomail, $totmailname, $subject, $message)
{
    $loginid    = "onlineauctionprojectmail@myprojectcoding.xyz";
    $password   = "h?eeL$9e0lp6";
    $smtpserver = "mail.myprojectcoding.xyz";
    $smtpport   = 26;
    $mailsender = "OnlineAuction";
    $companyname= "OnlineAuction";
    $facebook   = "https://www.facebook.com/OnlineAuction";
    $twitter    = "https://www.twitter.com/OnlineAuction";
    $youtube    = "https://www.youtube.com/OnlineAuction";
    $linkedin   = "https://www.linkedin.com/OnlineAuction";
    $companyaddress  = "secondchance.com, Kathmandu, Nepal";
    $contactno = "9862222222";
    $url = "www.secondchancce.com";

    // Include PHPMailer files
    require_once 'PHPMailer/src/Exception.php';
    require_once 'PHPMailer/src/PHPMailer.php';
    require_once 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = true; // set true for debugging
        $mail->isSMTP();
        $mail->Host       = $smtpserver;
        $mail->SMTPAuth   = true;
        $mail->Username   = $loginid;
        $mail->Password   = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $smtpport;

        // Recipients
        $mail->setFrom($loginid, $mailsender);
        $mail->addAddress($tomail, $totmailname);
        $mail->addReplyTo($loginid, $mailsender);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;

        // HTML body
        $mailmessage = "
        <body link='#00a5b5' vlink='#00a5b5' alink='#00a5b5'>
        <table align='center' style='width:600px;font-family:Arial,sans-serif;color:#555559;font-size:16px;line-height:26px;border-collapse:collapse;'>
            <tr>
                <td style='border:1px solid #eeeff0;padding:0;'>
                    <table style='width:100%;border-collapse:collapse;'>
                        <tr>
                            <td colspan='4' style='background:#fff;border-bottom:4px solid #00a5b5;padding:0;text-align:center;'>
                                <a href='$url' style='text-decoration:none;'><h2>$companyname</h2></a>
                            </td>
                        </tr>
                        <tr>
                            <td style='padding:20px;text-align:center;'>
                                <h2>$subject</h2>
                                <hr size='1' color='#eeeff0'>
                                <p>$message</p>
                            </td>
                        </tr>
                        <tr>
                            <td style='text-align:center;padding:10px;'>
                                <table style='margin:0 auto;'>
                                    <tr>";
        if($facebook && $twitter && $youtube && $linkedin){
            $mailmessage .= "
                                        <td><a href='$facebook'><img src='https://info.tenable.com/rs/tenable/images/facebook-teal.png'></a></td>
                                        <td><a href='$twitter'><img src='https://info.tenable.com/rs/tenable/images/twitter-teal.png'></a></td>
                                        <td><a href='$youtube'><img src='https://info.tenable.com/rs/tenable/images/youtube-teal.png'></a></td>
                                        <td><a href='$linkedin'><img src='https://info.tenable.com/rs/tenable/images/linkedin-teal.png'></a></td>";
        }
        $mailmessage .= "
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr style='border-top:4px solid #00a5b5;'>
                            <td style='text-align:center;padding:20px;font-size:12px;'>
                                <b>$companyname</b><br>
                                $companyaddress<br>
                                $contactno
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </body>";

        $mail->Body    = $mailmessage;
        $mail->AltBody = strip_tags($message);

        $mail->send();
        // echo "Mail sent successfully";

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
    }
}

// Example usage:
// sendmail("studentprojects.live@gmail.com", "Student Projects", "Test Subject", "This is a test message.");
?>