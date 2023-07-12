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
      <div class="content_history"> 
    <?php  
      
    // Import the file where we defined the connection to Database.     
        require_once "connection.php";
         
        $per_page_record = 10;  // Number of entries to show in a page.   
        // Look for a GET variable page if not found default is 1.        
        if (isset($_GET['page'])) {    
            $page  = $_GET['page'];    
        }    
        else {    
          $page=1;    
        }    
    
        $start_from = ($page-1) * $per_page_record;    
        
        if(isset($_POST['type_history'])){
          $time = $_POST['time'];
          if(strcmp($time, "day") == 0){
            $query = "SELECT AVG(aqi) as aqi, AVG(temp) as temp, day(time) as day,month(time) as month, year(time) as year FROM tbl_data 
            GROUP BY day(time), month(time), year(time) ORDER BY year(time) ASC, month(time) ASC, day(time) ASC
            LIMIT $start_from, $per_page_record; ";
            $query_page = "SELECT AVG(aqi) as aqi, AVG(temp) as temp, day(time) as day,month(time) as month, year(time) as year FROM tbl_data 
            GROUP BY day(time), month(time), year(time) ORDER BY year(time) ASC, month(time) ASC, day(time) ASC; ";                    
          }
          else if(strcmp($time, "month") == 0){
            $query = "SELECT AVG(aqi) as aqi, AVG(temp) as temp, month(time) as month, year(time) as year FROM tbl_data 
            GROUP BY month(time), year(time) ORDER BY year(time) ASC, month(time) ASC
            LIMIT $start_from, $per_page_record; ";
            $query_page = "SELECT AVG(aqi) as aqi, AVG(temp) as temp, month(time) as month, year(time) as year FROM tbl_data 
            GROUP BY month(time), year(time) ORDER BY year(time) ASC, month(time) ASC; ";
          }
          else if(strcmp($time, "year") == 0){
            $query = "SELECT AVG(aqi) as aqi, AVG(temp) as temp, year(time) as year FROM tbl_data 
            GROUP BY year(time)
            LIMIT $start_from, $per_page_record; ";
            $query_page = "SELECT AVG(aqi) as aqi, AVG(temp) as temp, year(time) as year FROM tbl_data GROUP BY year(time); ";  
          }
          else{
            $query = "SELECT AVG(aqi) as aqi, AVG(temp) as temp, day(time) as day,month(time) as month, year(time) as year FROM tbl_data 
            GROUP BY day(time), month(time), year(time) ORDER BY year(time) ASC, month(time) ASC, day(time) ASC
            LIMIT $start_from, $per_page_record; ";
            $query_page = "SELECT AVG(aqi) as aqi, AVG(temp) as temp, day(time) as day,month(time) as month, year(time) as year FROM tbl_data 
            GROUP BY day(time), month(time), year(time) ORDER BY year(time) ASC, month(time) ASC, day(time) ASC; ";      
          }
        }
        else{
          $query = "SELECT AVG(aqi) as aqi, AVG(temp) as temp, day(time) as day,month(time) as month, year(time) as year FROM tbl_data 
            GROUP BY day(time), month(time), year(time) ORDER BY year(time) ASC, month(time) ASC, day(time) ASC
            LIMIT $start_from, $per_page_record; ";
            $query_page = "SELECT AVG(aqi) as aqi, AVG(temp) as temp, day(time) as day,month(time) as month, year(time) as year FROM tbl_data 
            GROUP BY day(time), month(time), year(time) ORDER BY year(time) ASC, month(time) ASC, day(time) ASC; ";      
        }
        $rs_result_title = mysqli_query ($con, $query);
        $rs_result_page = mysqli_query ($con, $query_page); 
        $rs_result = mysqli_query ($con, $query); 
        
        
    ?>    
  
    <div class="container">   
      <br>   
      <div>   
        <h1 class="title">Historical</h1>
        <form action="./history.php" method="POST">
          <label style="color: white;">Choose a type time</label>
          <select  name="time">
            <option value="day">Day</option>
            <option value="month">Month</option>
            <option value="year">Year</option>
          </select>
          <input type="submit" value="Choose" name="type_history">
        </form>      
        <table class="history_table">   
          <thead>   
            <tr>
              <?php     
              while ($row = mysqli_fetch_array($rs_result_title)) {    
                    // Display each field of the records.    
                if(isset($row["day"])){
                  echo "<th>" . "Day". "</th>"; 
                }
                if(isset($row["month"])){
                  echo "<th>" . "Month" . "</th>"; 
                }
                if(isset($row["year"])){
                  echo "<th>" . "Year" . "</th>"; 
                }
                break;
              };
              ?>
              <th>Air Quality Index</th>  
              <th>Temperature</th>
              <th>Show Chart</th>    
            </tr>   
          </thead>   
          <tbody>   
            <?php
            $count = 0; 
            while ($row = mysqli_fetch_array($rs_result_page)) {    
              // Display each field of the records.  
              $count++;  
            }    
            while ($row = mysqli_fetch_array($rs_result)) {    
                  // Display each field of the records.   
            ?>     
            <tr>
            <?php       
                if(isset($row["day"])){
                  echo "<td>" . $row["day"] . "</td>";
                }
                if(isset($row["month"])){
                  echo "<td>" . $row["month"] . "</td>";
                }
                if(isset($row["year"])){
                  echo "<td>" . $row["year"] . "</td>";
                }
              ?>     
             <td><?php echo $row["aqi"]; ?></td> 
             <td><?php echo $row["temp"]; ?></td>
              
             <td>
              <form action="./chart.php" method="post">
                <input type="hidden" name="day" value="
                <?php       
                if(isset($row["day"])){
                  echo $row["day"];
                }
                else{
                  echo "NULL";
                }
                ?>
                ">
                <input type="hidden" name="month" value="
                <?php       
                if(isset($row["month"])){
                  echo $row["month"];
                }
                else{
                  echo "NULL";
                }
                ?>
                ">
                <input type="hidden" name="year" value="
                <?php       
                if(isset($row["year"])){
                  echo $row["year"];
                }
                else{
                  echo "NULL";
                }
                ?>
                ">
                <input type="submit" value="View" name="view_chart">
              </form>  
            </td>                                                  
            </tr>     
            <?php     
                };    
            ?>     
          </tbody>   
        </table>   
  
     <div class="pagination">    
      <?php  
        // $query = "SELECT COUNT(*) FROM tbl_data";     
        // $rs_result = mysqli_query($con, $query);     
        // $row = mysqli_fetch_row($rs_result);     
        $total_records = $count;     
          
    echo "</br>";     
        // Number of pages required.   
        $total_pages = ceil($total_records / $per_page_record);     
        $pagLink = "";       
      
        if($page>=2){   
            echo "<a href='history.php?page=".($page-1)."'>  Prev </a>";   
        }       
                   
        for ($i=1; $i<=$total_pages; $i++) {   
          if ($i == $page) {   
              $pagLink .= "<a class = 'active' href='history.php?page="  
                                                .$i."'>".$i." </a>";   
          }               
          else  {   
              $pagLink .= "<a href='history.php?page=".$i."'>   
                                                ".$i." </a>";     
          }   
        };     
        echo $pagLink;   
  
        if($page<$total_pages){   
            echo "<a href='history.php?page=".($page+1)."'>  Next </a>";   
        }   
  
      ?>    
      </div>  
  
  
      <div class="inline">   
      <input id="page" type="number" min="1" max="<?php echo $total_pages?>"   
      placeholder="<?php echo $page."/".$total_pages; ?>" required>   
      <button onClick="go2Page();">Go</button>   
     </div>    
    </div>   
  </div>  
  <script>   
    function go2Page()   
    {   
        var page = document.getElementById("page").value;   
        page = ((page><?php echo $total_pages; ?>)?<?php echo $total_pages; ?>:((page<1)?1:page));   
        window.location.href = 'history.php?page='+page;   
    }   
  </script>  
          
        
        
      </div>
    </div>

    
  </body>
</html>

