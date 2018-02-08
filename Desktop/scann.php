<?php
include 'header.php';
include_once '../func.inc.php';

echoifadmin(20);
?>


<form method="POST" action="omini.php">
    <b>ListenScan</b>
    
    <div>
        <div>Bitte kopiere alle Inventarnummer in das Textfeld, um dem System ihre Anwesenheit zu best&auml;tigen. 
        </div><br>
          <b>Optionen</b>
        <div>
        <input type="checkbox" name="Check" value="1" checked> Diese Nummern f&uuml;r Inventur melden ("scannen")<br>
        <?php
            if(checkthis(6)){
                echo '<input type="checkbox" name="Borrowed" value="1" checked> Sollte eine dieser Nummern verliehen sein, automatisch retounieren<br>';
            }
            
        
            if(checkthis(8)){
                echo '<input type="checkbox" name="Lost" value="1" checked> Nummern aus dieser Liste, die als "'. $status[3].'" gemeldet sind, als "'. $status[0].'" markieren <br>
                <input type="checkbox" name="FUCK" value="1" > Nummern aus dieser Liste, die als "'. $status[4].'" gemeldet sind, als "'. $status[0].'" markieren <br>
                <input type="checkbox" name="Broken" value="1" > Nummern aus dieser Liste, die als  "'. $status[2].'" oder "'. $status[1].'": gemeldet sind, als "'. $status[0].'" markieren<br>';
            }
        ?>
        <br>
        <input type="submit" value="Go!">
        </div>
    </div>
        <textarea name="IID" rows="25" style="width: 75%;" required=""></textarea>
</form>