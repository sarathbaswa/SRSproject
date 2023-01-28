<?php
session_start();
ini_set('display_errors', 1);
$user = $_SESSION['user'];
if (isset($_POST["book_type"])) {
  $_SESSION["book_type"] = "hotel";
}
?>
<!DOCTYPE html>
<html>
<html lang="en">
<head>
  <title>Credit Card</title>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="https://lh3.googleusercontent.com/-HtZivmahJYI/VUZKoVuFx3I/AAAAAAAAAcM/thmMtUUPjbA/Blue_square_A-3.PNG" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

  <link rel="stylesheet" href="css/index.css">
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
  <h1><b>Fill Credit Card Details</b></h1>
  <hr />
<div id="card">
  <form role="form" action="finish_payment.php" method="post">
    <div class="row">
    <div class="col-sm-6">
      <label for="fname">First Name:</label>
      <input type="text" class="form-control" id="fname" name="fname" placeholder="Name on card" required>
    </div>
    <div class="col-sm-6">
      <label for="mname">Middle Name:</label>
      <input type="text" class="form-control" id="mname" name="mname" required>
    </div>
    <div class="col-sm-6">
      <label for="lname">Last Name:</label>
      <input type="text" class="form-control" id="lname" name="lname" required>
    </div>
    </div>
    <hr >
    <div class="row">
      <div class="col-sm-6">
        <label for="ctype">Card Type:</label>
        <input type="text" class="form-control" id="ctype" name="ctype" required>
      </div>
    </div>
    <hr>

    <div class="row">
      <div class="col-sm-6">
        <label for="cnum">Card Number:</label>
        <input type="text" class="form-control" id="cnum" name="cnum" required>
      </div>
    </div>
    <hr>
     <div class="row">
    <div class="col-sm-6">
      <label for="edate">Expiry date:</label>
      <input type="date" class="form-control" id="edate" name="edate" required>
    </div>
    </div>
    <br>


    <div class="btn-group btn-group-justified">
    <div class="btn-group">
        <button type="submit" class="btn btn-success">Pay Now</button>
      </div>
    </div>
  </form>
  <<br><br>
</div>
</div>


</body>
</html>
