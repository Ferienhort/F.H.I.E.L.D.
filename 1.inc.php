<?php

//KATEGORIEN:
//Gelten die selben Regel wie bei den Stati
$category = array("Foto","Audio", "Licht", "Computer","Anderes","Privat");
$select_category=array(1,1,1,1,1,0);

//Ablegestelle:
//Gelten die selben Regel wie bei den Stati
$storage = array("Rabu", "Dachboden", "Villa","Ausw&auml;rts");
$select_storage=array(0,0,0,0);

//ZEIT FILTER
//Für die Auswahl: Hier muss aich alles abgestimmt sein!
//Selbe Logik wie oben....
$time = array("36 Stunden","3 Tage", "1 Woche", "2 Wochen", "1 Monat");
//Array mit STUNDEN der Zeit
$time_ms=array(36,3*24, 7*24, 14*24, 30*24);
$select_time= array(0,0,0,0,0);

//LABELS
//Für die Auswahl: Hier muss aich alles abgestimmt sein!
//Selbe Logik wie oben....
$label = array("Favorit");
$select_label= array(0,0,0);
$img_label=array("star.png","star_red.png","star_green.png");

//$hours ist die Zeint in Stunden, wie lange etwas verborgt sein muss bevor eine Warnung aufleuchtet
$hours=16;

//EXPORT
//Welche Daten Felder in welcher Reihenfolge Ausgeben werden
$export_ordnung = array("IID", "CATEGORY", "STATUS", "NAME","YEAR_PURCHASED","VALUE","STORAGE");

//INVENTUR
//Abwieviel verschiedenen gescannten Objekten soll dies als Inventur wahrgenommen werden
$inventory_minimum = 40;

//USER LEVEL
//IN ARBEIT: Userlevels: Jeder Nutzer hat ein Level (zwischen 0-10), fast alle Funktionen erfordern ein Mindestlevel.
//Die Userlevel können in der Oberfläche verändert werden, hier kann das Mindestlevel der Funktionen geändert werden
//Die Zahlen in den eckigen Klammern [] am Ende bitte ignorieren.
$zugriff = array(
        9,  // Inventar entfernen [0]
        10, // Config Datei sehen [1]
        6,  // User Verwaltung - Nur User mit geringeren Levels [2]
        8,  // Kann Inventar Bearbeiten [3]
        8,  // Detailansicht [4]
        11, // Debug Infos - Wenn diese aktiviert sind [5]
        4,  // Kann Verleihen, Retournieren [6]
        11, // Sieht alle Logs [7]
        4,  // Kann Status ändern [8]
        5,  // Kann exportieren [9]
        5,  // Sieht Geld (Preis) [10]
        5,  // Kann Labels Bearbeiten [11]
        15, // Kann IIDs bearbeiten [12]
        1,  // Kann neuen Artikel anlegen [13]
        8,  // Sieht diese Info im Usermenue [14]
        10, // Sieht letztes Backup [15]
        1,  //Sieht Lagerplatz [16]
        5,  //Sieht erweiterete eigenschaften [17]
        5,  // Kann Schachtelinhalte editieren [18]
        1,  // Sieht Schachtelinhalte [19]
        2,  // Kann Mehr Scannen [20]
        10, // Bekommt Benachrichtigungen [21]
        10, // Bekommt alerts [22]
        7,  // Sieht Hilfe [23]
        4,  // Kann Kommentare sehen [24]
        4,  // Kann Kommentare schreiben [25]
        8,   // Kann Nachbestellen [26]
        10, // Sieht entfernte Kommentare [27]
        7,   // Kann Kommentare entfernen [28]
        3,  // Schnellverleihmodul Aktivieren [29]
        );