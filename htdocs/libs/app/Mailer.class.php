<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public static function sendEmail($to, $name, $surname, $subject, $message, $email)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'smtp.example.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'user@example.com';
            $mail->Password   = 'secret';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            //Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress($to, "$name $surname");
            $mail->addReplyTo($email, "$name $surname");

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = "You have received a new message from $name $surname.<br><br>" . "Email: $email<br>" . "Message: <br>$message";
            $mail->AltBody = "You have received a new message from $name $surname.\n\n" . "Email: $email\n" . "Message:\n$message";

            $mail->send();
            return "Message has been sent";
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
