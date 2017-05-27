<?php

include_once '../func.inc.php';
kuume_session();
include '../config.inc.php';

checkordie();
echoifadmin(2);

if(isset($_GET[UID])&&isset($_GET[ACCEPT])){
    mysqli_query(connect(),"UPDATE kuume_user SET AKTIV=0, ENDE=NOW(), ADMIN=0 WHERE UID=$_GET[UID]");
    document(connect(), $_SESSION[UID],0, "Terminiert UID $_GET[UID] ".  getUser(connect(), $_GET[UID]),0,0);
    echo "<i>Burn Notice: Agent Nr: $_GET[UID] wurde termininert...</i>";
}
 else {
     echo "$_SESSION[NAME], bist du sicher? ";
     echo "<a href=duser.php?UID=$_GET[UID]&ACCEPT=1>YES!</a>";
}

include 'users.php';
?>
