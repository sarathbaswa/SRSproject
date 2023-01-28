<?php
session_start();
ini_set("display_errors", 1);

include_once 'connection.php';

if (!isset($_SESSION["user"])) {
  $_SESSION["fstatus"] = "Failed to register feedback. Please login!";
}
else{
     $msg = $_POST["msg"];
     $rid = $_POST["rating_id"];
     $user = $_POST["user"];

     $sql = "INSERT INTO feedback (passenger_id, comment, rating)
         VALUES ('$user', '$msg', '$rid')";
      echo $sql;
      $result = mysqli_query($conn,$sql);
     $_SESSION["fstatus"] = "Feedback registered successfully!";
}
header("Location: feedback.php");


 ?>
