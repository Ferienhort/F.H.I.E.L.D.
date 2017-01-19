<?php

function seconchart($data){
    return str_replace("google.charts.load('current', {'packages':['corechart']});", "", $data);
}



function FHIELD_pie($title, $data, $name){
    $element = randomKey(10);
    $output =array("","","");
    $output[0]=' <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
    $output[1]=" <script type=text/javascript>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart$element);
      function drawChart$element() {

        var data = google.visualization.arrayToDataTable([[";
    $last = end($title);
    foreach ($title as $value) {
        $output[1].="'$value'";
        if(!($last==$value)){
            $output[1].=",";  
        }
    }
    $output[1].="]";
   foreach ($data as $value) {
        $last = end($value);
        $output[1].=",[";
        foreach ($value as $li){
            if(is_int($li)){
                $output[1].="$li";
            }
            else{
             $output[1].="'$li'";
            }
            if(!($li==end($value)))
            {
                $output[1].=","; 
            }
            if(($last==$li)){
            $output[1].=",";  
            }
        }
       $output[1].="]";
    }
    $output[1].="]);
        var options = {
          title: '$name',
          backgroundColor: '#E6E6E6',
        };

        var chart = new google.visualization.PieChart(document.getElementById('$element'));

        chart.draw(data,  options);
      }
    </script>";
    
    $output[2]='<div id="'.$element.'" style="width: 48%; height: 48%; float: left;"></div>';

    return $output;
    
}