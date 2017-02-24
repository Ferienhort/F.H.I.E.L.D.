<?php
session_start();
include_once '../func.inc.php';
echoifadmin(17);
?>


<html>
    <head>
        <title>
            kuume
        </title><link rel="apple-touch-icon" sizes="57x57" href="../Icon/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="../Icon/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="../Icon/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="../Icon/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="../Icon/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="../Icon/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="../Icon/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="../Icon/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="../Icon/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="../Icon/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="../Icon/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="../Icon/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="../Icon/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="../Icon/manifest.json">
<link rel="mask-icon" href="../Icon/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="../Icon/favicon.ico">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-TileImage" content="../Icon/mstile-144x144.png">
<meta name="msapplication-config" content="../Icon/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        

<?php
$conn=connect();

if(isset($_POST[IID])){
    
    if($_FILES["fileToUpload"]["name"]!=""){
    $target_dir="../Uploads/Bilder/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if(isset($_FILES["fileToUpload"]["name"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $message= "Das ist kein Bild!";
        $uploadOk = 0;
    }
    }
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $message= "Das ist kein Bild!";
        $uploadOk = 0;
    }
    
    if ($uploadOk == 0) {
        $message = "Fehler";
    } else {
                list($width, $height) = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($width>$height){
                 $newwidth=800;
                 $newheight=$height*(800/$width);
                }
                else{
                    $newheight=800;
                    $newwidth=$width*(800/$height);
                }
                $image_p = imagecreatetruecolor($newwidth, $newheight);
            
                $bild_name="Bilder/".time().".jpg";
                $data = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);
                $image = imagecreatefromstring( $data );
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                imagedestroy($image);
                imagejpeg($image_p, "Uploads/".$bild_name);
                copy("Uploads/".$bild_name, "../Desktop/Uploads/".$bild_name);
                $query="INSERT INTO kuume_attachments (PATH, IID, TYPE, DATETIME_UPLOADED) VALUES('$bild_name',$_POST[IID],0,NOW());";
                mysqli_query(connect(),$query);
                document(connect(), $_SESSION[UID],$_POST[IID], "Anhang angeheftet", 0, 0);
            }
    
    
    
    }
   
    
    $query= "SELECT * FROM kuume_inventory WHERE IID=$_POST[IID]";
    $result=mysqli_fetch_array(mysqli_query($conn,  mysqli_real_escape_string($conn, $query) ));
    
    $_POST[ding_inhalt]=  str_replace("\r\n",";",$_POST[ding_inhalt]);
    $_POST[ding_inhalt]=  str_replace(";;","",$_POST[ding_inhalt]);

    
    
    
    if(substr($_POST[ding_inhalt], 1)!=";"){
        $_POST[ding_inhalt]=";".$_POST[ding_inhalt];
    }
    if(substr($_POST[ding_inhalt], -1)!=";"){
        $_POST[ding_inhalt]=$_POST[ding_inhalt].";";
    }
       
        
    if(isset($_POST[ding_rebuy]) != $result[REBUY]){
        if(!isset($_POST[ding_rebuy])){
            $_POST[ding_rebuy]=0;
        }
        $query="UPDATE kuume_inventory SET REBUY=".mysqli_real_escape_string($conn,$_POST[ding_rebuy])." WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]).";";
        message($query);
        mysqli_query($conn, $query);
        if($_POST[ding_rebuy]==1){
            document($conn, $_SESSION[UID], $_POST[IID],"Nachbestellung beantragt", 0, 0);
        }
        else {
            document($conn, $_SESSION[UID], $_POST[IID],"Nachbestellung abgebrochen", 0, 0);
        }
    }    
    if($result[CONTENT]!=$_POST[ding_inhalt]){
        $query="UPDATE kuume_inventory SET CONTENT='".mysqli_real_escape_string($conn,$_POST[ding_inhalt])."' WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]).";";
        message($query);
        mysqli_query($conn, $query);
        document($conn, $_SESSION[UID], $_POST[IID],"Bearbeitet Inhalt: $result[CONTENT] => $_POST[ding_inhalt]", 0, 0);  
        $message.="Inhalt erfolgreich bearbeitet";
    }

    if($result[PERCENT]!=$_POST[dings_prozent]){
        mysqli_query($conn, "UPDATE kuume_inventory SET PERCENT='".mysqli_real_escape_string($conn,$_POST[dings_prozent])."' WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]).";");
        document($conn, $_SESSION[UID], $_POST[IID],"Bearbeitet Prozent: $result[PERCENT] => $_POST[dings_prozent]", 0, 0);
        message("UPDATE kuume_inventory SET PROZENT='".mysqli_real_escape_string($conn,$_POST[dings_prozent])."' WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]).";");
    }
        if($_POST[dings_wo]!=$_POST[dings_wo_alt]){
        $query="UPDATE kuume_inventory SET CONTENT=REPLACE( CONTENT,'".mysqli_real_escape_string($conn,$_POST[IID])."','')"."WHERE IID=".mysqli_real_escape_string($conn,$_POST[dings_wo_alt]).";";
        message($query);
        $query="UPDATE kuume_inventory SET CONTENT=CONCAT( CONTENT,'".";".mysqli_real_escape_string($conn,$_POST[IID]).";') WHERE IID=".mysqli_real_escape_string($conn,$_POST[dings_wo]).";";
        message($query);
        mysqli_query($conn,$query );
        document($conn, $_SESSION[UID], $_POST[IID],"Bearbeitet Lagerstelle: $_POST[dings_wo_alt] => $_POST[dings_wo]", 0, 0);
    }
    
    
    if($_POST[ding_lender]!=""){
          $query= "UPDATE "
            . "kuume_inventory  SET DATETIME_EDITED=NOW(), DATETIME_LEND=NOW(), LENDER='$_POST[ding_lender]'"
            . " WHERE IID=$_POST[IID]";
            mysqli_query($conn, $query );
               document($conn, $_SESSION[UID], $_POST[IID],"Verliehen an $_POST[ding_lender]", -1, $_POST[ding_lender]);
               if($faulheitlevelmehrals9000==TRUE){
                   $message.="<br>";
               }
               $message.="Erfolgreich ausgliehen";
         }
    if(isset($_POST[ding_lender_old])){
            $query= "UPDATE "
            . "kuume_inventory  SET DATETIME_EDITED=NOW(), LENDER='0', DATETIME_LEND=0"
            . " WHERE IID=$_POST[IID]";
            mysqli_query($conn, $query );
               document($conn, $_SESSION[UID], $_POST[IID],"Retourniert von $_POST[ding_lender_old]", -1, $_POST[ding_lender_old]);
               if($faulheitlevelmehrals9000==TRUE){
                   $message.="<br>";
               }
               $message.="Erfolgreich retourniert";
               $faulheitlevelmehrals9000=TRUE;
     }
         
    $_GET[IID]=$_POST[IID];
    include 'kuume.php';
    die();
}


 if(!isset($_GET[IID])){
        die("Fehler...");
    }
    if($_GET[IID]==""){
        die("Kein Parameter!");
    }
    
    $query= "SELECT * FROM kuume_inventory WHERE IID=$_GET[IID]";
    $result=mysqli_fetch_array(mysqli_query($conn,  mysqli_real_escape_string($conn, $query) ));

    message($query);
    
echo "<form method=POST action=more.php id=formular enctype=multipart/form-data>";
 echo "IID: $result[IID]   ";
    echo "<br>";
    echo " Name: <b>$result[NAME]</b><span class=mobimenu><a href=kuume.php?IID=$result[IID]&ANON=1><img src=img/BackMobile.gif class=mobimenupix></a><a href=index.html><img class=mobimenupix src=img/Homebutton.gif></a></span><br>";

    if($result[LENDER]=="0" && checkthis(6)){
        echo '<br>Verleih: <br><input type="text" name="ding_lender"><br>'; 
        }
    elseif($result[LENDER]!="0"){
        echo "verliehen an $result[LENDER] am $result[DATETIME_LEND]";
            if(checkthis(6)){
                echo "<br> Wieder da: <input type=checkbox name=ding_lender_old value=$result[LENDER]><br>";
            }
            else {
                echo "<br>";
            }
        }
    
    
    if($result[YEAR_PURCHASED]!="0000"){
     echo "Angeschafft: $result[YEAR_PURCHASED]<br>";
     }
 if(checkthis(26)){
    echo "Nachbestellen: <input type=checkbox value=1 ";
        if($result[REBUY]==1){
            echo " checked ";
        }
    
        echo " name=ding_rebuy ><br>";
        }    
   


if(1){
    echo "<br>Datei anh&auml;ngen:<br>";
    echo '<input type="file" name="fileToUpload" id="fileToUpload"><br>';
}    

   
if(checkthis(10) &&  $result[VALUE]!=0){
    echo "Preis: $result[VALUE]<br>";
    }

    echo "Prozent:<br> <input type=text value='$result[PERCENT]' name=dings_prozent><br>"; 
    echo "<input type=hidden value=$result[IID] name=IID>";
    
    echo "Beinhaltet<br>";
$b=explode(";", $result[CONTENT]);
    echo "<textarea name=ding_inhalt rows=5>";
        foreach($b as $a){
           if($a !=""){
               echo"$a\r\n";
           }
        }
    echo "</textarea>";
    
    $rowrowrow=mysqli_query($conn, "SELECT * FROM kuume_inventory WHERE CONTENT LIKE '%;$result[IID];%'");
    $row=  mysqli_fetch_array($rowrowrow);
     echo "Ist in:<br> <input type=text value='$row[IID]' name=dings_wo style='width: 100px;'><input type=hidden name=dings_wo_alt value='$row[IID]'> <br>"; 
     ?>
    <br>
<input type="submit" value="Go!">
</form>