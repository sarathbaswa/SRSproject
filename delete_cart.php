<?php
session_start();
include_once 'connection.php';

if(!isset($_SESSION['user'])){
    header("Location: user_login.html");
}else{
    $user = $_SESSION['user'];
    $booking_id = $_POST["book_id"];

	$delete_query = "DELETE FROM booking WHERE ID = '$booking_id'";
	if(mysqli_query($conn,$delete_query)){
		 header("Location: show_cart.php");
	}

}
?>
