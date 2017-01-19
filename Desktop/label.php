<?php
session_start();

include_once '../func.inc.php';

echoifadmin(11);
$conn=connect();
$query="UPDATE kuume_inventory SET LABEL=IF(LABEL!=0,0,".mysqli_escape_string($conn,$_GET[label]).") WHERE IID=".mysqli_escape_string($conn,$_GET[IID]).";";

document($conn, $_SESSION[UID], $_GET[IID], "Label wechsel",0,0);

message($query);

mysqli_query($conn, $query);

include 'comments.php';