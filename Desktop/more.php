<?php

include_once 'func.inc.php';
kuume_session();

include 'header.php';
echoifadmin(17);

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
                copy("Uploads/".$bild_name, "../Mobile/Uploads/".$bild_name);
                $query="INSERT INTO kuume_attachments (PATH, IID, TYPE, DATETIME_UPLOADED) VALUES('$bild_name',$_POST[IID],0,NOW());";
                mysqli_query(connect(),$query);
                document(connect(), $_SESSION[UID],$_POST[IID], "Anhang angeheftet", 0, 0);
            }
        }
  
    
    if($_FILES["fileToUpload"]["name"]!=""){
    $target_dir = "Uploads/PDF/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if(isset($_FILES["fileToUpload"]["name"])) {
    $check = strpos($_FILES["fileToUpload"]["name"],"pdf");
    if($check !== false) {
        $uploadOk = 1;
         message($message);
    } else {
        $message= "Das ist kein PDF 1!";
        $uploadOk = 0;
        message($message);
    }
    }
    if($imageFileType != "pdf" && $imageFileType != "PDF") {
        $message= "Das ist kein PDF 2!";
        $uploadOk = 0;
         message($message);
    }
    
    if ($uploadOk == 0) {
        $message = "Fehler PDF 3!";
        message($message);
    } else {
                $targetfolder =$target_dir.$_FILES['fileToUpload']['name'];
                message("Checkpoint Charlie... $targetfolder");
                
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$targetfolder);
                
                
                copy($targetfolder, "../Mobile/$targetfolder");
                $query="INSERT INTO kuume_attachments (PATH, IID, TYPE, DATETIME_UPLOADED) VALUES('PDF/".mysqli_real_escape_string($conn,$_FILES["fileToUpload"]["name"])."',$_POST[IID],1,NOW());";
                mysqli_query(connect(),$query);
                document(connect(), $_SESSION[UID],$_POST[IID], "Anhang angeheftet", 0, 0);
            }
        }
    
    $query= "SELECT * FROM kuume_inventory WHERE IID=$_POST[IID]";
    $result=mysqli_fetch_array(mysqli_query($conn,  mysqli_real_escape_string($conn, $query) ));
    
    $_POST[ding_inhalt]=  str_replace("\r\n",";",$_POST[ding_inhalt]);
        $_POST[ding_inhalt]=  str_replace("\t",";",$_POST[ding_inhalt]);
        $_POST[ding_inhalt]=  str_replace(" ",";",$_POST[ding_inhalt]);
    $_POST[ding_inhalt]=  str_replace(";;",";",$_POST[ding_inhalt]);
        while(@strpos(";;",$_POST[ding_inhalt])!==FALSE){
              $_POST[ding_inhalt]=  str_replace(";;",";",$_POST[ding_inhalt]);  
        }
    if(substr($_POST[ding_inhalt], 1)!=";"){
        $_POST[ding_inhalt]=";".$_POST[ding_inhalt];
    }
    if(substr($_POST[ding_inhalt], -1)!=";"){
        $_POST[ding_inhalt]=$_POST[ding_inhalt].";";
    }
    if($result[CONTENT]!=$_POST[ding_inhalt]){
        $query="UPDATE kuume_inventory SET CONTENT='".mysqli_real_escape_string($conn,$_POST[ding_inhalt])."' WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]).";";
        message($query);
        mysqli_query($conn, $query);
        document($conn, $_SESSION[UID], $_POST[IID],"Bearbeitet Inhalt: $result[CONTENT] => $_POST[ding_inhalt]", 0, 0);  
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
    if($result[PERCENT]!=$_POST[dings_prozent]){
        mysqli_query($conn, "UPDATE kuume_inventory SET PERCENT='".mysqli_real_escape_string($conn,$_POST[dings_prozent])."' WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]).";");
        document($conn, $_SESSION[UID], $_POST[IID],"Bearbeitet Prozent: $result[PERCENT] => $_POST[dings_prozent]", 0, 0);
        message("UPDATE kuume_inventory SET PROZENT='".mysqli_real_escape_string($conn,$_POST[dings_prozent])."' WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]).";");
    }
    if($result[ACTUAL]!=$_POST[dings_haben]){
        mysqli_query($conn, "UPDATE kuume_inventory SET ACTUAL='".mysqli_real_escape_string($conn,$_POST[dings_haben])."' WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]).";");
        document($conn, $_SESSION[UID], $_POST[IID],"Bearbeitet Haben: $result[ACTUAL] => $_POST[dings_haben]", 0, 0);
        message("UPDATE kuume_inventory SET ACTUAL='".mysqli_real_escape_string($conn,$_POST[dings_haben])."' WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]).";");
    }
    if($result[DESIRED]!=$_POST[dings_soll]){
        mysqli_query($conn, "UPDATE kuume_inventory SET DESIRED='".mysqli_real_escape_string($conn,$_POST[dings_soll])."' WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]).";");
        document($conn, $_SESSION[UID], $_POST[IID],"Bearbeitet Soll: $result[DESIRED] => $_POST[dings_soll]", 0, 0);
        message("UPDATE kuume_inventory SET DESIRED='".mysqli_real_escape_string($conn,$_POST[dings_soll])."' WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]).";");
    }
    
    if($result[EXPIRATION_YEAR]!=$_POST[dings_ablaufjahr]){
        mysqli_query($conn, "UPDATE kuume_inventory SET EXPIRATION_YEAR='".mysqli_real_escape_string($conn,$_POST[dings_ablaufjahr])."',EXPIRATION_POINT='$_POST[dings_ablaufquartal]' WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]).";");
        document($conn, $_SESSION[UID], $_POST[IID],"Bearbeitet Ablaufdatum: $result[EXPIRATION_POINT]/$result[EXPIRATION_YEAR] =>  $_POST[dings_ablaufquartal] / $_POST[dings_ablaufjahr]", 0, 0);
    }
    
    
    
    if($_POST[dings_wo]!=$_POST[dings_wo_alt]){
        $query="UPDATE kuume_inventory SET CONTENT=REPLACE( CONTENT,'".mysqli_real_escape_string($conn,$_POST[IID])."','')"."WHERE IID=".mysqli_real_escape_string($conn,$_POST[dings_wo_alt]).";";
        message($query);
        $query="UPDATE kuume_inventory SET CONTENT=CONCAT( CONTENT,'".";".mysqli_real_escape_string($conn,$_POST[IID]).";') WHERE IID=".mysqli_real_escape_string($conn,$_POST[dings_wo]).";";
       message($query);
        mysqli_query($conn,$query );
        document($conn, $_SESSION[UID], $_POST[IID],"Bearbeitet Lagerstelle: $_POST[dings_wo_alt] => $_POST[dings_wo]", 0, 0);
    }
    $_GET[IID]=$_POST[IID];
    include "comments.php";
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
    
echo "<form method=POST action=more.php enctype=multipart/form-data> ";
 echo "IID: $result[IID]   ";
    if(checkthis(3)){
            echo "<a href=edit.php?IID=$result[IID] target=thatframeyo><img class=klein src=img/edit_all.png></a>";
        }
    if(checkthis(4)){
            echo "<a href=log.php?IID=$result[IID] target=thatframeyo><img class=klein src=img/log.png></a>";
        }
    if(checkthis(0)){
            echo "<a href=delete.php?IID=$result[IID] target=thatframeyo><img class=klein src=img/delete.png></a>";
        }
    echo "<br>";
    echo "<a href=comments.php?IID=$result[IID]><img src=img/left.png class=klein></a> Name: <b>$result[NAME]</b><br>";
if($result[YEAR_PURCHASED]!="0000"){
     echo "Angeschafft : $result[YEAR_PURCHASED]<br>";
     }
if(checkthis(10) &&  $result[VALUE]!=0){
    echo "Preis: $result[VALUE]<br>";
    }
  
if(checkthis(26)){
    echo "Nachbestellen: <input type=checkbox value=1 ";
        if($result[REBUY]==1){
            echo " checked ";
        }
    echo " name=ding_rebuy>";
}      
    if(1){
    echo "<br>Datei anh&auml;ngen:<br>";
    echo '<input type="file" name="fileToUpload" id="fileToUpload"><br>';
}   
    
    echo "Prozent:<br> <input type=text value='$result[PERCENT]' name=dings_prozent style='width: 100px;'><br>"; 
    echo "Soll/Haben <br><input type=text value='$result[DESIRED]' name=dings_soll style='width: 50px;'>   "; 
    echo "<input type=text value='$result[ACTUAL]' name=dings_haben style='width: 50px;'><br>"; 
    
    echo "Haltbar bis <br> <select name=dings_ablaufquartal>";
        if($result[EXPIRATION_POINT]==4 || $result[EXPIRATION_POINT]==0){
            echo " <option value=4 selected>Fr&uuml;hjahr</option> <option value=10>Herbst</option>";
        }
        else{
           echo " <option value=4 >Fr&uuml;hjahr</option> <option value=10 selected>Herbst</option>"; 
        }
    echo " Jahr><input type=text value='$result[EXPIRATION_YEAR]' name=dings_ablaufjahr style='width: 50px;'><br>"; 
    
    
    echo "<input type=hidden value=$result[IID] name=IID>";
    
    echo "Beinhaltet<br>";
$b=explode(";", $result[CONTENT]);
    echo "<textarea rows=10 style='width: 100px;' name=ding_inhalt>";
        foreach($b as $a){
           if($a !=""){
               echo"$a\r\n";
           }
        }
    echo "</textarea><br>";
    
    $rowrowrow=mysqli_query($conn, "SELECT * FROM kuume_inventory WHERE CONTENT LIKE '%;$result[IID];%'");
    $row=  mysqli_fetch_array($rowrowrow);
     echo "Ist in:<br> <input type=text value='$row[IID]' name=dings_wo style='width: 100px;' list=kisten><input type=hidden name=dings_wo_alt value='$row[IID]'> <br>"; 
     
          echo "<datalist id=kisten>";
     $query100="SELECT * FROM kuume_inventory WHERE OWNER = $_SESSION[NOW] AND CONTENT LIKE '%;%;%;'";
     $resultat= mysqli_query($conn, $query100);
        while($rowtheboat=mysqli_fetch_array($resultat)){
            echo "<option value='$rowtheboat[IID]'>$rowtheboat[NAME]</option>";
        }
     echo "</datalist>";
    ?><br>
<input type="submit" value="Go!">
</form>
    