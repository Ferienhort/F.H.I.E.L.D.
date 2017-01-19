<?php
include_once '../func.inc.php';
session_start();
$conn=connect();
document($conn, $_SESSION[UID], 0, "Hat sich ausgeloggt",0,0);
unset($_SESSION[UID]);
unset($_SESSION[AKTIV]);
unset($_SESSION[ADMIN]);
session_destroy();

include 'index.php';