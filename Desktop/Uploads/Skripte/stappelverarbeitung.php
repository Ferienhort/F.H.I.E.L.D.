<?php
include '../../../func.inc.php';

echo "<form action=stappelverarbeitung-do.php method=POST>";

echo "<b>Verschiebe Dinge</b> <input type=submit value='HIER STARTEN'><br>";
echo "<i>Gruppen Nr.:";
$i=1;
foreach($groups as $a){
    echo " $i) $a,";
    $i++;
}
echo "</i><br>";
echo "<br><b>Von</b><br>";
echo "Gruppe Nr.: <input type=text name=gruppevon size=2 required> Kategorie Nr.:  <input type=text name=kattegorievon size=2>";
echo "<i> (Achtung: erste Kategorie ist 0!)</i><br>";
echo "<b>Nach</b><br>";
echo "Gruppe Nr.: <input type=text name=gruppenach size=2 required> Kategorie Nr.:  <input type=text name=kattegorienach size=2 required>";
echo "<i> (Achtung: erste Kategorie ist 0!)</i><br>";
echo "<br><b>Wenn</b> ";
echo "<i>(leere Bedingungen werden ignoriert!)</i><br>";
echo "Namensteil: <input type=text name=namen>";
echo "<i>Verschiebt Dinge mit diesem Wort im Namen</i><br>";
echo "In Liste: <input type=text name=liste>";
echo "<i>IID's mit Beistrich (,) trennen</i><br>";
echo "<input type=checkbox name=fav value=TRUE> Ist Favorit <br><input type=checkbox name=not value=TRUE> Invertieren <i>also: ist <u>nicht</u> in der Liste, hat das Wort <u>nicht</u>, <u>kein</u> Favorit...</i>";
echo "</form>";
        

