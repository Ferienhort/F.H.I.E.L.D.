<?php
$start=time();

include "../func.inc.php";

$api="http://api.screenshotmachine.com/?key=f21647&size=X&format=PNG&cacheLimit=0&timeout=2000&url=http://kuumedb.lichtensteiner.at/Desktop/Uploads/Skripte/graphs.php";
$imageData = file_get_contents($api);
$name="Eins".date('yz').".png";
file_put_contents("Backups/Pix/Eins/$name",$imageData);

 $end=time();
 if($end-$start>=25){
     document_alert("Zeichnent dauert mehr als 25 Sekunden!", "David ", 4,$end-$start." Sekunden");
 } else {
    document_alert("Zeichnen Zeit OK ", "David ", 1,$end-$start." Sekunden");
 }