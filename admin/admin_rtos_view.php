<?php 
	include_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) {
		header("Location: ../adminlogin.php");
	}

	$rtos_array = array();
	$total_rtos = 0;
	$query = "SELECT * FROM regionaltrainingoffice;";
	$result = mysqli_query($conn, $query);
	if(!$result) 
	{		
		die("ERROR: ".mysqli_error($result));
	} 
	else if(mysqli_num_rows($result)>0)
	{
		$count = 0;
		While($x = mysqli_fetch_array($result)) 
		{
            $rtos_array[$count]['rto_id'] = $x['ID'];
			$rtos_array[$count]['rto_name'] = $x['NAME'];
			$rtos_array[$count]['rto_location'] = $x['LOCATION'];
			$rtos_array[$count]['head'] = $x['CONCERNED_PERSON'];
			$rtos_array[$count]['total_employees'] = $x['TOTAL_EMPLOYEES'];
			$rtos_array[$count]['total_vehicles'] = $x['TOTAL_VEHICLES'];
			$rtos_array[$count]['total_systems'] = $x['TOTAL_SYSTEMS'];
			$rtos_array[$count]['applications_capacity'] = $x['APPLICATIONS_CAPACITY'];
			$count++;
		}
		$total_rtos = $count;	
	}
?>
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Admin | applicants</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
	<style>
		table, tr, td, th
		{
			border: 1px solid black;
		}
	</style>
    <body onload="ButtonsEdit()">
        <div class="anks">    
            <img src="../assets/img/backgrounds/plain.jpg" class="bg">

            <?php include_once(LIB_PATH.DS.'layouts/navbar.php') ?>


            <!-- Top content -->
            <div class="top-content">
            	
                <div class="inner-bg" >
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 text">
                                <h1><strong>RTOs list</strong></h1>
                                <div style="float: right"><a href="Add_new_RTO.php"><u>+ ADD new RTO</u></a></div>
                                <div>
                                   <table class="table">
                                        <tr>
                                            <th>S.No</th>
                                            <th>RTO NAME</th>
                                            <th>LOCATION</th>
                                            <th>RTO HEAD</th>
                                            <th>TOTAL EMPLOYEES</th>
                                            <th>APPLICATIONS CAPACITY</th>
                                            <th>SYSTEMS</th>
                                            <th>VEHICLES(available)</th>
                                        </tr>
                                        <?php 	$count = 0;												
                                        		while ($count < $total_rtos) { ?>
                                        <tr>
                                        	<td><?php echo $count; ?></td>
                                        	<td><?php echo ucfirst($rtos_array[$count]['rto_name']); ?></td>
                                        	<td><?php echo ucfirst($rtos_array[$count]['rto_location']); ?></td>
                                        	<td><?php echo ucfirst($rtos_array[$count]['head']); ?></td>
                                        	<td><?php echo ucfirst($rtos_array[$count]['total_employees']); ?></td>
                                        	<td><?php echo ucfirst($rtos_array[$count]['applications_capacity']); ?></td>
                                        	<td><?php echo ucfirst($rtos_array[$count]['total_systems']); ?></td>
                                        	<td><?php echo ucfirst($rtos_array[$count]['total_vehicles']); ?></td>                                            
                                        </tr>
                                        <?php $count++;} ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div> 
    </body> 
</html>
<?php //mysqli_close($conn); ?>                              