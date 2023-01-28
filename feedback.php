<?php
	ini_set("display_errors", 1);
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Feedback</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="https://lh3.googleusercontent.com/-HtZivmahJYI/VUZKoVuFx3I/AAAAAAAAAcM/thmMtUUPjbA/Blue_square_A-3.PNG" />
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
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
<br> <br> <br> <br>
	<div class="container" id="contentdiv">
		<h1><b>Fill your feddback</b></h1>
		<hr />
		<div id="feedback">
      <?php

      if (isset($_SESSION["fstatus"])) {
          echo "<div class='alert alert-info'><strong>Status: </strong>".$_SESSION["fstatus"]."</div>";
          $_SESSION["fstatus"] = "";
      }

      ?>
			<form role="form" action="save_feedback.php" method="post">
			  <div class="row">
			  <div class="col-sm-6">
			    <label for="msg">Feedback:</label>
			    <input type="text" class="form-control" id="msg" name="msg"  required>
			  </div>
      </div>
      <div class="row">
			  <div class="col-sm-6">
			    <label for="rating_id">Rating: </label>
          <select class="form-control" name="rating_id">
			      <option value="1">1</option>
			      <option value="2">2</option>
            <option value="3">3</option>
			      <option value="4">4</option>
            <option value="5">5</option>
			      <option value="6">6</option>
            <option value="7">7</option>
			      <option value="8">8</option>
            <option value="9">9</option>
			      <option value="10">10</option>
			    </select>

			  </div>
			  </div>
			   <br>
			  <br>

				<div class="btn-group btn-group-justified">
					<div class="btn-group">
						<button type="submit" class="btn btn-success">Send Feedback</button>
					</div>
			  </div>
			</form>
		</div>
	</div>
</body>
</html>
