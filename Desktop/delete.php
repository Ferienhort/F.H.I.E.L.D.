<?php
session_start();

include_once '../func.inc.php';

checkordie();

echoifadmin(0);

if(isset($_GET[IID])&&isset($_GET[ACCEPT])){
    mysqli_query(connect(),"DELETE FROM kuume_inventory WHERE IID=$_GET[IID];");
    mysqli_query(connect(),"DELETE FROM kuume_actions WHERE IID=$_GET[IID]");
    mysqli_query(connect(),"DELETE FROM kuume_attachments WHERE IID=$_GET[IID]");
    mysqli_query(connect(),"DELETE FROM kuume_comments WHERE IID=$_GET[IID]");
    echo "<i>It's gone...</i>";
}
 else {
     echo "$_SESSION[NAME], bist du sicher?<br>";
     echo "<a href=delete.php?IID=$_GET[IID]&ACCEPT=1>YES!</a>";
}
?> 