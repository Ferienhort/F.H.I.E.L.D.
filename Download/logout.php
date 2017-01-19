<?php
include_once '../download.inc.php';
sec_session_start();

document_this($_SESSION["PWD"], Logout, 0,0);

session_unset();
session_destroy();

include "index.php";