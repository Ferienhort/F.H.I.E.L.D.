<?php include_once '../func.inc.php'; 
        checkordie();
        document(connect(), $_SESSION[UID], $_GET[IID], "Scannt Unbelegt" , 0, 0); ?>

<html>
    <head>
        <title>TODO supply a title</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>    <form action="insert.php" method=post id="formular">
            <p class="nachricht">
    Dieser Sticker ist noch nicht belegt!<br>
    Lege hier einen neuen Eintrag an!
            </p>
            <span class="mobimenu"><a href=index.html><img class=mobimenupix src=img/Homebutton.gif></a></span>
    Name:<br>
    <input type="text" name=ding_name required><br>
    Jahr d. Anschaffung:<br>
    <input type="number" name=ding_jahr size="4" pattern="[0-9]*" inputmode="numeric"><br>
    Anschaffungspreis:<br>
    <input type="number" name=ding_preis size="4" pattern="^[-+]?[0-9]*\.?[0-9]+$" inputmode="numeric"><br>
    Status:<br> <?php printStati(0);?> <br>
    Kategorie:<br> <?php printKat(0);?> <br>
    Platz: <br> <?php printStorage(0);?> <br>
    <?php if(count($_SESSION[OWNER])>1)
    {
      echo "Bereich: <select name=ding_bereich>";
      foreach($_SESSION[OWNER] as $a){
          echo "<option value=$a ";
          if($a==$_SESSION[NOW]){
              echo "selected";
          }
          echo " > ".$groups[$a-1]."</option>";
    
       }
       echo "</select>" ;
    }
        
    
    ?>
    <input type="hidden" name="ding_iid" value=<?php echo "$_GET[IID]"; ?>><input type="submit" value="Speichern!">
        </form>
        </body>
</html>