<?php

session_start();

include_once '../func.inc.php';

checkordie();
$conn =connect();
    
include 'header.php';


 $query= "SELECT * FROM kuume_user WHERE AKTIV=1 AND ADMIN <= $_SESSION[ADMIN] AND UID != 0 AND (OWNER LIKE '%$_SESSION[NOW]%')  ORDER BY ADMIN DESC";   
         message($query);
        

if($_POST[ichbinfaul]==1){

    $blabla = mysqli_query($conn, $query);
    while($row=mysqli_fetch_array($blabla)){

            $temp = "userpin".$row[UID];
            if($_POST[$temp] != "*****"){
                    if(does_pin_exist($conn, $_POST[$temp])){
                        die("Fehler! Der PIN ist viel zu einfach oder vorhersehbar! Bitte klicke erneut auf 'Benutzer'");
                    }
                    mysqli_query($conn, "UPDATE kuume_user SET PIN=$_POST[$temp] WHERE UID=$row[UID]");
                    document($conn, $_SESSION[UID],0,"Pin von UID: $row[UID] aktualisiert:", 0, 0);
            }
            $temp = "usernmame".$row[UID];
            if($_POST[$temp] != $row[NAME]){
                    mysqli_query($conn, "UPDATE kuume_user SET NAME='$_POST[$temp]' WHERE UID=$row[UID]");
                    document($conn, $_SESSION[UID],0,"Name von UID: $row[UID] aktualisiert: $row[NAME]=>$_POST[$temp]", 0, 0);
            }
            $temp = "usernachname".$row[UID];
            if($_POST[$temp] != $row[LAST_NAME]){
                    mysqli_query($conn, "UPDATE kuume_user SET LAST_NAME='$_POST[$temp]' WHERE UID=$row[UID]");
                    document($conn, $_SESSION[UID],0,"Nachname von UID: $row[UID] aktualisiert: $row[LAST_NAME]=>$_POST[$temp]", 0, 0);
            }
            $temp = "useradmin".$row[UID];
            if($_POST[$temp] != $row[ADMIN]){
                    if($_POST[$temp]<= $_SESSION[ADMIN]){
                         mysqli_query($conn, "UPDATE kuume_user SET ADMIN=$_POST[$temp] WHERE UID=$row[UID]");
                        document($conn, $_SESSION[UID],0,"Admin von UID: $row[UID] aktualisiert: $row[ADMIN]=>$_POST[$temp]", 0, 0);
            }
            }
            if($_SESSION[TECH]){
            $temp = "userowns".$row[UID];
            if($_POST[$temp] != $row[OWNER]){
                    message($_POST[$temp]." != ".$row[OWNER]);
                    mysqli_query($conn, "UPDATE kuume_user SET OWNER='$_POST[$temp]' WHERE UID=$row[UID]");
                    document($conn, $_SESSION[UID],0,"Gruppe von UID: $row[UID] aktualisiert: $row[OWNER]=>$_POST[$temp]", 0, 0);
            }
            }
    }
     
}

If($_POST[userpinneu]!=""){
    if(does_pin_exist($conn, $_POST[userpinneu])){
        die("Fehler! Der PIN ist viel zu einfach oder vorhersehbar! Bitte klicke erneut auf 'Benutzer'");
    }
    if($_POST[useradminneu]==""){
        $_POST[useradminneu]=0;
    }
    if(!isset($_POST[userownsneu])){
        $_POST[userownsneu]=$_SESSION[NOW];
    }
    mysqli_query($conn, "INSERT INTO kuume_user (PIN, NAME, LAST_NAME, ANFANG, AKTIV, ADMIN, OWNER) VALUE ($_POST[userpinneu], '$_POST[usernmameneu]', '$_POST[usernachnameneu]', NOW(), 1, $_POST[useradminneu],  '$_POST[userownsneu]')");
    document($conn, $_SESSION[UID],0,"Neuer User ($_POST[usernmameneu] $_POST[usernachnameneu], Admin:  $_POST[useradminneu], Gruppe: '$_POST[userownsneu]')", 0, 0);
    }
echo "<form action=users.php method=POST><input type=hidden name=ichbinfaul value=1><table>";


   echo "<tr>";
        echo "<td></td>";
        echo "<td>PIN</td>";
        echo "<td>NAME</td>";
        echo "<td>NACHNAME</td>";
        echo "<td>ADMIN</td>";
        if($_SESSION[TECH]){
              echo "<td>GRUPPE</td>";
        }
        echo "<td> </td>";
        echo "</tr>";
        
        
        
        
        
    $blabla = mysqli_query($conn, $query);
    while($result=mysqli_fetch_array($blabla)){
        echo "<tr>";
        echo "<td><div style='";
        echo primary_color($result[ADMIN]);
        echo " border-radius: 10px; padding: 5px; text-align: center;'>$result[UID]</div></td>";
        echo "<td><input style=width:100px; type=text name=userpin$result[UID] value='*****' size=6></td>";
        echo "<td><input type=text name=usernmame$result[UID] value='$result[NAME]'></td>";
        echo "<td><input type=text name=usernachname$result[UID] value='$result[LAST_NAME]'></td>";
        echo "<td><input name=useradmin$result[UID] value=$result[ADMIN] size=2 min=1 max=12 type=number></td>";
        if($_SESSION[TECH]){
              echo "<td><input type=text  style=width:80px; name=userowns$result[UID] value=$result[OWNER]></td>";
        }
        if($result[ADMIN]<$_SESSION[ADMIN]){
        echo "<td style='text-align: center;'><a href=duser.php?UID=$result[UID]><img src=img/delete.png class=klein>";
        }
       if(checkthis(7)){
            echo "<a href=spy.php?UID=$result[UID] target=thatframeyo><img class=klein src=img/log.png></a>";
        }
        echo "</a></td></tr>";
    }
    
    echo "<tr>";
        echo "<td></td>";
        echo "<td><input style=width:100px;type=number name=userpinneu size=6></td>";
        echo "<td><input type=text name=usernmameneu ></td>";
        echo "<td><input type=text name=usernachnameneu></td>";
                echo "<td><input size=2 min=1 max=10 type=number name=useradminneu></td>";
        if($_SESSION[TECH]){
              echo "<td><input type=text  style=width:80px name=userownsneu></td>";
        }
        echo "<td><input type=submit value=Speichern></td>";
        
        echo "</tr>";
    
        echo "</table></form>";

        
        
        
if(1){
    $i=$_SESSION[ADMIN];
    echo "<b>Berechtigungen:</b><br><br>";
    while($i>=0){
        echo "<b>Level $i</b><br>";
        $b=0;
        foreach($zugriff as $a){
            if($a==$i){
                echo $zugriffanzeige[$b]."<br>";
            }
            $b++;
        }
        $i--;
    }
        
      
    
}