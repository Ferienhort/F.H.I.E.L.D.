<?php

include_once 'config.inc.php';

function connect(){
    include 'config.inc.php'; 
    $conn = new mysqli($server, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function doesItExist($conn, $IID){
     $result = mysqli_query($conn, "SELECT * FROM `kuume_inventory` WHERE IID=$IID");
     $res=mysqli_fetch_array($result);

     if(mysqli_num_rows($result) == 0) { 
        return FALSE;
     }
     if($res[OWNER]!=$_SESSION[NOW]){
        if(in_array($res[OWNER], $_SESSION[OWNER]))
        {
            $_SESSION[NOW]=$res[OWNER];
            return doesItExist($conn, $IID);
        }
        else{
         die("Dieser Sticker ist bereits einer anderen Abteilung zugeordnet<br> <a href=index.html><img src=img/Homebutton.gif class=mobimenupix</a>");
          }
     }
     else{
         return TRUE;
     }
}

function getUser($conn, $UID){
        $result = mysqli_fetch_array(mysqli_query($conn, "SELECT NAME FROM `kuume_user` WHERE UID=$UID"));
        return $result[NAME];
}


function printStati($aktuell){
    include 'config.inc.php'; 
    echo '<select name="ding_status">';
    $i=0;
        foreach ($status as $a) {
            echo "<option value=$i";
            if($i==$aktuell){
             echo " selected ";
            }
            echo ">$a</option>";
            $i++;
        }
    echo "</select>";
}

  
function printKat($aktuell){
    include 'config.inc.php'; 
    echo ' <select name="ding_kategorie">';
    $i=0;
    foreach ($category as $a) {
        echo "<option value=$i";
        if($i==$aktuell){
            echo " selected ";
        }
        echo ">$a</option>";
         $i++;
    }
    echo "</select>";
}

function printStorage($aktuell){
    include 'config.inc.php'; 
    echo ' <select name="ding_platz">';
    $i=0;
    foreach ($storage as $a) {
        echo "<option value=$i";
        if($i==$aktuell){
            echo " selected ";
        }
        echo ">$a</option>";
         $i++;
    }
    echo "</select>";
}

function checkordie(){
    if(isset($_SESSION[UID]) && $_SESSION[AKTIV]==1){  
    }
    else{
        die("Ciao!");
    }
}

function echoifadmin($i){
    if(checkthis($i)){
      return TRUE;  
    }
    else{
        die("Kein Zugriff, Sorry.");
    }
}

function drawstatus($i){
    include 'config.inc.php';
    $ampeln=array(
        "Etwas",
        "AmpelGruen.png",
        "AmpelGelbGruen.png",
        "AmpelGelb.png",
        "AmpelRotGelb.png",
        "AmpelRot.png",
        "AmpelGone.png"
    );
    if($uses_robots==TRUE){
        return $ampeln[$robot_status[$i]];
    }
    else{
        return $icon_status[$i];
    }
}

function echo_mobile_debug($a){
    if($a==TRUE){
    echo "UID: $_SESSION[UID], IID: $_GET[IID]";
    }
    }

    
function checkthis($i){
    include 'config.inc.php';
    if($_SESSION[ADMIN]>=$zugriff[$i]){
        return TRUE;
        }
    return FALSE;
} 

function message($text){
    include 'config.inc.php';
    if($desktop_debug && checkthis(5)){
        echo "<p class=debugmessage>".$text."</p>";
    }
}


function document($conn, $UID, $IID, $text, $old, $new){
   $text=  str_replace(";;","", $text);
   $text=  str_replace(" ;"," ", $text);
   
   $UID=  mysqli_real_escape_string($conn, $UID);
   $IID=  mysqli_real_escape_string($conn, $IID);
   $ip =  mysqli_real_escape_string($conn, $_SERVER[REMOTE_ADDR]);
   $remoteaddr=  mysqli_real_escape_string($conn, gethostbyaddr($_SERVER[REMOTE_ADDR]));
   $agent=  mysqli_real_escape_string($conn, $_SERVER[HTTP_USER_AGENT]);
   
   if(substr($text,-1)==";"){
       $text=rtrim($text, ';');
   }
    if($old==-1){
        $query="INSERT INTO `kuume_actions` (IID, UID, TIME, TEXT, OLD, NEU, LENDER, IP, HOST, AGENT) VALUES($IID, $UID, NOW(),'".mysqli_real_escape_string($conn,$text)."', 0, 0, $new, '$ip','$remoteaddr','$agent');";    
    }
    else{
    $query="INSERT INTO `kuume_actions` (IID, UID, TIME, TEXT, OLD, NEU, IP, HOST, AGENT) VALUES($IID, $UID, NOW(), '".mysqli_real_escape_string($conn,$text)."', $old, $new, '$ip','$remoteaddr','$agent');";
    }
    mysqli_query($conn, $query);
    message($query);
}

function primary_color($a){
    if($a>=10){
        echo 'background-color: rgba(0,0,0,1); color: white; ';
    }
    elseif($a<10&&$a>=7){
        echo 'background-color: rgba(0, 100,0,0.4);';
    }
    elseif($a<7&&$a>=3){
        echo 'background-color: rgba(0,0,230,0.2);';
    }
    else{
        echo 'background-color: rgb(255,255,153);';
    }
}

function draw_label($a){
    include 'config.inc.php';
    $conn=connect();
    $result= mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM  `kuume_inventory` WHERE IID=$a"));
    $i=$result[LABEL]-1;
    return $img_label[$i];
}

function document_alert($text,$user,$level,$output){
    include 'config.inc.php';
    $query="INSERT INTO kuume_alerts (`LEVEL`, `MESSAGE`, `DATETIME_IT_HAPPENED`, `BY`, `OUTPUT`) VALUES($level,'".mysqli_real_escape_string(connect(),$text)."', NOW(),'$user','".mysqli_real_escape_string(connect(),$output)."')";
    mysqli_query(connect(),$query);
}

function eastereggs($i){
    if($i==1234){
        document(connect(), 2, 0,"Jemand wurde gerickrolled",0,0);
        header("Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ");
        die();
    }
    if($i==666){
        document(connect(), 2, 0,"Die Zahl des Teufels wurde aufgerufen",0,0);
        header("Location: https://www.youtube.com/watch?v=gEPmA3USJdI");
        die();
    }
    if($i==1111){
        document(connect(), 2, 0,"<i>Now the world is gone, I am just one</i>",0,0);
        header("Location: https://www.youtube.com/watch?v=WM8bTdBs-cw");
        die();
    } 
   if($i==0000){
        document(connect(), 2, 0,"Jemand hat einen schlechten Witz gelesen",0,0);
        header("Location: https://s-media-cache-ak0.pinimg.com/564x/27/86/e3/2786e38a4608976c24ef83ad493ca20d.jpg");
        die();
    } 
    if($i==2580){
        document(connect(), 2, 0,"Jemand glaubt er ist beliebt",0,0);
        header("Location: http://treasure.diylol.com/uploads/post/image/925928/resized_RjByp.jpg");
        die();
    }
    if($i==5555){
        document(connect(), 2, 0,"Jemand hat Mathenachhilfe bekommen",0,0);
        header("Location: https://www.youtube.com/watch?v=QTrM-UVcgBY");
        die();
    } 
    }
    
function does_pin_exist($conn, $pin){
    if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kuume_user WHERE PIN LIKE '".  mysqli_real_escape_string($conn, "$pin")."'"))>0){
        return TRUE;
    }
    else {
        return FALSE;
    }
}

function skript($input, $iid){
    include 'config.inc.php';
    $input.=" ";
    $conn=connect();
    $command=FALSE;
     if($_SESSION[ADMIN]<=7){
        return $input;
        }
    if(strpos($input,"++move:") !== FALSE){
        $command=TRUE;
        $temp=explode("++move:", $input);
        $temp=explode(" ",$temp[1]);
        $moveto=$temp[0];
        $query= "UPDATE kuume_inventory SET IID='".mysqli_real_escape_string($conn,$moveto)."', DATETIME_EDITED=NOW() WHERE IID=".mysqli_real_escape_string($conn,$iid);
        mysqli_query($conn,$query);
        $query= "UPDATE kuume_inventory SET CONTENT=REPLACE(CONTENT,';".mysqli_real_escape_string($conn,$iid).";',';".mysqli_real_escape_string($conn,$moveto).";') WHERE CONTENT LIKE '%;".mysqli_real_escape_string($conn,$iid).";%'";
        mysqli_query($conn,$query);
        $query= "UPDATE kuume_comments  SET IID='".mysqli_real_escape_string($conn,$moveto)."' WHERE IID=".mysqli_real_escape_string($conn,$iid);
        mysqli_query($conn,$query);
        $query= "UPDATE kuume_actions  SET IID='".mysqli_real_escape_string($conn,$moveto)."' WHERE IID=".mysqli_real_escape_string($conn,$iid);
        mysqli_query($conn,$query);
        $query= "UPDATE kuume_attachments SET IID='".mysqli_real_escape_string($conn,$moveto)."' WHERE IID=".mysqli_real_escape_string($conn,$iid);
        mysqli_query($conn,$query);
        document($conn, $_SESSION[UID],$moveto,"Verschiebt IID: $iid =>$moveto", 0, 0);
        echo "IID verschoben<br>";
        $_POST[ding_iid]=$moveto;
        
    }
    if(strpos($input,"++done") !== FALSE){
        $command=TRUE;
        $query= "UPDATE kuume_comments  SET COMMENT=REPLACE(COMMENT, '#','!!') WHERE IID=".mysqli_real_escape_string($conn,$iid);
        mysqli_query($conn,$query);
        document($conn, $_SESSION[UID],$iid,"Erledigt Anfrage", 0, 0);
        echo "#'s weg<br>";
    }
    if(strpos($input,"++group:") !== FALSE){
        $command=TRUE;
        $temp=explode("++group:", $input);
        $temp=explode(" ",$temp[1]);
        $moveto=$temp[0];
        $query= "UPDATE kuume_inventory SET OWNER='".mysqli_real_escape_string($conn,$moveto)."', DATETIME_EDITED=NOW() WHERE IID=".mysqli_real_escape_string($conn,$iid);
        mysqli_query($conn,$query);
        document($conn, $_SESSION[UID],$iid,"Zuordnung bearbeitet: => ".$groups[$moveto-1], 0, 0);
        echo "Gruppe bearbeitet<br>";
    }
    if(strpos($input,"++copy:") !== FALSE){
        $command=TRUE;
        $temp=explode("++copy:", $input);
        $temp=explode(" ",$temp[1]);
        $times=$temp[0];

        if($times>50){
            die("Maximal 50 Kopien!");
        }
        if(howmany($iid+1,$iid+$times+1)>0){
            die("Kopieren geht nicht, es gibt bereits Inventar in diesem Bereich!");
        }
        $build="";
            for($i=1; $i<=$times; $i++){
                $temp=$i+$iid;
                $query="INSERT INTO kuume_inventory (IID,NAME,YEAR_PURCHASED,DATETIME_CATALOGED,DATETIME_EDITED,CATEGORY,SUBCAT,STATUS,VALUE,LABEL,STORAGE,PERCENT,CONTENT,OWNER,REBUY) "
                        ." (SELECT $temp,NAME, YEAR_PURCHASED,NOW(),NOW(),CATEGORY,SUBCAT,STATUS,VALUE,LABEL,STORAGE,PERCENT,CONTENT,OWNER,REBUY FROM kuume_inventory WHERE IID=$iid)";
                mysqli_query($conn, $query);
                $build=$build+";"+$temp;
                document($conn, $_SESSION[UID],$temp,"Katalogisierte erstmalig (Klon von $iid)", 0, 0);
                usleep (300);            
            }
            $_POST[IID]=$build;
            unset($conn);
        echo "$times Klone von IID $iid angelegt <br>";
        die();
    }
    if(strpos($input,"++addscript:") !== FALSE){
        $command=TRUE;
        $temp=explode("++addscript:", $input);
        $temp=explode(" ",$temp[1]);
        $temp=explode(":",$temp[0]);
        $query="INSERT INTO kuume_attachments (PATH, IID, TYPE, SIZE, DATETIME_UPLOADED) VALUES('".mysqli_real_escape_string($conn, "Skripte/".$temp[0])."',".mysqli_real_escape_string($conn, $iid).",2,".mysqli_real_escape_string($conn, $temp[1]).", NOW());";
        mysqli_query(connect(),$query);
        document(connect(), $_SESSION[UID],$iid, "Skript angeheftet: $temp[0]", 0, 0);
        echo "Skript angeheftet: $temp[0]<br>";
    }
    if(strpos($input,"++rollback:") !== FALSE){
        $command=TRUE;
        $temp=explode("++rollback:", $input);
        $temp=explode(" ",$temp[1]);
        $needle=$temp[0];
        if(!$dir=scandir("../Backup/Backups/Data",1)){
            echo "Kein Backup gefunden!";
        }
        $file="../Backup/Backups/Data/".$dir[$needle];
        $templine = '';
        $lines = file($file, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
            foreach ($lines as $line) {
                if (substr($line, 0, 2) == '--' || $line == '')
                continue;
                $templine .= $line;
                if (substr(trim($line), -1, 1) == ';') {
                    mysqli_query($conn,$templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($conn) . '<br /><br />');
                   $templine = '';
                }
            }
        document($conn, $_SESSION[UID],0,"System Rollback ($needle Stunden)", 0, 0);
        echo "System Rollback ($needle Stunden)<br>";
        }

    if(strpos($input,"++alertsbegone") !== FALSE){
        $command=TRUE;
        $query= "UPDATE kuume_alerts SET LEVEL=3 WHERE LEVEL>3";
        mysqli_query($conn,$query);
        document($conn, $_SESSION[UID],0,"Alerts abgearbeitet", 0, 0);
        document_alert("Alerts von ".getUser($conn, $_SESSION[UID])." weggemacht ", getUser(connect(),2), 3,"");
        echo "Alle Alerts mit LEVEL 4 und LEVEL 5 auf LEVEL 3 gesetzt<br>";
    }
    if(strpos($input,"--order66") !== FALSE){
        $command=TRUE;
        $query= "DELETE FROM kuume_inventory WHERE IID > 100; "
                . "DELETE FROM kuume_attachments WHERE IID > 100;"
                . "TRUNCATE kuume_comments;"
                . " TRUNCATE kuume_actions;"
                . " TRUNCATE kuume_alerts;"
                . " ALTER TABLE kuume_user AUTO_INCREMENT = 1; ";
        mysqli_multi_query($conn,$query) or die(mysqli_error($conn));
        document($conn, $_SESSION[UID],0,"Datenbank gestutzt.", 0, 0);
        echo "<i><b>It is done</b></i><br>";
    }
    if($command){
        return "";
    }
    else{
        return $input;
    }
}


function randomKey($length) {
    $pool = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));

    for($i=0; $i < $length; $i++) {
        $key .= $pool[mt_rand(0, count($pool) - 1)];
    }
    return $key;
}

function howmany($start, $end){
    include 'config.inc.php';
    $conn = connect();
    return mysqli_num_rows(mysqli_query($conn, "SELECT * FROM  `kuume_inventory` WHERE IID >= $start AND IID < $end"));
}

function findmyparent($i){
    include 'config.inc.php';
    $conn = connect();
    $a=0;
    foreach ($group_numbers as $key){
        if($key[0]<= $i && $key[1] > $i){
            return $a;
        }
        $a++;
    }
    $a=0;
    foreach ($group_stickers as $key){
        if($key[0]<= $i && $key[1] > $i){
            return $a;
        }
        $a++;
    }
    return FALSE;
}

function htmltocsv($string){
    $string = html_entity_decode ($string);
    return $string;
}