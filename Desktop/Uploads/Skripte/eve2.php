<?php

ini_set('default_socket_timeout', 10);

include '../../../func.inc.php';

function document_eve($type, $ms){
}

function document_eve_bool($type, $ms, $bool){
}


$sitestotest = array(
    "http://www.ferienhort.at/",
    "http://www.ferienhort.at/wp-content/themes/fh2016/img/cover-feriencamps-sommer-2017.png",
    "http://fotoportal.kuume.ferienhort.at/identification.php",
    "http://fotoportal.kuume.ferienhort.at/themes/bootstrapdefault/Images/FH_Logo_2016_screen_transparent.png");

$sitestotest_names = array(
    "Ferienhort Startseite",
    "Ferienhort Banner",
    "FotoPortal Startseite",
    "FotoPortal Logo");

$i=0;

foreach ($sitestotest as $key)
{
    $t = microtime( TRUE );
    if(file_get_contents( $key ) == FALSE){
        $t = microtime( TRUE ) - $t;
        document_eve_bool($sitestotest_names[$i], $t, 0);

    }
    else{
                $api="http://api.screenshotmachine.com/?key=afadb4&size=X&format=PNG&cacheLimit=0&timeout=1000&url=$key";
        $imageData = file_get_contents($api);
        $name="Screenshot-".date('Y-m-d-H-i-s').".png";
        file_put_contents("Screenshots/$name",$imageData);
        $t = microtime( TRUE ) - $t;
        document_eve($sitestotest_names[$i], $t);
    }
    $i++;
}