<?php
	ini_set("display_errors", 1);
	session_start();
	if (isset($_GET["hotel_amount"])) {
		echo "set hotel amount ";
		$_SESSION["hotel_amount"] = $_GET["hotel_amount"];
	}
	include_once 'mileage.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Flights and Hotels Booking</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="https://lh3.googleusercontent.com/-HtZivmahJYI/VUZKoVuFx3I/AAAAAAAAAcM/thmMtUUPjbA/Blue_square_A-3.PNG" />
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
		<link rel="stylesheet" href="css/navigate.css">

    <script src="script/navigate.js"> </script>
</head>
<body>
	<background-image: "C:\xampp\htdocs\flight_booking">;
	<ul class="nav-header">
	  <li class="link"><a href="index.php">Home</a></li>
	  <li class="link"><a href="hotels.php">Book Hotels</a></li>
	  <li class="link"><a href="feedback.php">Feedback</a></li>
		<li class="link"><a href="show_cart.php">View Cart</a></li>
		<?php
			if (isset($_SESSION["user"])) {
			?>
						<li class="link" style="float:right"><a class="lactive" href="logout.php">Logout</a></li>
						<li class="loggedin" style="float:right">Logged in as:<?php echo $_SESSION["user"] ?></li>
						<li class="mileage" style="float:right">Redeemable Mileage:<?php echo $available_mileage ?></li>
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
	<div class="container" id="contentdiv">
		<h1><b>Book Flights and Find Best Deals</b></h1>
		<br />
		<p><b></b></p>
		<div class="btn-group btn-group-justified">
			<div class="btn-group">
			<button id="but1" type="button" href="#status" class="btn btn-primary">Check Flight Status</button>
			</div>
			<div class="btn-group">
			<button id="but2" type="button" href="#onewaytrip" class="btn btn-primary">Book Flights</button>
			</div>
			<div class="btn-group">
			<button id="but3" type="button" href="#twowaytrip" class="btn btn-primary">Find Deals</button>
			</div>
		<!--	<div class="btn-group">
			<button id="but4" type="button" href="#finddeals" class="btn btn-primary">Find Deals</button>
		</div>-->
		</div>
		<hr />
		<div id="status">
			<form role="form" action="search_status.php" method="post">
				<?php

				if (isset($_SESSION["flstatus"])) {
						echo "<div class='alert alert-info'><strong>Flight Status: </strong>".$_SESSION["flstatus"]."</div>";
						$_SESSION["flstatus"] = "";
				}

				?>
			  <div class="row">
			  <div class="col-sm-6">
			    <label for="flnum">Fligt Number:</label>
			    <input type="text" class="form-control" id="flnum" name="flnum"  required>
			  </div>
			  <div class="col-sm-6">
			    <label for="alname">Flight Name: </label>
			    <input type="text" class="form-control" id="alname" name="alname" required>
			  </div>
			  </div>
			  <hr >
			  <div class="row">
				  <div class="col-sm-6">
				    <label for="st_date">Departure date:</label>
				    <input type="date" class="form-control" id="st_date" name="st_date" required>
				  </div>
			  </div>

			  <br>
			  <br>

				<div class="btn-group btn-group-justified">
					<div class="btn-group">
						<button type="submit" class="btn btn-success">Check Status</button>
					</div>
					<div class="btn-group">
						<button type="reset"  class="btn btn-info" value="Reset">Clear All</button>
					</div>
			  </div>
			</form>
		</div>

	<div id="onewaytrip">
		<form role="form" action="search_oneway.php" method="post">
		  <div class="row">
		  <div class="col-sm-6">
		    <label for="from">Start:</label>
		    <input type="text" class="form-control" id="start_loc" name="start_loc"  required>
		  </div>
		  <div class="col-sm-6">
		    <label for="to">Destination:</label>
		    <input type="text" class="form-control" id="end_loc" name="end_loc" required>
		  </div>
		  </div>
		  <hr >
		  <div class="row">
			  <div class="col-sm-6">
			    <label for="depart_date">Departure Date:</label>
			    <input type="date" class="form-control" id="depart_date" name="depart_date" required>
			  </div>
		  </div>
		   <div class="row">
		   <hr >
		  <div class="col-sm-6">
		    <label for="pass_count">Passengers:</label>
		    <input type="text" class="form-control" id="pass_count" name="pass_count" required>
		  </div>
		  </div>
		  <br>
		  <br>
			<input type="hidden" name="order_by" value="flight_id">
			<input type="hidden" name="order_type" value="asc">
		  <div class="btn-group btn-group-justified">
				<div class="btn-group">
					<button type="submit" class="btn btn-success">Search</button>
				</div>
				<div class="btn-group">
					<button type="reset"  class="btn btn-info" value="Reset">Clear All</button>
				</div>
		  </div>
		</form>
	</div>

	<div id="twowaytrip">
		<form role="form" action="search_twoway.php" method="post">
			 <div class="row">
			  <div class="col-sm-6">
			    <label for="start_loc">Source:</label>
			    <input type="text" class="form-control" id="start_loc" name="start_loc"  required>
			  </div>
			  <div class="col-sm-6">
			    <label for="to">Destination:</label>
			    <input type="text" class="form-control" id="end_loc" name="end_loc"  required>
			  </div>
			 </div>

			 <hr >
			 <div class="row">
				 <div class="col-sm-6">
					 <label for="time_period">Time Period:</label>
					 <input type="text" class="form-control" id="time_period" name="time_period" placeholder="e.g. 1,2,3... days"required>
				 </div>
				 <div class="col-sm-6">
					 <label for="price_range">Price Range:</label>
					 <select class="form-control" name="price_range">
						 <option value="1">1 to 100 dollars</option>
						 <option value="2">101 to 1000 dollars</option>
						 <option value="3">Above 1000 dollars</option>
					 </select>
				 </div>
			</div>
			 <div class="row">
			  <div class="col-sm-6">
			   	<label for="pass_count">Passengers:</label>
			    <input type="text" class="form-control" id="pass_count" name="pass_count" required>
			  </div>
			 </div>
			 <br>

			  <div class="btn-group btn-group-justified">
				<div class="btn-group">
					<button type="submit" class="btn btn-success">Search</button>
				</div>
				<div class="btn-group">
					<button type="reset"  class="btn btn-info" value="Reset">Clear All</button>
				</div>
		  	  </div>
			</form>
	</div>
<!--	<div id="finddeals">
		<form role="form" action="find_deals.php" method="post">
			 <div class="row">
			  <div class="col-sm-6">
			  <label for="src_loc">Source :</label>
			  <input type="text" class="form-control" id="src_loc" name="src_loc" required>
			  </div>

				<div class="col-sm-6">
			  <label for="dest_loc">Destination:</label>
			  <input type="text" class="form-control" id="dest_loc" name="dest_loc" required>
			  </div>
			 </div>

			 <div class="row">
			  <div class="col-sm-6">
			  <label for="time_period">Time Period:</label>
			  <input type="text" class="form-control" id="time_period" name="time_period" placeholder="e.g. 1,2,3... days"required>
			  </div>
				<div class="col-sm-6">
			  <label for="price_range">Price Range:</label>
				<select class="form-control" name="price_range">
					<option value="1">1 to 100 dollars</option>
					<option value="2">101 to 1000 dollars</option>
					<option value="3">Above 1000 dollars</option>
				</select>
			  </div>
			 </div>

			 <div class="row">
			  <div class="col-sm-6">
			   	<label for="pass_count">Passengers:</label>
			    <input type="text" class="form-control" id="pass_count" name="pass_count" required>
			  </div>
			 </div>
			 <br>
			<div class="row">
			  <div class="col-sm-6">
			  <button type="submit" class="btn btn-primary">Find Best Deals</button>
			  </div>
			</div>
			</form>

	</div>-->

	</div>

</body>
</html>
