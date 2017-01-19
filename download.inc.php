<?php

$server = "dd29920.kasserver.com";
$username = "d0220110";
$password = "V7ntpLuc9HeKVYRw";
$database = "d0220110";


function document_this($schueler, $text, $file, $camp){
$server = "dd29920.kasserver.com";
$username = "d0220110";
$password = "V7ntpLuc9HeKVYRw";
$database = "d0220110";
    $conn = new mysqli($server, $username, $password, $database);
    $textding=explode("#",$text);
        if(empty($textding[1])==TRUE){
            $textding[1]="0"; 
        }
$query="INSERT INTO download_actions (DATETIME_HAPPENED, SCHUELER, TEXT, FILE, CAMP, IP, HOST, AGENT, DID) VALUES(NOW(),'".mysqli_real_escape_string($conn,$schueler)."', '".mysqli_real_escape_string($conn,$textding[0])."', '".mysqli_real_escape_string($conn,$file)."','".mysqli_real_escape_string($conn,$camp)."','".mysqli_real_escape_string($conn, $_SERVER[REMOTE_ADDR])."','".mysqli_real_escape_string($conn, gethostbyaddr($_SERVER[REMOTE_ADDR]))."','".mysqli_real_escape_string($conn, $_SERVER[HTTP_USER_AGENT])."',".mysqli_real_escape_string($conn,$textding[1]).")";
mysqli_query($conn, $query);
}


function sec_session_start() {
    ini_set('session.gc_maxlifetime', 86400);
    session_start();
    session_regenerate_id(true);
}