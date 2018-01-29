<?php
include_once '../func.inc.php';
kuume_session();
include 'header.php';



if (isset($_SESSION[NOW]))
{
    include $_SESSION[NOW] . '.inc.php';
}
checkordie();
$conn=connect();

if($_POST[ding_lender]!="" && isset($_POST[ding_lender])){
          $query= "UPDATE "
            . "kuume_inventory  SET DATETIME_EDITED=NOW(), DATETIME_LEND=NOW(), LENDER='$_POST[ding_lender]'"
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
            . "kuume_inventory  SET DATETIME_EDITED=NOW(), LENDER='0', DATETIME_LEND=0"
            . " WHERE IID=$_POST[ding_iid]";
            mysqli_query($conn, $query );
               document($conn, $_SESSION[UID], $_POST[ding_iid],"Retourniert", -1,0);
               if($faulheitlevelmehrals9000==TRUE){
                   $message.="<br>";
               }
               $message.="Erfolgreich retourniert";
               $faulheitlevelmehrals9000=TRUE;
     }

if($_POST[ding_kommentar]!=""){
    $_POST[ding_kommentar]=skript($_POST[ding_kommentar],$_POST[ding_iid]);
}

if($_POST[ding_kommentar]!=""){    
        $query= "INSERT INTO "
            . "kuume_comments (UID, IID, DATETIME, COMMENT) "
            . "VALUES($_SESSION[UID], $_POST[ding_iid],NOW(), '".mysqli_real_escape_string($conn,$_POST[ding_kommentar])."');";
     mysqli_query($conn, $query );
    $_GET[IID]=$_POST[ding_iid];
    document($conn, $_SESSION[UID],  $_POST[ding_iid], "Kommentiert", 0,0);
}

if(isset($_POST[ding_iid])){
    $_GET[IID]=$_POST[ding_iid];
}
    
if(isset($_POST[ding_status]) && $_POST[ding_status]!=$_POST[ding_status_alt]){
        $query="UPDATE "
            . "kuume_inventory  SET DATETIME_EDITED=NOW(), STATUS= $_POST[ding_status]"
            . " WHERE IID=$_POST[ding_iid]";
    document($conn, $_SESSION[UID],  $_POST[ding_iid], "Status Update", $_POST[ding_status_alt], $_POST[ding_status]);
    mysqli_query($conn,$query);
    $_GET[IID]=$_POST[ding_iid];
}

        if(!isset($_GET[IID])){
        die("Fehler...");
    }
        if($_GET[IID]==""){
        die("Kein Parameter!");
    }
    
    $query= "SELECT * FROM kuume_inventory WHERE IID=$_GET[IID]";
    $result=mysqli_fetch_array(mysqli_query($conn,  mysqli_real_escape_string($conn, $query) ));
   
    if($result[NAME]==""){
        include 'new.php';
        die();
    }
    if($result[OWNER]!=$_SESSION[NOW]){
        die("Dieser Sticker ist bereits einer anderen Abteilung zugeordnet");
    }
    echo '<form method="post" action="comments.php">';
    if(isset($_GET[Check]) && $_GET[Check]==1){
    document($conn, $_SESSION[UID], $_GET[IID], "Scannt", 0, 0);
    }
    else{
    document($conn, $_SESSION[UID], $_GET[IID], "Check", 0, 0);
    }
    
    $label = array("Favourit");
