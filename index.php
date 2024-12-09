<!-- Login page -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form action="login_handle.php" method="POST">
        <h2>Login</h2>

        <label>User Name / E-Mail</label>
        <input type="email" name="email" required placeholder="User Name / E-Mail"><br>

        <label>Password</label>
        <input type="Password" name="password" required placeholder="Password"><br>

        <button type="submit">LOGIN</button>
    </form>

</body>
</html>
