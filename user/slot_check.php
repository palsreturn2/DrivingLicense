<?php 

	require_once('../includes/initialize.php');
	if(!isset($_SESSION['user'])) {
		header("Location: ../home.php");
	}

	$dat = $_GET['date'];
	$Slot = $_GET['slot'];

	$query = "SELECT count(EMAIL) FROM slot WHERE SLOT = '{$Slot}' and SLOT_DATE = '{$dat}'; ";
	$result = mysqli_query($conn, $query);
	if(!$result && mysqli_num_rows($result)==0)
	{
		echo "20 slots are available.";
	}
	else if(!$result)
	{
		die("wrng retrieving at basic");
	} 
	else 
	{
		$slot1 = mysqli_fetch_array($result);
		$x =  $slot1['count(email)'];
		if($x == 20) 
		{
			echo "No free slots are available in this session ";
		} 
		else if ($x < 19) 
		{
			echo "There are ".(20-$x)." free slots availble";
		} 
		else if($x == 19)
		{
			echo "There is ".(20-$x)." free slot availble";
		} 
		else if($x >20) 
		{
			echo "Over slot implementation.. report to admin!!!";
		}
	}	
?>
