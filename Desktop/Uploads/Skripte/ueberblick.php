<?php

include 'vis.inc.php';
include '../../../func.inc.php';

$conn = connect();
$i=1;
$multidim = array();
foreach ($groups as $gruppe) {
    $query="SELECT COUNT(*) AS VAR FROM kuume_inventory WHERE OWNER = $i";
    $result= mysqli_query($conn, $query);
    $temp=mysqli_fetch_array($result);
    $multidim[$i]=array($gruppe, (int) $temp["VAR"]);
    $i++;
}

$echothis = FHIELD_pie(array("Gruppe","Anzahl"), $multidim, "Inventar");

$i=1;
$multidim = array();
foreach ($groups as $gruppe) {
    $query="SELECT COUNT(*) AS VAR FROM kuume_actions WHERE IID IN (SELECT IID AS VAR FROM kuume_inventory WHERE OWNER = $i) AND UID!= 0 AND IID != 0";
    $result= mysqli_query($conn, $query);
    $temp=mysqli_fetch_array($result);
    $multidim[$i]=array($gruppe, (int) $temp["VAR"]);
    $i++;
}
$echothis2 = FHIELD_pie(array("Gruppe","Anzahl"), $multidim, "Aktionen");

unset($multidim);
$multidim = array();
$i=0;
foreach ($status as $gruppe) {
    $query="SELECT COUNT(*) AS VAR FROM kuume_inventory WHERE STATUS = $i";
    $result= mysqli_query($conn, $query);
    $temp=mysqli_fetch_array($result);
    $multidim[$i]=array($gruppe, (int) $temp["VAR"]);
    $i++;
}

$echothis3 = FHIELD_pie(array("Status","Anzahl"), $multidim, "Stati");

unset($multidim);
$multidim = array();
        $max = mysqli_query(connect(),"SELECT MAX(IID) AS VAR FROM kuume_inventory");
        $max = mysqli_fetch_array($max);
        $end = $max["VAR"];

    $query="SELECT COUNT(*) AS VAR FROM kuume_inventory WHERE IID < ".$group_numbers[4][1];
    $result= mysqli_query($conn, $query);
    $temp=mysqli_fetch_array($result);
    $multidim[0]=array("virtuell", (int) $temp["VAR"]);

    $query="SELECT COUNT(*) AS VAR FROM kuume_inventory WHERE IID < 10000 AND IID > ".$group_numbers[4][1];
    $result= mysqli_query($conn, $query);
    $temp=mysqli_fetch_array($result);
    $multidim[1]=array("per Hand", (int) $temp["VAR"]);

    $query="SELECT COUNT(*) AS VAR FROM kuume_inventory WHERE IID > 10000 AND IID < $end";
    $result= mysqli_query($conn, $query);
    $temp=mysqli_fetch_array($result);
    $multidim[2]=array("Angeklebt", (int) $temp["VAR"]);


    
    
$echothis4 = FHIELD_pie(array("Status","Anzahl"), $multidim, "IID Beschriftung");

?>
<html><head>
<?php
echo $echothis[0];
echo $echothis[1];
echo seconchart($echothis2[1]);
echo seconchart($echothis3[1]);
echo seconchart($echothis4[1]);
?>
    </head><body>
        <?php
        echo $echothis[2];
        echo $echothis2[2];
        echo $echothis3[2];
        echo $echothis4[2];
        ?>
        
    </body>
