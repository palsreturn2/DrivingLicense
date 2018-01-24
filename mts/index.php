<?php
require_once('../includes/initialize.php');

if(!isset($_SESSION['mts'])) {
	header("Location: ../home.php");
}

date_default_timezone_set("Asia/Kolkata");

$email = $_SESSION['mts'];
$sql = "SELECT * FROM logindetails WHERE EMAIL = '{$email}'";
$result =  mysqli_query($conn,$sql);
$userRow = mysqli_fetch_array($result);

$sqlapp = "SELECT * FROM applications WHERE EMAIL = '{$email}'";
$result = mysqli_query($conn, $sqlapp);
if($result && mysqli_num_rows($result)>0)
{
	$appRow = mysqli_fetch_array();
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
                                <h1><strong>Driving License</strong> MTS Dashboard</h1>
                                <h3><a>Applications</a></h3>
                                <h3><a href=""></a></h3>
                            </div>

                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>
    </body>
</html>
