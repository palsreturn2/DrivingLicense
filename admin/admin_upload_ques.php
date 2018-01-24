<?php

require_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) 
	{
		header('Location: ../home.php');
	}	

	if(isset($_POST['Upload_ques'])) 
	{		
		$topic_id = $_POST["topic"];
		$question = mysqli_real_escape_string($conn, strtolower(trim($_POST['Question'])));
		$option1 = mysqli_real_escape_string($conn, strtolower(trim($_POST['Option-1'])));
		$option2 = mysqli_real_escape_string($conn, strtolower(trim($_POST['Option-2'])));
		$option3 = mysqli_real_escape_string($conn, strtolower(trim($_POST['Option-3'])));
		$option4 = mysqli_real_escape_string($conn, strtolower(trim($_POST['Option-4'])));
		$correct_option = mysqli_real_escape_string($conn, strtolower(trim($_POST['Answer'])));

		if(isset($_FILES['file_upload'])) 
		{
			$file = $_FILES['file_upload'];
			$file_name = $file['name'];
			$file_type = $file['type'];
			$file_size = $file['size'];	
			$tmp_path = $file['tmp_name'];
			$target_path = "../assets/img/onlinetest_pics/".$file['name'] ;
			if(move_uploaded_file($tmp_path,$target_path)) 
			{
				$query = "INSERT into question ( FILENAME, FILESIZE, QUESTION, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, TOPIC_ID) VALUES ( '{$file_name}', '{$file_size}' , '{$question}' , '{$option1}' , '{$option2}' , '{$option3}' , '{$option4}' , '{$correct_option}' , '{$topic_id}'); ";
				$result = mysqli_query($conn , $query);
				
				if(!$result) 
				{
					die("couldn't upload the requested query ".mysqli_error($conn));
				} 
				else 
				{
					$message = "Question is uploaded into the database!!  ";
				}
			}
		}
		else
		{
			$query = "INSERT into question (QUESTION, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, TOPIC_ID) VALUES ('{$question}' , '{$option1}' , '{$option2}' , '{$option3}' , '{$option4}' , '{$correct_option}' , '{$topic_id}'); ";
			
			$result = mysqli_query($conn , $query);
			
			if(!$result) 
			{
				die("couldn't upload the requested query ".mysqli_error($conn));
			} 
			else 
			{
				$message = "Question is uploaded into the database!!";
			}
		}
	}	

include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Admin | Upload questions</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
	<body>
		<div class="anks">
			<img src="../assets/img/backgrounds/plain.jpg" class="bg">
			<?php include_once(LIB_PATH.DS.'layouts/navbar.php'); ?>
			<div class="container inner-bg" >
				<div class="header" style="text-align:center; font-size: 25px;">
					<span>Upload the questions Below </span>
				</div>
				
				<div><p id="msg"></p></div>
				
				<div class="page-content ">
					<form method="post" id="question_form">
						<div class="cont-horizon">
			        		<div class="form-a-right">Topic ID: </div>
			        		<div class="form-a-left">		 											
								<input id = "topic" type="text" name="topic" readonly value = "<?php if(isset($_GET['topic'])) echo $_GET['topic'];?>">
							</div>	
	 					</div>
	 					<div class="cont-horizon">
			        		<div class="form-a-right">Question: </div>
			        		<div class="form-a-left">		 						
								<input id="question" type="text" name="Question">
							</div>	
	 					</div>
	 					<div class="cont-horizon">
			        		<div class="form-a-right">Option 1: </div>
			        		<div class="form-a-left">
	 							<input id="Option-1" type="text" name="Option-1">
	 						</div>	
	 					</div>
	 					<div class="cont-horizon">
			        		<div class="form-a-right">Option 2: </div>
			        		<div class="form-a-left">
	 							<input id="Option-2" type="text" name="Option-2" value="">
	 						</div>	
	 					</div>
	 					<div class="cont-horizon">
			        		<div class="form-a-right">Option 3: </div>
			        		<div class="form-a-left">
	 							<input id="Option-3" type="text" name="Option-3">
	 						</div>	
	 					</div>
	 					<div class="cont-horizon">
			        		<div class="form-a-right">Option 4: </div>
			        		<div class="form-a-left">
	 							<input id="Option-4" type="text" name="Option-4" value="">
	 						</div>	
	 					</div>
						<div class="cont-horizon">
			        		<div class="form-a-right">Answer: </div>
			        		<div class="form-a-left">
	 							<input id="Answer" type="text" name="Answer" value="">
	 						</div>	
	 					</div>	 					
	 					<div class="cont-horizon">
			        		<div class="form-a-right">Upload picture (if any): </div>
			        		<div class="form-a-left">
	 							<input id="file_upload" type="file" name="file_upload">
	 						</div>	
	 					</div>
	 					<div class="cont-horizon">
			        		<div class="form-a-right"></div>
			        		<div class="form-a-left">
		 						<input id="Upload_ques" type="submit" name="Upload_ques">
		 					</div>	
	 					</div>
					</form>
				</div>
			</div>	
		</div>
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript">
			function upload_question()
			{
				var formdata = new FormData();
				formdata.append("topic",document.getElementById("topic").value);
				formdata.append("Question",document.getElementById("question").value);
				formdata.append("Option-1", document.getElementById("Option-1").value);
				formdata.append("Option-2", document.getElementById("Option-2").value);
				formdata.append("Option-3", document.getElementById("Option-3").value);
				formdata.append("Option-4", document.getElementById("Option-4").value);
				formdata.append("Answer", document.getElementById("Answer").value);
				formdata.append("Upload_ques", "Uploaded");
				
				var file_upload = document.getElementById("file_upload").value;
				if(file_upload!="")
				{
					formdata.append("file_upload",document.getElementById("file_upload").files[0]);
					$.ajax({
						type: "POST",
						url: "admin_upload_ques.php",
						data: formdata,
						cache: false,
						async: false,
  			      	contentType: false,
						processData: false,
						success: function(e)
						{
							alert("Question uploaded");
							document.getElementById("msg").value = "Question uploaded";
						}
					});
				}
				else
				{
					$.ajax({
						type: "POST",
						url: "admin_upload_ques.php",
						data: formdata,
						async: false,
						contentType: false,
						processData: false,						
						success: function(e)
						{
							alert("Question uploaded");
							$('#question_form')[0].reset();
						}
					});
				}
				return false;
			}
			document.getElementById("Upload_ques").addEventListener('click', function(e){e.preventDefault();
upload_question();}, false);
		</script>
	</body>
</html>
