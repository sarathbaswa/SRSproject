<?php
session_start();
 ?>
<!DOCTYPE html>
<html>
<html lang="en">
<head>
  <title>Two Way Flights</title>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="https://lh3.googleusercontent.com/-HtZivmahJYI/VUZKoVuFx3I/AAAAAAAAAcM/thmMtUUPjbA/Blue_square_A-3.PNG" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/index.css">
		<link rel="stylesheet" href="css/admin_login.css">
   <script src="script/unavailable.js"></script>
  	<link rel="stylesheet" href="css/navigate.css">
 </head>
<body>

  <ul class="nav-header">
	  <li class="link"><a href="index.php">Home</a></li>
	  <li class="link"><a href="hotels.php">Book Hotels</a></li>
	  <li class="link"><a href="feedback.php">Feedback</a></li>
		<?php
			if (isset($_SESSION["user"])) {
			?>
						<li class="link" style="float:right"><a class="lactive" href="logout.php">Logout</a></li>
						<li class="loggedin" style="float:right">Logged in as:<?php echo $_SESSION["user"] ?></li>
		<?php
	   }
		 else {
		?>
	  <li class="link" style="float:right"><a class="lactive" href="user_login.html">Login</a></li>
		<?php
		}
		?>
	</ul>
  <br> <br>

<!-- Actual page content starts here -->
<div class="container-fluid text-center">
  <div class="row content">
    <div class="col-sm-2 sidenav">

    </div>
    <div class="col-sm-8 text-left">
      <h1>Available Flights</h1>


<?php

include_once 'connection.php';
date_default_timezone_set("America/Chicago");

ini_set('display_errors', 1);

if (!$conn) {
    die('Could not connect: ' . mysqli_error($conn));
}


function process_input($value) {
   $value = trim($value);
   $value = stripslashes($value);
   $value = htmlspecialchars($value);
   return $value;
}


$start_loc = process_input($_POST["start_loc"]);
$to = process_input($_POST["end_loc"]);

$time_period = (int)process_input($_POST["time_period"]);
$price_range = process_input($_POST["price_range"]);

$today=date("Y-m-d");
$depart_date_val =strftime("%Y-%m-%d", strtotime("$today +5 day"));
$return = strftime("%Y-%m-%d", strtotime("$depart_date_val +$time_period day"));
//$depart_date_val = $_POST["depart_date"];
//$return = $_POST["return_date"];

$price_check = "";
if ($price_range == "1") {
  $price_check = " price  < 100 ";
}
else if ($price_range == "2") {
  $price_check = " price > 100 and price  <= 1000 ";;
}
else {
  $price_check = " price  > 1000 ";
}

$class = 'Economy';
$pass_count = $_POST["pass_count"];
$stop = 'nonstop';

