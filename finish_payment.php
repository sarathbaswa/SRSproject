<?php
session_start();
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<html lang="en">
<head>
  <title>Payment</title>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="https://lh3.googleusercontent.com/-HtZivmahJYI/VUZKoVuFx3I/AAAAAAAAAcM/thmMtUUPjbA/Blue_square_A-3.PNG" />
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
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
      <h1>Payment Successful <br> <br><br> Thank You for booking. Have a Nice day!</h1>

<?php

include_once 'connection.php';

ini_set("display_errors", 1);

if (!isset($_SESSION["book_type"]) || isset($_SESSION["flight_amount"])){
  //echo "Pay in flights";
    $sql = mysqli_query($conn,"UPDATE booking
            SET is_paid = '1'
            WHERE user_name = '$user'");

      $sql1 ="select * from booking WHERE user_name = '$user'";
      $result = mysqli_query($conn,$sql1);
      $mileage = 0;
      while($row = mysqli_fetch_array($result)) {
        $fno = $row["flight_id"];
          $sql2 = "select distance from flights where flight_id = '$fno'";
          $result1 = mysqli_query($conn,$sql2);
          while($row1 = mysqli_fetch_array($result1)) {
             $mileage = $mileage + $row1["distance"];
          }
      }

      $mileage_update = mysqli_query($conn,"UPDATE customer
              SET mileage = '$mileage'
              WHERE username = '$user'");


    }

    if (isset($_SESSION["book_type"]) || isset($_SESSION["hotel_amount"])) {
      //echo "Pay in hotels";
      $sql = mysqli_query($conn,"UPDATE hotel_booking
              SET is_paid = '1'
              WHERE user_name = '$user'");
              unset($_SESSION["book_type"]);
    }


    if (isset($_SESSION["flight_amount"])) {
      unset($_SESSION["flight_amount"]);
    }

    if (isset($_SESSION["hotel_amount"])) {
      unset($_SESSION["hotel_amount"]);
    }
      mysqli_close($conn);
?>
    </div>
  </div>
</div>

</body>
</html>
