<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flight_db_1";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if(mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
