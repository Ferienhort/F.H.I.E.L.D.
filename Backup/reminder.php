<?php
require '../func.inc.php';
require 'PHPMailer-master/PHPMailerAutoload.php';


$mail = new PHPMailer;
    
    
include '../config-email.inc.php';


$groups_email=array(

    "kuume" => array(1,"kuume@ferienhort.at",'bot@kuume.at'),
    "OH" => array(3,"allround-camp@ferienhort.at", "christoph.mrkvicka@ferienhort.at","oh@kuume.at",'bot@kuume.at')
    );

foreach ($groups_email as $key)
{
    
    $result=mysqli_query(connect(), "SELECT * FROM `kuume_inventory`  WHERE LENDER NOT LIKE '0' AND OWNER = $key[0] ORDER BY LENDER");

    if(mysqli_num_rows($result) === 0 ){
       continue;
    }
 
    $text="";
 
     while ($row = mysqli_fetch_array($result))
    {
    $text.= $row[LENDER]." hat vor ".round((time()-strtotime($row[DATETIME_LEND]))/3600)." Stunden folgendes geliehen: ".$row[NAME]."\r\n<br>";
    }
        
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
