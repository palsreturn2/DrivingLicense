<?php

require_once('../includes/initialize.php');

if(!isset($_SESSION['mts'])) {
	echo 'no admin';
	header("Location: ../home.php");
}
else if(isset($_SESSION['mts'])) {
	header("Location: dashboard.php");
	echo ' admin';
}

if(isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['rto']);
	unset($_SESSION['userid']);
	unset($_SESSION['Name']);
	header("Location: ../home.php");
	echo 'logout RTO';
}
mysqli_close($conn);
?>
