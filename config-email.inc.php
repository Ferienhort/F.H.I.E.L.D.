<?php
require 'Backup/PHPMailer-master/PHPMailerAutoload.php';
$mail = new PHPMailer;




$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = '';  // Specify main and backup SMTP servers
$mail->SMTPAuth = TRUE;                               // Enable SMTP authentication
$mail->Username = '';                 // SMTP username
$mail->Password = '';                           // SMTP password
$mail->SMTPSecure = '';                            // Enable encryption, 'ssl' also accepted

$mail->From = '';
$mail->FromName = '';


$adminemail=array(" "); // Email adresse(n) die Benachrichtungen bekommen
