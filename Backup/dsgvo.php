
<?php
$start=time();
include_once '../func.inc.php';

$conn=connect();

$query="UPDATE kuume_actions SET IP = '', HOST = '', AGENT = '' WHERE kuume_actions.TIME < NOW() - INTERVAL 48 HOUR";
$bla=mysqli_fetch_array(mysqli_query($conn, $query));

$query="UPDATE kuume_user SET PIN = '', NAME = 'Jemand', LAST_NAME=' ', ANFANG='0000-00-00', Ende ='0000-00-00', AKTIV=0, ADMIN=0 WHERE (ENDE < NOW() - INTERVAL 10 YEAR AND ENDE != '0000-00-00')";
$bla=mysqli_fetch_array(mysqli_query($conn, $query));

$query="UPDATE kuume_user SET PIN = '', NAME = 'Ein Betreuer', LAST_NAME=' ', ANFANG='', Ende ='', AKTIV=0, ADMIN=0 WHERE (ENDE < NOW() - INTERVAL 2 YEAR AND ENDE != '0000-00-00') AND UID NOT IN (SELECT DISTINCT UID FROM kuume_actions WHERE IID IN (SELECT IID FROM kuume_inventory WHERE STATUS = 0)) AND UID NOT IN
(SELECT  DISTINCT UID FROM kuume_comments WHERE IID IN (SELECT IID FROM kuume_inventory WHERE STATUS = 0))";
$bla=mysqli_fetch_array(mysqli_query($conn, $query));

$query="UPDATE kuume_inventory SET LENDER = MD5(CONCAT(LENDER,RAND())) WHERE LENDER NOT LIKE '0' AND DATETIME_LEND < NOW() - INTERVAL 5 YEAR";
$bla=mysqli_fetch_array(mysqli_query($conn, $query));

$query="UPDATE kuume_actions SET LENDER = MD5(CONCAT(LENDER,RAND())) WHERE LENDER NOT LIKE '0' AND kuume_actions.TIME < NOW() - INTERVAL 2 YEAR";
$bla=mysqli_fetch_array(mysqli_query($conn, $query));

 $end=time();
 if($end-$start>=20){
     document_alert("Loschroutine dauert mehr als 20 Sekunden!", "Faith", 4,$end-$start." Sekunden");
 } else {
    document_alert("Loschroutine OK ", "Faith", 1,$end-$start." Sekunden");
 }
  

?>