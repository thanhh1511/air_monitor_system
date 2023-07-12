<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Personal Portfolio Website</title>
    <!----CSS link----->
    <link rel="stylesheet" href="style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script type="text/javascript" src="config.js"></script>
  </head>
  <body style="background-color: #0892D0;">
    <div class="hero">
    <nav>
        <ul>
        <li><a href="./index.php">Home</a></li>
          <li><a href="./history.php">History</a></li>

        </ul>
        <i class="fa fa-thermometer" id="icon_temp"></i>
        <h2 id="temp"></h2>
      </nav>
      <div class="chart_content"> 
        <?php   
            require_once "connection.php";   
        ?>    
        

        <?php
          if(isset($_POST['view_chart'])){
            $string_day = $_POST['day'];
            $string_month = $_POST['month'];
            $string_year = $_POST['year'];
            $day = (int)$string_day;
            $month = (int)$string_month;
            $year = (int)$string_year;
            $time_display = "";
          }
          if(!str_contains($string_day, "NULL")){
            $query = "SELECT AVG(aqi) as aqi, HOUR(time) as time FROM tbl_data WHERE day(time) = $day 
                      AND month(time) = $month AND year(time) = $year GROUP BY HOUR(time)";
            $time_display = "AQI in Day: " . $string_day . "/" . $string_month . "/" . $string_year;
          }
          else if(!str_contains($string_month, "NULL")){
            $query = "SELECT AVG(aqi) as aqi, DAY(time) as time FROM tbl_data 
                        WHERE month(time) = $month AND year(time) = $year GROUP BY day(time)";
            $time_display = "AQI in Month: " .  $string_month . "/" . $string_year;
          }
          else{
            $query = "SELECT AVG(aqi) as aqi, MONTH(time) as time FROM tbl_data 
                        WHERE year(time) = $year GROUP BY year(time)";
            $time_display = "AQI in Year: " . $string_year;
          }
          $rs_result = mysqli_query ($con, $query); 
          $array_xValues = array();
          $array_yValues = array();
          $max_value = 0;
          while ($row = mysqli_fetch_array($rs_result)) { 
            array_push($array_xValues, $row["time"]);
            array_push($array_yValues, $row["aqi"]);
            if($max_value < $row["aqi"]){
              $max_value = $row["aqi"];
            }
          }
          $max_y = (int)($max_value / 100) + 1;
          $max_y = $max_y * 100;
        ?>

        <h1 class="title">Chart</h1>
        <h2 class="time_chart"><?php echo $time_display ?></h2>  
        <canvas id="myChart"></canvas>

        <script>

        var xValues = <?php echo json_encode($array_xValues); ?>;
        var yValues = <?php echo json_encode($array_yValues); ?>;

        new Chart("myChart", {
          type: "line",
          data: {
            labels: xValues,
            datasets: [{
              fill: false,
              lineTension: 0,
              pointRadius: 6,
              backgroundColor: "rgba(8,146,208,1)",
              borderColor: "rgba(8,146,208,0.2)",
              data: yValues
            }]
          },
          options: {
            legend: {display: false},
            scales: {
              yAxes: [{ticks: {min: 0, max:parseInt(<?php echo $max_y; ?>)}}],
            }
          }
        });
        </script>
          
        
        
      </div>
    </div>

    
  </body>
</html>

