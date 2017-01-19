<?php
include_once '../func.inc.php';




if(!isset( $_GET[IID])){
    die("Ciao");
}

if(!doesItExist(connect(), $_GET[IID])){
    echo "0";
}