<?php 
	require_once('../includes/initialize.php');
	if(!isset($_SESSION['user'])) {
		 header('Location: ../home.php');
	}	

	$email = $_SESSION['user'];

	//retreiving the timestamp to put deadline on slotbooking
	$query = "SELECT TIMESTAMP FROM applications WHERE EMAIL = '{$email}' ; ";
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

	if(isset($_POST['Book_Slot'])) 
	{		
		$slot = trim($_POST['Slot']);
		$date = trim($_POST['Date']);

		if(strtotime($date) <= $slot_enddate) 
		{
			//checking  again whether the slot is free
			$query = "SELECT count(email) FROM slot WHERE SLOT = '{$slot}' and SLOT_DATE = '{$date}'";
			$result = mysqli_query($conn, $query);
			if(!$result && mysqli_num_rows($result)==0)
			{
				$count=0;
			}
			else if(!$result)
			{
				die("Slots are booked.. Can't book anymore");	
			}
			else 
			{
				$count = mysqli_fetch_array($result)['count(email)'];
			}
			
			$query = "SELECT R.ID AS RTOID FROM applications A,regionaltrainingoffice R WHERE R.NAME=A.VISITING_RTO AND A.EMAIL='{$email}'";
			$result = mysqli_query($conn, $query);
			$rto_id = mysqli_fetch_array($result)['RTOID'];
			
			$query = "SELECT ID FROM applications where EMAIL='{$email}'";
			$result = mysqli_query($conn, $query);
			$app_id = mysqli_fetch_array($result)['ID'];
			
			// Booking the slot 
			
			$query = "INSERT INTO slot (RTO_ID, SLOT_DATE, SLOT_TIMESTAMP, APPLICATION_ID, KNOWLEDGE_TEST, SKILL_TEST) VALUES(".$rto_id.", '{$date}', '{$now}', ".$app_id.",0,0)";
			
			$result = mysqli_query($conn, $query);
			if($result)
			{
				$query = "UPDATE applications SET SLOT_STATUS = 'Yes' WHERE EMAIL = '{$email}'";
				$result = mysqli_query($conn, $query);
				if($result)
				{
					header("Location: index.php");
				}
			}
			else
			{
				die("Error");
			}
		}
	}

	



?>
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Slot Booking</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<link rel="stylesheet" href="../assets/css/dashboard.css">
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
	<body>
		<div class="center">
			<img src="../assets/img/backgrounds/plain.jpg" class="bg">
			<?php include_once(LIB_PATH.DS.'layouts/navbar.php'); ?>
			<div class="container inner-bg">
				<?php if(!($current_date <= $slot_enddate)) { ?>
				<div class="header">
					<span>
						Your Online test End date is finished. Try applying after 15 days.
					</span>
				</div>	
				<?php } else { ?>	
				<div class="header">
					<span>
						<b>Slot Booking</b>
					</span>
				</div>
				<div class="page-content">
					<form action="SlotBooking.php" method="post">
						<div id="instr" class="row pad-el">
							<div class="col-md-12">
								Select slot for your online test from the given options. 
							</div>
						</div>
						<div class="">							
							<div class="date cont-horizon">
								<div class=" form-a-right">Date: </div> 
								<div class=" form-a-left">
									<select id="date" name="Date">
										<option value=""></option>
										<?php 	
											$tmp_date = $current_date;
											while($tmp_date <= $slot_enddate) 
											{
												$date_options = date("Y-m-d", $tmp_date);	
											?>
											<option value="<?php echo $date_options; ?>">
												<?php echo $date_options; ?> 
											</option>	
										<?php 
											$tmp_date = strtotime("+1 day",$tmp_date); }; 
										?>	
									</select>
								</div>
							</div>
							<div class="slot cont-horizon" style="display:none;">
								<div class="form-a-right">Slots: </div> 
								<div class="form-a-left">
									<select id="slot" name="Slot">
										<option value=""></option>
										<option value="1">morning</option>
										<option value="2">Evening</option>
									</select>
								</div>
							</div>
							<div id="notify" style="padding:20px ">

							</div>
							<input type="submit" class="app-sub" name="Book_Slot" value="Book now" >
						</div>
					</form>
				</div>
				<?php }; ?>
			</div>
		</div>	
		<?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>	
		<script type="text/javascript">
			$(document).ready(function() 
			{	
				$("#date").change(function()
				{
					val1 = $("#date option:selected").attr('value');
					if(val1 !== "")
					{
						$(".slot").css("display","flex" );
					} else 
					{
						$(".slot").css("display","none" );
					} 
					$("#slot option").prop('selected', false);
					$("input[type='submit']").prop('disabled', true );
					document.getElementById("notify").innerHTML="";
				});

				$("input[type='submit']").prop('disabled', true );

				$("#slot").change(function(){
					val2 = $("#slot option:selected").attr('value');
					if(val2 !== ""){
						callback = slotCheck(val1, val2);
						$("input[type='submit']").prop('disabled', false );
					} else {
						document.getElementById("notify").innerHTML = "Select the slot";
						$("input[type='submit']").prop('disabled',true);
					}
				});
				
			
				function slotCheck(val1, val2) {
		    		if((val1.length== 0) && (val2.length != 0)) {
						document.getElementById("notify").innerHTML = "Slot availability checking.. ";
						return;
					} else {
						var xmlhttp = new XMLHttpRequest();
						xmlhttp.onreadystatechange = function() {
							if(xmlhttp.readyState==4 && xmlhttp.status==200) {
								document.getElementById("notify").innerHTML = xmlhttp.responseText;
							};
						};
						xmlhttp.open("GET","slot_check.php?date=" + val1+"&slot="+val2, true);
						xmlhttp.send();
					};	
				};
			});

		</script>
	</body>
</html>	
