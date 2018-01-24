<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "DrivingLicenseDatabase";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
	die("Failed to connect to the Database Server");
}
?>
