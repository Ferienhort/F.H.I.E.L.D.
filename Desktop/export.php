<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

include_once '../func.inc.php';
echoifadmin(9);

$conn=connect();

document($conn, $_SESSION[UID], 0,"Exportiert",0,0);

if($_POST[time]=="TEST"){
    $_POST[egal]="TRUE";
}


 if(isset($_POST[ichbinfaul])){
    $i=0;
    foreach($category as $cat){
        $temp="cat".$i;
        $select_category[$i]=$_POST[$temp];
        $i++;
    }
    $i=0;
    foreach($status as $stat){
        $temp="status".$i;
        $select_status[$i]=$_POST[$temp];
        $i++;
    }
    $i=0;
    foreach($time as $cat){
        $temp="time".$i;
            if($_POST[time]==$i){
                $select_time[$i]=1;
            }
            else{
                $select_time[$i]=0;
            }
        $i++;
    }
    $i=0;
    foreach($label as $cat){
        $temp="label".$i;
        $select_label[$i]=$_POST[$temp];
        $i++;
    }
}
    
$buildingquery ="SELECT ".implode(",",$export_ordnung)." FROM `kuume_inventory` WHERE";


if($_POST[verliehen]==TRUE){
    $buildingquery.=" LENDER != 0 AND ";
}

$buildingquery.= " CATEGORY IN(";
    
    $i=0;
    foreach($select_category as $cat){
        if($cat==1){
           $buildingquery.=$i.","; 
        }
        $i++;
    }
    $buildingquery.="2500000) AND";
    
$buildingquery.= " LABEL IN(";
    
    $i=0;
    $a=0;
    foreach($select_label as $cat){
        if($cat==1){
           $buildingquery.=($i+1).","; 
           $a++;
        }
        $i++;
    }
    $i=0;
    if($a==0){
        $buildingquery.="$i,";
        $i++;
           foreach($label as $cat){
                 $buildingquery.="$i,";
                 $i++;
           } 
        }
    $buildingquery.="2500000) AND STATUS IN(";
    
    $i=0;
    foreach($select_status as $cat){
        if($cat==1){
           $buildingquery.=$i.","; 
        }
        $i++;
    }
    
    $buildingquery.="2500000)";
    
    if(!isset($_POST[ichbinfaul]) xor !isset($_POST[egal])){
        $buildingquery.=" AND IID ";
        if($_POST[not]!="FALSE"){
            $buildingquery.=" NOT ";
        }
        $buildingquery.=" IN (SELECT IID FROM `kuume_actions` WHERE TEXT LIKE 'Scannt' AND TIME";
        $i=0;
        $temp=0;
        foreach($select_time as $cat){
            if($cat==1){
                if($temp<=$time_ms[$i]){
                   $temp=$time_ms[$i];
                }
            }
        $i++;
    }
    $buildingquery.=" >= ";
     
    if($_POST[date]==0 || !isset($_POST[date])){
        $buildingquery.=" NOW() + INTERVAL 24 HOUR"; 
     }
     else
     {
        $buildingquery.=" str_to_date('$_POST[date]','%Y-%m-%d') + INTERVAL 24 HOUR";   
     }
            
            
    $buildingquery.=" - INTERVAL ($temp + 24) HOUR) ";
    }


$buildingquery.=" AND DATETIME_CATALOGED < ";

        if($_POST[date]==0 || !isset($_POST[date])){
        $buildingquery.=" NOW()"; 
     }
     else
     {
        $buildingquery.=" str_to_date('$_POST[date]','%Y-%m-%d') + INTERVAL 24 HOUR";   
     }
          
$buildingquery  .= " AND OWNER=$_SESSION[NOW] ORDER BY `kuume_inventory`.`CATEGORY` ASC, `kuume_inventory`.`STATUS` ASC, `kuume_inventory`.`NAME` ASC";
    
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