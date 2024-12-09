<!-- This is a landing page after login-->
<?php

session_start();

//check if the user has logged in
if(!isset($_SESSION['id']))
	{
        die("You are not logged in.");
  }
include "dbconn.php";
$email = $_SESSION['email'];

?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<title>Home</title>
		<link rel="stylesheet" type="text/css" href="style.css"> </head>

	<body>
		<div class="panel-body">
			<div>
				<table id="customers">
					<thead>
						<tr>
							<th>Login Time</th>
							<th>Logout Time</th>
							<th>IP Address</th>
						</tr>
					</thead>
					<?php
$sql = "SELECT * FROM login WHERE email='$email' ORDER BY id DESC LIMIT 10";
$run = mysqli_query($conn,$sql)or die(mysqli_error($conn));
$run=mysqli_query($conn,$sql);
$nor = mysqli_affected_rows($conn);

	if($nor > 0)

	{	?>
						<?php
			while($record = mysqli_fetch_array($run))
			{
				?>
							<tbody>
								<tr>
									<td>
										<?php echo $record["login_time"]; ?>
									</td>
									<td>
										<?php echo $record["logout_time"];;?>
									</td>
									<td>
										<?php echo $record["ip"];;?>
									</td>
								</tr>
								<?php



		} ?>
							</tbody>
				</table>
			</div>
		</div>
		<?php

}


?>
			<h1>Hello, <?php echo $_SESSION['full_name']; ?></h1>
			<br>
			<br> <a href="password.php">Change Password</a>
			<br>
			<br> <a href="logout.php">Logout</a> </body>

	</html>
