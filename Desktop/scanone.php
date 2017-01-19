<?php

include_once 'func.inc.php';

session_start();

document(connect(), $_SESSION[UID], $_GET[IID], "Scannt per Klick", 0,0);

echo "$_GET[IID] gescannt!";