<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



echo "<div style='";
echo primary_color($_SESSION[ADMIN]);
echo "' class=menu>";


echo "<span id=links>  <b>F.H.I.E.L.D.</b>  ";
if(count($_SESSION[OWNER])==1){
    echo $groups[$_SESSION[NOW]-1];
    }
else{
    echo "<form method=post action=switch.php id=switchthis name=wechsel ><select name=wechsel onchange='this.form.submit()'>";
        foreach($_SESSION[OWNER] as $i){
            echo "<option value=".$i." ";
                if($i==$_SESSION[NOW]){
                    echo "selected";
                }
            echo ">".$groups[$i-1]."</option>";
        }
    echo "</select>";
    echo "</form>";
}
    echo "  V.:$version ";
    if(checkthis(15)){
   echo "<span class=backup>";
   $dir=scandir("../Backup/Backups/Data",1);
   
    if(!is_array($dir)){
        echo "Kein Backup gefunden!";
    }
    else{
        $dir=$dir[1];
         $dir=explode("-", $dir);
    echo "<b>Letztes DB Backup:</b> $dir[4].$dir[3].$dir[2] um $dir[5]:".substr($dir[6],0,2);
    }
    echo "</span>";
}
echo "</span>";

echo "<span id=usermenu>";
if(checkthis(22)){
    echo "<span id=alert><a href=alert.php target=thatframeyo>";
    echo mysqli_num_rows(mysqli_query(connect(),"SELECT * FROM kuume_alerts WHERE LEVEL > 3 AND DATETIME_IT_HAPPENED > NOW() - INTERVAL 72 HOUR ORDER BY DATETIME_IT_HAPPENED DESC "));
    echo " Alerts</a> - </span>";
}
if(checkthis(21)){
    echo "<span id=hash><a href=hashtag.php target=thatframeyo># ";
    echo mysqli_num_rows(mysqli_query(connect(),"SELECT IID FROM  `kuume_comments` WHERE `COMMENT` LIKE  '%#%' AND IID IN(SELECT IID FROM kuume_inventory WHERE OWNER=$_SESSION[NOW])"));
    echo "</a> - </span>";
}
echo "<a href=cockpit.php target='thatframeyo'> $_SESSION[NAME]'s &Uuml;bersicht </a>- ";
if(checkthis(23)){
}

if(checkthis(20)){
    echo "<a href=scann.php target='thatframeyo'>Multiscan</a> - ";
}
if(checkthis(7)){
    echo "<a href=spy.php target='thatframeyo'>Log</a> - ";
}
if(checkthis(2)){
    echo "<a href=users.php target='thatframeyo'>Benutzer</a> - ";
}
echo '<a href=logout.php>Log Out</a></span></div>';


