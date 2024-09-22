<?php
include('app.php');
include_once 'Topic.php';
include_once 'Post.php';
include_once 'Consultants.php';
include_once 'Requests.php';
include_once 'RegisterController.php';

$topic = new Topic();
$post = new Post();
$consultants = new Consultant();
$request = new Requests();
$usersystem = new LoginController();

$requests = $_GET['request'];

if($_SESSION['auth_user']['user_type']=="Admin"){


if($requests=="deletePost"){
	$post->post_id = $_GET['postID'];	
	$post->topic_id = $_GET['topicID'];	
	$post->deletePost();
}

if($requests=="deleteTopic"){	
	$topic->topic_id = $_GET['topicID'];	
	$topic->deleteTopic();
}

if($requests=="deleteConsultant"){
    $consultantID = $_GET['consultantID'];
    $consultants->deleteConsultant($consultantID);
}

if($requests=="editRequest"){
    $requestID = $_POST['requestID'];
    $userID = $_POST['user-id'];
    $consultantID = $_POST['consultant-selection'];
    $userPhone = $_POST['user-phone'];
    $dateInput = (!empty($_POST['booking-date']))?$_POST['booking-date']: NULL;
    $timeInput = (!empty($_POST['booking-time']))?$_POST['booking-time']: NULL;
    $combinedDateTime = $dateInput . ' ' . $timeInput;
    $dateTimeObject = new DateTime($combinedDateTime);
    $msg = (!empty($_POST["message"]))?$_POST["message"]:"";
    if($request->editRequest($requestID,$userID,$consultantID,$userPhone,$dateTimeObject,$msg)){
        header("Location: ../request.php");
    };
}

if($requests=="editUserType"){
    $redirect= $_GET['redirect'];
    $userID= $_POST['admin-select-user-id'];
    $typeChange = $_POST['admin-select-acctype'];
    if($usersystem->editUserType($userID,$typeChange)){
        header("Location: ../$redirect");
    };
}


}

if($_SESSION['auth_user']['user_type']=="Admin" || $_SESSION['auth_user']['user_type']=="Consultant" ){
	if($requests=="editConsultant"){
	if ($_POST['submit'] == 'Update Consultant'){   
    $UserID =  (!empty($_POST["consultant-id"]))?$_POST["consultant-id"]:"";
    $oldImage= (!empty($_POST["consultant-pic"]))?$_POST["consultant-pic"]:"";
    $CName =  (!empty($_POST["consultant-name"]))?$_POST["consultant-name"]:"";
	$CEmail =  (!empty($_POST["consultant-email"]))?$_POST["consultant-email"]:"";
	$CPhone =  (!empty($_POST["consultant-phone"]))?$_POST["consultant-phone"]:"";
    $startHours = (!empty($_POST['consultant-starthours']))?$_POST['consultant-starthours']:"";
    $endHours = (!empty($_POST['consultant-endhours']))?$_POST['consultant-endhours']:"";
    $start12Hour = strtoupper(date('g:ia', strtotime($startHours)));
    $end12Hour = strtoupper(date('g:ia', strtotime($endHours)));
	$CHours =  "{$start12Hour}-{$end12Hour}";
	$CPlace =  (!empty($_POST["consultant-place"]))?$_POST["consultant-place"]:"";
    $CAbout =  (!empty($_POST["consultant-about"]))?$_POST["consultant-about"]:"";

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "fyp";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

//means no image uploaded
 if (!($_FILES['PicUpload']['error'] == 4)){
 if ($_FILES['PicUpload']['error'] === UPLOAD_ERR_OK){
  // get details of the uploaded file
  $fileTmpPath = $_FILES['PicUpload']['tmp_name'];
  $fileName = $_FILES['PicUpload']['name'];
  $fileSize = $_FILES['PicUpload']['size'];
  $fileType = $_FILES['PicUpload']['type'];
  $fileNameCmps = explode(".", $fileName);
  $fileExtension = strtolower(end($fileNameCmps));
    
  // sanitize file-name and getting form value
  $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

  // check if file has one of the following extensions
  $allowedfileExtensions = array('jpg', 'png');

  if (in_array($fileExtension, $allowedfileExtensions))
  {
   // directory in which the uploaded file will be moved
   $uploadFileDir = "../img/profile-pics/";
   $actualFileDir = "img/profile-pics/";
   //$dest_path = $uploadFileDir . $fileName;
	 $Image = $uploadFileDir . $newFileName;
     $ImageLoc = $actualFileDir . $newFileName;

   if(move_uploaded_file($fileTmpPath,$Image)) 
   {
    $message ='File is successfully uploaded.';

			// Check connection
			if (!$conn) {
			 die("Connection failed: " . mysqli_connect_error());
			}
			$sql = "UPDATE consultant SET consultantPic = ?, consultantName = ?, consultantEmail = ?, consultantPhone = ?, consultantHours = ?, consultantPlace = ?, consultantAbout = ? WHERE ConsultantID = ?";

// Create a prepared statement
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind parameters to the placeholders
    mysqli_stmt_bind_param($stmt, "sssssssi", $ImageLoc, $CName, $CEmail, $CPhone, $CHours, $CPlace, $CAbout, $UserID);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        if ($oldImage != NULL) {
            unlink("../" . $oldImage);
        }

        echo '<script type="text/javascript">
            alert("Consultant Updated !");
            window.location = "../consultant.php";
            </script>';
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
        echo '<br><a href="../home.php">Try Again</a>';
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error in preparing the statement: " . mysqli_error($conn);
    echo '<br><a href="../home.php">Try Again</a>';
}
			mysqli_close($conn);
   }
   else{
    $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
   }
  }
  else{
   $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
  }

 }
 else{
  $message = 'There is some error in the file upload. Please check the following error.<br>';
  $message .= 'Error:' . $_FILES['PicUpload']['error'];
 
 echo $message;
 echo '<br><a href="../home.php">Try Again</a>';
 }
 }
 else{
    
        if (!$conn) {
			 die("Connection failed: " . mysqli_connect_error());
			}
			$sql = "UPDATE consultant SET consultantName = ?, consultantEmail = ?, consultantPhone = ?, consultantHours = ?, consultantPlace = ?, consultantAbout = ? WHERE ConsultantID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssssssi", $CName, $CEmail, $CPhone, $CHours, $CPlace, $CAbout, $UserID);
                if (mysqli_stmt_execute($stmt)) {
                echo '<script type="text/javascript">
                    alert("Consultant Updated !");
                    window.location = "../consultant.php";
                    </script>';
            } else {
                echo "Error: " . mysqli_stmt_error($stmt);
                echo '<br><a href="../home.php">Try Again</a>';
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error in preparing the statement: " . mysqli_error($conn);
            echo '<br><a href="../home.php">Try Again</a>';
        }
			        mysqli_close($conn);
 	        }
        };

        }

