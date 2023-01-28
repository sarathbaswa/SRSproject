<?php
// Start the session
session_start();
ini_set("display_errors", 1);
?>


<!DOCTYPE html>
<html>
<html lang="en">
<head>
  <title>CheckOut cart</title>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="https://lh3.googleusercontent.com/-HtZivmahJYI/VUZKoVuFx3I/AAAAAAAAAcM/thmMtUUPjbA/Blue_square_A-3.PNG" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/admin_login.css">
    <script src="script/navigate.js"> </script>
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
      <h1>Check Out Cart</h1>

<?php

include_once 'connection.php';

ini_set('display_errors', 1);

if(!isset($_SESSION['user'])){
    header("Location: user_login.html");
}else{
    $user = $_SESSION['user'];


    $sql = "SELECT H.name as name, H.place as place, H.price as price, HB.in_date as in_date
    , HB.out_date as out_date, HB.num_rooms as num_rooms,HB.num_persons as num_persons,
     HB.id as hbid from hotel_booking HB, hotels H where HB.user_name = '$user' AND HB.is_paid = '0'
              and HB.hid = H.id  ORDER BY HB.book_time";


    $result = mysqli_query($conn,$sql);
    $rowcount = mysqli_num_rows($result);
    if ($rowcount >0 ) {
    $gross_total = 0;
    echo "<div class='alert alert-info'>Cart Details:</div>";

    echo "<table class='table table-bordered table-striped table-hover'>
          <thead>
          <tr>
            <th>Hotel Name</th>
            <th>Location</th>
            <th>Check In Date</th>
            <th>Check Out Date</th>
            <th>Room count</th>
            <th>Price(per head)</th>
            <th>Total Persons</th>
            <th>Total Amount</th>
            <th>Action</th>
          </tr>
          </thead>";

    while($row = mysqli_fetch_array($result)) {
        echo "<tbody><tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['place'] . "</td>";
        echo "<td>" . $row['in_date']. "</td>";
        echo "<td>" . $row['out_date'] . "</td>";
        echo "<td>" . $row['num_rooms'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>" . $row['num_persons'] . "</td>";
        echo "<td>" . $row['price'] * $row['num_persons']  . "</td>";

        echo '<td>
            <form action="delete_hotel_cart.php" method="post">
            <input type="hidden" name="book_id" value="'.$row['hbid'].'" >
            <button type="submit" class="btn btn-danger">Delete</button></div>
            </form>
            </td>';

            echo "</tr>";
        $gross_total += $row['price'] * $row['num_persons'] ;
    }

    $tax_price = $gross_total * 0.15;
    $total = $gross_total + $tax_price;
    echo " </tbody></table>";
    echo " <form action='credit_card.php' method='post'>";
    echo "<div class='row'>
			  <div class='col-sm-4'><p class='lead'>Gross Total: <span id='gtotal'>$".$gross_total."</span></p></div>
        <div class='col-sm-4'><p class='lead'>Tax amount: <span id='tax'>$".$tax_price."</span></p></div>
        <div class='col-sm-4'><p class='lead'>Final amount: <span id='total'>$".$total."</span></p></div>
        <input type ='hidden' name='book_type' value='hotel'>";
        if (isset($_SESSION["flight_amount"])) {
          $total = $total + (int)$_SESSION["flight_amount"];
          $total = $total - ($total *0.2);
          echo "<div class='col-sm-4'><p class='lead'>Final Flight amount: <span id='total'>$".$_SESSION['flight_amount']."</span></p></div>";
          echo "<div class='col-sm-4'><p class='lead'>Grand Total (20% discount): <span id='total'>$".$total."</span></p></div>";
        }


			  echo "<div class='col-sm-4'><button type='submit' class='btn btn-primary'>Pay Now</button></div>
			</div>";

    echo "</form>";
    echo "<br>";
    echo "<br>";
    if (!isset($_SESSION["flight_amount"])) {
      echo "<a class='bighref' href=index.php?hotel_amount=",urlencode($total),">Book Flights to avail extra discount</a>";
    }
  }
  else{
    echo "<div class='alert alert-info'><strong>Empty Cart.</strong></div>";
  }

}

mysqli_close($conn);
?>
    </div>
  </div>
</div>

</body>
</html>
