<?php
session_start();
include_once 'connection.php';
ini_set("display_errors", 1);

if(!isset($_SESSION['user'])){
    header("Location: user_login.html");
}else{
    $user = $_SESSION['user'];
    $booking_id = $_POST["book_id"];

	$delete_query = "DELETE FROM hotel_booking WHERE ID = '$booking_id'";
  echo $delete_query;
	if(mysqli_query($conn,$delete_query)){
		 header("Location: show_hotel_cart.php");
	}

}
?>