global $availableCountValue,$sql,$sql2;

    $sql = "SELECT F.flight_id AS flight_id, company, type, dep_loc, dep_time, arr_loc, arr_time, FD.name AS class_name, capacity, price
            FROM flights F,  flight_details FD, flight_company FC , airstation A
            WHERE (F.flight_id = FD.flight_id) AND (F.airplane_id = FC.ID) AND FD.name = '$class' AND
            ((dep_loc = '$start_loc') AND (arr_loc = '$to')) AND $price_check
            GROUP BY F.flight_id
            ORDER BY F.flight_id";
        //    echo "<br>".$sql;
    $result = mysqli_query($conn,$sql);
      $result_count1 = 0;
      $result_count2 = 0;

      while($r = mysqli_fetch_array($result)) {
        $result_count1 =  $result_count1 + 1;
      }
      $result = mysqli_query($conn,$sql);
    $sql2 = "SELECT F.flight_id AS flight_id, company, type, dep_loc, dep_time, arr_loc, arr_time, FD.name AS class_name, capacity, price
            FROM flights F,  flight_details FD, flight_company FC , airstation A
            WHERE (F.flight_id = FD.flight_id) AND (F.airplane_id = FC.ID) AND FD.name = '$class' AND
            ((dep_loc = '$to') AND (arr_loc = '$start_loc')) AND $price_check
            GROUP BY F.flight_id
            ORDER BY F.flight_id";
      //     echo "<br>".$sql2;
    $result_query2 = mysqli_query($conn,$sql2);

    while($r = mysqli_fetch_array($result_query2)) {
      $result_count2 =  $result_count2 + 1;
    }
    $result_query2 = mysqli_query($conn,$sql2);

    $total_results = $result_count1 * $result_count2;

  //  echo "<br> Result1 ".$result_count1;
  //  echo "<br> Result2 ".$result_count2;


    if($total_results == 0){
        echo "<div class='alert alert-info'><strong>Search Result: </strong>".$total_results." result</div>";
    }
    else{

    echo "<div class='alert alert-info'><strong>Search Result: </strong>".$total_results." result(s)</div>";

    echo "<table class='table table-bordered table-striped table-hover'>
          <thead>
          <tr>
            <th>Flight</th>
            <th>Company</th>
            <th>Date</th>
            <th>Start Location</th>
            <th>Departure Time</th>
            <th>End Location</th>
            <th>Arrival Time</th>
            <th>Rem. Seats</th>
            <th>Req. Seats</th>
            <th>Amount($)</th>
            <th>Action</th>
          </tr>
          </thead>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tbody>";

            $allotedQuery = "SELECT flight_id,  COUNT(*)
                        FROM booking B
                        WHERE B.book_date = '".$depart_date_val."' AND B.flight_id = '".$row['flight_id']."' AND is_paid=1
                        GROUP BY flight_id";
            $reserved_query = mysqli_query($conn, $allotedQuery);
            $alloted_result = mysqli_fetch_array($reserved_query);

            $capacity = mysqli_query($conn, "SELECT capacity FROM flight_details FD WHERE FD.flight_id='".$row['flight_id']."'");
            $fetch_capacity_array = mysqli_fetch_array($capacity);


            if(mysqli_num_rows($reserved_query)>0){
                $availableCountValue = $fetch_capacity_array['capacity'] - $alloted_result['COUNT(*)'];
            }else{
                $availableCountValue = $fetch_capacity_array['capacity'];
            }


    $result_query2 = mysqli_query($conn,$sql2);
    $result_count2 = mysqli_num_rows($result_query2);

    if($result_count2>0){
        while($row2 = mysqli_fetch_array($result_query2)){

        echo "<tr>";
        echo "<td>" . $row['flight_id'] . "</td>";
        echo "<td>" . $row['company']." ".$row['type']. "</td>";
        echo "<td>" . $depart_date_val . "</td>";
        echo "<td>" . $row['dep_loc'] . "</td>";
        echo "<td>" . $row['dep_time'] . "</td>";
        echo "<td>" . $row['arr_loc'] . "</td>";
        echo "<td>" . $row['arr_time'] . "</td>";
        echo "<td>".$availableCountValue."</td>";
        echo "<td>" . $pass_count . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>" . $row2['flight_id'] . "</td>";
        echo "<td>" . $row2['company']." ".$row2['type']. "</td>";
        echo "<td>" . $return . "</td>";
        echo "<td>" . $row2['dep_loc'] . "</td>";
        echo "<td>" . $row2['dep_time'] . "</td>";
        echo "<td>" . $row2['arr_loc'] . "</td>";
        echo "<td>" . $row2['arr_time'] . "</td>";
            $allotedQuery4 = "SELECT flight_id, class_type, COUNT(*)
                        FROM booking B
                        WHERE B.book_date = '".$return."' AND B.flight_id = '".$row2['flight_id']."'AND B.class_type ='".$row2['class_name']."' AND is_paid=1
                        GROUP BY flight_id, class_type";
            $reserved_query4 = mysqli_query($conn, $allotedQuery4);
            $alloted_result4 = mysqli_fetch_array($reserved_query4);

            $capacity4 = mysqli_query($conn, "SELECT capacity FROM flight_details FD WHERE FD.flight_id='".$row2['flight_id']."' AND FD.name= '".$row2['class_name']."'");
            $fetch_capacity_array4 = mysqli_fetch_array($capacity4);
            if(mysqli_num_rows($reserved_query4)>0){
                $ticketsAvailable_return = $fetch_capacity_array4['capacity'] - $alloted_result4['COUNT(*)'];
            }else{
                $ticketsAvailable_return = $fetch_capacity_array4['capacity'];
            }

            echo "<td>".$ticketsAvailable_return."</td>";
            echo "<td>" . $pass_count . "</td>";
            echo "<td>" . $row2['price'] . "</td>";

        if($pass_count<=$availableCountValue && $pass_count<=$ticketsAvailable_return){
        echo '<td>
            <form action="passengers.php" method="post">
            <input type="hidden" name="flight_id_1" value="'.$row['flight_id'].'">
            <input type="hidden" name="pass_count" value="'.$pass_count.'">
            <input type="hidden" name="price" value="'.$row['price'].'">
            <input type="hidden" name="date" value="'.$depart_date_val.'">
            <input type="hidden" name="flight_id_2" value="'.$row2['flight_id'].'">
            <input type="hidden" name="price2" value="'.$row2['price'].'">
            <input type="hidden" name="date2" value="'.$return.'">
            <input type="hidden" name="type" value="twoway">
            <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
            </td>';
        }else{
            echo "<td><button type='button' class='btn btn-warning' onclick='alert_not_available()'>UnAvailable</button></td>";
        }
        echo "</tr>";
    }

    }
    }
    echo " </tbody></table>";
  }

//mysqli_free_result($result);

mysqli_close($conn);
?>


    </div>

  </div>
</div>
</body>
</html>
