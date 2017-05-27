<?php

include_once 'func.inc.php';

kuume_session();

document(connect(), $_SESSION[UID], $_GET[IID], "Scannt per Klick", 0,0);

echo "$_GET[IID] gescannt!";