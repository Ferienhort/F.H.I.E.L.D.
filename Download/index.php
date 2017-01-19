<?php
include_once "../download.inc.php";
sec_session_start();

$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
$string = '';
 for ($i = 0; $i < 50; $i++) {
      $string .= $characters[mt_rand(0, strlen($characters) - 1)];
 }

$blabla=$string;
$form = '<p>Um auf die Fotos zugreifen zu k&ouml;nnen, gib als Passwort bitte deinen <b>Nachnamen</b> und anschlie&szlig;end deine <b>Sch&uuml;lernummer</b> ein.</p> <form action="index.php" method="post" accept-charset="utf8_unicode_ci">Passwort:<input type="text" name="'.$blabla.'" placeholder="Beispielname851"><input type="submit" value="Download"></form>';

if(isset($_SESSION["string"])){
    $blabla=$_SESSION["string"];
    $_POST[pwd]=$_POST[$blabla];
}

$_SESSION["string"]=$string;

?>
<html>
<head>

<link rel="apple-touch-icon-precomposed" sizes="57x57" href="apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="apple-touch-icon-60x60.png" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="apple-touch-icon-120x120.png" />
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="apple-touch-icon-76x76.png" />
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="apple-touch-icon-152x152.png" />
<link rel="icon" type="image/png" href="favicon-196x196.png" sizes="196x196" />
<link rel="icon" type="image/png" href="favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
<link rel="icon" type="image/png" href="favicon-128.png" sizes="128x128" />
<meta name="application-name" content="&nbsp;"/>
<meta name="msapplication-TileColor" content="#FFFFFF" />
<meta name="msapplication-TileImage" content="mstile-144x144.png" />
<meta name="msapplication-square70x70logo" content="mstile-70x70.png" />
<meta name="msapplication-square150x150logo" content="mstile-150x150.png" />
<meta name="msapplication-wide310x150logo" content="mstile-310x150.png" />
<meta name="msapplication-square310x310logo" content="mstile-310x310.png" />
 
<title>
Kuume Foto Download
</title>
 
<style>
/* unvisited link */
a:link {
color: grey;
}
 
/* visited link */
a:visited {
color:grey;
}
 
/* mouse over link */
a:hover {
color: grey;
}
 
/* selected link */
a:active {
color: grey;
}
</style>
</head>
<body>
<div style="
margin: auto;
position: relative;
top: 10%;
width: 40%;
padding: 10px;
text-align: center;
color: #676f7a;
 
">
<img src="unnamed.jpg">
<p><b> Foto Download Sommer 2015 <br></b></p>
<?php
$conn = new mysqli($server, $username, $password, $database);

if(isset($_SESSION["PWD"])){
    $_POST[pwd]=$_SESSION["PWD"];
}


$query= "SELECT * FROM download_actions WHERE TEXT LIKE '%Unaut%' AND IP LIKE '$_SERVER[REMOTE_ADDR]' AND DATETIME_HAPPENED > NOW() - INTERVAL 24 HOUR AND DATETIME_HAPPENED > IFNULL((SELECT DATETIME_HAPPENED AS ZAHL FROM download_actions WHERE 'TEXT' LIKE '%Login%' ORDER BY DATETIME_HAPPENED DESC LIMIT 1),  NOW() - INTERVAL 24 HOUR)";
$temp1=  mysqli_num_rows(mysqli_query($conn, $query));
$query= "SELECT * FROM download_actions WHERE TEXT LIKE '%Unaut%' AND AGENT LIKE '".mysqli_real_escape_string($conn, $_SERVER[HTTP_USER_AGENT])."' AND DATETIME_HAPPENED > NOW() - INTERVAL 24 HOUR AND DATETIME_HAPPENED > IFNULL((SELECT DATETIME_HAPPENED AS ZAHL FROM download_actions WHERE 'TEXT' LIKE '%Login%' ORDER BY DATETIME_HAPPENED DESC LIMIT 1),  NOW() - INTERVAL 24 HOUR)";
$temp2=  mysqli_num_rows(mysqli_query($conn, $query));

