<?php

	require_once('../includes/initialize.php');
	if(!isset($_SESSION['user'])) {
		 header('Location: ../home.php');
	}	

	$TestDuration = "01:30:00";

	
?>
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Online Test</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<link rel="stylesheet" href="../assets/css/dashboard.css">
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>

<body>
	<img src="../assets/img/backgrounds/plain.jpg" class="bg">
	<?php include_once(LIB_PATH.DS.'layouts/navbar.php') ?>
	<div class="container inner-bg" >
		<div id="Timer"></div>
		<div class="header">
			<h1><strong>Online Test</strong> </h1>
		</div>	
		<div class="page-content inner-bg">
			<form name="onlineTest" action="test_results.php" method="post">
				<?php 
					$query = "SELECT * FROM testtopics" ;
					$result = mysqli_query($conn, $query);
					if(!$result) 
					{
						die('query failed at accessing topics');
					} 
					else 
					{
						$total_questions = 0;
						$section_count = 0;
						while($topic_set = mysqli_fetch_array($result)) 
						{
							$query = "SELECT * FROM question where TOPIC_ID = '{$topic_set['ID']}'";
							$res = mysqli_query($conn, $query);
							if(!$res) 
							{
								die('query failed at accessing questions');
							}
							else 
							{
								$i = 1;
								while($ques_arrays = mysqli_fetch_array($res))
								{
									$section[$i]['question'] = $ques_arrays['QUESTION'];
									for($k=1; $k<=4; $k++)
									{
										$section[$i]['option'.$k] = $ques_arrays['OPTION'.$k];	
									}
									$section[$i]['correct_option'] = $ques_arrays['ANSWER'];
									if($ques_arrays['FILENAME'] != NULL)
									{
										$q = "SELECT FILENAME FROM question WHERE question = '{$ques_arrays['QUESTION']}' ; " ;
										$r = mysqli_query($conn, $q);
										if(!$r) 
										{
											die("error at bringing pics details");
										}
										else 
										{
											$fn = mysqli_fetch_array($r);
											$section[$i]['filename'] = $fn['FILENAME'];
										}
									}
									$i++;
									$total_questions++;
								}
								$section_count++;	
							}
							
						}
					}	

					//setting the questions into an array
					$Test_ques_no = 20;
					$q_no = 1 ;
					$y = rand(1,$total_questions+1);
					while($q_no <= 20)
					{						
						if($y>=$total_questions+1) 
							$y = 1;
						if(isset($section[$y]))
						{
							$final_question_set[$q_no] = $section[$y];
							$q_no++;
						}						
						$y++;
					}
					$_SESSION['test_questions'] = $final_question_set;
						//questions Implementation
					$i = 1;
						while($i<=20)
						{?>
							<div class="questions">
								<div id="Q<?php echo $i; ?>">
									<div class="q_head">
										<span ><?php echo $i. ". &nbsp  &nbsp"; ?></span><?php echo $final_question_set[$i]['question'];?>
									</div>
									<?php if(isset($final_question_set[$i]['filename'])){ ?>
									<div>
										<img src="../assets/img/onlinetest_pics/<?php $final_question_set[$i]['filename']; ?>" height="100px">
									</div>
										<?php } ; ?>
									<div class="q_ans">
										<?php 
											$j = rand(1,4);
											for($k=1; $k<5; $k++){
												if($j>4) { $j = $j - 4 ;}
												?>
												<input type="radio" name="question<?php echo $i; ?>" value="<?php echo $final_question_set[$i]['option'.$j]; ?>" >
												<span style="padding-right:20px">
													<?php echo $final_question_set[$i]['option'.$j]; ?>
												</span>	
												</input>
												<br>
												<?php 
													$j++;
											}
												?>
											</div>
										</div>
									</div>	
									<?php	
							$i++;		
						};
					?>
					<div style="text-align:center; float: center;padding:50px;">
						<input type="hidden" name="TotalCount" value="<?php echo $Test_ques_no; ?>">
						<input type="submit" name="Submit_test" value="Submit Answers" ></input>
					</div>
					<div id="timer_submit">
						<div id="ts_content">
							<div>Your time is Up!! Click the button below to submit</div>
							<input type="submit" name="Submit_test" value="Submit Answers"></input>							
						</div>
					</div>
				</form>				
			</div>
		</div>	
		<script type="text/javascript">
			hours = 0;
		    mins = 02;
		    seconds = 0;
		    Timer = setInterval(changeTime,1000);

		    function changeTime() {
	    		if(seconds == -1){
		    		seconds = 59;
			    	mins = mins-1;
			    }	
			    if(mins == -1){
			    	mins = 59;
			    	hours = hours -1;
			    }
			    if(hours == -1) {
					document.getElementById("timer_submit").style.display = "block";							    		
			    } else {
					document.getElementById("Timer").innerHTML = hours + " : " + mins + " : " + seconds;
			    }
	    		seconds = seconds - 1;
		    }
		</script>
		<?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>
	</body>
</html>
