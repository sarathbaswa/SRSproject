<?php
session_start();
unset($_SESSION['user']);
if (isset($_SESSION["flight_amount"])) {
  unset($_SESSION["flight_amount"]);
}

if (isset($_SESSION["hotel_amount"])) {
  unset($_SESSION["hotel_amount"]);
}
header("Location: index.php");
?>
