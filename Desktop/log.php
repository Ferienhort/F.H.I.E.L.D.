<?php

include_once '../func.inc.php';

kuume_session();

echoifadmin(4);
?>

<html>
    <head>
        
    </head>
    <body>
        <?php
   
        
    $query="SELECT * FROM `kuume_actions` WHERE IID=$_GET[IID] AND AID NOT IN (SELECT AID FROM `kuume_actions` WHERE TEXT LIKE 'Check' AND UID=0) ORDER BY `kuume_actions`.`TIME` DESC ";
    $conn=  connect();
    $temp=mysqli_query($conn,  $query);

    echo "<div id= detaillist>";
   
    while ($row = mysqli_fetch_array($temp)) {
        echo "<p class=detailentry>".getUser($conn,$row[UID])." ($row[TIME]): $row[TEXT] ";
            if($row[OLD] != $row[NEU]){
                $a =$row[OLD];
                 $b = $row[NEU];
                echo "(von '$status[$a]' zu '$status[$b]')";
            }
        echo "</p>";
}

        
        
        ?>
    </body>
</html>

