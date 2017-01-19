<?php
include '../download.inc.php';
sec_session_start();

if($_SESSION["text"]!= hash(md5, $_SESSION["PWD"].$_SERVER[REMOTE_HOST].$_SERVER[HTTP_USER_AGENT])){
   document_this("","Unauthorisierter Zugriffsversuch A.2", "$_GET[FILE]",$_GET[CAMP]);
   die("kein Zugriff  Fehler: A.2");
}

if(isset($_SESSION["PWD"])==FALSE){
   document_this("","Unauthorisierter Zugriffsversuch A.3", "$_GET[FILE]",$_GET[CAMP]);
   die("kein Zugriff  Fehler: A.3");
}

if(!isset($_GET[CAMP]) || !isset($_GET[FILE])){
   document_this($_SESSION["PWD"],"Unauthorisierter Zugriffsversuch A.4", "$_GET[FILE]",$_GET[CAMP]);
   die("Nice Try!  Fehler: A.4");
}


$conn = new mysqli($server, $username, $password, $database);

$pwd=$_SESSION["PWD"];
$query = mysqli_query($conn, "SELECT * FROM download_schueler WHERE PW='$pwd'");

if (mysqli_num_rows ($query)==0) {
    document_this($_SESSION["PWD"],"Unauthorisierter Zugriffsversuch A.5", "$_GET[FILE]",$_GET[CAMP]);
    die("Nice Try! Fehler: A.5");
}
else{
    $flipflop=FALSE;
    while($row=mysqli_fetch_array($query)){
        if((strpos($row[CAMP], $_GET[CAMP]) !== false)){
            $flipflop=TRUE;
        }
    }
    if(!$flipflop){
        document_this($_SESSION["PWD"],"Unauthorisierter Zugriffsversuch A.6", "$_GET[FILE]",$_GET[CAMP]);
        die("Nice Try! Fehler: A.6");
    }
}

$file = $_SERVER['DOCUMENT_ROOT'].'/Ddata/'.$_GET[CAMP]."/".$_GET[FILE].'.zip';

if(!file_exists($file)){
    document_this($_SESSION["PWD"],"Unauthorisierter Zugriffsversuch A.7", "$_GET[FILE]",$_GET[CAMP]);
    die("Nice Try! Fehler: A.7");
}

sleep(1);

$var=time();

document_this($_SESSION["PWD"],"Download Startet #$var", "$_GET[FILE]",$_GET[CAMP]);

$file_name = basename($file);

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$file_name);
header('Content-Length: '.filesize($file)."'");
echo readfile($file);

    
document_this($_SESSION["PWD"],"Download Beendet #$var", "$_GET[FILE]",$_GET[CAMP]);
exit;