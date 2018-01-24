<?php
	include_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) 
	{
		header("Location: ../adminlogin.php");
	}

	if(isset($_POST['Create_RTO'])) 
	{		
		$RTO_name = mysqli_real_escape_string($conn,trim($_POST['RTO_Name']));
		$RTO_location = mysqli_real_escape_string($conn,trim($_POST['RTO_Location']));
		$RTO_name_location = $RTO_name."_".$RTO_location;
		$concerned_person = mysqli_real_escape_string($conn,trim($_POST['Head']));
		$Employees_total = 0; 
		$Applications_capacity = mysqli_real_escape_string($conn,trim($_POST['applications_capacity']));
		$Total_vehicles = mysqli_real_escape_string($conn,trim($_POST['total_vehicles']));
		$Total_systems = mysqli_real_escape_string($conn,trim($_POST['total_systems']));

		//Insertion of basic details of RTO into central server
		$query = "INSERT INTO regionaltrainingoffice (NAME, LOCATION, CONCERNED_PERSON, TOTAL_EMPLOYEES, APPLICATIONS_CAPACITY, TOTAL_VEHICLES, TOTAL_SYSTEMS) VALUES ( '{$RTO_name}', '{$RTO_location}', '{$concerned_person}', {$Employees_total}, {$Applications_capacity}, {$Total_vehicles}, {$Total_systems} );" ;
		echo $query;
		$result = mysqli_query($conn, $query);
		if($result)
		{
			echo 'RTO added';
		}
		else
		{
			echo 'RTO could not be added';
		}
	}	
?>
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Admin | Add RTO</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<link rel="stylesheet" href="../assets/css/dashboard.css">
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>

	<body>
		<img src="../assets/img/backgrounds/plain.jpg" class="bg">
		<?php include_once(LIB_PATH.DS.'layouts/navbar.php') ?>
		<div class="container inner-bg" >
			<div class="header">
				<h1><strong>ADD NEW RTO</strong></h1>
			</div>
			<div class="page-content">
				<form action="Add_new_RTO.php" method="POST">	
					<div class="cont-horizon">
						<div class="form-a-right">
							Name of the RTO
						</div>
						<div class="form-a-left">
							<input type="text" name="RTO_Name" placeholder="Enter RTO name" value="">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Location of the RTO
						</div>
						<div class="form-a-left">
							<input type="text" name="RTO_Location" placeholder="Enter RTO Location" value="">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Head of the RTO
						</div>
						<div class="form-a-left">
							<input type="text" name="Head" placeholder="Enter Head of RTO" value="">
						</div>
					</div>
					
					<div class="cont-horizon">
						<div class="form-a-right">
							Applications capacity per month 
						</div>
						<div class="form-a-left">
							<input type="number" name="applications_capacity" placeholder="Enter aplications capacity" value="">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Total Vehicles available for test
						</div>
						<div class="form-a-left">
							<input type="number" name="total_vehicles" placeholder="Enter total vehicles" value="">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Total systems for online test
						</div>
						<div class="form-a-left">
							<input type="number" name="total_systems" placeholder="Enter no. of systems" value="">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">	
						</div>
						<div class="form-a-left">
							<input id="submit" type="submit" name="Create_RTO" value="Create Now">
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
<?php //mysqli_close($conn); ?>