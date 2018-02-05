<?php

session_start();
include '../../../func.inc.php';

$conn=connect();

if(!is_numeric($_POST[gruppevon]) || !is_numeric($_POST[gruppenach])) {
    die("Ich kann eine Zahl der Gruppen nicht lesen.");
}

if(!is_numeric($_POST[kattegorienach])) {
    die("Ich kann eine Zahl der Kategorien nicht lesen.");
}

$query="SELECT IID,NAME FROM kuume_inventory WHERE OWNER=$_POST[gruppevon] ";


if(isset($_POST[kattegorievon]) && is_numeric($_POST[kattegorievon])){
    $query.=" AND CATEGORY=$_POST[kattegorievon]";  
}

if(isset($_POST[liste]) && $_POST[liste]!=""){
    if($_POST[not]==TRUE){
        $query.=" AND IID NOT IN($_POST[liste])";  
    }
    else {
        $query.=" AND IID IN($_POST[liste])";;    
    }
}

if(isset($_POST[namen]) && $_POST[namen]!=""){
    if($_POST[not]==TRUE){
        $query.=" AND NAME NOT LIKE '%$_POST[namen]%'";  
    }
    else {
        $query.=" AND NAME LIKE '%$_POST[namen]%'";;    
    }
}

if($_POST[fav]==TRUE){
    if($_POST[not]==TRUE){
       $query.=" AND LABEL = 0";  
    }
    else {
        $query.=" AND LABEL = 1";    
    }
}

message($query);

$result = mysqli_query($conn, $query);

$i=0;

while ($row = mysqli_fetch_array($result)) {
    $query = "UPDATE kuume_inventory SET OWNER=$_POST[gruppenach], CATEGORY=$_POST[kattegorienach] WHERE IID=$row[IID]";
    mysqli_query($conn, $query);
    message($query);
    document($conn, $_SESSION[UID], $row[IID],"Verschiebt $_POST[gruppevon]/$_POST[kattegorievon]  => $_POST[gruppenach]/$_POST[kattegorienach]", 0, 0);
    $i++;
    echo "$row[NAME] verschoben <br>";
}

echo "<br> <br><b>$i  Dinge verschoben!</b>";

document($conn, $_SESSION[UID], 9,"Verschiebt $i Dinge von $_POST[gruppevon] => $_POST[gruppenach]/$_POST[kattegorienach]", 0, 0);


