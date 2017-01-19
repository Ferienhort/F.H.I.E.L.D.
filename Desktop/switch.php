<?php
session_start();
if(isset($_POST[wechsel])){
    $_SESSION[NOW]=$_POST[wechsel];
    include 'index.php';
}
else{
    include 'index.php';
}