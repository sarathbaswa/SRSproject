<?php
session_start();
 ?>
﻿<!DOCTYPE html>
<html>
<html lang="en">
<head>
  <title>Find Best Deals</title>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="https://lh3.googleusercontent.com/-HtZivmahJYI/VUZKoVuFx3I/AAAAAAAAAcM/thmMtUUPjbA/Blue_square_A-3.PNG" />
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/admin_login.css">
  	<link rel="stylesheet" href="css/navigate.css">
    <script src="unavailable.js"></script>
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
      <h1>Best Deal Results</h1>

<?php
include_once 'connection.php';
ini_set('display_errors', 1);

$sch_date = $_POST["src_loc"];
$sch_date = $_POST["dest_loc"];
$sch_date = $_POST["price_range"];
$sch_date = $_POST["time_period"];
$pass_count = $_POST["pass_count"];

global $deals_sql, $tickectsAvailable;

$deals_sql = "SELECT *
            FROM flights F,  flight_details FD, flight_company FC
            WHERE (F.flight_id = FD.flight_id) AND (F.airplane_id = FC.ID)

            ORDER BY F.flight_id";


$deals_result = mysqli_query($conn,$deals_sql);
$deals_count = mysqli_num_rows($deals_result);


if($deals_count == 0){
    echo "<div class='alert alert-info'><strong>Search Results: </strong>".$deals_count." result</div>";
}
else{
echo "<div class='alert alert-info'><strong>Search Results: </strong>".$deals_count." results</div>";

echo "<table class='table table-bordered table-striped table-hover'>
      <thead>
      <tr>
        <th>FlightId</th>
        <th>FlightName</th>
        <th>Date</th>
        <th>Start</th>
        <th>StartTime</th>
        <th>End</th>
        <th>EndTime</th>
        <th>Rem. Seats</th>
        <th>Req. Seats</th>
        <th>Amount($)</th>
        <th>Action</th>
      </tr>
      </thead>";
    while($row = mysqli_fetch_array($deals_result)) {
        echo "<tbody><tr>";
        echo "<td>" . $row['flight_id'] . "</td>";
        echo "<td>" . $row['company']." ".$row['type']. "</td>";
        echo "<td>" . $sch_date . "</td>";
        echo "<td>" . $row['dep_loc'] . "</td>";
        echo "<td>" . $row['dep_time'] . "</td>";
        echo "<td>" . $row['arr_loc'] . "</td>";
        echo "<td>" . $row['arr_time'] . "</td>";
        $sql_alloted = "SELECT flight_id, class_type, COUNT(*)
                    FROM booking B
                    WHERE B.book_date = '".$sch_date."' AND B.flight_id = '".$row['flight_id']."' AND is_paid=1
                    GROUP BY flight_id, class_type";
        $sql_alloted_res = mysqli_query($conn, $sql_alloted);
        $sql_alloted_resNumber = mysqli_fetch_array($sql_alloted_res);

        $sql_capacity = mysqli_query($conn, "SELECT capacity FROM flight_details FD WHERE FD.flight_id='".$row['flight_id']."'");
        $finalCount = mysqli_fetch_array($sql_capacity);


        if(mysqli_num_rows($sql_alloted_res)>0){
            $tickectsAvailable = $finalCount['capacity'] - $sql_alloted_resNumber['COUNT(*)'];
        }else{
            $tickectsAvailable = $finalCount['capacity'];
        }

        echo "<td>".$tickectsAvailable."</td>";
        echo "<td>".$pass_count."</td>";
        echo "<td>" . $row['price'] . "</td>";

    if($pass_count <= $tickectsAvailable){
    echo '<td>
        <form action="review_cart.php" method="post">
        <input type="hidden" name="date" value="'.$sch_date.'">
        <input type="hidden" name="type" value="deals">
        <input type="hidden" name="flight_id" value="'.$row['flight_id'].'">
        <input type="hidden" name="pass_count" value="'.$pass_count.'">
        <input type="hidden" name="price" value="'.$row['price'].'">
        <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>
        </td>';
    }else{
        echo "<td><button type='button' class='btn btn-warning' onclick='alert_not_available()'>Unavailable</button></td>";
    }

    echo "</tr>";
}
echo " </tbody></table>";

}
mysqli_close($conn);
?>
    </div>
  </div>
</div>

</body>
</html>
