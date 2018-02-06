<?php

include_once 'func.inc.php';
include 'header.php';

echoifadmin(22);

if(isset($_GET[i]) && is_numeric($_GET[i])){
   $min=$_GET[i];
}
else{
    $min=0;
}

$query="SELECT * FROM kuume_alerts WHERE LEVEL>= $min ORDER BY DATETIME_IT_HAPPENED DESC LIMIT 2000";

echo "<p> <a href=alert.php?i=0>Alle Alerts</a> | <a href=alert.php?i=3>Mindeslevel 3</a>  | <a href=alert.php?i=4> Mindeslevel 4</a></p>";

$result=mysqli_query(connect(), $query);
while($row=  mysqli_fetch_array($result)){
    echo "<p style='";
    switch ($row[LEVEL]) {
        case 5:
            echo "font-weight: 900; ";
        case 4:
            echo "color: red;";
            break;
        case 3:
            echo "color: black;";
            break;
        case 2:
        case 1:
            echo "color: green;";
            break;
    }
    echo "'><b>$row[BY]</b> meldet um $row[DATETIME_IT_HAPPENED]: <br>LEVEL $row[LEVEL]: $row[MESSAGE]";
    if($row[OUTPUT]!=""){
        echo " ($row[OUTPUT])</p>";
    }else{
        echo "<p>";
    }
}