<?php
include_once 'header.php';
kuume_session();

checkordie();

?>

<head>
    <script>
        function lost(a,b){
            var kommentar = prompt("Bitte eine kurze Beschreibung","");
            if(kommentar!=null){
                document.getElementById("eins").value=kommentar;
                document.getElementById("zwei").value=a;
                document.getElementById("drei").value=b;
                document.getElementById("ohvis").submit();
            }
        }
    </script>
    <style>
        
        .floaty{ 
            float: left;
            margin: 10px;
            padding: 10px;
            width: 350px;
            height: 170px;
            vertical-align: middle;
        }
        
        body{
        }
    </style>
    <meta name="viewport" content="width=device-width,initial-scale=1">

</head>

<div>
<?php

    if(checkthis(30))
    {
        $conn= connect();
        
       if(isset($_POST[zwei])){
            $query="UPDATE "
            . "kuume_inventory  SET DATETIME_EDITED=NOW(), STATUS=$_POST[zwei]"
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
                $_POST[kind]=1;
            }
            $conn=connect();
            $nummern=  str_replace("\r\n", ";", $_POST[nummern]);
            $nummern=  str_replace("\r", ";", $nummern);
            $nummern=  str_replace("\n", ";", $nummern);
            $nummern=  str_replace(",", ";", $nummern);
            $nummern= explode(";", $nummern);
            foreach ($nummern as $value)
            {
                $query="UPDATE kuume_inventory SET DATETIME_LEND=NOW(),DATETIME_EDITED=NOW(), LENDER='$_POST[kind]' WHERE IID=$value AND OWNER=$_SESSION[NOW];";
                message($query);
                $result=mysqli_query($conn,$query);
                
                message(mysqli_affected_rows($conn)." Reihen geupdatet");
                if((mysqli_affected_rows($conn) == 1) && ($_POST[kind] != "0")){
                    document($conn, $_SESSION[UID], $value, "Verliehen an $_POST[kind]", -1, $_POST[kind]);
                    }
                }
            }
            
            
            
        if(isset($_POST[nummern2])){
            $conn=connect();
            $nummern=  str_replace("\r\n", ";", $_POST[nummern2]);
            $nummern=  str_replace("\r", ";", $nummern);
            $nummern=  str_replace("\n", ";", $nummern);
            $nummern=  str_replace(",", ";", $nummern);
            $nummern= explode(";", $nummern);
            foreach ($nummern as $value)
            {
                $query="UPDATE kuume_inventory SET DATETIME_LEND=0,DATETIME_EDITED=NOW(), LENDER=0 WHERE IID=$value AND OWNER=$_SESSION[NOW];";
                message($query);
                $result=mysqli_query($conn,$query);
                message(mysqli_affected_rows($conn)." Reihen geupdatet");
                if((mysqli_affected_rows($conn) == 1)){
                    document($conn, $_SESSION[UID], $value, "Retourniert", -1, 0);
                    }
                }
            }
       
   
            
        $result=mysqli_query(connect(), "SELECT * FROM kuume_inventory WHERE LENDER NOT LIKE '0' AND OWNER=$_SESSION[NOW] AND STATUS=0 ORDER BY LENDER "); //TO_NUMBER(REGEX_SUBSTR(LENDER,'[0-9]*'))
            if(mysqli_num_rows($result)>0){
                echo "<div class=floaty style='background-color: rgba(255, 0, 0, 0.2);'><p class=quick>Im Moment sind ".(mysqli_num_rows($result))." Artikel verliehen <br><font color=grey> </font>";
            }
            else {
                echo "<div class=floaty style='background-color: rgba(255, 0, 0, 0.2);'>Im Moment sind keine Artikel verliehen";
            }
                echo " <a href=$desktop_link>Zur Desktop Ansicht wechseln </a>";
                echo "<br> <a href=$mobile_link>Zur Web App wechseln </a><br> Verwende <b>STEUERUNG+F</b> um Kinder- und Inventarnummern schnell zu finden<br>";
                echo "Unbedingt kontrollieren ob JavaScript erlaubt ist :D!</div>";
    
        $i=0;
            
        echo "<div class=floaty style='background-color: rgba(0, 0, 255, 0.2);'><form method=POST action=oh.php id=ohvis><b>Verleih</b><br>Hier Inventarnummern eingeben:";
        echo "<br>";
        echo "<textarea name=nummern rows=4 style='width=100%'></textarea><br>";
        echo "an <input type=text name=kind size=4> <input type=submit value=Verleihen>";
        echo "";
        echo "</div>";
        
        echo "<div class=floaty style='background-color: rgba(0, 0, 255, 0.2);'><b> Retour</b><br>Hier Inventarnummern eingeben:";
        echo " ";
        echo "<br>";
        echo "<input type=hidden id=eins name=eins> <input type=hidden id=zwei name=zwei><input type=hidden id=drei name=drei> ";
        echo "<textarea name=nummern2 rows=4 style='width=100%'></textarea><br>";
        echo "<input type=submit value=Retournieren> ";
        echo "";
        echo "</div></form>";
        }
     
    while($row=mysqli_fetch_array($result)){
        if($i==0){
            echo "<div class=floaty style='background-color: rgba(0, 255, 0, 0.2);'>";
        }
        echo "<span class=lendstuff><b>[$row[LENDER]] $row[NAME] </b><br><i>IID: $row[IID]</i> <a href=oh.php?num=$row[IID]> Retour</a> - <a href=javascript:lost(1,$row[IID]);>Kaput</a> - <a href=javascript:lost(3,$row[IID]);> Verlohren</a><br></span>";
        $i++;
        if($i==4){
            echo "</div>";
            $i=0;
        }
        
        }
        
         $result=mysqli_query(connect(), "SELECT * FROM kuume_inventory WHERE LENDER NOT LIKE '0' AND OWNER=$_SESSION[NOW] AND STATUS!=0 AND IID IN (SELECT IID FROM kuume_actions WHERE  kuume_actions.TIME > NOW() - INTERVAL 12 MONTH AND kuume_actions.TEXT LIKE '%pdate%') ORDER BY LENDER "); //TO_NUMBER(REGEX_SUBSTR(LENDER,'[0-9]*'))
                while($row=mysqli_fetch_array($result)){
        if($i==0){
            echo "<div class=floaty style='background-color: rgba(255, 0, 0, 0.1);'>";
        }
        $stat=$row[STATUS];
        echo "<span class=lendstuff><b>[$row[LENDER]] $row[NAME] </b><i>($status[$stat])</i><br><i>IID: $row[IID]</i> <a href=oh.php?num=$row[IID]> Retour / Repariert</a> <br></span>";
        $i++;
        if($i==4){
            echo "</div>";
            $i=0;
        }
        
        }