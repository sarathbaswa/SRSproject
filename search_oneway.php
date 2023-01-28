<?php
session_start();
 ?>
<!DOCTYPE html>
<html>
<html lang="en">
<head>
  <title>One Way Flights</title>
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
    <h1>Search Results</h1>
    <form action="search_oneway.php" method="post">
    <div class="row">
			  <div class="col-sm-6">
			    <label for="class">Filter By:</label>
			    <select class="form-control" name="order_by">
			      <option value="flight_id">Flight Number</option>
			      <option value="price">Price</option>
			    </select>
          <br>
          <br>
          <select class="form-control" name="order_type">
			      <option value="asc">low to high</option>
			      <option value="desc">high to low</option>
			    </select>
			  </div>
		</div>
    <input type="hidden" name="start_loc" value="<?php echo $_SESSION['start_loc'] ?>">
    <input type="hidden" name="to" value="<?php echo $_SESSION['to'] ?>">
    <input type="hidden" name="depart" value="<?php echo $_SESSION['depart_date'] ?>">
    <input type="hidden" name="pass_count" value="<?php echo $_SESSION['pass_count'] ?>">
    <br>
    <button type="submit" class="btn btn-primary">Filter</button>
  </form>

<?php

include_once 'connection.php';

ini_set('display_errors', 1);

function process_input($value) {
   $value = trim($value);
   $value = stripslashes($value);
   $value = htmlspecialchars($value);
   return $value;
}

$order_by = $_POST["order_by"];
$order_type = $_POST["order_type"];

$start_location = process_input($_POST["start_loc"]);
$end_location = process_input($_POST["end_loc"]);
$depart_date = $_POST["depart_date"];
$class = 'Economy';
$pass_count = $_POST["pass_count"];
$stop = 'nonstop';


if ($start_location != "") {
      $_SESSION["start_loc"] = $start_location;
      $_SESSION["end_loc"] = $end_location;
      $_SESSION["depart_date"] = $depart_date;
      $_SESSION["pass_count"] = $pass_count;
}
else{
  $start_location = process_input($_SESSION["start_loc"]);
  $end_location = process_input($_SESSION["end_loc"]);
  $depart_date = $_SESSION["depart_date"];
  $pass_count = (int)$_SESSION["pass_count"];
  unset($_SESSION['start_loc']);
}

global $result, $sql1,$sql2,$ticketsAvailable;

    $sql1 = "SELECT F.flight_id AS flight_id, company, type, dep_loc,
           dep_time, arr_loc, arr_time, FD.name AS class_name, capacity, price, COUNT(*)
            FROM flights F,  flight_details FD, flight_company FC , airstation A
            WHERE (F.flight_id = FD.flight_id) AND (F.airplane_id = FC.ID) AND FD.name = '$class' AND
           ((((city_name LIKE '%$start_location%') AND (code_name = dep_loc)) OR  ((city_name LIKE '%$end_location%') AND (code_name = arr_loc)))
           OR (((dep_loc LIKE '%$start_location%') AND (arr_loc LIKE '%$end_location%'))) )
            GROUP BY F.flight_id
            HAVING COUNT(*)>1
            ORDER BY ".$order_by." ".$order_type;
    //echo $sql1;
    $result = mysqli_query($conn,$sql1);

    if(mysqli_num_rows($result))
      { $result = mysqli_query($conn,$sql1);}
    else{
      $sql2 = "SELECT F.flight_id AS flight_id, company, type, dep_loc, dep_time, arr_loc, arr_time, FD.name AS class_name, capacity, price
            FROM flights F,  flight_details FD, flight_company FC , airstation A
            WHERE (F.flight_id = FD.flight_id) AND (F.airplane_id = FC.ID)  AND FD.name = '$class' AND
           ((((city_name LIKE '%$start_location%') AND (code_name = dep_loc)) AND (arr_loc LIKE '%$end_location%'))
           OR ((dep_loc LIKE '%$start_location%') AND ((city_name LIKE '%$end_location%') AND (code_name = arr_loc)))  )
            GROUP BY F.flight_id
            ORDER BY ".$order_by." ".$order_type;;
      $result = mysqli_query($conn,$sql2);
    }

    $rowcount = mysqli_num_rows($result);

    if($rowcount == 0){
        echo "<div class='alert alert-info'><strong>Search Results: </strong>".$rowcount." result</div>";
    }
    else{
    echo "<div class='alert alert-info'><strong>Search Results: </strong>".$rowcount." result(s)</div>";

    echo "<table class='table table-bordered table-striped table-hover'>
          <thead>
          <tr>
            <th>Flight</th>
            <th>Flight Company</th>
            <th>Date</th>
            <th>Start Location</th>
            <th>Departure Time</th>
            <th>End Location</th>
            <th>Arrival Time</th>
            <th>Remaining Seats</th>
            <th>Requested Seats</th>
            <th>Amount</th>
            <th>Action</th>
          </tr>
          </thead>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tbody><tr>";
        echo "<td>" . $row['flight_id'] . "</td>";
        echo "<td>" . $row['company']." ".$row['type']. "</td>";
        echo "<td>" . $depart_date . "</td>";
        echo "<td>" . $row['dep_loc'] . "</td>";
        echo "<td>" . $row['dep_time'] . "</td>";
        echo "<td>" . $row['arr_loc'] . "</td>";
        echo "<td>" . $row['arr_time'] . "</td>";

            $alloted_query = "SELECT flight_id, class_type, COUNT(*)
                        FROM booking B
                        WHERE B.book_date = '".$depart_date."' AND B.flight_id = '".$row['flight_id']."' AND is_paid=1
                        GROUP BY flight_id, class_type";
            $alloted_query_result = mysqli_query($conn, $alloted_query);
            $alloted_query_resultNumber = mysqli_fetch_array($alloted_query_result);

            $capacity = mysqli_query($conn, "SELECT capacity FROM flight_details FD WHERE FD.flight_id='".$row['flight_id']."'");
            $fetch_capacity_array = mysqli_fetch_array($capacity);


            if(mysqli_num_rows($alloted_query_result)>0){
                $ticketsAvailable = $fetch_capacity_array['capacity'] - $alloted_query_resultNumber['COUNT(*)'];
            }else{
                $ticketsAvailable = $fetch_capacity_array['capacity'];
            }

            echo "<td>".$ticketsAvailable."</td>";
            echo "<td>".$pass_count."</td>";
            echo "<td>" . $row['price'] . "</td>";
            $final_price = $pass_count * $row['price'];

        if($pass_count <=$ticketsAvailable){
        echo '<td>
            <form action="passengers.php" method="post">
            <input type="hidden" name="pass_count" value="'.$pass_count.'">
            <input type="hidden" name="price" value="'.$row['price'].'">
            <input type="hidden" name="flight_id" value="'.$row['flight_id'].'">
            <input type="hidden" name="date" value="'.$depart_date.'">
            <input type="hidden" name="type" value="oneway">
            <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
            </td>';
        }else{
            echo "<td><button type='button' class='btn btn-warning' onclick='check_not_available()'>Unavailable</button></td>";
        }

        echo "</tr>";
    }
    echo " </tbody></table>";

    }

  //}

mysqli_close($conn);
?>
    </div>

  </div>
</div>


</body>
</html>
