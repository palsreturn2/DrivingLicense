<?php 
	require_once('../includes/initialize.php');
	if(!isset($_SESSION['user'])) {
		 header('Location: ../home.php');
	}	
	$email = $_SESSION['user'];
	$userid = $_SESSION['userid'];
	//retreiving the timestamp to put deadline on slotbooking
	$sql = "SELECT ID FROM applications WHERE USER_ID = {$userid} AND NOT STATUS='Deleted'";
	$result = mysqli_query($conn, $sql);
	if($result)
	{
		$appid = mysqli_fetch_array($result)[0];
	}
	else
	{
		die();
	}
	$query = "SELECT TIMESTAMP FROM applications WHERE ID = {$appid}";
	$result = mysqli_query($conn, $query);
	if(!$result)
	{
		die("Zero entries of applicant found");	
	}
	else 
	{
		$timestamp = mysqli_fetch_array($result);
		$approved_date=strtotime($timestamp['TIMESTAMP']);
		$slot_enddate = strtotime("+15 days",$approved_date);
		$current_date = strtotime(date('Y-m-d h:m:s'));
		$now = date('Y-m-d h:m:s');
	}
	if(isset($_POST['delete_application']) && $_POST['delete_application']=="true")
	{
		$query = "UPDATE applications SET STATUS='Deleted' WHERE ID={$appid}";
		$result = mysqli_query($conn, $query);
		if(!$result)
		{
			die("Zero entries of applicant found");
		}
	}

	
?>

<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Reapply</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<link rel="stylesheet" href="../assets/css/dashboard.css">
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>

	<body>
		<div class="anks">
			<img src="../assets/img/backgrounds/plain.jpg" class="bg">

			<?php include_once(LIB_PATH.DS."layouts/navbar.php"); ?>

     		<div class="top-content inner-bg">
				<div style="padding-bottom: 170px">
					<div class="container">
						<div class="row">
							<div class="col-sm-8 col-sm-offset-2 text">
								<h1>Re-Application</h1>
								<br><br><br>
								<div class="description">
									<span class="li-text">
										<strong>Warning!!</strong> This will remove all the previously held data. Are you sure you want to continue?
										<br><br>
									</span>
									<button id="reapply" type="button" class="btn btn-primary" style="background-color: #f0ad4e">Reapply</button>
									<button id="cancel" onclick="location.href='index.php'" type="button" class="btn btn-primary" style="background-color: #f0ad4e">Cancel</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			document.getElementById("reapply").addEventListener('click', 
				function(e) {
					$.post("Reapply.php",
						{delete_application: "true"},
						function(data, status) 
						{
							$("#console").text(status);
							window.location.href="index.php";
						}
					);
				}, false);
		</script>
		<?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>
	</body>
</html>
