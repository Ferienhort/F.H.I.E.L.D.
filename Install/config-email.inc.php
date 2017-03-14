<?php
require 'Backup/PHPMailer-master/PHPMailerAutoload.php';
$mail = new PHPMailer;


$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = '';  // Specify main and backup SMTP servers
$mail->SMTPAuth = "";                               // Enable SMTP authentication
$mail->Username = '';                 // SMTP username
$mail->Password = '';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'bot@kuume.at';
$mail->FromName = 'kuumeBot'; 



$adminemail=array(" "); // Email adresse(n) die Benachrichtungen bekommen
