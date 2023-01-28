<?php
session_start();
include_once 'connection.php';

if(!isset($_SESSION['user']))
{
	echo 0;
}
else
    echo $_SESSION['user'];
?>
