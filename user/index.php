<?php
require_once('../includes/initialize.php');
if(!isset($_SESSION['user'])) {
	header("Location: ../home.php");
}

date_default_timezone_set("Asia/Kolkata");


$email = $_SESSION['user'];
$userid = $_SESSION['userid'];
$sql = "SELECT * FROM logindetails WHERE ID = {$userid};";
$result =  mysqli_query($conn,$sql);
if($result && mysqli_num_rows($result)>0)
{
	$userRow = mysqli_fetch_array($result);
}


$sqlapp = "SELECT * FROM applications WHERE USER_ID = {$userid};";
$result = mysqli_query($conn, $sqlapp);
if($result && mysqli_num_rows($result)>0)
{
	$appRow = mysqli_fetch_array($result);
}


if (isset($appRow["ID"])) {
    ?>
    <script>
    function ButtonsEdit() 
    {
        document.getElementById('NewApplication').disabled = false; 
        ButtonsEdit2()
    }
    </script>
    <?php
}
if (isset($appRow['ID']) && isset($appRow['STATUS']) && $appRow['STATUS']=='Submitted Succesfully - Decision Pending') 
{
    ?>
    <script>
    function ButtonsEdit2() {
        document.getElementById('NewApplication').disabled = true; 
        document.getElementById('StatusApplication').disabled = false; 
    }
    </script>
    <?php    
}

$query = "SELECT SLOT_DATE from slot WHERE APPLICATION_ID = (SELECT ID FROM applications WHERE USER_ID = {$userid})";
$res = mysqli_query($conn, $query);
if($res && mysqli_num_rows($res)>0)
{
	$slotlist = mysqli_fetch_array($res);
}


$now = date('Y-m-d');
echo $now;
?>


<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Dashboard</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
	<body onload="ButtonsEdit()">
		<div class="anks">
			<img src="../assets/img/backgrounds/plain.jpg" class="bg">
			<?php include_once(LIB_PATH.DS."layouts/navbar.php"); ?>
			<!-- Top content -->
			<div class="top-content">   	
				<div class="inner-bg" >
					<div class="container">
						<div class="row">
							<div class="col-sm-12 text">
								<h1><strong>Driving License</strong> Application Form</h1>
								<div class="top-big-link">
									<button id="NewApplication" onclick="location.href='newapplication.php'" type="button" class="btn btn-primary" style="background-color: #4CAF50">Apply for License Now</button>                                    
									<button id="StatusApplication" onclick="location.href='status.php'" type="button" disabled="true" class="btn btn-warning" style="background-color: #f0ad4e">Check Status</button>
									<?php 
									if(isset($appRow['STATUS']) && $appRow['STATUS']=="Approved" && (!isset($appRow['SLOT_STATUS']) || $appRow['SLOT_STATUS']!="Yes")  && time()<=strtotime($appRow['USER_UPDATE_TIME'])+30*24*60*60)
									{
									?>
									<button id="SlotBooking" onclick="location.href='SlotBooking.php'" type="button" class="btn btn-primary" style="background-color: #4CAF50">Book your slot here</button>
									<?php 
									}                   	  
									if(isset($appRow['SLOT_STATUS']) && $appRow['SLOT_STATUS']=="Yes" && $now==$slotlist['SLOT_DATE'] && $appRow['STATUS']=="Approved") 
									{ 
									?>
									<button id="OnlineTest" onclick="location.href='OnlineTest.php'" type="button" class="btn btn-primary" style="background-color: #f0ad4e">Start Online Test</button>        
									<?php 
									} 
									?>
									<button id="Reapply" onclick="location.href='Reapply.php'" type="button" class="btn btn-primary" style="background-color: #f0ad4e">Reapply</button>
									</div>
								</div>
							</div>
						</div>
					</div> 
				</div>
			</div>    
			<?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>
	</body>
</html>
