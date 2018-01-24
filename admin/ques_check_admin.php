<?php 
	require_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) {
		header("Location: ../home.php");
	}
	
	if(isset($_POST['instruction']) && $_POST['instruction']=='question_delete')
	{
		$del_query = 'DELETE FROM question where ID='.$_POST['question_id'];
		$result = mysqli_query($conn, $del_query);
		if(!$result)
		{
			die("couldn't upload the requested query ".mysqli_error($conn));
		}
	}
	if(isset($_GET['topic'])) 
	{
		$topic = $_GET['topic'];
		$questions = "select * from question where TOPIC_ID=".$topic;
		$question_result = mysqli_query($conn, $questions);
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
					<h1>Questions of TOPIC ID <?php echo $topic; ?></h1>
				</div>
				<div class="page-content">
					<table id="quest_container" class="table-content" style="width:80%">
						<tr>
							<th>QUESTION</th>
							<th>OPTION1</th>
							<th>OPTION2</th>
							<th>OPTION3</th>
							<th>OPTION4</th>
							<th>ANSWER</th>
							<th>IMAGE</th>
						</tr>
						<?php
							if($question_result && mysqli_num_rows($question_result)>0) 
							while($question = mysqli_fetch_array($question_result))
							{															
								echo '<tr id="q'.$question["ID"].'"><th>'.$question["QUESTION"].'</th><th>'.$question["OPTION1"].'</th><th>'.$question["OPTION2"].'</th><th>'.$question["OPTION3"].'</th><th>'.$question["OPTION4"].'</th><th>'.$question["ANSWER"].'</th><th><a id='.$question["ID"].' href="view_image.php?question_id='.$question["ID"].'">'.$question["FILENAME"].'</a></th><th> <a id='.$question["ID"].' href="" onClick=deleteQuestion('.$question["ID"].')>Delete</a></th></tr>';
							} 
						?>
					</table>
					<a href="admin_upload_ques.php?topic=<?php echo $topic;?>">Upload questions</a>
				</div>	
			</div>	
		</div>
		<?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>
		<script>
		function deleteQuestion(question_id)
		{
			var formdata = new FormData();
			formdata.append('instruction','question_delete');
			formdata.append('question_id',question_id);
			
			$.ajax({
				type: 'POST',
				url: 'ques_check_admin.php',
				data: formdata,
				async: false,
				contentType: false,
				processData: false,						
				success: function(e)
				{
					$("#q"+question_id).remove();
				}
			});
		}
		</script>
		</body>
</html>	

