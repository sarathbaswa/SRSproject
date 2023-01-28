<?php
session_start();
 ?>
<!DOCTYPE html>
<html>
<html lang="en">
<head>
  <title>Search Hotels</title>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="https://lh3.googleusercontent.com/-HtZivmahJYI/VUZKoVuFx3I/AAAAAAAAAcM/thmMtUUPjbA/Blue_square_A-3.PNG" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/admin_login.css">
  <link rel="stylesheet" href="css/navigate.css">

<script src="script/unavailable.js"></script>
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
  <?php
  include_once 'connection.php';
  ini_set('display_errors', 1);

  $order_by = $_POST["order_by"];
  $order_type = $_POST["order_type"];

  $rc = $_POST["rc"];
  $cindate = $_POST["cindate"];
  $coutdate = $_POST["coutdate"];
  $pcount = $_POST["pc"];
  $place = $_POST["dest"];
 ?>

<!-- Actual page content starts here -->
<div class="container-fluid text-center">
  <div class="row content">
    <div class="col-sm-2 sidenav">

    </div>
    <div class="col-sm-8 text-left">

      <form action="search_hotels.php" method="post">
      <div class="searchbar">
            <div>
            <label for="class">Filter By:</label>
          </div>
          <div>
            <select class="form-control" name="order_by">
              <option value="name">Hotel Name</option>
              <option value="price">Price</option>
              <option value="star">Rating</option>
            </select>
          </div>
          <div>
            <select class="form-control" name="order_type">
              <option value="asc">asc</option>
              <option value="desc">desc</option>
            </select>
          </div>


      <div>
      <button type="submit" class="btn btn-primary">Filter</button>
      </div>
      <input type="hidden" name="rc" value="<?php echo $rc ?>">
      <input type="hidden" name="pc" value="<?php echo $pcount ?>">
      <input type="hidden" name="dest" value="<?php echo $place ?>">
      <input type="hidden" name="cindate" value="<?php echo $cindate ?>">
      <input type="hidden" name="coutdate" value="<?php echo $coutdate ?>">

      </div>
      </form>
      <?php
      global $sql;

          $sql = "SELECT *
                  FROM hotels
                  WHERE room_count >= '$rc'
                  and name like '%$place%' ORDER BY ".$order_by." ".$order_type; ;

        //  echo $sql;
      $result = mysqli_query($conn,$sql);
      $rowcount = mysqli_num_rows($result);


      if($rowcount == 0){
          echo "<div class='alert alert-info'><strong>Search Results: </strong>".$rowcount." result</div>";
      }
      else{
      echo "<div class='alert alert-info'><strong>Search Results: </strong>".$rowcount." results</div>";

      echo "<table class='table table-bordered table-striped table-hover'>
            <thead>
            <tr>
              <th>Hotel Name</th>
              <th>Place Name</th>
              <th>Room Rent(per head)</th>
              <th>Star Category</th>
              <th>Book Now</th>
            </tr>
            </thead>";
      while($row = mysqli_fetch_array($result)) {
           $hid = $row['id'];
          echo "<tbody><tr>";
          echo "<td>" . $row['name'] . "</td>";
          echo "<td>" . $row['place'] . "</td>";
          echo "<td>" . $row['price'] . "</td>";
          echo "<td>" . $row['star'] . "</td>";

          echo '<td>
              <form action="review_hotel_cart.php" method="post">
              <input type="hidden" name="hid" value="'.$hid.'">
              <input type="hidden" name="indate" value="'.$cindate.'">
              <input type="hidden" name="outdate" value="'.$coutdate.'">
              <input type="hidden" name="num_per" value="'.$pcount.'">
              <input type="hidden" name="num_room" value="'.$rc.'">
              <button type="submit" class="btn btn-primary">Add to Cart</button>
              </form>
              </td>';

          echo "</tr>";
      }
      echo " </tbody></table>";

      }

      mysqli_close($conn);
      ?>

    </div>

  </div>
</div>


</body>
</html>
