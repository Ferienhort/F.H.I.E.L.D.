<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename='.date("M-j-H-i").'.csv');

include_once '../func.inc.php';
echoifadmin(9);

$conn=connect();

document($conn, $_SESSION[UID], 0,"Exportiert",0,0);

if($_POST[time]=="TEST"){
    $_POST[egal]="TRUE";
}

$buildingquery ="SELECT ".implode(",",$export_ordnung)." FROM `kuume_inventory` WHERE";



include 'build-query.php';


$query=$buildingquery;   
    message($query);

$query=$buildingquery;

$output = fopen('php://output', 'w');


fputcsv($output, $export_ordnung );

$rows =mysqli_query($conn,  $query);

while ($row = mysqli_fetch_assoc($rows)){
    $row[STATUS]=  htmltocsv($status[$row[STATUS]]);
    $row[CATEGORY]=htmltocsv($category[$row[CATEGORY]]);
    $row[STORAGE]=htmltocsv($storage[$row[STORAGE]]);
    
    foreach ($row as $b){
        $b= '"'.$b.'"';
    }
    
    fputcsv($output, array_values($row));
    
    
}