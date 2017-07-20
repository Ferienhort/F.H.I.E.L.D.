<?php

//KATEGORIEN:
// Wichtig: Neue Kategorien müssen am Ende des Arrays hinzugefügt werden, sonst explodiert das System!
$category = array("Helme","Audio", "Licht", "Computer","Anderes","Privat");
//Welche Kategorien beim einloggen Automatisch aktiviert (selected) sind.
$select_category=array(1,1,1,1,1,0);

//ABLAGESTELLE:
//Gelten die selben Regel wie bei den Kategorien
$storage = array("Kletterkammerl", "Altes Molo", "Meixner Hohe","Leichtathletik","Villa");
$select_storage=array(0,0,0,0);
 
//$hours ist die Zeint in Stunden, wie lange etwas verborgt sein muss bevor eine Warnung aufleuchtet
$hours=16;

//EXPORT
//Welche Daten Felder in welcher Reihenfolge Ausgeben werden
$export_ordnung = array("IID", "CATEGORY", "STATUS", "NAME","YEAR_PURCHASED","VALUE","STORAGE");

//INVENTUR
//Abwieviel verschiedenen gescannten Objekten soll der als Inventur wahrgenommen werden
$inventory_minimum = 25;

//USER LEVEL
//Userlevels: Jeder Nutzer hat ein Level (zwischen 0-10), fast alle Funktionen erfordern ein Mindestlevel.
//Die Userlevel können in der Oberfläche verändert werden, hier kann das Mindestlevel der Funktionen geändert werden
//Die Zahlen in den eckigen Klammern [] am Ende bitte ignorieren.
$zugriff = array(
        8,  // Inventar entfernen [0] 
        10, // Config Datei sehen [1]
        7,  // User Verwaltung - Nur User mit geringeren Levels [2]
        7,  // Kann Inventar Bearbeiten [3]
        8,  // Detailansicht [4]
        10, // Debug Infos - Wenn diese aktiviert sind [5]
        12,  // Kann Verleihen, Retournieren [6]
        10, // Sieht alle Logs [7]
        4,  // Kann Status ändern [8]
        5,  // Kann exportieren [9]
        5,  // Sieht Geld (Preis) [10]
        7,  // Kann Labels Bearbeiten [11]
        15, // Kann IIDs bearbeiten [12]
        1,  // Kann neuen Artikel anlegen [13]
        7,  // Sieht diese Info im Usermenue [14]
        10, // Sieht letztes Backup [15]
        1,  //Sieht Lagerplatz [16]
        5,  //Sieht erweiterete eigenschaften [17]
        5,  // Kann Schachtelinhalte editieren [18]
        1,  // Sieht Schachtelinhalte [19]
        2,  // Kann Mehr Scannen [20]
        10, // Bekommt Benachrichtigungen [21]
        9, // Bekommt alerts [22]
        7,  // Sieht Hilfe [23]
        4,  // Kann Kommentare sehen [24]
        4,  // Kann Kommentare schreiben [25]
        7,   // Kann Nachbestellen [26]
        7, // Kann Kommentare entfernen  [27]
        9,   // Sieht entfernte Kommentare[28]
        7,  // Detailansicht Aktivieren [29]
        7, // Schnellverleih [30]
        );