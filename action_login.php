<?php
session_start();
include_once 'connection.php';

if(isset($_SESSION['user'])!="")
{
	header("Location: index.php");
}

	$user_name=$_POST['username'];
	$password=$_POST['pwd'];
	$query_result=mysqli_query($conn,"SELECT * FROM customer WHERE username='$user_name'");
	$row=mysqli_fetch_array($query_result);
	if($row['password']==$password)
	{
		$_SESSION['user']=$row['username'];
		header("Location: index.php");
	}
	else
	{

	echo '
			<head>
			<title>Customer login</title>
			<meta charset="utf-8">
		    <meta name="viewport" content="width=device-width, initial-scale=1">
				<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

				<link rel="shortcut icon" type="image/x-icon" href="https://lh3.googleusercontent.com/-HtZivmahJYI/VUZKoVuFx3I/AAAAAAAAAcM/thmMtUUPjbA/Blue_square_A-3.PNG" />
			<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		    <link rel="stylesheet" href="css/index.css">
		    <link rel="stylesheet" href="css/layout.css">
		    <link rel="stylesheet" href="css/admin_login.css">
		    <script src="script/signin.js"> </script>
			<script src="script/navigate.js"> </script>

			<meta http-equiv="refresh" content="3;url=user_login.html">
			</head>
			<body >
			<ul class="nav-header">
			  <li class="link"><a href="index.php">Home</a></li>
			  <li class="link" style="float:right"><a class="lactive" href="user_login.html">Login</a></li>
			</ul>
		<!-- Actual page content starts here -->

	<div class="container" id="content-div">
		<p>Invalid user name or password <a href="user_login.html">Go Back</a></p>
	</div>
	</body>';

	}


mysqli_close($conn);
?>
