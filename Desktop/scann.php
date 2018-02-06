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
        <input type="checkbox" name="Borrowed" value="1" checked> Sollte eine dieser Nummern verliehen sein, automatisch retounieren<br>
        <input type="checkbox" name="Lost" value="1" checked> Nummern aus dieser Liste, die als "<?php echo $status[3] ?>" gemeldet sind, als "<?php echo $status[0] ?>" markieren <br>
        <input type="checkbox" name="FUCK" value="1" > Nummern aus dieser Liste, die als "<?php echo $status[4] ?>" gemeldet sind, als "<?php echo $status[0] ?>" markieren <br>
        <input type="checkbox" name="Broken" value="1" > Keine diese Nummern ist "<?php echo $status[1] ?>" oder "<?php echo $status[2] ?>": Status automatisch auf "<?php echo $status[0] ?>" setzen<br>
        <br>
        <input type="submit" value="Go!">
        </div>
    </div>
        <textarea name="IID" rows="25" style="width: 75%;" required=""></textarea>
</form>