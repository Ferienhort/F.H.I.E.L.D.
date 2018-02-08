<?php
include_once '../func.inc.php'; 
kuume_session();
?>

<html>
    <head>
        <link rel="apple-touch-icon" sizes="57x57" href="Icon/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="Icon/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="Icon/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="Icon/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="Icon/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="Icon/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="Icon/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="Icon/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="Icon/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="Icon/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="Icon/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="Icon/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="Icon/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="Icon/manifest.json">
<link rel="mask-icon" href="Icon/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="Icon/favicon.ico">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-TileImage" content="Icon/mstile-144x144.png">
<meta name="msapplication-config" content="Icon/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1 "/>
<link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
         <link rel="stylesheet" type="text/css" href="style.css">
         <?php
         $easteregg = array("FerienHort Inventar, Export und Logistik Division",
             "FerienHort In Einer Leiwanden Datenbank",
             "FerienHort Ist Ein Logistisches Dillema",
             "FerienHort In Ein Lustiger Datensatz",
             "FerienHort Intervention, Enforcement and Logistics Division",
             "FHield Ist Eine Lange Datei",
             "the Framework of HortsInventar, -Equiment, -Lager und -Daten",
             "Ferienhort Hat Interne Equipment & Lager Dokumentation",
             "Fhield Hat Irgendeine Extrem Lustige beDeutung"
             );
         
         echo "<title> F.H.I.E.L.D. - ".$easteregg[rand(0,count($easteregg)-1)]."</title>";
        
         ?>
    </head>
     <script type="text/javascript">

 
                function display(bild){
                    if(bild==0){
                       document.getElementById("content").innerHTML = "";
                        document.getElementById("content").style.visibility = "hidden" ;
                    }
                    else{
                        document.getElementById("content").style.visibility = "visible" ;
                        document.getElementById("content").innerHTML = "<a href='javascript:display(0)'><img width=100% src=Uploads/"+bild+"></a>";
                    }
            }
                    function eexport(){
            var e = document.getElementById("eee");
            e.value="TRUE";
            document.suchfilter.submit();
            e.value="FALSE";
        }
         </script>
    <body>
        
        <?php

include_once '../func.inc.php';        
 $connect=  connect();       
 foreach($_GET as $a) {
     $a=  mysqli_real_escape_string($connect,$a);
 }
 
  foreach($_POST as $a) {
     $a=  mysqli_real_escape_string($connect,$a);
 }
 
 if(isset($_POST[omniIID])){
             $_POST[IID]=$_POST[omniIID];
             $_SESSION[omni]=$_POST;
         }
if(isset($_GET[S])){
             $_POST=$_SESSION[omni];
         }

               