$select_label= array(0);
$img_label=array("star.png");
    
        $i=0;
        foreach($img_label as $l){
            if(checkthis(11)){
                echo "<a href=label.php?IID=$result[IID]&label=".($i+1).">";
            }
            echo "<img class= klein src=img/$l ";
   
            $row=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `kuume_inventory` WHERE IID=$result[IID]"));
            if($row[LABEL]!=$i){
                
            }
            else{
                echo " style='filter: grayscale(70%); -webkit-filter: grayscale(70%);' ";
            }
            echo ">";
            if(checkthis(11)){
                echo "</a>";
            }
            $i++;
        }
        
    
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
    if(isset($_GET[slink]))
    {  
        echo "<a href=omini.php?S=1><img src=img/left.png class=klein></a>";
    }
    else{
        echo "<a href=cockpit.php><img src=img/left.png class=klein></a>";
    }
    echo "Name: <b>$result[NAME]</b>";
    if(checkthis(17)){
        echo "<a href=more.php?IID=$result[IID]><img src=img/right.png class=klein></a>";
    }
    $a=$result[CATEGORY];
    echo "<br>Kategorie: ".$category[$a]."<br><input type=hidden value=$result[STATUS] name=ding_status_alt>";
    if(checkthis(16)){
    $a=$result[STORAGE];
    echo "Lagerplatz: ". $storage[$a]." <br>";
    }
    if($result[PERCENT]!="0"){
    echo 'Prozent: '.$result[PERCENT]."%<br>";
    }
        echo 'Status: ';
        if(checkthis(8))
        {
            echo printStati($result[STATUS]);
        }
        else{
            echo $status[$result[STATUS]];
        }
       echo "<br>";
       
           
        if($result[EXPIRATION_YEAR]!=0){
            echo "<br> L&auml;uft"; 
            if($result[EXPIRATION_POINT]==4){
                echo " Fr&uuml;jahr ";
            }
            else {
                echo " Herbst ";
            }
            echo "$result[EXPIRATION_YEAR] ab <br>";
                
        }
        
     if($result[LENDER]=="0" && checkthis(6)){
         if($result[STATUS]==0){
        echo 'Verleih: <input type="text" name="ding_lender">'; 
         }
        }
    elseif($result[LENDER]!="0"){
        
        if($result[STATUS]==0){
            echo "verliehen an $result[LENDER] am $result[DATETIME_LEND]";
            if(checkthis(6)){
                echo "<br> Wieder da: <input type=checkbox name=ding_lender_old value=$result[LENDER]>";
            }
        }
        elseif($result[STATUS]==4 or $result[STATUS]==3){
            echo "Verlohren von $result[LENDER] am $result[DATETIME_LEND]";
            if(checkthis(6)){
                echo "<br> Wieder da: <input type=checkbox name=ding_lender_old value=$result[LENDER]>";
            }
        }
        elseif($result[STATUS]==1 or $result[STATUS]==2){
            echo "Kaput gemacht von $result[LENDER] am $result[DATETIME_LEND]";
            if(checkthis(6)){
                echo "<br> Repariert: <input type=checkbox name=ding_lender_old value=$result[LENDER]>";
            }
        }
        }
        
       $faulagain=True;
        $dings=explode(";", $result[CONTENT]);
             foreach($dings as $a){
                 if($a!="" && $a!=" "){
                     
                 $b=mysqli_query($conn, "SELECT * FROM kuume_inventory WHERE IID=$a");
                 if($b==FALSE || mysqli_num_rows($b)==0){
                        if($faulagain){
                             echo "<p id=inhalt><b> Inhalt:</b>";
                             $faulagain=FALSE;
                        }
                     echo "<br> Ung&uumltige Nummer '$a'";
                 }
                else{
                    if($faulagain){
                             echo "<p id=inhalt><b> Inhalt:</b>";
                             $faulagain=FALSE;
                        }
                    $rowb=mysqli_fetch_array($b);
                    echo "<br>$rowb[NAME]<a href=comments.php?IID=$rowb[IID]><img src=img/edit.png class=klein></a>";
            }
             }
             }
            echo "</p>";
         message("SELECT * FROM kuume_inventory WHERE CONTENT LIKE '%;$result[IID];%'");
        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kuume_inventory WHERE CONTENT LIKE '%;$result[IID];%'"))>0){ 
            echo "<p id=inside>Zu finden in ";
            $sushi=mysqli_query($conn, "SELECT * FROM kuume_inventory WHERE CONTENT LIKE '%;$result[IID];%'");
            while ($row=mysqli_fetch_array($sushi)) {
                echo "$row[NAME]<a href=comments.php?IID=$row[IID]><img src=img/edit.png class=klein></a>";
            }
            echo "</p>";
        }
        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kuume_attachments WHERE IID=$result[IID] AND TYPE=0"))>0){ 
            echo "<p id=bilder><b>Anh&auml;nge</b><br><br>";
            $sushi=mysqli_query($conn, "SELECT * FROM kuume_attachments WHERE IID=$result[IID] AND TYPE=0");
            while ($row=mysqli_fetch_array($sushi)) {
                echo "<a href=javascript:display('$row[PATH]');><img src=Uploads/$row[PATH] class=gallerypic clas=gallerypic></a>";
            }
            echo "</p>";
        }
        
        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kuume_attachments WHERE IID=$result[IID] AND TYPE=1"))>0){ 
            $sushi=mysqli_query($conn, "SELECT * FROM kuume_attachments WHERE IID=$result[IID] AND TYPE=1 ORDER BY AAID");
            while ($row=mysqli_fetch_array($sushi)) {
            echo "<a href=Uploads/$row[PATH]>".  str_replace("PDF/","", $row[PATH])."</a><br>";
            }
        }
        
        
                if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kuume_attachments WHERE IID=$result[IID] AND TYPE=2"))>0){ 
            $sushi=mysqli_query($conn, "SELECT * FROM kuume_attachments WHERE IID=$result[IID] AND TYPE=2 ORDER BY AAID");
            while ($row=mysqli_fetch_array($sushi)) {
            echo "<iframe name=klein style='border: 0px;' id=klein src=Uploads/$row[PATH] width=95% height=".($row[SIZE]*100)."></iframe>";
            }
        }
        

       echo "<br><b>Updates</b><br>";     
    $query="SELECT * FROM `kuume_actions` WHERE IID=$_GET[IID] AND TEXT NOT LIKE 'Check' ORDER BY `kuume_actions`.`TIME` DESC LIMIT 3 ";
    $temp=mysqli_query($conn,  $query);

    echo "<div id= detaillist>";
   
    while ($row = mysqli_fetch_array($temp)) {
        echo "<p class=detailentry>".getUser($conn,$row[UID])." ($row[TIME]): $row[TEXT] ";
            if($row[OLD] != $row[NEU]){
                $a =$row[OLD];
                 $b = $row[NEU];
                echo "(von '$status[$a]' zu '$status[$b]')";
            }
    }
        echo "</p></div>";
        
    if(checkthis(25)){
        
        echo '
        <br>
        <div id="content"> </div>
            <b>Kommentare</b> <br>
            <textarea name="ding_kommentar"></textarea>';
    } 
    if(!isset($_GET[IID])){
        die("Fehler");
    }
    
    
    
    if(checkthis(24)){
    $query="SELECT * FROM `kuume_comments` WHERE IID=$_GET[IID] ORDER BY DATETIME DESC ";

    $temp=mysqli_query($conn, $query);

    echo "<div>";
   
    while ($row = mysqli_fetch_array($temp)) {
        if($row[VISABLE]==0 && checkthis(27)){
        echo "<p class=detaillist style=' font-style: italic;'><b>UNSICHTBAR</b>  ".getUser($conn,$row[UID])." ($row[DATETIME]): ".stripslashes($row[COMMENT]);
        echo "</p>";
        }
        elseif($row[VISABLE]==1){
            echo "<p class=detaillist>".getUser($conn,$row[UID])." ($row[DATETIME]): ".stripslashes($row[COMMENT]);
            if(checkthis(28)){
                echo "<a href=dcomment.php?CID=$row[CID]&IID=$_GET[IID]><img src=img/delete.png class=klein></a>";
            }
            echo "</p>";   
        }

    }
    }
    
    echo  '<input type="hidden" value="'.$_GET[IID].'" name="ding_iid">';
        ?><br>            
            
 
            <input type="submit">
        </form>
        <i>Keine weiteren Kommentare</i></div>
    </body>
</html>