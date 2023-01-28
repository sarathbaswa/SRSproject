<?php
// Start the session
session_start();
ini_set("display_errors", 1);
?>


<!DOCTYPE html>
<html>
<html lang="en">
<head>
  <title>CheckOut cart</title>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="https://lh3.googleusercontent.com/-HtZivmahJYI/VUZKoVuFx3I/AAAAAAAAAcM/thmMtUUPjbA/Blue_square_A-3.PNG" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/admin_login.css">
    <script src="script/navigate.js"> </script>
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
      <h1>Check Out Cart</h1>

<?php

include_once 'connection.php';

ini_set('display_errors', 1);

if(!isset($_SESSION['user'])){
    header("Location: user_login.html");
}else{
    $user = $_SESSION['user'];

    $redeem_sql = mysqli_query($conn,"SELECT redeem, mileage
							            FROM customer WHERE username = '$user'");

      $available = 0;
		  while($row = mysqli_fetch_array($redeem_sql)) {
        $mileage = $row["mileage"];
        $redeem = $row["redeem"];
        $available = $mileage - $redeem;
      }
      $dcount =0;
      $rcount1 =0;


      if ($available >= 25000) {

        $dcount = (int)($available / 25000);
        $rcount1 = $dcount * 25000;


      }
      $icount =0;
      $rcount2 =0;
      if ($available >= 50000) {

        $icount = (int)($available / 50000);
        $rcount2 = $icount * 50000;

      }


  //    echo "Reedeamle dom flight count ".$dcount;
  //    echo "Reedeamle int flight count ".$icount;
$sql = "SELECT F.flight_id AS flight_id, company, type, B.ID AS book_id, book_time, B.book_date,  dep_loc,
          dep_time,pname, arr_loc, arr_time, FD.name AS class_name, capacity, price, F.flight_type as fltype
            FROM flights F,  flight_details FD, flight_company FC , booking B
            WHERE (F.flight_id = FD.flight_id) AND (B.flight_id = FD.flight_id)  AND (F.airplane_id = FC.ID)
            AND  B.user_name = '$user' AND is_paid = '0'
            ORDER BY book_time";


$result = mysqli_query($conn,$sql);
$rowcount = mysqli_num_rows($result);
$booked_i_flights = 0;
$booked_d_flights = 0;
$booked_i_flights_price = 0;
$booked_d_flights_price = 0;

    if($rowcount == 0){
        echo "<div class='alert alert-info'><strong>Empty Cart.</strong></div>";
    }
    else{

    echo "<div class='alert alert-info'>Cart Details:</div>";

    echo "<table class='table table-bordered table-striped table-hover'>
          <thead>
          <tr>
           <th>Passenger</th>
            <th>Time</th>
            <th>FlightId</th>
            <th>Date</th>
            <th>Start Location</th>
            <th>Departure Time</th>
            <th>End Location</th>
            <th>Arrival Time</th>
            <th>Amount</th>
            <th>Action</th>
          </tr>
          </thead>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tbody><tr>";
        echo "<td>" . $row['pname'] . "</td>";
        echo "<td>" . $row['book_time'] . "</td>";
        echo "<td>" . $row['flight_id'] . "</td>";
        echo "<td>" . $row['book_date'] . "</td>";
        echo "<td>" . $row['dep_loc'] . "</td>";
        echo "<td>" . $row['dep_time'] . "</td>";
        echo "<td>" . $row['arr_loc'] . "</td>";
        echo "<td>" . $row['arr_time'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";

        if ($row['fltype'] == "domestic" ) {
          if ($dcount > 0) {
            $booked_d_flights++;
            $booked_d_flights_price += $row["price"] ;
            $dcount--;
          }

          //echo "<br> d count ".$dcount;
        }
        else{

          if ($icount > 0) {
            $booked_i_flights++;
            $booked_i_flights_price += $row["price"] ;
            $icount--;
          }

        }

            //calculate number of remain seats
            $alloted_query = "SELECT flight_id, COUNT(*)
                        FROM booking B
                        WHERE B.book_date = '".$row['book_date']."' AND B.flight_id = '".$row['flight_id']."' AND is_paid=1
                        GROUP BY flight_id";
            $alloted_query_result = mysqli_query($conn, $alloted_query);
            $alloted_query_resultNumber = mysqli_fetch_array($alloted_query_result);

            $capacity = mysqli_query($conn, "SELECT capacity FROM flight_details FD WHERE FD.flight_id ='".$row['flight_id']."'");
            $capacity_result_array = mysqli_fetch_array($capacity);

            if(mysqli_num_rows($alloted_query_result)>0){
                $avalCount = $capacity_result_array['capacity'] - $alloted_query_resultNumber['COUNT(*)'];
            }else{
                $avalCount = $capacity_result_array['capacity'];
            }

        if($avalCount>0){
        echo '<td>
            <form action="delete_cart.php" method="post">
            <input type="hidden" name="book_id" value="'.$row['book_id'].'" >
            <button type="submit" class="btn btn-danger">Delete</button></div>
            </form>
            </td>';
        }else{
            echo "<td><button type='button' class='btn btn-warning' onclick='alert_not_available()'>Tickets not available</button></td>";
        }

		$sum = mysqli_query($conn,"SELECT SUM(price)
							            FROM booking B, flight_details FD
							            WHERE B.user_name = '$user' AND is_paid = '0'
							             AND B.flight_id = FD.flight_id");

		$t = mysqli_fetch_array($sum);
		$gross_total = $t['SUM(price)'];


    $tax_price = $gross_total * 0.15;
    $total = $gross_total + $tax_price;

        echo "</tr>";
    }


    if ($booked_i_flights > 0) {

      $rvalue = $booked_i_flights * 50000;

      echo " <br><form action='redeem.php' method='post'>";
      echo '<input type="hidden" name="rcount" value="'.$rvalue.'" >';
      echo '<input type="hidden" name="iprice" value="'.$booked_i_flights_price.'" >';
      echo "<div class='row'>
          <div class='col-sm-4'><p class='lead'>You are eligible to redeem for <span id='bicount'>".$booked_i_flights."</span>  international tickets</p></div>
          <div class='col-sm-4'><button type='submit' class='btn btn-primary'>Apply redeem</button></div>
        </div>";
        echo "</form <br>";

    }

    if ($booked_d_flights > 0) {

      $rvalue = $booked_d_flights * 25000;
      //echo "Reedemable points ". $rvalue;
      echo " <br><form action='redeem.php' method='post'>";
      echo '<input type="hidden" name="dprice" value="'.$booked_d_flights_price.'" >';
      echo '<input type="hidden" name="rcount" value="'.$rvalue.'" >';
      echo "<div class='row'>
          <div class='col-sm-4'><p class='lead'>You are eligible to redeem for <span id='dicount'>".$booked_d_flights."</span>  domestic tickets</p></div>
          <div class='col-sm-4'><button type='submit' class='btn btn-primary'>Apply redeem</button></div>
        </div>";
        echo "</form <br>";

    }

    //echo " Redeem dom price ".$_SESSION["redeem_d_price"];
    //echo " Redeem int price ".$_SESSION["redeem_i_price"];
    if (isset($_SESSION["redeem_d_price"])) {
      $gross_total = $gross_total -  (int)$_SESSION["redeem_d_price"];
      $_SESSION["redeem_d_price"] = "";
    }

    if (isset($_SESSION["redeem_i_price"])) {
      $gross_total = $gross_total - (int)$_SESSION["redeem_i_price"];
      $_SESSION["redeem_i_price"] = "";
    }

    $tax_price = $gross_total * 0.15;
    $total = $gross_total + $tax_price;

    echo " </tbody></table>";
    echo " <form action='credit_card.php' method='post'>";



    echo "<div class='row'>
			  <div class='col-sm-4'><p class='lead'>Gross Total: <span id='gtotal'>$".$gross_total."</span></p></div>
        <div class='col-sm-4'><p class='lead'>Tax amount: <span id='tax'>$".$tax_price."</span></p></div>
        <div class='col-sm-4'><p class='lead'>Final Flight amount: <span id='total'>$".$total."</span></p></div>";
        if (isset($_SESSION["hotel_amount"])) {
          $total = $total + (int)$_SESSION["hotel_amount"];
          $total = $total - ($total *0.2);
          echo "<div class='col-sm-4'><p class='lead'>Final Hotel amount: <span id='total'>$".$_SESSION['hotel_amount']."</span></p></div>";
          echo "<div class='col-sm-4'><p class='lead'>Grand Total (20% discount): <span id='total'>$".$total."</span></p></div>";
        }
    echo "<div class='col-sm-4'><button type='submit' class='btn btn-primary'>Pay Now</button></div>
			</div>";

    echo "</form>";
    echo "<br>";
    echo "<br>";
      if (!isset($_SESSION["hotel_amount"])) {
        echo "<a class='bighref' href=hotels.php?flight_amount=",urlencode($total),">Book Hotels to avail extra discount</a>";
      }
    }
}

mysqli_close($conn);
?>
    </div>
  </div>
</div>

</body>
</html>
