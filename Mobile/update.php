<?php 

include_once "../func.inc.php";
kuume_session();
checkordie();

echo_mobile_debug($mobile_debug);
$faulheitlevelmehrals9000=FALSE;
$conn= connect();

if($_POST[ding_kommentar]!=""){
    $_POST[ding_kommentar]=skript($_POST[ding_kommentar],$_POST[ding_iid]);
}


    if($_POST[ding_kommentar]!=""){
    $query= "INSERT INTO "
            . "kuume_comments (UID, IID, DATETIME, COMMENT) "
            . "VALUES($_SESSION[UID], $_POST[ding_iid],NOW(), '".mysqli_real_escape_string($conn,$_POST[ding_kommentar])."')";
    mysqli_query($conn, $query );
    document($conn, $_SESSION[UID], $_POST[ding_iid],"Kommentiert", "0", "0");
    $message="Kommentar erfolgreich hinzugef&uuml;gt";
    $faulheitlevelmehrals9000=TRUE;
    }
    
     
     elseif($_POST[ding_status]!=$_POST[ding_status_alt]){
            $query= "UPDATE "
            . "kuume_inventory  SET DATETIME_EDITED=NOW(), STATUS= $_POST[ding_status]"
            . " WHERE IID=$_POST[ding_iid]";
            mysqli_query($conn, $query );
               document($conn, $_SESSION[UID], $_POST[ding_iid],"Status Update", $_POST[ding_status_alt], $_POST[ding_status]);
               if($faulheitlevelmehrals9000==TRUE){
                   $message.="<br>";
               }
               $message.="Status erfolgreich ge&auml;ndert";
               $faulheitlevelmehrals9000=TRUE;
     }
     
     if($_POST[ding_lender]!=""){
          $query= "UPDATE "
            . "kuume_inventory  SET DATETIME_EDITED=NOW(), DATETIME_LEND=NOW(), LENDER=$_POST[ding_lender]"
            . " WHERE IID=$_POST[ding_iid]";
            mysqli_query($conn, $query );
               document($conn, $_SESSION[UID], $_POST[ding_iid],"Verliehen an $_POST[ding_lender]", -1, $_POST[ding_lender]);
               if($faulheitlevelmehrals9000==TRUE){
                   $message.="<br>";
               }
               $message.="Erfolgreich ausgliehen";
         }
    if(isset($_POST[ding_lender_old])){
            $query= "UPDATE "
            . "kuume_inventory  SET DATETIME_EDITED=NOW(), LENDER=0, DATETIME_LEND=0"
            . " WHERE IID=$_POST[ding_iid]";
            mysqli_query($conn, $query );
               document($conn, $_SESSION[UID], $_POST[ding_iid],"Retourniert von $_POST[ding_lender_old]", -1, $_POST[ding_lender_old]);
               if($faulheitlevelmehrals9000==TRUE){
                   $message.="<br>";
               }
               $message.="Erfolgreich retourniert";
               $faulheitlevelmehrals9000=TRUE;
     }
         
     $_GET[IID]=$_POST[ding_iid];

     include 'kuume.php';
