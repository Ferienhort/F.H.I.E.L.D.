<?php
include_once 'header.php';
kuume_session();

checkordie();


?>

<head>
    <script>
        function lost(a,b){
            var kommentar = prompt("Bitte eine kurze Beschreibung","Beschreibung");
            document.getElementById("eins").value=kommentar;
            document.getElementById("zwei").value=a;
            document.getElementById("drei").value=b;
            document.getElementById("ohvis").submit();
        }
    </script>
</head>

<div>
<?php

    if(checkthis(30))
    {
        $conn= connect();
        
       if(isset($_POST[eins])){
            $query="UPDATE "
            . "kuume_inventory  SET DATETIME_EDITED=NOW(), STATUS= $_POST[zwei]"
            . " WHERE IID=$_POST[drei]";
            document($conn, $_SESSION[UID],  $_POST[drei], "Status Update", 0, $_POST[zwei]);
            mysqli_query($conn,$query);
            message($query);
            
            $query= "INSERT INTO "
            . "kuume_comments (UID, IID, DATETIME, COMMENT) "
            . "VALUES($_SESSION[UID], $_POST[drei],NOW(), '".mysqli_real_escape_string($conn,$_POST[eins])."');";
            mysqli_query($conn, $query );
            document($conn, $_SESSION[UID],  $_POST[drei], "Kommentiert", 0,0);
            message($query);
       }

        
        if(isset($_GET[num]) && !isset($_GET[status])){
            $_POST[nummern]=$_GET[num];
            
        }
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
                if((mysqli_affected_rows($conn) == 1) && ($_POST[kind] != "0")){
                    document($conn, $_SESSION[UID], $value, "Verliehen an $_POST[kind]", -1, $_POST[kind]);
                    }
                }
            }
        echo "<div><form method=POST action=oh.php id=ohvis>Hier Invetarnummern eingeben:";
        echo "<input type=hidden id=eins name=eins> <input type=hidden id=zwei name=zwei><input type=hidden id=drei name=drei> ";
        echo "<br>";
        echo "<textarea name=nummern rows=4 cols=50 style='width=100%'></textarea>";
        echo "<span style='float: right'>an <input type=text name=kind size=4 required> <input type=submit value=Verleihen></span> ";
        echo "</form>";
        echo "</div>";
        }
 echo "<div>";
     
$result=mysqli_query(connect(), "SELECT * FROM kuume_inventory WHERE LENDER NOT LIKE '0' AND OWNER=$_SESSION[NOW] AND STATUS=0");
    if(mysqli_num_rows($result)>0){
         echo "<div class=cockpit-half><p class=quick>Im Moment sind ".(mysqli_num_rows($result))." Artikel verliehen <br><font color=grey> </font>";
         echo "<ul class=quicklist>";
    }
    while($row=mysqli_fetch_array($result)){
            echo "<li>";
            if(@mysqli_num_rows(mysqli_query(connect(), "SELECT * FROM  `kuume_inventory` WHERE IID=$row[IID] AND DATETIME_LEND <= NOW() - INTERVAL $hours HOUR AND DATETIME_LEND!=0"))>0){
                echo "<img class=klein src=img/time.png title=Verliehen!>";
            } 
            echo "<b>[$row[LENDER]]</b>$row[NAME]<a href=oh.php?num=$row[IID]> Retour</a> - <a href=javascript:lost(1,$row[IID]);>Kaputt</a> - <a href=javascript:lost(3,$row[IID]);> Verlohren</a>";
    }
    if(mysqli_num_rows($result)>0){
         echo "</ul></p></div>";
    }