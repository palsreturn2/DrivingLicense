<?php
	require_once('../includes/initialize.php');
	if(!isset($_SESSION['user'])) {
		header('Location: ../home.php');
			}	

	$email = $_SESSION['user'];

	if(!isset($_POST['Submit_test']))
	{
		header("Location: home.php");
	} 
	else
	{
		// validating the response params
		$Total = $_POST['TotalCount'];
		$Attempted = 0;
		$correct = 0;
		for($q_count=1;$q_count<=$Total;$q_count++){
			if(isset($_POST['question'.$q_count])){
				if($_SESSION['test_questions'][$q_count]['correct_option'] == trim($_POST['question'.$q_count])) {
					$correct++;
				}	
				$Attempted++;
			}
		}
		$Perccentage = ($correct/$Total)*100;

		$q = "SELECT ATTEMPT from applications WHERE EMAIL = '{$email}' ; ";
		$r = mysqli_query($conn, $q);
		$attemptlist = mysqli_fetch_array($r);
		$attemptlist['ATTEMPT'] +=1;
		if($perccentage>=40)
			$query = "UPDATE applications SET KNOWLEDGE_TEST_RESULTS='{$Perccentage}' , ATTEMPT = '{$attemptlist}', STATUS='SlotTest Passed' WHERE EMAIL = '{$email}' ;";
		else
			$query = "UPDATE applications SET KNOWLEDGE_TEST_RESULTS='{$Perccentage}' , ATTEMPT = '{$attemptlist}', STATUS='Slottest Failed..Please Reapply to give restart process' WHERE EMAIL = '{$email}' ;";
		
		$result = mysqli_query($conn, $query);
		if(!$result){
			die("ERROR: ".mysqli_error($conn));
		} else {
			$message = "Success";
		}

?>
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Online Test Results</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<link rel="stylesheet" href="assets/css/dashboard.css">
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>

	<body>
		<img src="../assets/img/backgrounds/plain.jpg" class="bg">
		<?php include_once(LIB_PATH.DS."layouts/navbar.php"); ?>
		<div class="container page">
			<div class="header">
				<div>Test results</div>
			</div>
			<div class="page-content">
				<div class="row admin-table-header">
					<div class="col-sm-3">
					Total Questions 
					</div>
					<div class="col-sm-3">
					Total Questions Attempted
					</div>
					<div class="col-sm-3">
					Total Correct answers
					</div>
					<div class="col-sm-3">
					Perccentage of marks 
					</div>
				</div>
				<div class="row admin-table-contents">
					<div class="col-sm-3">
					<?php echo $Total; ?> 
					</div>
					<div class="col-sm-3">
					<?php echo $Attempted; ?> 
					</div>
					<div class="col-sm-3">
					<?php echo $correct; ?>
					</div>
					<div class="col-sm-3">
					<?php echo $Perccentage; ?> 
					</div>
				</div>
				<div >
					<?php if($Perccentage>=40){ ?>
						<span>You are paased in the exam </span>
					<?php } else { ?>
						<span>You are failed in the exam</span>
					<?php } ?>
				</div>
			</div>
		</div>
	</body>
</html>	
		
<?php
	}

?>
