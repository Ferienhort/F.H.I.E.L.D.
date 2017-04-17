<?php

    $query= "SELECT * FROM kuume_inventory WHERE IID=$_GET[IID]";
    if(!isset($_GET[ANON])){
    document($conn, $_SESSION[UID], $_GET[IID],"Scannt", "0", "0");
    }
    else{
       document($conn, $_SESSION[UID], $_GET[IID],"Check", "0", "0");  
    }
    $result=mysqli_fetch_array(mysqli_query($conn,  mysqli_real_escape_string($conn, $query) ));
    if($result[STATUS]==3){
         echo "<script type=text/javascript>
                window.alert('Achtung: Dieses Objekt ist als verloren gemeldet! Bitte gib dem Zustaendigen Bescheid, dass du es gefunden hast!');
            </script>";
         
     }
    if($result[OWNER]!=$_SESSION[NOW] && $result[OWNER]!=""){
        die("Dieser Sticker ist bereits einer anderen Abteilung zugeordnet $result[OWNER]!=$_SESSION[NOW] && $result[OWNER]");
    }
    echo '<form action="update.php" method="POST" id=formular>';
    if(isset($message)){
         echo "<p class=nachricht>$message</p>";
     }

    echo '<span class=titel>'.  utf8_encode($result[NAME]).' <i>('.$groups[$result[OWNER]-1].')</i></span><span class=mobimenu>';
    if(checkthis(17))
            {
        echo "<a href=more.php?IID=$result[IID]><img class=mobimenupix src=img/Tools.gif></a>";
                
    }
    echo "<a href=index.html><img class=mobimenupix src=img/Homebutton.gif></a></span>";
    echo '<br>IID: '.$result[IID]."<br>";
    if($result[PERCENT]!="0"){
    echo 'Prozent: '.$result[PERCENT]."%<br>";
    }
    echo "Kategorie: ";
    echo $category[$result[CATEGORY]];
    if(checkthis(16)){
        echo "<br>Lagerplatz: ";
        echo $storage[$result[STORAGE]];
    }
    echo '<input type="hidden" name="ding_iid" value='.$result[IID].'><input type="hidden" name="ding_status_alt" value='.$result[STATUS].'>';

            if(checkthis(8))
        {   
                    echo "<br><br>Status:";
            echo printStati($result[STATUS]);
        }
        else{
            echo "<br>Status: ";
            echo $status[$result[STATUS]];
        }
    
        if($result[LENDER]=="0" && checkthis(6)){
        echo '<br>Verleih: <br><input type="text" name="ding_lender">'; 
        }
        elseif($result[LENDER]!="0"){
        echo "verliehen an $result[LENDER] am $result[DATETIME_LEND]";
            if(checkthis(6)){
                echo "<br> Wieder da: <input type=checkbox name=ding_lender_old value=$result[LENDER]>";
            }
            else {
                echo "<br>";
            }
        }
     $faulagain=True;
        $dings=explode(";", $result[CONTENT]);
             foreach($dings as $a){
                 if($a!="" && $a!=" "){
                     
                 $b=mysqli_query($conn, "SELECT * FROM kuume_inventory WHERE IID=$a");
                 if($b==FALSE || mysqli_num_rows($b)==0){
                        if($faulagain){
                             echo "<p id=inhalt><b> Inhalt:</b>";
                             $faulagain=FALSE;
                        }
                     echo "<br> Ung&uumltige Nummer '$a'";
                 }
                else{
                    if($faulagain){
                             echo "<p id=inhalt><b> Inhalt:</b>";
                             $faulagain=FALSE;
                        }
                    $rowb=mysqli_fetch_array($b);
                    echo "<br>$rowb[NAME]";
            }
             }
             }
            echo "</p>";
        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kuume_inventory WHERE CONTENT LIKE '%;$result[IID];%'"))>0){ 
            echo "<p id=inside>Zu finden in ";
            $sushi=mysqli_query($conn, "SELECT * FROM kuume_inventory WHERE CONTENT LIKE '%;$result[IID];%'");
            while ($row=mysqli_fetch_array($sushi)) {
                echo "$row[NAME]";
            }
            echo "</p><br>";
        }
        
        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kuume_attachments WHERE IID=$result[IID] AND TYPE=0"))>0){ 
            echo "<p id=bilder><b>Anh&auml;nge</b><br><br>";
            $sushi=mysqli_query($conn, "SELECT * FROM kuume_attachments WHERE IID=$result[IID]");
            while ($row=mysqli_fetch_array($sushi)) {
                echo "<a href=javascript:display('$row[PATH]');><img src=Uploads/$row[PATH] class=gallerypic></a>";
            }
            echo "</p><br>";
            }
            
        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kuume_attachments WHERE IID=$result[IID] AND TYPE=1"))>0){ 
            $sushi=mysqli_query($conn, "SELECT * FROM kuume_attachments WHERE IID=$result[IID] AND TYPE=1 ORDER BY AAID");
            while ($row=mysqli_fetch_array($sushi)) {
            echo "<a href=Uploads/$row[PATH]>".  str_replace("PDF/","", $row[PATH])."</a><br>";
            }
        }
        
        
    $query= "SELECT * FROM kuume_comments WHERE IID=$_GET[IID] ORDER BY DATETIME DESC";
    $result=mysqli_query($conn, $query);
    
    if(checkthis(23)){
    echo '<br>Neues Kommentar: <br><input type="Text" name="ding_kommentar" value="">';  
    }
    echo '<br><input type=submit value="Speichern!">';
    if(mysqli_num_rows($result) > 0  && checkthis(24)){
        while($row=mysqli_fetch_array($result)){

        if($row[VISABLE]==0 && checkthis(27)){
        echo "<p class=blabla style=' font-style: italic;'><b>UNSICHTBAR</b>  ".getUser($conn,$row[UID])." ($row[DATETIME]): ".stripslashes($row[COMMENT]);
        echo "</p>";
        }
        elseif($row[VISABLE]==1){
            echo "<p class=blabla>".getUser($conn,$row[UID])." ($row[DATETIME]): ".stripslashes($row[COMMENT]);
            echo "</p>";   
        }

        }
    
        }
     else {
        echo "<p class=blabla><i>Keine Kommentare</i></p>";
    }
    
