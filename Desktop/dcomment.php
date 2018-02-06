<?php


include_once '../func.inc.php';
kuume_session();

checkordie();
echoifadmin(28);

if(isset($_GET[CID])&&isset($_GET[ACCEPT])){
    mysqli_query(connect(),"UPDATE kuume_comments SET VISABLE=0 WHERE CID=$_GET[CID]");
    document(connect(), $_SESSION[UID],$_GET[IID], "Entfernt Kommentar $_GET[CID]",0,0);
    echo "<i>Burn Notice: Das Kommetar wurde entfernt</i>";
}
 else {
     echo "$_SESSION[NAME], bist du sicher? ";
     echo "<a href=dcomment.php?CID=$_GET[CID]&ACCEPT=1&IID=$_GET[IID]>YES!</a><br>";
}

include 'comments.php';
?>
