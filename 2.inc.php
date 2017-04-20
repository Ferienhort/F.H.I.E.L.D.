<?php

//KATEGORIEN:
//Gelten die selben Regel wie bei den Stati
$category = array(
"Pfeile",
"B&ouml;gen",
"Zielscheiben",
"3D-Ziele",
"Zielauflagen 60cm",
"Zielauflagen 80cm",
"Finger-Tabs",
"Schiesshandschuhe",
"Unterarmsch&uuml;tzer",
"Sehnenhalter",
"Spannschn&uuml;re",
"Scheibenn&auml;gel",
"Diverses");

$select_category= array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);

//Ablegestelle:
//Gelten die selben Regel wie bei den Stati
$storage = array("Leichtathletikh&uuml;tte",
"Kletterkammerl",
"Halle",
"Baseballplatz");
$select_storage=array(0,0,0,0); 


//LABELS
//Für die Auswahl: Hier muss auch alles abgestimmt sein!
//Selbe Logik wie oben....
$label = array("Favorit");
$select_label= array(0,0,0);
$img_label=array("star.png","star_red.png","star_green.png");

//$hours ist die Zeint in Stunden, wie lange etwas verborgt sein muss bevor eine Warnung aufleuchtet
$hours=16;

//EXPORT
//Welche Daten Felder in welcher Reihenfolge Ausgeben werden
$export_ordnung = array("IID", "CATEGORY", "STATUS", "NAME","YEAR_PURCHASED","VALUE","STORAGE");

//USER LEVEL
//IN ARBEIT: Userlevels: Jeder Nutzer hat ein Level (zwischen 0-10), fast alle Funktionen erfordern ein Mindestlevel.
//Die Userlevel können in der Oberfläche verändert werden, hier kann das Mindestlevel der Funktionen geändert werden
//Die Zahlen in den eckigen Klammern [] am Ende bitte ignorieren.
$zugriff = array(
        9,  // Inventar entfernen [0]
        10, // Config Datei sehen [1]
        8,  // User Verwaltung - Nur User mit geringeren Levels [2]
        9,  // Kann Inventar Bearbeiten [3]
        9,  // Detailansicht [4]
        11, // Debug Infos - Wenn diese aktiviert sind [5]
        11, // Kann Verleihen, Retournieren [6]
        10, // Sieht alle Logs [7]
        5,  // Kann Status ändern [8] 
        8,  // Kann exportieren [9]
        5,  // Sieht Geld (Preis) [10]
        5,  // Kann Labels Bearbeiten [11]
        11, // Kann IIDs bearbeiten [12]
        5,  // Kann neuen Artikel anlegen [13]
        8,  // Sieht diese Info im Usermenue [14]
        10, // Sieht letztes Backup [15]
        1,  //Sieht Lagerplatz [16]
        1,  //Sieht erweiterete eigenschaften [17]
        6,  // Kann Schachtelinhalte editieren [18]
        1,  // Sieht Schachtelinhalte [19]
        5,  // Kann Mehr Scannen [20]
        10, // Bekommt Benachrichtigungen [21]
        10, // Bekommt alerts [22]
        5,  // Sieht Hilfe [23]
        1,  // Kann Kommentare sehen [24]
        3,   // Kann Kommentare schreiben [25]
        7,   // Kann Nachbestellen [26]
        10, // Sieht entfernte Kommentare [27]
        7,  // Kann Kommentare entfernen [28]
        11,  // Schnellverleihmodul Aktivieren [29]
        );
