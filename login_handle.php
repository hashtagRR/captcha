<!-- login validation -->

<?php

session_start();
include "dbconn.php";

//check whether the POST variables have recieved
if (isset($_POST['email']) && isset($_POST['password']))
{

//get the IP address
			function get_client_ip()
			{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

//escape strings to mitigate command and sql injections
  $email = mysqli_real_escape_string($conn,$_POST['email']);
	$pass = mysqli_real_escape_string($conn,$_POST['password']);


    $sql = "SELECT salt FROM users WHERE email='$email'";

    $result =  mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0)
	{
		$rec = mysqli_fetch_array($result);

		$salt = $rec['0'];

		//salt the input password
		$salted_pw = $pass.$salt ;

		//hash the salted input password
		$hashed_pw = hash('sha3-512' , $salted_pw);

		$sql2 = "SELECT full_name,id,email,timestamp FROM users WHERE email='$email' AND password='$hashed_pw'";
		$result2 = mysqli_query($conn,$sql2);


		//check if the query is run successfully
		if(!$result2)
		{
			die(mysqli_error($conn)); //Error if sql could not be run
		}

		//Check if the query returns any records
		if(mysqli_num_rows($result2) > 0)
		{
			//Put the returned record into an array called $rec
			$rec = mysqli_fetch_array($result2);

			//Create session variables
			$_SESSION['full_name'] = $rec['full_name'];
			$_SESSION['id'] = $rec['id']; //or $rec[1]
			$_SESSION['email'] = $rec['email'];
			$_SESSION['timestamp'] = $rec['timestamp'];

			//get the ip of the client
			$ip = get_client_ip();
			$_SESSION['ip'] = $ip;

			//check the password expiration
			$timestamp1 = $_SESSION['timestamp'];
			$timestamp2 = date("Y-m-d");

			$_SESSION['login_time'] = date('Y-m-d H:i:s');

			//convert the variablesinto time data type
			$date1 = strtotime($timestamp1);
			$date2 = strtotime($timestamp2);

			//check the differance between the last password change
			$differance=$date2 - $date1;

			//check if the password is 30 days old in seconds
			if($differance> 2592000)
			{
				//redirect to the password change page
				echo '<script type="text/javascript">';
				echo 'alert("password has expired. Please change your password");';
				echo 'window.location.href = "password.php";';
				echo '</script>';
			}
			else
			{
				//redirect user to home page
				header('location:home.php');
			}
		}
		else
		{
			//input password is incorrect
			echo '<script type="text/javascript">';
			echo 'alert("password is incorrect");';
			echo 'window.location.href = "index.php";';
			echo '</script>';
		}
	}
	else
	{
		//input username is incorrect
		echo '<script type="text/javascript">';
		echo 'alert("Username is incorrect");';
		echo 'window.location.href = "index.php";';
		echo '</script>';
		}

}
else
{
    header('Location: index.php');
    exit();
}

?>
