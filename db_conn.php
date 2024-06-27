<?php
$_servername = "localhost";
$username = "root";
$password = "";
$dbname = "voltageweb";

$conn = mysqli_connect($_servername,$username,$password,$dbname);

if(!$conn){
    die("connection failed". mysqli_connect_error());
}
//echo "Connected Successfully";