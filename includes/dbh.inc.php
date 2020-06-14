<?php
$servername ="localhost";
$dbusername = "root";
$dbpassword ="";
$dbname ="mylogin";

// line 8 is the connection too our database
$connect = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

// displaying error msg if connection to DB failed
if(!$connect){
    die("connection to database failed :".mysqli_connect_error());
}
