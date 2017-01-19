<?php

// MYSQL VERBDINUNG
$server = "dd29920.kasserver.com";
$username = "d0220110";
$password = "V7ntpLuc9HeKVYRw";
$database = "d0220110";

//Zeile ab Welcher dieses Dokument im Admin Panel angezeigt wird
$displayforadmins=11;

//STATI:
// Wichtig: Neue Kategorien müssen am Ende des Arrays hinzugefügt werden, sonst explodiert das System!
$status = array("OK","Kaput","In Reperatur", "Verlohren", "Pensioniert");
//Welche Stati beim einloggen Automatisch aktiviert sind.
//Wie bei allen kommenden Arrays ist die Reihenfolge der Werte relevant
$select_status=array(1,1,1,1,0);
//Status Icons: Ampeln, ja oder nein. Bei nein müssen anderen Icons verwendet werden!
$uses_robots=TRUE;
//Ampeln: 1=Grün, 2=GrünGelb, 3=Gelb. 4=GelbRot, 5=Rot, 6=Durchgestrichen
$robot_status=array(1,3,5,5,6);
//Icons, wenn nicht ampeln.
$icon_status=array("eineDateiimordnerIMG.png","eineAndere.jpg","EinPenis.png");

//KATEGORIEN:
//Gelten die selben Regel wie bei den Stati
$category = array("Kamera, etc","Audio", "Licht", "Computer","Container","Anderes");
$select_category=array(1,1,1,1,1,0);

//Ablegestelle:
//Gelten die selben Regel wie bei den Stati
$storage = array("Rabu", "Dachboden");
$select_storage=array(0,0);


//ZEIT FILTER
//Für die Auswahl: Hier muss aich alles abgestimmt sein!
//Selbe Logik wie oben....
$time = array("3 Tage", "1 Woche", "2 Wochen", "1 Monat");
//Array mit STUNDEN der Zeit
$time_ms=array(3*24, 7*24, 14*24, 30*24);
$select_time= array(0,0,0,0);

//LABELS
//Für die Auswahl: Hier muss aich alles abgestimmt sein!
//Selbe Logik wie oben....
$label = array("Favorit");
$select_label= array(0);
$img_label=array("star.png","star_red.png","star_green");


//$hours ist die Zeint in Stunden, wie lange etwas verborgt sein muss bevor eine Warnung aufleuchtet
$hours=16;

//Mobile Debug Info Ein/Aus. Hilfreich bei der erstellung, ansonsten eher komisch
$mobile_debug=FALSE;
//Desktop Debug Info Ein/Aus. Hilfreich bei der erstellung, ansonsten eher komisch
$desktop_debug=FALSE;

//BACK UPs
//BackUp Interval der Datenbank in MINUTEN. Mindestens 10, Nie=0
$backupdata=15;
//TAGE wie lange die Backups gespeichert werden. Mindestens 3, Ewig=0
$backupdatadays=7;

//EXPORT
//Welche Daten Felder in welcher Reihenfolge Ausgeben werden
$export_ordnung = array("IID", "CATEGORY", "STATUS", "NAME", "LENDER", "DATETIME_LEND","YEAR_PURCHASED","VALUE","STORAGE");


//USER LEVEL
//IN ARBEIT: Userlevels: Jeder Nutzer hat ein Level (zwischen 0-10), fast alle Funktionen erfordern ein Mindestlevel.
//Die Userlevel können in der Oberfläche verändert werden, hier kann das Mindestlevel der Funktionen geändert werden
//Die Zahlen in den eckigen Klammern [] am Ende bitte ignorieren.
$zugriff = array(
        9, // Inventar entfernen [0]
        10,// Config Datei sehen [1]
        6, // User Verwaltung - Nur User mit geringeren Levels [2]
        8, // Kann Inventar Bearbeiten [3]
        7, // Detailansicht [4]
        11,// Debug Infos - Wenn diese aktiviert sind [5]
        4, // Kann Verleihen, Retournieren [6]
        11,// Sieht alle Logs [7]
        4, // Kann Status ändern [8] NICHT AKTIV
        5, // Kann exportieren [9]
        5, // Sieht Geld (Preis) [10]
        5, // Kann Labels Bearbeiten [11]
        7, // Kann IIDs bearbeiten [12]
        1, // Kann neuen Artikel anlegen [13]
        8,  // Sieht diese Info im Usermenue [14]
        10,  // Sieht letztes Backup [15]
        5  //Sieht Lagerplatz [16]
        );


// Anzeige der Rechte in der Hilfe: Von welcher Zeile zu welcher Zeile
$starthere=70;
$endhere=93;

