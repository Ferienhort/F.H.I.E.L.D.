<?php
$start=time();

include "../func.inc.php";


$api="http://api.screenshotmachine.com/?key=afadb4&size=X&format=PNG&cacheLimit=0&timeout=2000&url=http://kuumedb.lichtensteiner.at/Desktop/Uploads/Skripte/ueberblick.php";
$imageData = file_get_contents($api);
$name="Eins".date('yz').".png";
file_put_contents("Backups/Pix/Eins/$name",$imageData);


$api="http://api.screenshotmachine.com/?key=afadb4&size=X&format=PNG&cacheLimit=0&timeout=2000&url=http://kuumedb.lichtensteiner.at/Desktop/Uploads/Skripte/dgraph.php";
$imageData = file_get_contents($api);
$name="Zwei".date('yz').".png";
file_put_contents("Backups/Pix/Zwei/$name",$imageData);


$api="http://api.screenshotmachine.com/?key=afadb4&size=X&format=PNG&cacheLimit=0&timeout=2000&url=http://kuumedb.lichtensteiner.at/Desktop/Uploads/Skripte/numbers.php";
$imageData = file_get_contents($api);
$name="Drei".date('yz').".png";
file_put_contents("Backups/Pix/Drei/$name",$imageData);



 $end=time();
 if($end-$start>=25){
     document_alert("Zeichnent dauert mehr als 25 Sekunden!", "David ", 4,$end-$start." Sekunden");
 } else {
    document_alert("Zeichnen Zeit OK ", "David ", 1,$end-$start." Sekunden");
 }