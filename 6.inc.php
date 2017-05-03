<?php

//KATEGORIEN:
//Gelten die selben Regel wie bei den Stati
$category = array("Computer","Zubeh&ouml;r","Netzwerk","Software");
$select_category=array(1,1,1,1);

//Ablegestelle:
//Gelten die selben Regel wie bei den Stati 
$storage = array("Lager B&uuml;ro FH","Rabu","Lager B&uuml;ro Wien");
$select_storage=array(0,0);


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
$export_ordnung = array("IID", "CATEGORY", "STATUS", "NAME");

//USER LEVEL
//IN ARBEIT: Userlevels: Jeder Nutzer hat ein Level (zwischen 0-10), fast alle Funktionen erfordern ein Mindestlevel.
//Die Userlevel können in der Oberfläche verändert werden, hier kann das Mindestlevel der Funktionen geändert werden
//Die Zahlen in den eckigen Klammern [] am Ende bitte ignorieren.
$zugriff = array(
        5, // Inventar entfernen [0]
        10, // Config Datei sehen [1]
        5, // User Verwaltung - Nur User mit geringeren Levels [2]
        5, // Kann Inventar Bearbeiten [3]
        5, // Detailansicht [4]
        10, // Debug Infos - Wenn diese aktiviert sind [5]
        5, // Kann Verleihen, Retournieren [6]
        11, // Sieht alle Logs [7]
        5, // Kann Status ändern [8] NICHT AKTIV
        5,  // Kann exportieren [9]
        5,  // Sieht Geld (Preis) [10]
        5,  // Kann Labels Bearbeiten [11]
        10,  // Kann IIDs bearbeiten [12]
        5,  // Kann neuen Artikel anlegen [13]
        5,  // Sieht diese Info im Usermenue [14]
        10,  // Sieht letztes Backup [15]
        5,  //Sieht Lagerplatz [16]
        5,  //Sieht erweiterete eigenschaften [17]
        5,  // Kann Schachtelinhalte editieren [18]
        5,  // Sieht Schachtelinhalte [19]
        5,  // Kann Mehr Scannen [20]
        5,  // Bekommt Benachrichtigungen [21]
        10,  // Bekommt alerts [22]
        5,  // Sieht Hilfe [23]
        3,  // Kann Kommentare sehen [24]
        3,  // Kann Kommentare schreiben [25]
        5, // Kann nachbestellen [26]
        10, // Sieht entfernte Kommentare [27]
        7,  // Kann Kommentare entfernen [28]
        7,  // Detailansicht Aktivieren [29]
        11, // Schnellverleih [30]
        );
