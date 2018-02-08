<?php
include_once '../func.inc.php';
kuume_session();
include 'header.php';
include '../config.inc.php'

?>

<html>
    <body>

<?php


$result=mysqli_query(connect(), "SELECT COUNT(DISTINCT IID) AS ITEMS FROM kuume_inventory WHERE OWNER=$_SESSION[NOW] AND STATUS = 0");
$row=  mysqli_fetch_array($result);
$totals=$row[ITEMS];

$result=mysqli_query(connect(), "SELECT COUNT(DISTINCT kuume_actions.IID) AS SCANNS, DATE_FORMAT(kuume_actions.TIME + INTERVAL 24 HOUR,'%Y-%m-%d') AS INVENTUR_ZEIT FROM kuume_actions WHERE kuume_actions.IID IN(SELECT kuume_inventory.IID FROM kuume_inventory WHERE OWNER= $_SESSION[NOW]) AND kuume_actions.TEXT LIKE '%Scannt%' GROUP BY DATE_FORMAT(kuume_actions.TIME,'%Y%m%d') ORDER BY INVENTUR_ZEIT DESC ");
    while($row=  mysqli_fetch_array($result)){
        if($row[SCANNS]>=$inventory_minimum){
            echo "<div class=cockpit-full><p class=quick>Willkommen $_SESSION[NAME]! <br>Die letzte Inventur der ".$groups[$_SESSION[NOW]-1]." war am $row[INVENTUR_ZEIT]. Es wurden $row[SCANNS] von $totals Artikel (".(100*round($row[SCANNS]/$totals,2))."%) des aktuell verf&uuml;gbaren Inventars dokumentiert. </p>";
             echo "</div>";
            break;
            }
        }

        
        echo "<div class=cockpit-full><table style='width: 100%; text-align: center;'><tr><td></td>";
        foreach ($status as $cat) {
            if($cat != $status[count($status)-1]){
                echo "<td>$cat</td>";
                }
            }
        echo "</tr>";
     for($s=0;$s<count($category);$s++) {
         echo "<tr><td  style='text-align: left;'>$category[$s]</td>";
         for($c=0;$c<count($status)-1;$c++) {
            $query="SELECT COUNT(IID) AS CCC FROM kuume_inventory WHERE CATEGORY=$s AND STATUS=$c AND OWNER=$_SESSION[NOW]";
            $result=  mysqli_fetch_array(mysqli_query(connect(), $query));
            echo "<td style='width: 70px; vertical-align: middle;'>$result[CCC]</td>";
        }        
        echo "</tr>";
     }
     
     echo "</table></div>";
        
         if(checkthis(30))
    {
        if(isset($_POST[nummern])){
            if(($_POST[kind]=="")){
                $_POST[kind]=0;
            }
            
            $conn=connect();
            $nummern=  str_replace("\r\n", ";", $_POST[nummern]);
            $nummern=  str_replace("\r", ";", $nummern);
            $nummern=  str_replace("\n", ";", $nummern);
            $nummern=  str_replace(",", ";", $nummern);
            $nummern= explode(";", $nummern);
            foreach ($nummern as $value)
            {
                $query="UPDATE kuume_inventory SET DATETIME_LEND=IF(LENDER NOT LIKE '$_POST[kind]',IF('$_POST[kind]' LIKE '0',0,NOW()),0),DATETIME_EDITED=NOW(), LENDER=IF(LENDER NOT LIKE '$_POST[kind]','$_POST[kind]',0) WHERE IID=$value AND OWNER=$_SESSION[NOW];";
                message($query);
                $result=mysqli_query($conn,$query);
                message(mysqli_affected_rows($conn)." Reihen geupdatet");
                if((mysqli_affected_rows($conn) == 1) && ($_POST[kind] == "0")){
                    document($conn, $_SESSION[UID], $value, "Retourniert", -1,"$_POST[kind]");
                }
                if((mysqli_affected_rows($conn) == 1) && ($_POST[kind] != "0")){
                    document($conn, $_SESSION[UID], $value, "Verliehen an $_POST[kind]", -1, $_POST[kind]);
                }
            }
        }
        echo "<div class=cockpit-half><form method=POST action=cockpit.php>Schnellverleih: <br> Inventar Nummern eingeben:";
        echo "<br>";
        echo "<textarea name=nummern rows=4 cols=50 style='width=100%'></textarea>";
        echo "<span style='float: right'><input type=submit value=Retournieren> oder an <input type=text name=kind size=4> <input type=submit value=Verleihen></span> ";
        echo "</form>";
        echo "</div>";
        
    }
   
     
     
     
