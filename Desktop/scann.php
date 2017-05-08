<?php
include 'header.php';
include_once '../func.inc.php';

echoifadmin(20);
?>


<form method="POST" action="omini.php">
    <b>Listenscan</b>
    Scan<input type="checkbox" name="Check" value="1" checked> <input type="submit" value="Go!"><br><br>
    <textarea name="IID" rows="25" style="width: 75%;" required=""></textarea>


</form>
</form>