<?php
require_once('../includes/initialize.php');

if(!isset($_SESSION['admin'])) {
	header("Location: ../home.php");
}

date_default_timezone_set("Asia/Kolkata");


$email = $_SESSION['admin'];
$sql = "SELECT * FROM logindetails WHERE EMAIL = '$email';";
$result =  mysqli_query($conn,$sql);
if($result && mysqli_num_rows($result)>0)
{
	$userRow = mysqli_fetch_array($result);
}

if(isset($_GET['rto_office'])) 
{
    $rtoname = $_GET['rto_office'];
} else 
{
    $rtoname = NULL;
}

$sqlapp = "SELECT * FROM applications WHERE EMAIL = '$email' and VISITING_RTO = '{$rtoname}' ;";
$result = mysqli_query($conn, $sqlapp);
if($result && mysqli_num_rows($result)>0)
{
	$appRow = mysqli_fetch_array($result);
}

?>





<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Admin | applicants</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>

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
                                <h1><strong>Driving License Applications</strong>
                                    <?php if($rtoname !=NULL){
                                        echo "(RTO - ".$rtoname.")";
                                    } ?>
                                </h1>
                                <div class="top-big-link">
                                   <table class="table">
                                        <tr>
                                            <th style="text-align: center;">S.No</th>
                                            <th style="text-align: center;">Applied Date and Time</td>
                                            <th style="text-align: center;">Application ID</th>
                                            <th style="text-align: center;">Full name</th>
                                            <th style="text-align: center;">Email</th>
                                            <?php if($rtoname==NULL) { echo '<th style="text-align: center;">Preferred RTO</th>'; } ?>
                                            <th style="text-align: center;">Status</th>
                                        </tr>
                                        <?php
                                            $sqlAdminList = "SELECT VISITING_RTO,TIMESTAMP,USER_UPDATE_TIME,FIRSTNAME,LASTNAME, ID, EMAIL, STATUS FROM applications " ;
                                            if ($rtoname!=NULL) {
                                                $sqlAdminList .= "WHERE VISITING_RTO = '{$rtoname}' "; 
                                            };
                                            $sqlAdminList .= "ORDER BY USER_UPDATE_TIME DESC;";
                                            $adminListResult = mysqli_query($conn, $sqlAdminList);
                                            $counter = 1;
                                            if ($adminListResult && mysqli_num_rows($adminListResult) > 0) {

                                                while ($appRow = mysqli_fetch_array($adminListResult)) {
                                                    if ($appRow['STATUS']!="Approved"){
                                                        $adminStatus = "Not Approved";
                                                    } if ($appRow['STATUS']=="Approved") {
                                                        $adminStatus = "Approved";
                                                    } if ($appRow['STATUS']=="Rejected") {
                                                        $adminStatus = "Rejected";
                                                    } 

                                                    $query = "SELECT SIGNATURE_NAME,PHOTO_NAME from fileuploads WHERE APPLICATION_ID='$appRow[ID]'; ";
                                                    $result = mysqli_query($conn, $query);
                                                    $filelist = mysqli_fetch_array($result);

                                                    echo "
                                                        <tr>
                                                            <td>".$counter."</td>                                                            
                                                            <td>".$appRow['TIMESTAMP']."</td>
                                                            <td><a target='_blank' href='adminformview.php?id=".$appRow['ID']."&signfile=".$filelist['SIGNATURE_NAME']."&picfile=".$filelist['PHOTO_NAME']."'><b>".$appRow['ID']."</b></a></td>
                                                            <td>".ucfirst($appRow['FIRSTNAME'])." ".ucfirst($appRow['LASTNAME'])."</td>
                                                            <td>".$appRow['EMAIL']."</td>";
                                                    if($rtoname == NULL) {
                                                        echo "<td><a href='admin_applicants.php?rto_office=".$appRow['VISITING_RTO']."' >".ucfirst($appRow['VISITING_RTO'])."</td>";
                                                    }
                                                    echo "<td><a href='documentscheck.php?id=".$appRow['ID']."'><b>".$adminStatus."</b></a></td>


                                                    ";
                                                    $counter++;
                                                }

                                            }
                                        

                                        ?>

                                   </table>



                                </div>
                            </div>

                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>

    </body>


</html>