//ADD CONSULTANT
if($requests=="addConsultant"){
	if ($_POST['submit'] == 'Add Consultant'){   
    $UserID =  (!empty($_POST["consultant-id"]))?$_POST["consultant-id"]:"";
    $CName =  (!empty($_POST["consultant-name"]))?$_POST["consultant-name"]:"";
	$CEmail =  (!empty($_POST["consultant-email"]))?$_POST["consultant-email"]:"";
	$CPhone =  (!empty($_POST["consultant-phone"]))?$_POST["consultant-phone"]:"";
	$startHours = (!empty($_POST['consultant-starthours']))?$_POST['consultant-starthours']:"";
    $endHours = (!empty($_POST['consultant-endhours']))?$_POST['consultant-endhours']:"";
    $start12Hour = strtoupper(date('g:ia', strtotime($startHours)));
    $end12Hour = strtoupper(date('g:ia', strtotime($endHours)));
	$CHours =  "{$start12Hour}-{$end12Hour}";
	$CPlace =  (!empty($_POST["consultant-place"]))?$_POST["consultant-place"]:"";
    $CAbout =  (!empty($_POST["consultant-about"]))?$_POST["consultant-about"]:"";

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "fyp";

	// Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

//means no image uploaded
 if (!($_FILES['PicUpload']['error'] == 4)){
 if ($_FILES['PicUpload']['error'] === UPLOAD_ERR_OK){
  // get details of the uploaded file
  $fileTmpPath = $_FILES['PicUpload']['tmp_name'];
  $fileName = $_FILES['PicUpload']['name'];
  $fileSize = $_FILES['PicUpload']['size'];
  $fileType = $_FILES['PicUpload']['type'];
  $fileNameCmps = explode(".", $fileName);
  $fileExtension = strtolower(end($fileNameCmps));
    
  // sanitize file-name and getting form value
  $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

  // check if file has one of the following extensions
  $allowedfileExtensions = array('jpg', 'png');

  if (in_array($fileExtension, $allowedfileExtensions))
  {
   // directory in which the uploaded file will be moved
   $uploadFileDir = "../img/profile-pics/";
   $actualFileDir = "img/profile-pics/";
   //$dest_path = $uploadFileDir . $fileName;
	 $Image = $uploadFileDir . $newFileName;
     $ImageLoc = $actualFileDir . $newFileName;

   if(move_uploaded_file($fileTmpPath,$Image)) 
   {
    $message ='File is successfully uploaded.';

			// Check connection
			if (!$conn) {
			 die("Connection failed: " . mysqli_connect_error());
			}
			$sql = "INSERT INTO consultant (consultantName, consultantEmail, consultantPhone, consultantHours, consultantPlace, consultantPic, consultantAbout) VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
            
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssssss", $CName, $CEmail, $CPhone, $CHours, $CPlace, $ImageLoc, $CAbout);
            
                if (mysqli_stmt_execute($stmt)) {
                    echo '<script type="text/javascript">
                        alert("Consultant Added !");
                        window.location = "../consultant.php";
                        </script>';
                } else {
                    echo "Error: " . mysqli_stmt_error($stmt);
                    echo '<br><a href="../home.php">Try Again</a>';
                }
            
                mysqli_stmt_close($stmt);
            } else {
                echo "Error in preparing the statement: " . mysqli_error($conn);
                echo '<br><a href="../home.php">Try Again</a>';
            }
			mysqli_close($conn);
   }
   else{
    $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
   }
  }
  else{
   $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
  }

 }
 else{
  $message = 'There is some error in the file upload. Please check the following error.<br>';
  $message .= 'Error:' . $_FILES['PicUpload']['error'];
 
 echo $message;
 echo '<br><a href="../home.php">Try Again</a>';
 }
 }
 else{
    
        if (!$conn) {
			 die("Connection failed: " . mysqli_connect_error());
			}
			$sql = "INSERT INTO consultant (consultantName, consultantEmail, consultantPhone, consultantHours, consultantPlace, consultantAbout) VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssssss", $CName, $CEmail, $CPhone, $CHours, $CPlace, $CAbout);

                if (mysqli_stmt_execute($stmt)) {
                    echo '<script type="text/javascript">
                        alert("Consultant Added !");
                        window.location = "../consultant.php";
                        </script>';
                } else {
                    echo "Error: " . mysqli_stmt_error($stmt);
                    echo '<br><a href="../home.php">Try Again</a>';
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "Error in preparing the statement: " . mysqli_error($conn);
                echo '<br><a href="../home.php">Try Again</a>';
            }           
			            mysqli_close($conn);
 	            }
            }
}

