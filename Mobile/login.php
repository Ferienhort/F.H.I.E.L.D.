<?php
include_once '../func.inc.php';

kuume_session();
$conn=connect();


if(isset($_POST[PIN]) && !isset($message)){
        eastereggs($_POST[PIN]);
        $query= "SELECT * FROM kuume_user WHERE PIN=".mysqli_real_escape_string($conn, $_POST[PIN])." AND AKTIV=1";
        $result=mysqli_query($conn,  $query);
        
        if(mysqli_num_rows($result)>0){
            $resultat =  mysqli_fetch_array($result);
            $_SESSION[UID]=$resultat[UID];
            $_SESSION[NAME]=$resultat[NAME];
            $_SESSION[AKTIV]=$resultat[AKTIV];
            $_SESSION[ADMIN]=$resultat[ADMIN];
            $i=substr($resultat[OWNER],0,1);
            if($i=="0"){
                $_SESSION[TECH]=TRUE;
            }
            else{
                $_SESSION[TECH]=FALSE;
            }
            $i=explode(",",$resultat[OWNER]);
            $a=0;
            $_SESSION[OWNER]=array();
            foreach($i as $b){
                    if($b!=0){
                    $_SESSION[OWNER][$a]=$b;
                    $a++;
                }
            }
            if($_SESSION[OWNER][0]==0){
                $_SESSION[NOW]=$_SESSION[OWNER][1];
                message($_SESSION[NOW]."=".$_SESSION[OWNER][1]);
            }
            else{
                $_SESSION[NOW]=$_SESSION[OWNER][0]; 
                message($_SESSION[NOW]."=".$_SESSION[OWNER][0]);
            }
            document($conn, $_SESSION[UID], 0, "Hat sich eingeloggt (Mobile)",0,0);
            $_GET[IID]=$_POST[geheim];
            
            
            include "kuume.php";
        }
        
       else{
            $message="Diesen PIN kenne ich nicht. Versuchs nochmal!";
            session_destroy();
            document(connect(), 2, 0,"Schlechter PIN",0,0);
            sleep(3);
            $_GET[IID]=$_POST[geheim];
            include 'kuume.php';
            
       }
    
}

else{
     echo "<div id=login><img id=logo src=kuume.png><br>";
     if(isset($message)){
         echo "<p class=nachricht>$message</p>";
     }
    die("<br>PIN eingeben: <br><form action=login.php method=POST> <input type=hidden value=$_GET[IID] name=geheim><input type=number name=PIN pattern='[0-9]*' inputmode=numeric>  <input type=submit value=Go!>");
 echo "/div>";
    
}