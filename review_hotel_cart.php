<?php
ini_set("display_errors", 1);
session_start();
include_once 'connection.php';
date_default_timezone_set("America/Chicago");
$hid = $_POST["hid"];
$indate = $_POST["indate"];
$outdate = $_POST["outdate"];
$num_persons = $_POST["num_per"];
$num_rooms = $_POST["num_room"];
$current_time = date("Y-m-d h:i:s");

if(!isset($_SESSION['user'])){
    header("Location: user_login.html");
}else{
    $user = $_SESSION['user'];

      	$sql = "INSERT INTO hotel_booking (hid, book_time, in_date, out_date, user_name, num_persons, num_rooms, is_paid)
      			VALUES ('$hid', '$current_time', '$indate', '$outdate', '$user', '$num_persons', '$num_rooms', '0')";;
        echo "".$sql;
        $result = mysqli_query($conn,$sql);

        header("Location: show_hotel_cart.php");
}

mysqli_close($conn);

?>
