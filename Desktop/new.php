<?php include_once '../func.inc.php'; 
        checkordie();
    if(isset($_GET[Check]) && $_GET[Check]==1){
    document($conn, $_SESSION[UID], $_GET[IID], "Scannt Unbelegt", 0, 0);
    }
    else{
    document($conn, $_SESSION[UID], $_GET[IID], "Check Unbelegt", 0, 0);
    }

    ?>

    
    Dieser Sticker ist noch nicht belegt!<br>
    Lege hier einen neuen Eintrag an!<br>
    
    <form action="insert.php" method=post id="formular">
    Name:<br>
    <input type="text" name=ding_name required><br>
    Jahr d. Anschaffung:<br>
    <input type="number" name=ding_jahr size="4"><br>
    Preis:<br>
    <input type="number" name=ding_geld size="4"><br>
    Status:<br> <?php printStati(0);?> <br>
    Kategorie:<br> <?php printKat(0);?> <br>
    Lagerplatz:<br> <?php printStorage(0);?> <br>
    <input type="hidden" name="ding_iid" value=<?php echo "$_GET[IID]"; ?>><input type="submit" value="Speichern!">
    </form>
    