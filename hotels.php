<?php
	ini_set("display_errors", 1);
	session_start();
	if (isset($_GET["flight_amount"])) {
		$_SESSION["flight_amount"] = $_GET["flight_amount"];
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Hotel Booking</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="https://lh3.googleusercontent.com/-HtZivmahJYI/VUZKoVuFx3I/AAAAAAAAAcM/thmMtUUPjbA/Blue_square_A-3.PNG" />
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

		<link rel="stylesheet" href="css/index.css">
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/admin_login.css">
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


	<div class="container" id="contentdiv">
		<h1><b>Search Hotels</b></h1>
		<br />
		<p><b>Choose your hotel option</b></p>
		<hr />

	<div id="hotels">
		<form role="form" action="search_hotels.php" method="post">
			 <div class="row">
			  <div class="col-sm-6">
			    <label for="dest">Hotel Name:</label>
			    <input type="text" class="form-control" id="dest" name="dest"  required>
			  </div>
			  <div class="col-sm-6">
			    <label for="to">Room Count:</label>
			    <input type="text" class="form-control" id="rc" name="rc" placeholder="eg. 1 or 2 or 3..." required>
			  </div>
			 </div>
			 <hr >
			<div class="row">
			  <div class="col-sm-6">
			    <label for="depart">Check In Date:</label>
			    <input type="date" class="form-control" id="cindate" name="cindate" required>
			  </div>
			  <div class="col-sm-6">
			    <label for="coutdate">Check Out Date:</label>
			    <input type="date" class="form-control" id="coutdate" name="coutdate" required>
			  </div>
			 </div>
			 <hr >
			 <div class="row">
			  <div class="col-sm-6">
			   	<label for="pc">Person Count:</label>
			    <input type="text" class="form-control" id="pc" name="pc" required>
			  </div>
			 </div>
			 <br>
			 <input type="hidden" name="order_by" value="name">
			 <input type="hidden" name="order_type" value="asc">
			  <div class="btn-group btn-group-justified">
				<div class="btn-group">
					<button type="submit" class="btn btn-success">Search</button>
				</div>
				<div class="btn-group">
					<button type="reset"  class="btn btn-info" value="Reset">Reset</button>
				</div>
		  	  </div>
			</form>
	</div>

	</div>


</body>
</html>
