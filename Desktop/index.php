<?php

session_start();

 if($_POST[export]==TRUE){
        include 'export.php';
        die();
    }
    
include 'header.php';
//Debug Screen
include_once "../func.inc.php";

if(isset($_SESSION[UID]))
    {
    include 'kuume.php';    
}
else{
    include 'login.php';
}
?>
</body>
</html>