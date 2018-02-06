<?php


include '../../../func.inc.php';

$sitestotest_names = array(
    "Ferienhort Startseite",
    "Ferienhort Banner",
    "FotoPortal Startseite",
    "FotoPortal Logo");

$connect=connect();
$string = "";
foreach ($sitestotest_names as $key)
{
  $result=  mysqli_fetch_array(
          mysqli_query($connect, "SELECT COUNT( * ) AS ZAHL FROM eve WHERE (type LIKE '$key' AND OK=0) AND evetime > DATE(NOW()) - INTERVAL 7 DAY")
          );
  $string=$string."'$key' war $result[ZAHL] Minuten ausgefallen die letzten 7 Tage<br>";
}

?>


<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
        <?php
        foreach ($sitestotest_names as $key)
            {
            echo "['$key',";
                    $result=  mysqli_fetch_array(
                            mysqli_query($connect, "SELECT MIN( ms ) AS ZAHLEINS  , MAX( ms ) AS ZAHLZWEI, AVG( ms ) as ZAHLDREI FROM eve WHERE type LIKE '$key' AND evetime > DATE(NOW()) - INTERVAL 7 DAY AND ok = 1")
                    );
                    $result2=  mysqli_fetch_array(
                            mysqli_query($connect, "SELECT AVG ( ms ) as ZAHL FROM eve WHERE type LIKE '$key' AND evetime > DATE(NOW()) - INTERVAL 14 DAY AND evetime < DATE(NOW()) - INTERVAL 6 DAY AND ok = 1")
                    );
                    echo "$result[ZAHLEINS],$result2[ZAHL],$result[ZAHLDREI],$result[ZAHLZWEI]],";
            }

        
        ?>
    ], true);

    var options = {
      legend:'none'
    };

    var chart = new google.visualization.CandlestickChart(document.getElementById('chart_div'));

    chart.draw(data, options);
  }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 95%; height: 95%;"></div>
    <?php 
echo $string;
?>
  </body>
</html>
