<?php

if($_POST[verliehen]==TRUE){
    $buildingquery.=" LENDER NOT LIKE '0' AND STATUS=0 AND ";
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
    
    if($_POST[not]!="FAUL" && isset($_POST[not])){
        $buildingquery.=" AND IID ";
        if($_POST[not]!="FALSE"){
            $buildingquery.=" NOT ";
        }
        $buildingquery.=" IN (SELECT IID FROM `kuume_actions` WHERE TEXT LIKE '%Scannt%' AND TIME";
        $i=0;
        $temp=36;
    $buildingquery.=" <= ";
     
    if($_POST[date]==0 || !isset($_POST[date])){
        $buildingquery.=" NOW() + INTERVAL 24 HOUR AND TIME >= NOW() - INTERVAL 36 HOUR )"; 
     }
     else
     {
        $buildingquery.=" str_to_date('$_POST[date]','%Y-%m-%d') + INTERVAL 48 HOUR AND TIME >= str_to_date('$_POST[date]','%Y-%m-%d') - INTERVAL 36 HOUR) ";   
     }
       
     
            
    }

$buildingquery.=" AND DATETIME_CATALOGED < ";

     if($_POST[date]==0 || !isset($_POST[date])){
        $buildingquery.=" NOW()"; 
     }
     else
     {
        $buildingquery.=" str_to_date('$_POST[date]','%Y-%m-%d') + INTERVAL 24 HOUR";   
     }
 
     if($_POST[bestellt]==TRUE){
         $buildingquery .= "AND REBUY=1 ";
     }
     
    if($_POST[lauftbald]==TRUE){
        
        if(date("n") <= 4){
                $buildingquery .= "AND (EXPIRATION_POINT=4 AND EXPIRATION_YEAR=".date("Y").")";
        }
        else if(date("n") <= 10){
                $buildingquery .= "AND (EXPIRATION_POINT=10 AND EXPIRATION_YEAR=".date("Y").")";
        }
        else {
            $buildingquery .= "AND (EXPIRATION_POINT=4 AND EXPIRATION_YEAR=1+".date("Y").")";
        }
         
        }
        
        if($_POST[abgelaufen]==TRUE){
            if($_POST[lauftbald]==TRUE){
                $buildingquery .= "OR";
            }
            else {
                $buildingquery .= "AND";
            }
            $buildingquery .= "(EXPIRATION_YEAR!=0 AND (EXPIRATION_YEAR<".date("Y")." OR (EXPIRATION_YEAR=".date("Y")." AND EXPIRATION_POINT<=".date("n").")))";
        }
        
        
$buildingquery  .= " AND OWNER=$_SESSION[NOW] ORDER BY `kuume_inventory`.`CATEGORY` ASC, `kuume_inventory`.`STATUS` ASC, `kuume_inventory`.`NAME` ASC";
    
$query=$buildingquery;
message($query);