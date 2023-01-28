<?php
  session_start();
  include_once 'connection.php';
  ini_set('display_errors', 1);
  $number = $_POST["flnum"];
  $dep_date = $_POST["st_date"];
  $sql = "SELECT * FROM flights WHERE flight_id = '".$number."'";

  echo $sql;
  $result = mysqli_query($conn,$sql);
  $found = 0;
  while($row = mysqli_fetch_array($result)) {
    $_SESSION["flstatus"] = $row['status'];
    echo $row['status'];
    $found = 1;
    break;
  }

  if ($found == 0)
    $_SESSION["flstatus"] = "Flight not found";
  header("Location: index.php");
 ?>
