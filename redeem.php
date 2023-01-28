<?php
session_start();
ini_set("display_errors", 1);

include_once 'connection.php';

     $rcount = $_POST["rcount"];
     if (isset($_POST["dprice"])) {
     $_SESSION["redeem_d_price"] = $_POST["dprice"];
    }
     if (isset($_POST["iprice"])) {
     $_SESSION["redeem_i_price"] = $_POST["iprice"];
   }
     $user = $_SESSION["user"];

     $sql1 ="select * from customer WHERE username = '$user'";
     $result = mysqli_query($conn,$sql1);

     while($row = mysqli_fetch_array($result)) {
       $redeem = $row["redeem"];
       $uredeem = $redeem + $rcount;
       $sql2 ="update customer set redeem = '$uredeem' WHERE username = '$user'";
       $result = mysqli_query($conn,$sql2);
       break;
     }

    header("Location: show_cart.php");


 ?>
