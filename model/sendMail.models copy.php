<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
class sendMail
{
  var $type = "Content-Type: text/html; charset=UTF-8\r\n";

  function mail(
    $from,
    $name,
    $Subject,
    $body
  ) {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'thientrile2003@gmail.com';
    $mail->Password   = 'lbvzopqeovpduiln';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;


    $mail->setFrom('thientrile2003@gmail.com', 'DGWORK');
    $mail->addAddress($from, $name);
    // $mail->addAddress('ellen@example.com');           
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $Subject;
    $mail->Body    =  $body;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
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
    return $this->mail($sendTo, 'you', $header, $content);
  }
}
