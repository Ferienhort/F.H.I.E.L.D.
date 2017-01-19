<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['treemap']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Location', 'Parent', 'Sektor', 'Anzahl'],
        ['F.H.I.E.L.D.', null, 0, 0],
        
        <?php
        include '../../../func.inc.php';
        $a=0;
        foreach ($groups as $key){
            echo "['$key','F.H.I.E.L.D.',0,0],";

            $a++;
        }
        echo "['Frei','F.H.I.E.L.D.',0,0],";
        $key= "Frei";


        
        $max = mysqli_query(connect(),"SELECT MAX(IID) AS VAR FROM kuume_inventory");
        $max = mysqli_fetch_array($max);
        $max = $max["VAR"];
        
        foreach ($group_stickers as $value) {
            if($value[1]>$max){
                $max=$value[1];
            }
    
}
                
        for($i=0;$i<=$max;$i=$i+50){
            
            if(findmyparent($i)===FALSE){
                $zwi="Frei";
            }
            else{
                $b=findmyparent($i);
                $zwi=$groups[$b];
            }
            if($zwi != "Frei"){
                echo "['$i-".($i+50)."','".$zwi."',50,".  howmany($i, $i+50)."],";
            }
        }
       /* 
        $max = mysqli_query(connect(),"SELECT IID, NAME FROM kuume_inventory");
        
        while($result = mysqli_fetch_array($max)){
             echo "['$result[NAME]:$result[IID]','".(round($result[IID]/50,0)*50)."-".(round($result[IID]/50,0)*50+50)."',1,null],";
        }*/
        ?>

      ]);

      var tree = new google.visualization.TreeMap(document.getElementById('chart_div'));

      var options = {
        highlightOnMouseOver: true,
        maxDepth: 1,
        maxPostDepth: 2,
        minColor: '#CCCCCC',
        midColor: '#FF9966',
        maxColor: '#CC0000',
        headerHeight: 15,
        showScale: true,
        height: 500,
        useWeightedAverageForAggregation: false,
        showScale: true,
        maxColorValue: 50,
        minColorValue: 0
      };

        tree.draw(data, options);

      }
      
    </script>
  </head>
  <body>
    <div id="chart_div" style="width:  95%; height:95%;"></div>
     <div id="table_div"></div>
  </body>
</html>