<?php
    session_start();
    include_once "../func.inc.php";
    $conn=connect();
    checkordie();
   
    echoifadmin(13);
    
    $query = "INSERT INTO kuume_inventory (IID, NAME, YEAR_PURCHASED, DATETIME_CATALOGED, STATUS, VALUE, STORAGE, OWNER, CATEGORY)";
    $query.= " VALUES(".  mysqli_real_escape_string($conn, $_POST[ding_iid]).",'";
    $query.= mysqli_real_escape_string($conn, $_POST[ding_name])."','";
    $query.= mysqli_real_escape_string($conn, $_POST[ding_jahr])."',";
    $query.="NOW(),";
    $query.=  mysqli_real_escape_string($conn, $_POST[ding_status]).",";
    $query.=  "IF('".mysqli_real_escape_string($conn, $_POST[ding_geld])."' LIKE '', 0,'".mysqli_real_escape_string($conn, $_POST[ding_geld])."'),";
    $query.=  mysqli_real_escape_string($conn, $_POST[ding_platz]).",";
    $query.=$_SESSION[NOW].",";
    $query.= mysqli_real_escape_string($conn, $_POST[ding_kategorie]).");";
    
    message($query);
    
    mysqli_query($conn, $query);
    document($conn, $_SESSION[UID], $_POST[ding_iid], "Katalogisierte erstmalig" , 0, $_POST[ding_status]);
    echo "Eintrag hinzugef&uuml;gt";
    
    $_GET[IID]=$_POST[ding_iid];
    include 'comments.php';
    