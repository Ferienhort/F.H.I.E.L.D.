<?php
session_start();
    include_once "../func.inc.php";
    $conn=connect();
    checkordie();
     //Debug Screen
     echo_mobile_debug($mobile_debug);
     
     if(isset($_POST[ding_bereich])){
         $_SESSION[NOW]=$_POST[ding_bereich];
     }
     
     $_POST[ding_preis]= str_replace(",", ".", $_POST[ding_preis]);
     
    $query = "INSERT INTO kuume_inventory (LENDER,IID, NAME, YEAR_PURCHASED, DATETIME_CATALOGED, STATUS, VALUE, STORAGE, OWNER, CATEGORY)";
    $query.= " VALUES(0,".  mysqli_real_escape_string($conn, $_POST[ding_iid]).",'";
    $query.= mysqli_real_escape_string($conn, $_POST[ding_name])."','";
    $query.= mysqli_real_escape_string($conn, $_POST[ding_jahr])."',";
    $query.="NOW(),";
    $query.=  mysqli_real_escape_string($conn, $_POST[ding_status]).",";
    $query.=  "IF('".mysqli_real_escape_string($conn, $_POST[ding_preis])."' LIKE '', 0,'".mysqli_real_escape_string($conn, $_POST[ding_preis])."'),";
    $query.=  mysqli_real_escape_string($conn, $_POST[ding_platz]).",";
        $query.=  mysqli_real_escape_string($conn, $_SESSION[NOW]).",";
    $query.= mysqli_real_escape_string($conn, $_POST[ding_kategorie]).");";
    mysqli_query($conn, $query);
    
    document($conn, $_SESSION[UID], $_POST[ding_iid], "Katalogisierte erstmalig" , 0, $_POST[ding_status]);
    
    
    $_GET[IID]=$_POST[ding_iid];
    $message="Erfolgreich katalogiesiert";
    include 'kuume.php';
    