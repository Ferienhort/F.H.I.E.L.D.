<?php

// MYSQL VERBDINUNG
$server = "dd29920.kasserver.com";
$username = "d0220110";
$password = "V7ntpLuc9HeKVYRw";
$database = "d0220110";

//Zeile ab Welcher dieses Dokument im Admin Panel angezeigt wird
$displayforadmins=11;

//GRUPPEN
//Namen
$groups=array("kuume","Pfeilsport","O.H.");


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
$icon_status=array("eineDateiimordnerIMG.png","eineAndere.jpg","weiterso.png");


//Mobile Debug Info Ein/Aus. Hilfreich bei der erstellung, ansonsten eher komisch
$mobile_debug=FALSE;
//Desktop Debug Info Ein/Aus. Hilfreich bei der erstellung, ansonsten eher komisch
$desktop_debug=FALSE;

//BACK UPs
//BackUp Interval der Datenbank in MINUTEN. Mindestens 10, Nie=0
$backupdata=15;
//TAGE wie lange die Backups gespeichert werden. Mindestens 3, Ewig=0
$backupdatadays=7;


//Versioning
$version = "&Alpha;.0524";

if(isset($_SESSION[NOW])){
    include $_SESSION[NOW].'.inc.php';
}