if($temp1>=15){
        echo "<p> Zu viele unauthorisierte Versuche. Bitte versuche es morgen nocheinmal!</p>";
        document_this("SYSTEM","Gesperrt IP fragt an: $_SERVER[REMOTE_ADDR] G.8", 0,0);
        session_unset();
        session_destroy();
    }
elseif($temp2>100){
        echo "<p> Zu viele unauthorisierte Versuche. Bitte versuche es morgen nocheinmal!</p>";
        document_this("SYSTEM","Gesperrter Browser fragt an: $_SERVER[HTTP_USER_AGENT] G.9", 0,0);
        session_unset();
        session_destroy();
}
elseif(isset($_POST[pwd])){

$pwd=strtolower(str_replace(" ","",str_replace("-","",mysqli_real_escape_string($conn, $_POST[pwd]))));
$query1 = mysqli_query($conn, "SELECT * FROM download_schueler WHERE PW='$pwd'");

$blubb= preg_replace('/\d/', '', $pwd );;
$query= "SELECT AID FROM download_actions WHERE TEXT LIKE '%Unaut%' AND SCHUELER LIKE '%$blubb%' AND DATETIME_HAPPENED > NOW() - INTERVAL 24 HOUR";
$temp=  mysqli_num_rows(mysqli_query($conn, $query));
$query= "SELECT AID FROM download_actions WHERE TEXT LIKE '%Login%' AND SCHUELER LIKE '%$pwd%' ";
$temp1=  mysqli_num_rows(mysqli_query($conn, $query));
$whitelist = array("kuumeislove", "prakprakprak2016");

    if(in_array($pwd, $whitelist)){
        $temp1=1;
    }

    if($temp>=7){
        echo "<p> Zu viele unauthorisierte Versuche. Bitte versuche es morgen nocheinmal</p>";
        document_this("$blubb","Gesperrter Name fragt an: $blubb G.10", 0,0);
        session_unset();
        session_destroy();
    }
    elseif($temp1>=10){
        echo "<p> Du hast dich bereits zu oft eingeloggt. </p>";
        document_this("$blubb","Wiederhohlungstaeter fragt an: $blubb G.11", 0,0);
        session_unset();
        session_destroy();
    }
    elseif (mysqli_num_rows ($query1)>0) {
    $_SESSION["PWD"]=$pwd;
    $_SESSION["text"]=hash(md5, $pwd.$_SERVER[REMOTE_HOST].$_SERVER[HTTP_USER_AGENT]);
    while($result = mysqli_fetch_assoc($query1)){
        $_SESSION[STRING].=$result[CAMP]."+";
    }
    document_this($pwd, "Login", 0, 0);
    
        if (strpos( $_SESSION[STRING], 'CC') !== false) {
    echo "<p>Classic Camp Fotos freigeschaltet: Leider sind diese noch nicht verf&uuml;gbar</p>";
    }
    
        if (strpos( $_SESSION[STRING], 'AC') !== false) {
    echo "<p>Allround Camp Fotos freigeschaltet: Leider sind diese noch nicht verf&uuml;gbar</p>";
    }
    
        if (strpos( $_SESSION[STRING], 'SC') !== false) {
    echo "<p>Special Camp Fotos freigeschaltet: Leider sind diese noch nicht verf&uuml;gbar</p>";
    }
    
    }
    
else{
    document_this($pwd, "Unauthorisierter Zugriffsversuch B.1", 0, 0);
    echo "<p>Ung&uuml;ltiges Passwort: Bitte versuch es ein weiteres Mal!</p>";
    echo $form;
    }
}
else{
    echo $form;  
}

mysqli_close($conn);

 ?>
<p style="font-size: small">Bei Fragen wende dich bitte an <a href="mailto:downloads@kuume.at">downloads@kuume.at</a><?php if(isset($_SESSION["PWD"])){ echo " - <a href=logout.php> Logout </a>";} ?></p>
</div>-
 
</body>
</html>