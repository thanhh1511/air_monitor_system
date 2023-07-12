<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "db_airquality";
$con = mysqli_connect($servername, $username, $password, $database);
$sql_aqi = mysqli_query($con, "SELECT aqi FROM tbl_data ORDER BY time DESC LIMIT 1");
while($row_aqi = mysqli_fetch_array($sql_aqi)){
    $value = $row_aqi['aqi'];
}

// Output "no suggestion" if no hint was found or output correct values
echo $value;
?> 