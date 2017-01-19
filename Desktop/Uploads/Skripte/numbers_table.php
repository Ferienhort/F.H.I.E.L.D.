<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);

      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Gruppe');      
        data.addColumn('number', 'Anfang');
        data.addColumn('number', 'Ende');
        data.addColumn('number', 'Belegt');
        data.addColumn('number', 'Frei');
        data.addColumn('number', 'Auslastung');
        data.addColumn('number', 'Anfang');
        data.addColumn('number', 'Ende');
        data.addColumn('number', 'Belegt');
        data.addColumn('number', 'Frei');
        data.addColumn('number', 'Auslastung');
        data.addRows([
         <?php
                 include '../../../func.inc.php';
                 for($i=0; $i<count($groups); $i++){
                     $value=$group_numbers[$i];
                     $temp= (howmany($value[0], $value[1]))/($value[1]-$value[0]);
                     echo "['$value[2]',$value[0],$value[1],".(howmany($value[0], $value[1])).",".(($value[1]-$value[0])-howmany($value[0], $value[1])).",{v: $temp,  f: '".round($temp*100, 2)."%'},";
                     $value=$group_stickers[$i];
                     $temp= (howmany($value[0], $value[1]))/($value[1]-$value[0]);
                     echo "$value[0],$value[1],".(howmany($value[0], $value[1])).",".(($value[1]-$value[0])-howmany($value[0], $value[1])).",{v: $temp,  f: '".round($temp*100, 2)."%'}],";
                 }
         
         php?>
        ]);

        var table = new google.visualization.Table(document.getElementById('table_div'));

        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
      }
    </script>
  </head>
  <body>
    <div id="table_div" style="width:  95%; height:95%;"></div>
  </body>
</html>