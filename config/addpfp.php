<?php
include('RegisterController.php');
include('app.php');
$redirect = $_GET['redirect'];
$CLIENT_ID = "729e4118d3dcc356fe2898137c127b63"; 

$UserID =  (!empty($_POST["UserID"]))?$_POST["UserID"]:"";
    $oldImage= (!empty($_POST["pfp"]))?$_POST["pfp"]:"";
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "fyp";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

if (isset($_POST['updatePFP']))
{   
    

//means no image uploaded
 if (!($_FILES['fileUpload']['error'] == 4)){
 if ($_FILES['fileUpload']['error'] === UPLOAD_ERR_OK){
  // get details of the uploaded file
  $fileTmpPath = $_FILES['fileUpload']['tmp_name'];
  $fileName = $_FILES['fileUpload']['name'];
  $fileSize = $_FILES['fileUpload']['size'];
  $fileType = $_FILES['fileUpload']['type'];
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
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.imgbb.com/1/upload?key=$CLIENT_ID");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    
    $imageData = file_get_contents($Image);
    $imageFile = new CURLFile($Image, mime_content_type($Image), basename($Image));
    curl_setopt($ch, CURLOPT_POSTFIELDS, ["image" => $imageFile]);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) {
        die("cURL Error: " . curl_error($ch));
    }
    
    $responseData = json_decode($response, true);
    
    if (isset($responseData['data']['url']) && isset($responseData['data']['delete_url'])) {
        $imgURL = $_SESSION['auth_user']['imgURL'] = $responseData['data']['url'];
    } else {
        echo "Failed to retrieve image URLs from imgBB API.";
    }

			// Check connection
			if (!$conn) {
			 die("Connection failed: " . mysqli_connect_error());
			}
			$sql="UPDATE user SET pfp = '$ImageLoc', imgURL = '$imgURL'   WHERE UserID = '$UserID'";
            
            if(mysqli_query($conn,$sql)){

                if($oldImage!=NULL){
                    unlink("../".$oldImage);
                }

                $_SESSION['auth_user']['user_pfp'] = $ImageLoc;
				echo '<script type="text/javascript">
                alert("Profile Picture Updated!';
                if($redirect!=""){
                echo ' ");
                    window.location ="../'.$redirect;
                }else{
                echo ' ");
                    window.location ="../home.php';
                }
              
                echo'";
                    </script>';
                
			}else{
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
  $message .= 'Error:' . $_FILES['fileUpload']['error'];
 
 echo $message;
 echo '<br><a href="../home.php">Try Again</a>';
 }
 }
 else{
    
        if (!$conn) {
			 die("Connection failed: " . mysqli_connect_error());
			}

			echo '<script type="text/javascript">
             alert("No picture uploaded!';
             if($redirect!=""){
            echo ' ");
                window.location ="../'.$redirect;
            }else{
            echo ' ");
                window.location ="../home.php';
            }
          
            echo'";
                </script>';
                
		
		mysqli_close($conn);    
 }
};

if (isset($_POST['deletePFP'])){
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
       }
   $sql="UPDATE user SET pfp = NULL, imgURL= NULL  WHERE UserID = '$UserID'";
   

   if(mysqli_query($conn,$sql)){
       if($oldImage!=NULL){
           unlink("../".$oldImage);
       }   

       $_SESSION['auth_user']['user_pfp'] = NULL;

       echo '<script type="text/javascript">
        alert("Deleting current picture';
        if($redirect!=""){
       echo ' ");
           window.location ="../'.$redirect;
       }else{
       echo ' ");
           window.location ="../home.php';
       }
     
       echo'";
           </script>';
           
   }else{
       echo "Error: " . $sql . "<br>" . mysqli_error($conn);
       echo '<br><a href="../home.php">Try Again</a>';
   }
   mysqli_close($conn);    
}
?>