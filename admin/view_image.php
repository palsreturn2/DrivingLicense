<?php 
	require_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) {
		header("Location: ../home.php");
	}
	if(isset($_GET['question_id'])) 
	{
		echo $_GET['question_id'];
		$questions = "select * from question where ID=".$_GET['question_id'];
		$result = mysqli_query($conn, $questions);
		if(!$result)
		{
			die("No such image..");
		}
		else
		{
			$question = mysqli_fetch_array($result);
		}
	}
?>
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
	<title>Admin | Update questions</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
	<link rel="stylesheet" href="../assets/css/dashboard.css">
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
	<body>
		<div class="anks">
			<img src="../assets/img/backgrounds/plain.jpg" class="bg">
			<?php include_once(LIB_PATH.DS.'layouts/navbar.php'); ?>
			
			<div class="container  inner-bg" >
				<div class="header">
					<h1>Question ID <?php echo $question["ID"]; ?></h1>
				</div>
				<div class="page-content">
					<?php echo '<img src="../assets/img/'.$question['FILENAME'].'">'?>
				</div>
			</div>
		</div>
	</body>
</html>
