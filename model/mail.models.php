<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/autoload.php';
class mail
{
  var $type = "Content-Type: text/html; charset=UTF-8\r\n";

  function sendMail(
    $from,
    $name,
    $Subject,
    $body
  ) {
    $mail = new PHPMailer(true);
    $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      )
    );
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'thientrile2003@gmail.com';
    $mail->Password   = 'bkzvwxtlbbdonexz';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;


    $mail->setFrom('thientrile2003@gmail.com', 'DGWORK');
    $mail->Subject = $Subject;
    $mail->isHTML(true);
    $mail->Body    =  $body;
    $mail->addAddress($from);
    
    return $mail->send()?true:false;
  }
  function confirmMail($sendTo, $code, $name = "")
  {
    $header = "Confirm Email";

    $name = $name != "" ? $name : "you";

    $content = "<html>
  <head>
    <title>Confirmation Email</title>
  </head>
  <body>
    <h1>Confirmation Email</h1>
    <p>Dear $name,</p>
    <p>Thank you for your recent request. Please find your confirmation code below:</p>
    <h2>Confirmation Code:$code</h2>
    <p>Please use this code to confirm your request.</p>
    <p>If you have any questions or concerns, please do not hesitate to reach out to us.</p>
    <p>Best regards,<br>
    DGWORK</p>
  </body>
</html>
";
    return mail::sendMail($sendTo, 'you', $header, $content);
  }
}
