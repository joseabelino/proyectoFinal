<?php
require 'PHPMailer/PHPMailerAutoload.php';

class sendMailToConfirmSession 
{
    public $user="null";
    public function __construct($user)
    {
        $this->$user = $user;   
    }

    public function sendMail()
    {
        $mail = new PHPMailer;
        //$mail->SMTPDebug = 3;                               // Enable verbose debug outpu
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'jose201400588@gmail.com';                 // SMTP username
        $mail->Password = 'lvzmdypgiuydeisu';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('jose201400588@gmail.com', 'Admin');
        $mail->addAddress('jose201400588@gmail.com');    

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Inicio de sesion';
        $mail->Body    = "Se ha detectado un inicio de sesion con el usuario $user";
        $mail->AltBody = '...';

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }
}

$sendmail = new sendMailToConfirmSession("JUAN");

$sendmail->sendMail();