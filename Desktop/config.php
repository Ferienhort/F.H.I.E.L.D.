<?php
session_start();
?>
<html>
    <head>
<meta charset="utf8">
    </head>
    <body>


<?php
include_once '../func.inc.php';

    if(isset($_SESSION[UID]) && checkthis(1)){}
    else{
        die("Ciao!");
    }

 $fp = fopen("../config.inc.php", "r");

for ($i=0; $i<$displayforadmins; $i++){
$line = fgets($fp);
}
echo "Dieses Dokument ist im Rootverzeichnis zu finden - das System kann dort angepasst werden!";
echo "<pre>";
while($line=fgets($fp))
{
    echo $line;
}


?>
</body>
</html>
