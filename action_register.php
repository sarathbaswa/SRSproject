<?php

session_start();
if(isset($_SESSION['user'])!="")
{
 header("Location: index.html");
}
include_once 'connection.php';


 $user_name = $_POST['username'];
 $first_name =$_POST['first_name'];
  $last_name =$_POST['last_name'];
   $mobile =$_POST['phone'];
 $email_id = $_POST['email_id'];
 $password = $_POST['passwd'];

 if(isset($_POST['m_name'])){
 	$m_name = $_POST['m_name'];
 }else{
 	$m_name = "";
 }
$gender_value = "";
  if(isset($_POST['gender_value'])){
 	$gender_value = $_POST['gender_value'];
 }else{
 	$gender_value = "";
 }
$dob_value = "";
  if(isset($_POST['dob_value'])){
 	$dob_value = $_POST['dob_value'];
 }else{
 	$dob_value = "";
 }


 if(mysqli_query($conn,"INSERT INTO customer(username,email,password,first_name,last_name,mobile,middle_name,gender,dob) VALUES('$user_name','$email_id','$password','$first_name','$last_name','$mobile','$m_name','$gender_value','$dob_value')"))
 {
  $_SESSION['user']=$user_name;
        header("Location: index.php");
         }
 else
 {
  ?>
        <script>alert('Registration failed');</script>
        <?php
 }

mysqli_close($conn);
?>
