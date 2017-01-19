<?php
session_start();

include_once '../func.inc.php';

echoifadmin(3);

if(!(!isset($_GET[IID]) || !isset($_POST[IID]))){
    die("Fehler");
}
    $conn=connect();
    
   
if(isset($_POST[IID])){
    $query= "SELECT * FROM kuume_inventory WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]);
    $result=mysqli_fetch_array(mysqli_query($conn,$query)); 
         
        if($_POST[dingsname]!=$result[NAME]){
               $query= "UPDATE kuume_inventory SET NAME='".mysqli_real_escape_string($conn,$_POST[dingsname])."', DATETIME_EDITED=NOW() WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]);
               mysqli_query($conn,$query);
               document($conn, $_SESSION[UID], $_POST[IID],"Bearbeitet Namen: $result[NAME] => $_POST[dingsname]", 0, 0);
               $message=1;
        }
        if($_POST[dingsjahr]!=$result[YEAR_PURCHASED]){
               $query= "UPDATE kuume_inventory SET YEAR_PURCHASED=".mysqli_real_escape_string($conn,$_POST[dingsjahr]).", DATETIME_EDITED=NOW() WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]);
               mysqli_query($conn,$query);
               document($conn, $_SESSION[UID], $_POST[IID],"Bearbeitet Jahr: $result[YEAR_PURCHASED] => $_POST[dingsjahr]", 0, 0);
               $message=1;
        }
        if($_POST[ding_status]!=$result[STATUS]){
               $query= "UPDATE kuume_inventory SET STATUS=".mysqli_real_escape_string($conn,$_POST[ding_status]).", DATETIME_EDITED=NOW() WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]);
               mysqli_query($conn,$query);
               document($conn, $_SESSION[UID], $_POST[IID],"Update Status", $result[STATUS], $_POST[ding_status]);
               $message=1;
        }
        if($_POST[ding_kategorie]!=$result[CATEGORY]){
               $query= "UPDATE kuume_inventory SET CATEGORY=".mysqli_real_escape_string($conn,$_POST[ding_kategorie]).", DATETIME_EDITED=NOW() WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]);
               mysqli_query($conn,$query);
               document($conn, $_SESSION[UID], $_POST[IID],"Bearbeitet Kategorie: $result[CATEGORY] => $_POST[ding_kategorie]", 0, 0);
               $message=1;
        }
        if($_POST[ding_platz]!=$result[STORAGE]){
               $query= "UPDATE kuume_inventory SET STORAGE=".mysqli_real_escape_string($conn,$_POST[ding_platz]).", DATETIME_EDITED=NOW() WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]);
               message($query);
               mysqli_query($conn,$query);
               document($conn, $_SESSION[UID], $_POST[IID],"Bearbeitet Lagerplatz: $result[STORAGE] => $_POST[ding_platz]", 0, 0);
               $message=1;
        }
        if($_POST[dingspreis]!=$result[VALUE]){
               $query= "UPDATE kuume_inventory SET VALUE=".mysqli_real_escape_string($conn,$_POST[dingspreis]).", DATETIME_EDITED=NOW() WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]);
               mysqli_query($conn,$query);
               document($conn, $_SESSION[UID], $_POST[IID],"Bearbeitet Preis: $result[VALUE] => $_POST[dingspreis]", 0, 0);
               $message=1;
        }
        if($_POST[dings_nummer]!=$result[IID]){
               $query= "UPDATE kuume_inventory SET IID='".mysqli_real_escape_string($conn,$_POST[dings_nummer])."', DATETIME_EDITED=NOW() WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]);
               mysqli_query($conn,$query);
               $query= "UPDATE kuume_comments  SET IID='".mysqli_real_escape_string($conn,$_POST[dings_nummer])."' WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]);
               mysqli_query($conn,$query);
               $query= "UPDATE kuume_actions  SET IID='".mysqli_real_escape_string($conn,$_POST[dings_nummer])."' WHERE IID=".mysqli_real_escape_string($conn,$_POST[IID]);
               mysqli_query($conn,$query);
               document($conn, $_SESSION[UID], $_POST[dings_nummer],"Bearbeitet IID: $result[IID] => $_POST[dings_nummer]", 0, 0);
               $_POST[IID]= $_POST[dings_nummer];
        }
        
        $_GET[IID]=$_POST[IID];
        
}
    $query= "SELECT * FROM kuume_inventory WHERE IID=$_GET[IID]";
    $result=mysqli_fetch_array(mysqli_query($conn,  mysqli_real_escape_string($conn, $query) ));
    include 'header.php';
    
    if(isset($message)){
        echo "Dieser Arikel wurde bearbeitet. Es werden die eingetragengen &Auml;nderungen angezeigt. <br>";
        echo "Dr&uumlcke den Bleistift (<a href=comments.php?IID=$_GET[IID]><img class=klein src=img/edit.png></a>) um zur &Uuml;bersicht zu gelangen.";
    }
    echo '<form action="edit.php" method="POST" id=formular><input type=hidden name=IID value='.$_GET[IID].'>';
    echo "Nummer: ";
    if(checkthis(12)){
        echo"<br><input type=text name=dings_nummer value='".$result[IID]."'><br>";
    }
    else{
        echo $result[IID]."<br><br><input type=hidden name=dings_nummer value='".$result[IID]."'>";
    }
    echo "Name: <br><input type=text name=dingsname value='".$result[NAME]."'><br>";
    echo "Preis: <br><input type=text name=dingspreis value='".$result[VALUE]."'><br>";
    echo 'Anschaffung:<br> <input type=text name=dingsjahr value="'.$result[YEAR_PURCHASED].'"><br>';
    echo 'Status:<br> ';
    echo printStati($result[STATUS])."<br>";
    echo "Kategorie:<br> ";
    echo printKat($result[CATEGORY])."<br>";
    echo "Lagerplatz:<br>";
   printStorage($result[STORAGE]);
   echo "<br>";
       echo "<input type=submit value=AUF!>";
    
    
?>

