<?php

session_start();

if(!isset($_SESSION['id']))
	{
        die("You are not logged in.");
  }
  
else
{
	$email = $_SESSION['email'];
	$ip = $_SESSION['ip'];
	$login_time = $_SESSION['login_time'];
	
	
	include "dbconn.php";
	
	$sql = "INSERT INTO login(email,login_time,ip) VALUES('$email','$login_time','$ip')";
				$run = mysqli_query($conn,$sql)or die(header('location:home.php?msg=Could not log out'));
	session_unset();
	session_destroy();
	header("Location: index.php");
	
	
	
	
}













?>