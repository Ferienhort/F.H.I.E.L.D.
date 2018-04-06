<?php

include_once '../func.inc.php';
kuume_session();
include 'header.php';
include '../config.inc.php';


$result=mysqli_query(connect(), "SELECT * FROM kuume_inventory WHERE LENDER NOT LIKE '0' AND OWNER=$_SESSION[NOW] AND STATUS=0");
$abc = mysqli_num_rows($result);
    if($abc>0){
         echo "<div class=cockpit-full><p class=quick>Im Moment sind ".($abc)." Artikel verliehen <br><font color=grey> </font>";
         
         if(1){
             echo "<ul class=quicklist>";
             while($row=  mysqli_fetch_array($result)){
                echo "<li><img src=img/".drawstatus($row[STATUS])." class=klein>";
                if(mysqli_num_rows(mysqli_query(connect(), "SELECT * FROM  `kuume_inventory` WHERE IID=$row[IID] AND DATETIME_LEND <= NOW() - INTERVAL $hours HOUR AND DATETIME_LEND!=0"))>0){
                    echo "<img class=klein src=img/time.png title=Verliehen!>";
                } 
            echo "<b>[$row[LENDER]]</b>$row[NAME]<a href=comments.php?IID=$row[IID]><img src=img/right.png class=klein></a>";
            }
            echo "</ul>"; 
         }
        else {
            echo "<br> <a href=away.php>Anschauen</a>";
            }
         echo "</div>"; 
    }