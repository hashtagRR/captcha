<!-- Change password page -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" type="text/css" href="style.css">
	
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="js/jquery.passwordRequirements.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>


<body>

<script>
 function checkPass()
{
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field 
    //and the confirmation field
    if(pass1.value == pass2.value){
        //The passwords match
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!"
    }else{
        //The passwords do not match
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!"
    }
} 
 
 
 </script>

<script>
        /* trigger when page is ready */
        $(document).ready(function (){
            $(".pr-password").passwordRequirements({

            });
        });
    </script>

<form action="password_handle.php" method="post">
        <h2>Change The Password</h2>

        <label>Current Password</label>
        <input type="password" name="pw_old" required placeholder="Current Password"><br>

        <label>New Password</label>
        <input type="password" class="pr-password form-control" name="pass1" id="pass1" required placeholder="Password" ><br>		

        <label>Re-Type New Password</label>
        <input type="Password" name="pass2" id="pass2" required placeholder="Re-Type Password" onkeyup="checkPass(); return false;"><br>
		<span id="confirmMessage" class="confirmMessage"></span><br><br>

        <input type="submit" name="submit" value="submit">
</form>

</html>
