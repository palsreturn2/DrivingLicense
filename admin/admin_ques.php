<?php 
	require_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) {
		header("Location: ../home.php");
	}

	$email = $_SESSION['admin'];
	
	$sql = "SELECT * FROM logindetails WHERE EMAIL = '$email';";
	$result =  mysqli_query($conn,$sql);
	if($result && mysqli_num_rows($result)>0)
	{
		$userRow = mysqli_fetch_array($result);
	}
	
	if(isset($_POST["submit_topic"]))
	{
		$new_topic = $_POST["topic"];		
		$new_topic_query = 'INSERT INTO testtopics(TOPIC) VALUES(\''.$new_topic.'\')';
		$result = mysqli_query($conn, $new_topic_query);
		if($result)
		{
			$new_topic_id = "SELECT ID FROM testopics WHERE TOPIC='$new_topic'";
			$result = mysqli_query($conn, $new_topic_id);
			if($result)
			{
				$id = mysqli_fetch_array($result)["ID"];
				echo $id;
			}
			else
				echo -1;
		}
	}
	if(isset($_POST["instruction"]) && $_POST["instruction"]=="topic_delete")
	{
		$del_query = 'DELETE FROM testtopics where ID='.$_POST['topic_id'];
		$result = mysqli_query($conn, $del_query);
		if(!$result)
		{
			die("couldn't upload the requested query ".mysqli_error($conn));
		}
		$del_query = 'DELETE FROM question where TOPIC_ID='.$_POST['topic_id'];
		$result = mysqli_query($conn, $del_query);
	}

?>
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Admin | questions</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
    <body>
    	<img src="../assets/img/backgrounds/plain.jpg" class="bg">
        <?php include_once(LIB_PATH.DS.'layouts/navbar.php') ?>
    	<div class="container inner-bg">
			<?php include_once(LIB_PATH.DS.'layouts/navbar.php'); ?>
	        <div class="page-content ">	        	
	        	<?php if(isset($_SESSION['message'])) { ?>
	        	<div id="message"> <?php echo $_SESSION['message']; ?> </div>	
	        		<?php unset($_SESSION['message']) ;} ?>
	        	<div id = "addnewtopics" style="float: right">
					<form method="post"> 
						<input type="text" name="topic" id="topic"> 
						<input type="submit" value="Add Topic" name="submit_topic" id="submit_topic"> 
					</form>
				</div>
				
				<h1>Topics</h1>
				<table id="quest_container" class="table-content" style="width:50%">
					<tr>
						<th>Topic</th>
						<th>Number of Questions</th>
					</tr>
					<?php 
					$topic_query = 'SELECT * FROM testtopics';
					$topic_result = mysqli_query($conn, $topic_query);
					if($topic_result && mysqli_num_rows($topic_result)>0) 
						while($topic = mysqli_fetch_array($topic_result))
						{
							$topic_nques_query = "SELECT COUNT(*) FROM question, testtopics WHERE question.TOPIC_ID = ".$topic["ID"]." and question.TOPIC_ID = testtopics.ID;";
							$result = mysqli_query($conn, $topic_nques_query);							
							echo '<tr id=t'.$topic["ID"].'><th><a href="ques_check_admin.php?topic='.$topic["ID"].'">'.$topic["TOPIC"].'</a></th><th>'.mysqli_fetch_array($result)[0].'</th><th><a id='.$topic["ID"].' href="" onClick=deleteTopic('.$topic["ID"].')>Delete</a></th></tr>';
						} 
					?>
				</table>
			</div>
		</div>
		<script>
		function addtopic()
		{
			var formdata = new FormData();
			var topic =  document.getElementById("topic").value;
			formdata.append("submit_topic", topic);
			$.ajax({
				type: "POST",
				url: "admin_ques.php",
				data: formdata,
				success: function(e)
				{
					var table = document.getElementById("quest_container").value;
					if(this.responseText!=-1)
						table = table+'<tr><th><a href="ques_check_admin.php?topic='+this.responseText+'">'+topic+'</a></th><th>0</th></tr>';
					document.getElementById("quest_container").value = table;
					console.log(this.response);	
				}
			});
		}
		function deleteTopic(topic_id)
		{
			var formdata = new FormData();
			formdata.append('instruction','topic_delete');
			formdata.append('topic_id',topic_id);
			
			$.ajax({
				type: 'POST',
				url: 'admin_ques.php',
				data: formdata,
				async: false,
				contentType: false,
				processData: false,						
				success: function(e)
				{
					$("#t"+topic_id).remove();
				}
			});
		}
	    
		document.getElementById("submit_topic").addEventListener("click",function(e){addtopic()}, false);
		</script>
		<?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?> 
    </body>
</html>
