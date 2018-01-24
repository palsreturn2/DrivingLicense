<?php

require_once('../includes/initialize.php');
	if(!isset($_SESSION['rto'])) {
		header("Location: ../home.php");
	}


$rtoid = $_SESSION['rtoid'];
$uniqID = $_GET['id'];

$sql = "SELECT * FROM applications WHERE ID = {$uniqID}";
$result =  mysqli_query($conn,$sql);
$appRow = mysqli_fetch_array($result);

$sqldoc = "SELECT * FROM fileuploads WHERE APPLICATION_ID = {$uniqID}";
$docRow = mysqli_fetch_array(mysqli_query($conn, $sqldoc));


if (isset($_POST['approved'])) {
    $sqlApprove = "UPDATE applications SET STATUS='Approved' WHERE ID='$uniqID'; ";
    mysqli_query($conn, $sqlApprove);
    header("Location: applications_view.php");
}

if (isset($_POST['rejected'])) {
    $sqlApprove = "UPDATE applications SET STATUS='Rejected' WHERE ID='$uniqID'; ";
    mysqli_query($conn, $sqlApprove);
    header("Location: applications_view.php");
    
}

?>

<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Admin | Documents check</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>

	<body>
		<div class="anks">
			<img src="../assets/img/backgrounds/plain.jpg" class="bg">
			<?php include_once(LIB_PATH.DS.'layouts/navbar.php'); ?>
			<div class="top-content">
				<div style="padding-bottom: 170px">
					<div class="container">
						<div class="row">
							<div class="col-sm-12 text" style="padding-top: 40px" >
								<div style="color: #fff">                            	
									<h1 style="color: #fff"><strong>Upload</strong> Documents</h1>
								</div>
							</div>
						</div>
						<br>

						<div class="row">
							<div class="col-sm-6 col-sm-offset-3 form-box">
								<form role="form" method="POST" class="registration-form">
									<div class="form-top">
										<div class="form-top-left">
											<h3> The Following Documents were uploaded</h3>
										</div>
										<div class="form-top-right">
											<i class="fa fa-file"></i>
										</div>
									</div>
									<div class="form-bottom">
										<div class="form-group form-inline" style="text-align: center;">
											<a target="_blank" href="documentsimageview.php?id=<?php echo $uniqID."&file=".$docRow['PHOTO_NAME'];  ?>">Photograph</a>
										</div>
										<div class="form-group form-inline" style="text-align: center;">
											<a target="_blank" href="documentsimageview.php?id=<?php echo $uniqID."&file=".$docRow['SIGNATURE_NAME']; ?>">Signature</a>
										</div>

										<div class="form-group form-inline" style="text-align: center;">
											<a target="_blank" href="documentsimageview.php?id=<?php echo $uniqID."&file=".$docRow['IDPROOF_NAME']; ?>">ID Proof</a>
										</div>

										<div class="form-group form-inline" style="text-align: center;">
 											<a target="_blank" href="documentsimageview.php?id=<?php echo $uniqID."&file=".$docRow['ADDRESS_PROOF_NAME'];?>">Address Proof</a>
										</div>
										<div align="center">
											<button name="approved" type='submit' id="approved" class="btn">Approve Application</button>
											<button name="rejected" type="submit" id="reject" class="btn btn-danger">Reject Application</button>
										</div> 
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>
		<script src="assets/js/retina-1.1.0.min.js"></script>
	</body>

</html>