$result=mysqli_query(connect(), "SELECT * FROM kuume_inventory WHERE LENDER NOT LIKE '0' AND OWNER=$_SESSION[NOW] AND STATUS=0");
    if(mysqli_num_rows($result)>0){
         echo "<div class=cockpit-half><p class=quick>Im Moment sind ".(mysqli_num_rows($result))." Artikel verliehen <br><font color=grey> </font>";
         echo "<ul class=quicklist>";
    }
    while($row=  mysqli_fetch_array($result)){
            echo "<li><img src=img/".drawstatus($row[STATUS])." class=klein>";
            if(mysqli_num_rows(mysqli_query(connect(), "SELECT * FROM  `kuume_inventory` WHERE IID=$row[IID] AND DATETIME_LEND <= NOW() - INTERVAL $hours HOUR AND DATETIME_LEND!=0"))>0){
                echo "<img class=klein src=img/time.png title=Verliehen!>";
            } 
            echo "<b>[$row[LENDER]]</b>$row[NAME]<a href=comments.php?IID=$row[IID]><img src=img/right.png class=klein></a>";
    }
    if(mysqli_num_rows($result)>0){
         echo "</ul></p></div>";
    }
    
    $query="SELECT * FROM kuume_inventory WHERE LENDER NOT LIKE '0' AND OWNER=$_SESSION[NOW] AND STATUS!=0 AND IID IN (SELECT IID FROM kuume_actions WHERE kuume_actions.TEXT LIKE '%Status%' AND kuume_actions.TIME > NOW() - INTERVAL 10 DAY)";
    message($query);
    $result=mysqli_query(connect(),$query);
    if(mysqli_num_rows($result)>0){
         echo "<div class=cockpit-half><p class=quick>".(mysqli_num_rows($result))." Artikel sind innerhalb der letzten 10 Tage kaputt oder verlohren gegangen";
         echo "<ul class=quicklist>";
    }
    while($row=  mysqli_fetch_array($result)){
            echo "<li><img src=img/".drawstatus($row[STATUS])." class=klein>";
            echo "<b>[$row[LENDER]]</b>$row[NAME]<a href=comments.php?IID=$row[IID]><img src=img/right.png class=klein></a>";
    }
    if(mysqli_num_rows($result)>0){
         echo "</ul></p></div>";
    }

    
    
  $result=mysqli_query(connect(), "SELECT * FROM kuume_inventory WHERE PERCENT BETWEEN 1 AND 50 AND OWNER=$_SESSION[NOW] UNION SELECT * FROM kuume_inventory WHERE ACTUAL <= (DESIRED/2) AND DESIRED != 0  AND OWNER=$_SESSION[NOW]");
    if(mysqli_num_rows($result)>0 && checkthis(17)){
         echo "<p> Im Moment sind ".(mysqli_num_rows($result))." Artikel unter 50%";
         echo "<ul class=quicklist>";
    }
    while(($row=mysqli_fetch_array($result)) && checkthis(17) ){
            echo "<li><img src=img/".drawstatus($row[STATUS])." class=klein>";
                if($row[PERCENT]!=0){
                    echo "<b>[$row[PERCENT]%]</b>";
                }
                if($row[DESIRED]!=0){
                    echo "<b>[$row[ACTUAL]/$row[DESIRED]]</b>";
                }
            echo " $row[NAME]<a href=comments.php?IID=$row[IID]><img src=img/right.png class=klein></a>";
    }
    if(mysqli_num_rows($result)>0 && checkthis(17)){
         echo "</ul></p></div>";
    }  

    
          
    $result=mysqli_query(connect(), "SELECT * FROM kuume_actions WHERE UID=$_SESSION[UID] AND (TEXT LIKE '%Kommentiert%' OR TEXT LIKE '%Status%')");
    $query="";
    $first=FALSE;
    while($row=  mysqli_fetch_array($result)){
        if($first){
            $query.=" UNION ";
        }
         $query.= " SELECT '$row[TEXT]' AS PRE, kuume_actions.* FROM kuume_actions WHERE TIME > (SELECT TIME FROM kuume_actions WHERE AID=$row[AID]) AND UID != $_SESSION[UID] AND IID=$row[IID] AND (TEXT LIKE '%Kommentiert%' OR TEXT LIKE '%Status%') AND TIME > NOW() - INTERVAL 14 MONTH AND IID IN (SELECT IID FROM kuume_inventory WHERE OWNER=$_SESSION[NOW])";
         $first=TRUE;
    }
    if($query!=""){
        $query.= " ORDER BY TIME DESC";
    
        
    $conn = connect();

    $result=  mysqli_query(connect(), $query);
    if(mysqli_num_rows($result)>0){
       echo "<div class=cockpit-full><p class=quick>Benachrichtigungen<ul class=quicklist>";
    }
    while($row=mysqli_fetch_array($result)){
        if(strpos($row[PRE], "Kommentiert") !== false && strpos($row[TEXT], "Kommentiert") !== false) {    
        echo "<li><b>[$row[IID]]</b> ".getUser($conn,$row[UID])." hat einen Artikel kommentiert, nachdem du ihn kommentiert hast<a href=comments.php?IID=$row[IID]><img src=img/right.png class=klein></a>";
        }
        elseif(strpos($row[PRE], "Kommentiert") !== false && strpos($row[TEXT], "Status") !== false) {    
        echo "<li><b>[$row[IID]]</b> ".getUser($conn,$row[UID])." hat einen Artikelstatus ge&auml;ndert, nachdem du den Artikel kommentiert hast<a href=comments.php?IID=$row[IID]><img src=img/right.png class=klein></a>";
        }
        elseif(strpos($row[PRE], "Status") !== false && strpos($row[TEXT], "Kommentiert") !== false) {   
        echo "<li><b>[$row[IID]]</b> ".getUser($conn,$row[UID])." hat einen Artikel kommentiert, dessen Status du ge&auml;ndert hast<a href=comments.php?IID=$row[IID]><img src=img/right.png class=klein></a>";
        }
        elseif(strpos($row[PRE], "Status") !== false && strpos($row[TEXT], "Status") !== false) { 
        echo "<li><b>[$row[IID]]</b> ".getUser($conn,$row[UID])." hat einen Status bearbeitet, den du ge&auml;ndert hast<a href=comments.php?IID=$row[IID]><img src=img/right.png class=klein></a>";
        }
    }
    if(mysqli_num_rows($result)>0){
       echo "</ul></p></div>";
    }
    }
        $a=$_SESSION[NOW]-1;
    echo "<div class=cockpit-half><p class=quick>Es sind alle Sticker von <b>".$group_stickers[$a][0]."</b> bis <b>".$group_stickers[$a][1]."</b> f&uuml;r euch reserviert </p>"
    . "<p class=quick>Folgende Zahlen stehen noch f&uuml;r handschriftliche Beschriftung zur Verf&uuml;gung<ul class=quicklist>";

    
    $query="SELECT * FROM kuume_inventory WHERE IID BETWEEN ".$group_numbers[$a][0]." AND ".$group_numbers[$a][1]." ORDER BY IID ASC";
    $result=  mysqli_query(connect(), $query);
    $all=array();
    $i=0;
    while ($row = mysqli_fetch_array($result)) {
        $all[$i]=$row[IID];
        $i++;
    }
    
    if(isset($all[0])){
        $old=$all[0];
    }
    else{
        echo "<li>".$group_numbers[$a][0]."-".$group_numbers[$a][1]."</li></ul>";
    }
    for($i=$group_numbers[$a][0];$i<=$group_numbers[$a][1];$i++){
        if(!in_array($i, $all) && in_array($old, $all)){
            echo "<li>$i";
            $last=$i;
        }
        if(!in_array($old, $all) && in_array($i, $all)){
           if($last==$old){
               echo "</li>";
               $last=0;
           }
            else {
                echo "-$old</li>";
            }
        }
        $old=$i;
    }
    if($last!=0 && howmany($last, $group_numbers[$a][1])==0){
         echo "-$old</li>";
    }
    echo "</ul></p></div>";