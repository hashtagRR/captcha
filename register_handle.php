<?php

$captcha = $_POST['g-recaptcha-response'];

    if(!$captcha) 
	{
		echo '<script type="text/javascript">';
        echo 'alert("Please check the captcha");';
        echo 'window.location.href = "register.php";';
        echo '</script>';
    }
	else
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
		
		$secretKey = "6LfeXwsgAAAAAArPPFKgoDb8O8XubcmlmZWEnb0-";
       
        // post request to server
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);
        
		// should return JSON with success as true
        if($responseKeys["success"]) 
		{
			include "dbconn.php";
			
            $fname = mysqli_real_escape_string($conn,$_POST['fname']);
			$email = mysqli_real_escape_string($conn,$_POST['email']);
			$pw = mysqli_real_escape_string($conn,$_POST['pass1']);
			
			$salt = generateRandomString();
			$salted_pw = $pw.$salt ;
			
			$hashed_pw = hash('sha3-512' , $salted_pw);
			
			//check whether the user has already been registered
			$sql = "SELECT id FROM users WHERE email='$email'";
			$run = mysqli_query($conn,$sql);

			if(!$run)
			{
				die(mysqli_error($conn)); //Error if sql could not be run
			}
			
			if(mysqli_num_rows($run) > 0)
			{	
				echo '<script type="text/javascript">'; 
				echo 'alert("User already exist. Please login.");'; 
				echo 'window.location.href = "index.php";';
				echo '</script>';
				
			} 
			else
			{
				$timestamp = date("Y-m-d");
				
				$sql = "INSERT INTO users(full_name,email,password,salt,timestamp) VALUES('$fname','$email','$hashed_pw','$salt','$timestamp')";
				$run = mysqli_query($conn,$sql)or die(header('location:register.php?msg=Could not registered'));
				//or die(mysqli_error($con));
			
				echo '<script type="text/javascript">'; 
				echo 'alert("Registration seccessfull. Please login with the new credentials");'; 
				echo 'window.location.href = "index.php";';
				echo '</script>';
				
			}
		}

		else 
		{
			echo 'Captcha Failed';
        }
		
		
	}
	

?>
