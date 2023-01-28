<?php
ini_set("display_errors", 1);
session_start();
include_once 'connection.php';
date_default_timezone_set("America/Chicago");
$travel_mode = $_POST["type"];
$current_time = date("Y-m-d h:i:s");

if(!isset($_SESSION['user'])){
    header("Location: user_login.html");
}else{
    $user = $_SESSION['user'];

  	if($travel_mode =="deals" || $travel_mode =="oneway" ){
    	$forward_flight_no = $_POST["flight_id"];
      $pass_count = $_POST["pass_count"];
    	$class = 'none';
    	$forward_price_val = $_POST["price"];
    	$date = $_POST["date"];
      $pnames = $_POST["pnames"];
      $ages = $_POST["pages"];
      $pgenders = $_POST["pgenders"];

      $pages = array_fill(0,$pass_count, 0);
    //  foreach ($pnames as $value) {
    //    echo "$value <br>";
    //  }

      for ($x = 0; $x < $pass_count; $x++) {
        $pages[$x] = (int)$ages[$x];
      }

      for ($x = 0; $x < $pass_count; $x++) {
      	$sql = "INSERT INTO booking (book_time, book_date, flight_id, user_name, class_type, is_paid, pname,page,pgender)
      			VALUES ('$current_time', '$date', '$forward_flight_no', '$user', '$class', '0', '$pnames[$x]', '$pages[$x]', '$pgenders[$x]')";
        echo "".$sql;
        $result = mysqli_query($conn,$sql);
      }
        header("Location: show_cart.php");
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

      $pnames = $_POST["pnames"];
      $ages = $_POST["pages"];
      $pgenders = $_POST["pgenders"];

      for ($x = 0; $x < $pass_count; $x++) {
        $pages[$x] = (int)$ages[$x];
      }

      for ($x = 0; $x < $pass_count; $x++) {
      	$sql = "INSERT INTO booking (book_time, book_date, flight_id, user_name, class_type, is_paid, pname,page,pgender)	VALUES ('$current_time',
          '$date', '$forward_flight_no', '$user', '$class', '0', '$pnames[$x]', '$pages[$x]', '$pgenders[$x]')";
      	$result = mysqli_query($conn,$sql);
      	$sql2 = "INSERT INTO booking (book_time, book_date, flight_id, user_name, class_type, is_paid, pname,page,pgender)VALUES ('$current_time',
           '$return_date_val', '$return_flight_no', '$user', '$return_class_val', '0', '$pnames[$x]', '$pages[$x]', '$pgenders[$x]')";;
      	$result2 = mysqli_query($conn,$sql2);
      }
      header("Location: show_cart.php");
    }
      echo "Failed to add to cart..";
  }

mysqli_close($conn);

?>