if($requests=="requestApproval"){
    $requestID = $_POST['requestID'];
    if(isset($_POST['accept'])){
        if($request->acceptRequest($requestID)){
            header("Location: ../request.php");
        };
    }elseif(isset($_POST['reject'])){
        if($request->rejectRequest($requestID)){
            header("Location: ../request.php");
        };
    }
}

}

if($requests=="createRequest"){
    $userID = $_POST['user-id'];
    $consultantID = $_POST['consultant-selection'];
    $userPhone = (!empty($_POST['user-phone']))?$_POST['user-phone']:"NONE";
    $dateInput = (!empty($_POST['booking-date']))?$_POST['booking-date']: NULL;
    $timeInput = (!empty($_POST['booking-time']))?$_POST['booking-time']: NULL;
    $combinedDateTime = $dateInput . ' ' . $timeInput;
    $dateTimeObject = new DateTime($combinedDateTime);
    $approval = (!empty($_POST['approval']))?$_POST['approval']:"PENDING";
    $msg = (!empty($_POST["message"]))?$_POST["message"]:"";
    if($request->createRequest($userID,$consultantID,$userPhone,$dateTimeObject,$approval,$msg)){
        header("Location: ../request.php");
    };
}

if($requests=="deleteRequest"){
    $requestID = $_POST['requestID'];
    if($request->deleteRequest($requestID)){
        header("Location: ../request.php");
    };
}


if($requests=="getconsultantPFP"){
    $consultantID= $_GET['consultantID'];
    $result = $request->getconsultantPFP($consultantID);
    echo $result;
}

if($requests=="getuserPFP"){
    $userID= $_GET['userID'];
    $result = $request->getuserPFP($userID);
    echo $result;
}

if($requests=="getworkHours"){
    $consultantID= $_GET['consultantID'];
    $result = $request->getWorkHours($consultantID);
    echo $result;
}


?>