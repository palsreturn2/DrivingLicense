<?php
require_once('../includes/initialize.php');

if(!isset($_SESSION['rto'])) {
	header("Location: ../home.php");
}

date_default_timezone_set("Asia/Kolkata");

$userid = $_SESSION['userid'];
$email = $_SESSION['rto'];

$sql = "SELECT ID FROM regionaltrainingoffice WHERE USER_ID={$userid}";
$result = mysqli_query($conn, $sql);

if($result)
{
	$rtoid = mysqli_fetch_array($result)['ID'];
	$_SESSION["rtoid"] = $rtoid;
}
else
{
	die();
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>MTS | applicants</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>

    <body>
        <div class="anks">    
            <img src="../assets/img/backgrounds/plain.jpg" class="bg">
            <?php include_once(LIB_PATH.DS.'layouts/navbar.php') ?>
            <!-- Top content -->
            <div class="top-content">
            	
                <div class="inner-bg" >
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text">
                                <h1><strong>Driving License</strong> RTO Dashboard</h1>
                                <h3><a href="applications_view.php">Applications</a></h3>                                
                            </div>

                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>
    </body>
</html>
