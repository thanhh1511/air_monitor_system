<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_airquality";

// Create connection
$con = mysqli_connect($servername, $username, $password, $database);
?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Personal Portfolio Website</title>
    <!----CSS link----->
    <link rel="stylesheet" href="style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="config.js"></script>
  </head>
  <body onload="startTime()">
    <div class="hero">
      <nav>
      

        
        <ul>
        <li><a href="./index.php">Home</a></li>
          <li><a href="./history.php">History</a></li>

        </ul>
        <i class="fa fa-thermometer" id="icon_temp"></i>
        <h2 id="temp"></h2>
      </nav>
      <div class="content">
        <div class="column side" id="infor1">
            <h2 id="status"></h2>
            <p id="status_describe"></p>
        </div>
          
        <div class="column middle">
            <div class="chart">
                <h1 id="aqi"></h1>
                <p>AQI</p>
            </div>
            <div class="time">
                <h1 id="timeid"></h1>
            </div>
            
        </div>
          
        <div class="column side" id="infor2">
        <table>
          <tr>
            <th>Index</th>
            <th>Level of Concern</th>
          </tr>
          <tr>
            <td>Less than 50</td>
            <td>Good</td>
          </tr>
          <tr>
            <td>51 to 100</td>
            <td>Moderate</td>
          </tr>
          <tr>
            <td>101 to 150</td>
            <td>Unhealthy for Sensitive Groups</td>
          </tr>
          <tr>
            <td>151 to 200</td>
            <td>Unhealthy</td>
          </tr>
          <tr>
            <td>201 to 300</td>
            <td>Very Unhealthy</td>
          </tr>
          <tr>
            <td>Higher</td>
            <td>Hazardous</td>
          </tr>
        </table>
        </div>
      </div>
    </div>

    
  </body>
</html>

