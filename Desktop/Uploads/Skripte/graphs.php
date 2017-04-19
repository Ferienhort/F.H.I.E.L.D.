 <html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
            google.charts.load('current', {'packages':['line']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Zeitraum');
<?php

include '../../../func.inc.php';
        
function fhzeit($year){
    $fhtime=array();
    $fhtime[0]=array("Jan-Mar $year","BETWEEN '$year-01-01  00:00:00' AND '$year-03-31 23:59:59'");
    $fhtime[1]=array("April $year","BETWEEN '$year-04-01  00:00:00' AND '$year-04-30 23:59:59'");
    $fhtime[2]=array("Mai $year","BETWEEN '$year-05-01 00:00:00' AND '$year-05-31 23:59:59'");
    $fhtime[3]=array("Juni $year","BETWEEN '$year-06-01 00:00:00' AND '$year-06-30 23:59:59'");
    $fhtime[4]=array("Juli $year (Woche 1)","BETWEEN '$year-07-01 00:00:00' AND '$year-07-07 23:59:59'");
    $fhtime[5]=array("Juli $year (Woche 2)","BETWEEN '$year-07-08 00:00:00' AND '$year-07-14 23:59:59'");
    $fhtime[6]=array("Juli $year (Woche 3)","BETWEEN '$year-07-15 00:00:00' AND '$year-07-21 23:59:59'");
    $fhtime[7]=array("Juli $year (Woche 4)","BETWEEN '$year-07-21 00:00:00' AND '$year-07-28 23:59:59'");
    $fhtime[8]=array("Juli $year (Woche 5)","BETWEEN '$year-07-29 00:00:00' AND '$year-08-04 23:59:59'");
    $fhtime[9]=array("August $year (Woche 1)","BETWEEN '$year-08-05 00:00:00' AND '$year-08-12 23:59:59'");
    $fhtime[10]=array("August $year (Woche 2)","BETWEEN '$year-08-13 00:00:00' AND '$year-08-20 23:59:59'");
    $fhtime[11]=array("August $year (Woche 3)","BETWEEN '$year-08-21 00:00:00' AND '$year-08-28 23:59:59'");
    $fhtime[12]=array("August $year (Woche 4)","BETWEEN '$year-08-29 00:00:00' AND '$year-09-05 23:59:59'");
    $fhtime[13]=array("Sept $year","BETWEEN '$year-09-06 00:00:00' AND '$year-09-30 23:59:59'");
    $fhtime[14]=array("Okt-Dez $year","BETWEEN '$year-10-01 00:00:00' AND '$year-12-31 23:59:59'");
    
    return $fhtime;
    
}   

$conn=connect();

foreach ($groups as $key)
{
    echo "data.addColumn('number', '$key');\n";
}

echo "data.addRows([\n";
 
    for($i=2016; $i<=  date(Y); $i++){
        $fhtime=fhzeit($i);
 
       foreach($fhtime as $key){
                 echo "[";
                $a=1;
                echo "'$key[0]',";
                while($a<=count($groups)){
                    $query="SELECT COUNT(*) AS ZAHL FROM kuume_actions WHERE IID!=0 AND IID IN (SELECT IID FROM kuume_inventory WHERE OWNER = $a) AND UID!= 0 AND kuume_actions.TIME $key[1]";
                     $result=mysqli_query($conn, $query);
                     $res=mysqli_fetch_array($result);
                     echo "$res[ZAHL]";
                     if($a!=count($groups)){
                         echo ",";
                     }
                $a++;
                }
       
       echo "],\n";
       } 
    }


echo "     ]);";


?>
    
     
      var options = {
        chart: {
          title: 'Userhandlungen in Ferienhort Zeit',
        }

            

      };

      var chart = new google.charts.Line(document.getElementById('linechart_material'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }

    
    
        </script>
  </head>
  <body>
      <div id="linechart_material" style="height: 95%; width: 95%"></div>
  </body>
</html>