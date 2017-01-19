<?php session_start();  ?> 
<html>
    <head> <link rel="apple-touch-icon" sizes="57x57" href="../Icon/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="../Icon/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="../Icon/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="../Icon/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="../Icon/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="../Icon/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="../Icon/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="../Icon/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="../Icon/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="../Icon/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="../Icon/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="../Icon/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="../Icon/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="../Icon/manifest.json">
<link rel="mask-icon" href="../Icon/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="../Icon/favicon.ico">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-TileImage" content="../Icon/mstile-144x144.png">
<meta name="msapplication-config" content="../Icon/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
        <meta charset="utf8_unicode_ci">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head><script type="text/javascript">
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
         </script>
    <body><div id="content"></div>
        <?php
        
            //Debug Screen
            include_once "../func.inc.php";
            echo_mobile_debug($mobile_debug);

            if($_GET[IID]==""){
                die("<span class=message> Schlechter Parameter: Bitte klick <a href=index.html>hier</a></span>!");
                
            }
            
            if(isset($_SESSION[UID]))
               {
                $conn = connect();
                $iinfo=doesItExist($conn, $_GET[IID]);
                    
                
                if($iinfo===FALSE){
                    include 'new.php';
                }
                else{
                include 'edit.php';
                }
                
                }
            else{
                include "login.php";
            }
        ?>
    </body>
</html>
