<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "db_airquality";
$con = mysqli_connect($servername, $username, $password, $database);
$sql_temp = mysqli_query($con, "SELECT temp FROM tbl_data ORDER BY time DESC LIMIT 1");
while($row_temp = mysqli_fetch_array($sql_temp)){
    $value = $row_temp['temp'];
}

// Output "no suggestion" if no hint was found or output correct values
echo $value;
?> 