<?php
  ini_set("display_errors", 1);
  session_start();
  include_once 'connection.php';
  date_default_timezone_set("America/Chicago");
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
      <h1>Enter passenger Details</h1>
      <form action="review_cart.php" method="post">
        <hr>
<?php
$travel_mode = $_POST["type"];

if(!isset($_SESSION['user'])){
    header("Location: user_login.html");
}else{
    $user = $_SESSION['user'];
  	if($travel_mode =="oneway" ){
      	$forward_flight_no = $_POST["flight_id"];
        $pass_count = $_POST["pass_count"];
      	$class = 'none';
      	$forward_price_val = $_POST["price"];
      	$fdate = $_POST["date"];


        for ($x = 0; $x < $pass_count; $x++) {
      ?>

        <h2>Passenger: <?php echo $x+1 ?></h2>
        <div class="row">
            <div class="col-sm-6">
              <label for="pname">Passenger Name :</label>
            </div>
            <div class="col-sm-6">
              <input type="text" name="pnames[]" value="ravi">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
              <label for="page">Age :</label>
            </div>
            <div class="col-sm-6">
              <input type="text" name="pages[]" value="20">
              </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
              <label for="pgender">Gender :</label>
            </div>
            <div class="col-sm-6">
              <input type="text" name="pgenders[]" value="male">
            </div>
        </div>
        <hr>
            <?php
        }
        ?>
        <input type="hidden" name= "type" id= "type" value="<?php echo $travel_mode ?>">
        <input type="hidden" name= "flight_id" id= "flight_id" value="<?php echo $forward_flight_no ?>">
        <input type="hidden" name= "price" id= "price" value="<?php echo $forward_price_val ?>">
        <input type="hidden" name= "pass_count" id= "pass_count" value="<?php echo $pass_count ?>">
        <input type="hidden" name= "date" id= "date" value="<?php echo $fdate ?>">
        <button type='submit' class='btn btn-primary'>Proceed To Purchase</button>
      </form>
      <?php
    //  header("Location: show_cart.php");

    	}
    	if($travel_mode =="twoway"){
      	$forward_flight_no = $_POST["flight_id_1"];
        $pass_count = $_POST["pass_count"];
      	$class = 'none';
      	$forward_price_val = $_POST["price"];
      	$date = $_POST["date"];
      	$return_flight_no = $_POST["flight_id_2"];
      	$return_class_val = 'none';
      	$return_price_val = $_POST["price2"];

      	$return_date_val = $_POST["date2"];
        for ($x = 0; $x < $pass_count; $x++) {
          ?>

            <h2>Passenger: <?php echo $x+1 ?></h2>
            <div class="row">
                <div class="col-sm-6">
                  <label for="pname">Passenger Name :</label>
                </div>
                <div class="col-sm-6">
                  <input type="text" name="pnames[]" value="ravi">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                  <label for="page">Age :</label>
                </div>
                <div class="col-sm-6">
                  <input type="text" name="pages[]" value="20">
                  </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                  <label for="pgender">Gender :</label>
                </div>
                <div class="col-sm-6">
                  <input type="text" name="pgenders[]" value="male">
                </div>
            </div>
            <hr>
                <?php
            }
            ?>
            <input type="hidden" name= "type" id= "type" value="<?php echo $travel_mode ?>">
            <input type="hidden" name= "pass_count" id= "pass_count" value="<?php echo $pass_count ?>">

            <input type="hidden" name= "flight_id_1" id= "flight_id_1" value="<?php echo $forward_flight_no ?>">
            <input type="hidden" name= "price" id= "price" value="<?php echo $forward_price_val ?>">
            <input type="hidden" name= "date" id= "date" value="<?php echo $date ?>">

            <input type="hidden" name= "flight_id_2" id= "flight_id_2" value="<?php echo $return_flight_no ?>">
            <input type="hidden" name= "price2" id= "price2" value="<?php echo $return_price_val ?>">
            <input type="hidden" name= "date2" id= "date2" value="<?php echo $return_date_val ?>">

            <button type='submit' class='btn btn-primary'>Proceed To Purchase</button>
          </form>
          <?php
        //  header("Location: show_cart.php");
        }

      }



mysqli_close($conn);

?>
    </div>
  </div>
</div>
</body>
</html>
