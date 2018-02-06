<?php
include 'config-mysql.inc.php';

//Ab welchem Userlevel die Skriptsprache global aktiviert wird. Kann in X.inc.php uberschrieben werden.
$enablescript=7;

//Namen
$groups = array("kuume", "Pfeilsport", "O.H.", "KuBu", "Admin", "FH-IT","Abenteuer","Klettern","RaBu");
$group_numbers = array(
            array(3000, 3200, "kuume"),
            array(1000, 2000, "Pfeilsport"),
            array(300, 950, "O.H."),
            array(4000, 4200, "KuBu"),
            array(1, 100, "Admin"),
            array(2000, 2200, "FH-IT"),
            array(5000, 5999, "Abenteuer"),
            array(6000, 6500, "Klettern"),
            array(3000, 3200, "RaBu")

);

$group_stickers = array(
            array(30000, 30300, "kuume"),
            array(10000, 10200, "Pfeilsport"),
            array(80000, 80100, "O.H."),
            array(40000, 40200, "KuBu"),
            array(100100, 100600, "Admin"),
            array(20000, 20100, "FH-IT"),
            array(50000, 50100, "Abenteuer"),
            array(60000, 60200, "Klettern"),
            array(30000, 30300, "RaBu")
    );

//STATI:
// Wichtig: Neue Stati müssen am Ende des Arrays hinzugefügt werden, sonst explodiert das System!
$status = array("OK", "Kaputt", "In Reparatur", "Unauffindbar", "Ausgegliedert");
//Welche Stati beim einloggen Automatisch aktiviert sind.
//Wie bei allen kommenden Arrays ist die Reihenfolge der Werte relevant
$select_status = array(1, 1, 1, 0, 0);
//Status Icons: Ampeln, ja oder nein. Bei nein müssen anderen Icons verwendet werden!
$uses_robots = TRUE;
//Ampeln: 1=Grün, 2=GrünGelb, 3=Gelb. 4=GelbRot, 5=Rot, 6=Durchgestrichen
$robot_status = array(1, 3, 4, 5, 6); 
//Icons, wenn nicht ampeln.
$icon_status = array("eineDateiimordnerIMG.png", "eineAndere.jpg", "weiterso.png");

//Mobile Debug Info Ein/Aus. Hilfreich bei der erstellung, ansonsten eher komisch
$mobile_debug = FALSE;
//Desktop Debug Info Ein/Aus. Hilfreich bei der erstellung, ansonsten eher komisch
$desktop_debug = FALSE;

//BACK UPs
//TAGE wie lange die Backups gespeichert werden. Mindestens 3, Ewig=0
$backupdatadays = 7;

//LABELS
//Für die Auswahl: Hier muss aich alles abgestimmt sein!
//Selbe Logik wie oben....
//DIESES FEATURE WURDE NIE FERTIG GESTELLT. ES GIBT NUR 1 LABEL, DAS SICH HIER BEARBETIEN LAeSST
$label = array("Favorit");
$select_label= array(0,0,0);
$img_label=array("star.png","star_red.png","star_green.png");


$zugriffanzeige = array(
    "Inventar entfernen",
    "Config Datei sehen",
    "User Verwaltung - Nur User mit geringeren Levels",
    "Kann Inventar Bearbeiten",
    "Inventurverlauf",
    "Debug Infos - Wenn diese aktiviert sind",
    "Kann Verleihen, Retournieren",
    "Sieht alle Logs",
    "Status bearbeiten",
    "Kann exportieren",
    "Sieht Geld (Preis)",
    "Kann Labels Bearbeiten",
    "Kann IIDs bearbeiten",
    "Kann neuen Artikel anlegen",
    "Sieht diese Info im Usermenue",
    "Sieht letztes Backup ",
    "Sieht Lagerplatz",
    "Sieht erweiterete Eigenschaften",
    "Kann Schachtelinhalte editieren",
    "Sieht Schachtelinhalte",
    "Kann MultiScannen",
    "Bekommt Benachrichtigungen",
    "Bekommt Alerts",
    "Sieht Hilfe",
    "Kann Kommentare sehen",
    "Kann Kommentare schreiben",
    "Kann nachbestellen",
    "Kann Kommentare entfernen",
    "Kann entfernte Kommentare sehen",
    "Detailansicht",
    "Schnellverleihmodul Aktivieren",
    "OH-Modul Aktivieren",
    "Ablaufdaten"
);

//Links 
$desktop_link = "http://admin.kuume.at";
$mobile_link = "http://app.kuume.at";
$sticker_link = "http://inventar.ferienhort.at";

//LABELS
//Für die Auswahl: Hier muss aich alles abgestimmt sein!
//Selbe Logik wie oben....
//DIESES FEATURE WURDE NIE FERTIG GESTELLT. ES GIBT NUR 1 LABEL, DAS SICH HIER BEARBETIEN LAeSST
$label = array("Favorit");
$select_label= array(0,0,0);
$img_label=array("star.png","star_red.png","star_green.png");


//Versioning 
$version = "&beta;17.02 \"Hans\" ";

if (isset($_SESSION[NOW]))
{
    include "ConfigFiles/".$_SESSION[NOW] . '.inc.php';
}