<?php
require_once('../includes/initialize.php');
if(!isset($_SESSION['user'])) {
	header("Location: ../home.php");
}
if($_SESSION['AppStatus']!="Saved") {
	header("Location: newapplication.php");
}



$email = $_SESSION['user'];
$sql = "SELECT * FROM logindetails WHERE EMAIL = '$email';";
$result =  mysqli_query($conn,$sql);

if($result && mysqli_num_rows($result) > 0)
{
	$userRow = mysqli_fetch_array($result,MYSQLI_ASSOC);
}

$sqlapp = "SELECT * FROM applications WHERE EMAIL = '$email';";
$result = mysqli_query($conn, $sqlapp);
if($result && mysqli_num_rows($result) > 0)
{
	$appRow = mysqli_fetch_array($result, MYSQLI_ASSOC);
}

$email = $appRow['EMAIL'];
$uniqID = $appRow['ID'];

// if ($appRow['Status']=="Submitted Succesfully - Decision Pending") {
//     header("Location: status.php");
// }

$sqldoc = "SELECT * FROM fileuploads WHERE ID = SELECT APPLICATION_ID FROM applications WHERE EMAIL = '$email';";
$result = mysqli_query($conn, $sqldoc);
if($result && mysqli_num_rows($result) > 0)
{
	$docRow = mysqli_fetch_array($result, MYSQLI_ASSOC);
}

// if (isset($docRow)) {
//     header("Location: review.php");
// }


//UPLOADING DOCUMENTS...


if (isset($_POST['upload']) && $_FILES['file-photo']['size']>0) 
{
    mkdir(SITE_ROOT.DS."assets/application images/".$uniqID);

    $fileNamePhoto = $_FILES['file-photo']['name'];
    $tmpNamePhoto = $_FILES['file-photo']['tmp_name'];
    $fileSizePhoto = $_FILES['file-photo']['size'];
    $fileTypePhoto = $_FILES['file-photo']['type'];
    $target_path = SITE_ROOT.DS."assets/application images/".$uniqID."/".$fileNamePhoto;
    move_uploaded_file($tmpNamePhoto,$target_path);

    $fp = fopen($target_path, 'r');
    $contentPhoto = fread($fp, filesize($target_path));
    $contentPhoto = addslashes($contentPhoto);
    fclose($fp);

    if (!get_magic_quotes_gpc()) 
	{
        $fileNamePhoto = addslashes($fileNamePhoto);
    }

    $fileNameSign = $_FILES['file-sign']['name'];
    $tmpNameSign = $_FILES['file-sign']['tmp_name'];
    $fileSizeSign = $_FILES['file-sign']['size'];
    $fileTypeSign = $_FILES['file-sign']['type'];
    $target_path = SITE_ROOT.DS."assets/application images/".$uniqID."/".$fileNameSign;
    move_uploaded_file($tmpNameSign,$target_path);

    $fp = fopen($target_path, 'r');
    $contentSign = fread($fp, filesize($target_path));
    $contentSign = addslashes($contentSign);
    fclose($fp);

    if (!get_magic_quotes_gpc()) 
	{
        $fileNameSign = addslashes($fileNameSign);
    }

    $fileNameID = $_FILES['file-id-proof']['name'];
    $tmpNameID = $_FILES['file-id-proof']['tmp_name'];
    $fileSizeID = $_FILES['file-id-proof']['size'];
    $fileTypeID = $_FILES['file-id-proof']['type'];
    $target_path = SITE_ROOT.DS."assets/application images/".$uniqID."/".$fileNameID;
    move_uploaded_file($tmpNameID,$target_path);

    $fp = fopen($target_path, 'r');
    $contentID = fread($fp, filesize($target_path));
    $contentID = addslashes($contentID);
    fclose($fp);

    if (!get_magic_quotes_gpc()) 
	{
		$fileNameID = addslashes($fileNameID);
    }

    $fileNameAdd = $_FILES['file-add-proof']['name'];
    $tmpNameAdd = $_FILES['file-add-proof']['tmp_name'];
    $fileSizeAdd = $_FILES['file-add-proof']['size'];
    $fileTypeAdd = $_FILES['file-add-proof']['type'];
    $target_path = SITE_ROOT.DS."assets/application images/".$uniqID."/".$fileNameAdd;
    move_uploaded_file($tmpNameAdd,$target_path);

    $fp = fopen($target_path, 'r');
    $contentAdd = fread($fp, filesize($target_path));
    $contentAdd = addslashes($contentAdd);
    fclose($fp);

    if (!get_magic_quotes_gpc()) 
	{
        $fileNameAdd = addslashes($fileNameAdd);
    }


    if (isset($docRow['ID'])) 
	{

        $uploadQueryUpdate = "UPDATE fileuploads SET PHOTO_NAME='$fileNamePhoto', PHOTO_TYPE='$fileTypePhoto', PHOTO_SIZE='$fileSizePhoto', PHOTO_CONTENT='$contentPhoto', SIGNATURE_NAME='$fileNameSign', SIGNATURE_TYPE='$fileTypeSign', SIGNATURE_SIZE='$fileSizeSign', SIGNATURE_CONTENT='$contentSign', IDPROOF_NAME='$fileNameID', IDPROOF_TYPE='$fileTypeID', IDPROOF_SIZE='$fileSizeID', IDPROOF_CONTENT='$contentID', ADDRESS_PROOF_NAME='$fileNameAdd', ADDRESS_PROOF_TYPE='$fileTypeAdd', ADDRESS_PROOF_SIZE='$fileSizeAdd', ADDRESS_PROOF_CONTENT='$contentAdd' WHERE APPLICATION_ID='$uniqID';";

        mysqli_query($conn, $uploadQueryUpdate);
    }

    else 
	{

        $uploadQuery = "INSERT INTO fileuploads (APPLICATION_ID, PHOTO_NAME, PHOTO_TYPE, PHOTO_SIZE, PHOTO_CONTENT, SIGNATURE_NAME, SIGNATURE_TYPE, SIGNATURE_SIZE, SIGNATURE_CONTENT, IDPROOF_NAME, IDPROOF_TYPE, IDPROOF_SIZE, IDPROOF_CONTENT, ADDRESS_PROOF_NAME, ADDRESS_PROOF_TYPE, ADDRESS_PROOF_SIZE, ADDRESS_PROOF_CONTENT) VALUES ('$uniqID', '$fileNamePhoto', '$fileTypePhoto', '$fileSizePhoto', '$contentPhoto', '$fileNameSign', '$fileTypeSign', '$fileSizeSign', '$contentSign', '$fileNameID', '$fileTypeID', '$fileSizeID', '$contentID', '$fileNameAdd', '$fileTypeAdd', '$fileSizeAdd', '$contentAdd') ;";

        $res = mysqli_query($conn, $uploadQuery);
        if(!$res)
		{
            die(mysqli_error($conn));
        }
    }

    $_SESSION['uploads'] = 1;

    header("Location: submitted.php");
}

