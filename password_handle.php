<!-- password validation and change -->

<?php

session_start();
include "dbconn.php";

if (isset($_POST['pw_old']) && isset($_POST['pass1']) && isset($_POST['pass2']))
{

	function generateRandomString($length = 20) 
		{
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) 
			{
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}


    $pw_old = mysqli_real_escape_string($conn,$_POST['pw_old']);
	$pass1 = mysqli_real_escape_string($conn,$_POST['pass1']);
	$pass2 = mysqli_real_escape_string($conn,$_POST['pass2']);
	
	$id = $_SESSION['id'];
	$email = $_SESSION['email'];

    $sql = "SELECT salt,password FROM users WHERE email='$email'";

    $result =  mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0)
	{
		$rec = mysqli_fetch_array($result);
	
		$salt = $rec['0']; 
		$hashed_pw_db = $rec['1']; 
		
		$salted_pw_input = $pw_old.$salt ;
		$hashed_pw_input = hash('sha3-512' , $salted_pw_input);
		
		if ($hashed_pw_input == $hashed_pw_db)
		{
			$salted_pw_new = $pass1.$salt ;
			$hashed_pw_new = hash('sha3-512' , $salted_pw_new);
			
			if ($hashed_pw_db == $hashed_pw_new)
			{
				echo '<script type="text/javascript">'; 
				echo 'alert("You cannot use the old password");'; 
				echo 'window.location.href = "password.php";';
				echo '</script>';
			}
			
			else
			{
				$salt_new = generateRandomString();
				$salted_pw_new_2 = $pass1.$salt_new ;
				$hashed_pw_new_2 = hash('sha3-512' , $salted_pw_new_2);
				
				$timestamp = date("Y-m-d");
				
				$sql ="UPDATE users SET password='$hashed_pw_new_2',salt='$salt_new' WHERE email='$email', timestamp='$timestamp'";
				$run = mysqli_query($conn,$sql) or die(header('location:password.php?msg=Could not save the password'));
				//or die(mysqli_error($con));
	
				echo '<script type="text/javascript">'; 
				echo 'alert("successfully Changed The Password");'; 
				echo 'window.location.href = "Home.php";';
				echo '</script>';
				
			}
		}
		
		else
		{
			echo '<script type="text/javascript">'; 
			echo 'alert("Current password is incorrect");'; 
			echo 'window.location.href = "password.php";';
			echo '</script>';
		} 
	}	
	else
	{
		echo $email;
		
		//echo '<script type="text/javascript">'; 
		//echo 'alert("Session has timed out. Please login again");'; 
		//echo 'window.location.href = "index.php";';
		//echo '</script>';
		} 
    
}
else
{
    header('Location: index.php');
    exit();
}
