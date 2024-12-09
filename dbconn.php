<!-- database configuation with mysql -->

<?php

$servername = "localhost";
$uname = "root";
$password = "";
$db_name = "cs_project";

$conn = mysqli_connect($servername, $uname, $password, $db_name);

if (!$conn){
    echo "Connection Failed";
}


