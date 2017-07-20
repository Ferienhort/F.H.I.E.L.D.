<?php

include_once '../func.inc.php';
kuume_session();
$conn=connect();
include 'header.php';

if(is_numeric($_POST[IID])==TRUE){
    $_GET[IID]=$_POST[IID];
    $_GET[Check]=$_POST[Check];
    include 'comments.php';
    die();
}

$a=explode("#", $_POST[IID]);
skript($a[0],$a[1]);

$_POST[IID]=  str_replace("http://inventar.ferienhort.at/kuume.php?IID=","", $_POST[IID]);
$_POST[IID]=  str_replace("\r\n",";", $_POST[IID]);
$_POST[IID]=  str_replace(",",";", $_POST[IID]);
if(strpos($_POST[IID], "++prefix:") !== FALSE){
        $temp=explode("++prefix:",$_POST[IID]);
        $temp=explode(";",$temp[1]);
        $pre=$temp[0];
        $_POST[IID]= str_replace("++prefix:$pre", "", $_POST[IID]);
}
else{
    $pre=0;
}
$a=explode(";", $_POST[IID]);

if(count($a)>1){
    $updatethis=false;
    foreach ($a as $i){
            if(strpos($i, "::") !== FALSE){
                $temp=explode("::",$i);
                if(is_numeric($temp[0]) && is_numeric($temp[1])){
                        $updatethis=TRUE;
                }
                $i=$temp[0];
        }
        if(is_numeric($i)){
            $i=$i+$pre;
        $query="SELECT * FROM kuume_inventory WHERE IID=$i";
        $result=mysqli_query($conn, $query);
            if(isset($_POST[Check]) && $_POST[Check]==1){
            document($conn, $_SESSION[UID], $i, "Scannt", 0, 0);
            }
            else{
            document($conn, $_SESSION[UID], $i, "Check", 0, 0);
            }
       $res=mysqli_fetch_array($result);
       if($res[STATUS]==3){
           echo "<b><font color=red>VERLOREN</b></font>";
       }
       if(mysqli_num_rows($result)==0){
           echo "$i ist unbelegt <a href=comments.php?IID=$i><img class=klein src=img/add.png></a><br>";
       }
       elseif($res[OWNER]!=$_SESSION[NOW]){
           echo "$i ist einem anderen Bereich zugeordnet<br>";
       }
       else{
           
         echo"<img src=img/".drawstatus($res[STATUS])." class= klein><span class=itemtitle> ";
         if(@mysqli_num_rows(mysqli_query($conn, "SELECT * FROM  `kuume_inventory` WHERE IID=$res[IID] AND DATETIME_LEND <= NOW() - INTERVAL $hours HOUR AND DATETIME_LEND!=0"))>0){
                echo "<img class=klein src=img/time.png>";
            }
        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM  `kuume_comments` WHERE IID=$res[IID] AND VISABLE=1"))>0){
                echo "<img class=klein src=img/comment.png>";
            }
        if(mysqli_num_rows(mysqli_query($conn, "SELECT LABEL  FROM  `kuume_inventory` WHERE LABEL>0 AND IID=$res[IID]"))>0){
                echo "<img class=klein src=img/".draw_label($res[IID]).">";
            }    
           
        // echo " <b>$row[IID]</b>";
        if($row[LENDER]!=0){
            echo "<b>[$res[LENDER]] </b>";
        }
            if(isset($_POST[Check]) && $_POST[Check]==1){
                echo "$i $res[NAME] gescannt";
            }
            else{
                echo "$i $res[NAME] ";
            }
             if($updatethis==TRUE){
                if($res[PERCENT]!=0){
                    $query="UPDATE kuume_inventory SET PERCENT = $temp[1] WHERE IID = $temp[0]";
                    message($query);
                    echo ", auf $temp[1]% aktualisiert";
                    document($conn, $_SESSION[UID], $res[IID], "Bearbeitet Prozent $res[PERCENT] => $temp[1]",0,0);
                }
                elseif($res[DESIRED]!=0){
                    $query="UPDATE kuume_inventory SET ACTUAL = $temp[1] WHERE IID = $temp[0]";
                    message($query);
                     echo ", auf $temp[1] St&uuml;ck aktualisiert";
                     document($conn, $_SESSION[UID], $res[IID], "Bearbeitet Anzahl $res[DESIRED] => $temp[1]",0,0);
                }
                else{
                    $query="UPDATE kuume_inventory SET ACTUAL = $temp[1] WHERE IID = $temp[0]";
                    message($query);
                    echo ", auf $temp[1]% St&uuml;ck aktualisiert";
                    document($conn, $_SESSION[UID], $res[IID], "Bearbeitet Prozent $res[PERCENT] => $temp[1]",0,0);
                }
                mysqli_query($conn,$query);
                }
            echo "<a href=comments.php?IID=$res[IID]&slink=oida target='thatframeyo' ><img class=klein src=img/edit.png></a>";
            if(checkthis(3)){
                echo "<a href=edit.php?IID=$res[IID] target=thatframeyo><img class=klein src=img/edit_all.png></a>";
                }
                if(checkthis(4)){
                echo "<a href=log.php?IID=$res[IID] target=thatframeyo><img class=klein src=img/log.png></a>";
                }
                if(checkthis(0)){
                echo "<a href=delete.php?IID=$res[IID] target=thatframeyo><img class=klein src=img/delete.png></a>";
                }
                echo "<br>";
                $updatethis=false;
           
       }
    }
}
}
else{
    $query="SELECT * FROM kuume_inventory WHERE NAME LIKE '%". mysqli_real_escape_string($conn,$_POST[IID])."%' AND OWNER = $_SESSION[NOW]";
    
    if(isset($_POST[kom]) && $_POST[kom]==1){
    $query= $query="SELECT * FROM kuume_inventory WHERE OWNER = $_SESSION[NOW] AND (NAME LIKE '%". mysqli_real_escape_string($conn,$_POST[IID])."%' OR IID IN(SELECT IID FROM kuume_comments WHERE COMMENT LIKE '%". mysqli_real_escape_string($conn,$_POST[IID])."%')) ";
    }
    $result=mysqli_query($conn, $query);
    while($res=mysqli_fetch_array($result)){
                
                echo "<img src=img/".drawstatus($res[STATUS])." class=klein>";
                echo "$res[NAME] ";
                echo "<a href=comments.php?IID=$res[IID]&slink=oida target='thatframeyo' ><img class=klein src=img/edit.png></a>";
                if(checkthis(3)){
                echo "<a href=edit.php?IID=$res[IID] target=thatframeyo><img class=klein src=img/edit_all.png></a>";
                }
                if(checkthis(4)){
                echo "<a href=log.php?IID=$res[IID] target=thatframeyo><img class=klein src=img/log.png></a>";
                }
                if(checkthis(0)){
                echo "<a href=delete.php?IID=$res[IID] target=thatframeyo><img class=klein src=img/delete.png></a>";
                }
                echo "<br>";
    }
    

    
}
echo "<i>keine weiteren Ergebnisse</i>";