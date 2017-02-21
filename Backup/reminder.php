<?php
require '../func.inc.php';

require 'PHPMailer-master/PHPMailerAutoload.php';

$groups_email=array(

    "kuume" => array(1,"kuume@ferienhort.at"),
    "OH" => array(3,"allround-camp@ferienhort.at", "christoph.mrkvicka@ferienhort.at","oh@kuume.at")

);

foreach ($groups_email as $key)
{
    
    $result=mysqli_query(connect(), "SELECT * FROM `kuume_inventory`  WHERE LENDER !=0 AND OWNER = $key[0] ORDER BY LENDER");

    if(mysqli_num_rows($result) === 0 ){
       continue;
    }
 
    $text="";
 
     while ($row = mysqli_fetch_array($result))
    {
    $text.= $row[LENDER]." hat vor ".round((time()-strtotime($row[DATETIME_LEND]))/3600)." Stunden folgendes geliehen: ".$row[NAME]."\r\n<br>";
    }
        
$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'w013876e.kasserver.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'm03a30e0';                 // SMTP username
$mail->Password = 'XxT7XV2EZmCzYMMY';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'bot@kuume.at';
$mail->FromName = 'kuumeBot';

foreach ($key as $value)
{
    if(!is_int($value)){
        $mail->addAddress($value);
    }
}
     // Add a recipient

$mail->AddBCC("gregor@lichtensteiner.at");

$mail->addReplyTo('downloads@kuume.at', 'Downloads');

$mail->Subject = 'Erinnerung';
$mail->Body    = $mail->AltBody = $text;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
    document(connect(), 2, 0, "Erinnerungen verschickt" , 0, 0);
} else {
    echo $text;
}

}