?>
<!-- Top content -->
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Upload Documents</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
    <body>
        <div class="anks">
            <img src="../assets/img/backgrounds/plain.jpg" class="bg">
            <?php include_once(LIB_PATH.DS.'layouts/navbar.php'); ?>
            <div class="top-content inner-bg">
                <div style="padding-bottom: 170px">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 text" style="padding-top: 40px" >
                            <div style="color: #fff">
                            	<span class="li-text">Your Application ID is <b><?php echo $appRow['ID']; ?></b>. To Review or Edit the Application Click <a href="newapplication.php" style="color: yellow"><b>here</b></a></span>
                                <h1 style="color: #fff"><strong>Upload</strong> Documents</h1>
                            </div>
                            </div>
                        </div>

                            <br>

                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3 form-box">
                                <form role="form" action="uploaddocs.php" method="POST" enctype="multipart/form-data" class="registration-form">
                                        <div class="form-top">
                                            <div class="form-top-left">
                                                <h3> The Following Documents are required to be uploaded</h3>
                                            </div>
                                            <div class="form-top-right">
                                                <i class="fa fa-file"></i>
                                            </div>
                                        </div>
                                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                                        <div class="form-bottom">
                                            <div class="form-group form-inline">
                                                <label for="file-photo" class="upload-label">Photograph</label>
                                                <input type="file" name="file-photo" placeholder="Photograph" class="form-control" id="file-photo">
                                            </div>
                            
                                            <div class="form-group form-inline">
                                                <label for="file-sign" class="upload-label">Signature</label>
                                                <input type="file" name="file-sign" placeholder="Signature" class="form-control" id="file-sign">
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="file-id-proof" class="upload-label">ID Proof</label>
                                                <input type="file" name="file-id-proof" class="form-control" id="file-id-proof">
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="file-id-proof" class="upload-label">Address Proof</label>
                                                <input type="file" name="file-add-proof" class="form-control" id="file-add-proof">
                                            </div>
                                            <button name="upload" type="submit" id="upload" class="btn">Upload</button>
                                            
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
        <?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>
    </body>

</html>