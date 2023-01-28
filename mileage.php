<?php
include_once 'connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$available_mileage = 0;
if (isset($_SESSION["user"])) {
  $user_id =  $_SESSION['user'];
  $redeem_sql = mysqli_query($conn,"SELECT redeem, mileage
                        FROM customer WHERE username = '$user_id'");
    while($row = mysqli_fetch_array($redeem_sql)) {
      $mileage = $row["mileage"];
      $redeem = $row["redeem"];
      $available_mileage = $mileage - $redeem;
    }
    if ($available_mileage < 0) {
      $available_mileage = 0;
    }
}

 ?>
