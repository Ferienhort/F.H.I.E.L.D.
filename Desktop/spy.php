<?php
session_start();

include_once '../func.inc.php';

echoifadmin(7);

include 'header.php';

if(isset($_GET[UID])){
    $clause=" UID=$_GET[UID]";
}
else{
    $clause=1;
}


    $query="SELECT * FROM `kuume_actions` WHERE $clause AND UID!=0 ORDER BY `kuume_actions`.`TIME` DESC ";
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
            if($row[IID]!=0){
        echo " (IID: $row[IID])";
            }
            echo "<br><font size='2'>$row[IP], $row[HOST],<br>$row[AGENT]</font> </p>";
            }

        
        
        ?>
    </body>
</html>
