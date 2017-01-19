<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Camp', 'Kinder','Logins', 'Angefangen', 'Abgeschlossen', 'Fehler'],
        <?php
          include '../../../func.inc.php';
        
          $conn = connect();
          
          $camp = array ("CC","AC","SC");
          foreach ($camp as $value) {
               
              echo "['$value'";
               $query="SELECT 
COUNT(DISTINCT download_actions.SCHUELER) AS VAR
FROM download_actions 
WHERE download_actions.SCHUELER 
IN(
SELECT download_schueler.PW FROM download_schueler WHERE download_schueler.CAMP LIKE '%$value%'
)
UNION ALL
SELECT 
COUNT(*) AS VAR
FROM download_actions 
WHERE download_actions.SCHUELER 
IN(
SELECT download_schueler.PW FROM download_schueler WHERE download_schueler.CAMP LIKE '%$value%'
) 
AND download_actions.TEXT LIKE '%Login%'
UNION ALL
SELECT 
COUNT(*) AS VAR
FROM download_actions 
WHERE download_actions.CAMP LIKE '%$value%'
AND download_actions.TEXT LIKE '%Startet%'
UNION ALL
SELECT 
COUNT(*) AS VAR
FROM download_actions 
WHERE download_actions.CAMP LIKE '%$value%'
AND download_actions.TEXT LIKE '%Beendet%'
UNION ALL
SELECT 
COUNT(*) AS VAR
FROM download_actions 
WHERE download_actions.CAMP LIKE '%$value%' AND (download_actions.TEXT LIKE '%A.%' OR (download_actions.TEXT LIKE '%B.%' OR  download_actions.TEXT LIKE '%G.%'))";
               $result=  mysqli_query($conn, $query);
               while ($row = mysqli_fetch_array($result)){
                   echo ", $row[VAR]";
               }
               echo "],";
          }
           echo "]);";       
         ?>


        var options = {
          chart: {
            title: 'Fotodownload 2016',
            subtitle: 'Wichtigsten Daten',
          },
          bars: 'horizontal',
          backgroundColor: '#E6E6E6'
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data,  google.charts.Bar.convertOptions(options));
      }
    </script>
  </head>
  <body>
    <div id="barchart_material" style="width: 95%; height: 95%;"></div>
  </body>
</html>
