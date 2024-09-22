<?php include('config/app.php'); 
include('config/AuthController.php');
include('config/Consultants.php');
$redirect = basename($_SERVER['PHP_SELF']);
$AuthLogin = new AuthenticatorController($redirect);
$consultants = new Consultant();?>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/consultant.css" />
  <link rel="stylesheet" href="css/navbar.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Sen:wght@400;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="tinymce/tinymce.min.js"></script>
  <script src="js/tinymce_editor.js"></script>
  <link rel="icon" href="img/logo.png" type="image/x-icon">
  <title>SuicideNeutralizer | Consultants</title>
  <?php 
    if(!isset($_SESSION['authenticated']) OR $_SESSION['auth_user']['user_type']=="Member"){ ?>
  <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="ad6f3143-98ba-4e8e-9f26-855358541a32";(function(){d=document;s=d.createElement("script");s.src="js/client.crisp.chat.js";s.async=1;var firstScript = document.head.getElementsByTagName("script")[0];
firstScript.parentNode.insertBefore(s, firstScript);})();</script>
  <?php }?>
  <style>.crisp-client .cc-tlyw .cc-kxkl .cc-1hqb .cc-gye0 .cc-11uv .cc-15ak .cc-acjo .cc-nmj4 {display:none !important;}</style>
</head>

<body>

  <?php include('config/navbar.php'); ?>
  <div class="centering">
    <div class="single">
      <label style="font-size:30px;font-weight:700;">Consultants</label>
      <br><br>

      <!-- ADD consultant button for admins and consultants -->
      <?php if($_SESSION['auth_user']['user_type']=="Admin" OR $_SESSION['auth_user']['user_type']=="Consultant") :?>
				<a type="button" class="btn-primary" onclick="document.getElementById('add-consultant-container').style.display='block'"><span id="compose-btn" >Add New Consultant</span></a><br>
        <div id="add-consultant-container" class="modal">
               <div class="consultant-info">
               <div class="grid-span-2">
               <h1>Consultant</h1>
                </div>
               <div class="pfp-contained">
                  <img id="consultant-modal-pic" class="consultant-img" src="img/pfp.jpeg">
                </div>
               <div>
               <span onclick="document.getElementById('add-consultant-container').style.display='none'" class="close" title="Close Modal">&times;</span>
               <form action="config/authActions.php?request=addConsultant" method="POST" enctype="multipart/form-data">
               <h2> Name: <input class="text-box" type="text" name="consultant-name" placeholder="e.g. Ausca Lai" value="" required> </h2> <br>
               <?php if($_SESSION['auth_user']['user_type']=="Consultant"):?>
                <input type="hidden" name="consultant-email" readonly value="<?= $_SESSION['auth_user']['user_email']?>" >
               <?php else:?>
               <h2> Email: <input class="text-box" type="text" name="consultant-email" placeholder="e.g. user@user.com" value=""></h2> <br>
               <?php endif;?>
               <h2> Phone: <input class="text-box" type="text" name="consultant-phone" placeholder="e.g. +60123456789" value="" required></h2> <br>
               <h2> Work Hours:  <input class="text-box" type="time" name="consultant-starthours" style="width:30%;"value="" required>-<input class="text-box" type="time" name="consultant-endhours" style="width:30%;"value="" required></h2> <br>
               <h2> Workplace:  <input class="text-box" type="text" name="consultant-place" placeholder="e.g. Sunway College" value="" required> </h2><br>
               <h2> About Me (optional): </h2> <textarea name="consultant-about" id="add-about"></textarea><br>
               <script>startEditor2("add-about");</script>	
               <h2>
               <label for="fileUpload" class="custom-file-upload"><i class="fa fa-cloud-upload"></i> Upload Picture</label><input id="fileUpload" type="file" name="PicUpload" accept="image/png, image/jpg"/>
               </h2><br>
               <input class="submit-btn" type="submit" value="Add Consultant" name="submit">
               </form>
              </div>
              </div>
             </div>
        <?php endif;?>

        <!--Search Bar-->
				<form id="search-form" action="" method="POST">
          <input class="Search-box" type="text" name="search" placeholder="Search Consultants">
        </form>
        <?php
        $key="";
        if(isset($_GET['consultant'])){
          $key=$_GET['consultant'];
        }
        if(isset($_POST['search'])){
        $key=$_POST['search'];
        }
        ?>
		  <br>
      <div class="consultants-grid">
        
        <?php
					$result = $consultants->getConsultantList($key);
          if(mysqli_num_rows($result) > 0):
					while ($consultant = $result->fetch_assoc()) {
            if($consultant['consultantPic']==NULL){
              $CPic = "img/pfp.jpeg";
            }else{
              $CPic = $consultant['consultantPic'];
            }
					?>

          <!--Displays small consultants-->
						<button class="consultant-btn" onclick="document.getElementById('consultant-container-<?= $consultant['consultantID']?>').style.display='block'">
              <div class="btn-grid">
              <img id="pfp-consultant-btn" src="<?=$CPic?>">
              <div class="consult-btn-text">
                <h1><?= $consultant['consultantName']?></h1>
                <br>
                <p> <?= $consultant['consultantHours']?> </p>
                <br>
                <p> <?= $consultant['consultantPlace']?> </p>
              </div>
             </button>

             <div id="consultant-container-<?= $consultant['consultantID']?>" class="modal">
               <div class="consultant-info">
               <div class="grid-span-2">
               <h1>Consultant</h1>
                </div>

            <!--Disolays consultants modal for admin to edit-->
            <?php if($_SESSION['auth_user']['user_type']=="Admin") :
               list($start, $end) = explode('-', $consultant['consultantHours']);
               $startTime = date('H:i', strtotime($start));
               $endTime = date('H:i', strtotime($end));?>
               <div class="pfp-contained">
                  <img id="consultant-modal-pic-<?=$consultant['consultantID']?>" class="consultant-img" src="<?=$CPic?>">
                  <div class="text-right" id="button_section_<?php echo $consultant['consultantID']; ?>">
                  <br>
							    <a class="btn-default" href="config/authActions.php?request=deleteConsultant&consultantID=<?= $consultant['consultantID']?>"><i class="fa-solid fa-trash"></i> Delete Consultant</a>
                  </div>
                </div>
               <div>
               <span onclick="document.getElementById('consultant-container-<?= $consultant['consultantID']?>').style.display='none'" class="close" title="Close Modal">&times;</span>
               <form action="config/authActions.php?request=editConsultant" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="consultant-id" readonly value="<?= $consultant['consultantID']?>" >
               <input type="hidden" name="consultant-pic" readonly value="<?=$consultant['consultantPic']?>" >
               <h2> Name: <input class="text-box" type="text" name="consultant-name" placeholder="e.g. Ausca Lai" value="<?= $consultant['consultantName']?>" required> </h2> <br>
               <h2> Email: <input class="text-box" type="text" name="consultant-email" placeholder="e.g. user@user.com" value="<?= $consultant['consultantEmail']?>"></h2> <br>
               <h2> Phone: <input class="text-box" type="text" name="consultant-phone" placeholder="e.g. +60123456789" value="<?= $consultant['consultantPhone']?>" required></h2> <br>
               <h2> Work Hours:  <input class="text-box" type="time" name="consultant-starthours" style="width:30%;"value="<?=$startTime?>" id="startHours"required>-<input class="text-box" type="time" name="consultant-endhours" style="width:30%;"value="<?=$endTime?>" id="endHours" required></h2> <br>
               <h2> Workplace:  <input class="text-box" type="text" name="consultant-place" placeholder="e.g. Sunway College" value="<?= $consultant['consultantPlace']?>" required> </h2><br>
               <h2> About Me (optional): </h2> 
               <textarea name="consultant-about" id="add-about-<?=$consultant['consultantID']?>" class="note-editor"><?=$consultant['consultantAbout']?></textarea><br>
              <script>startEditor2("add-about-<?=$consultant['consultantID']?>");</script>
               <h2>
               <label for="fileUpload-<?=$consultant['consultantID']?>" class="custom-file-upload"><i class="fa fa-cloud-upload"></i> Upload Picture</label><input id="fileUpload-<?=$consultant['consultantID']?>" type="file" name="PicUpload" accept="image/png, image/jpg"/>
               </h2><br>
               <input class="submit-btn" type="submit" value="Update Consultant" name="submit">
               </form>
              </div>
              </div>
               
            
              <!--Displays consultants modal for consultant to edit their own profile-->
              <?php elseif($_SESSION['auth_user']['user_email']==$consultant['consultantEmail']):
                 list($start, $end) = explode('-', $consultant['consultantHours']);
                 $startTime = date('H:i', strtotime($start));
                 $endTime = date('H:i', strtotime($end));?>
                <div class="pfp-contained">
                  <img id="consultant-modal-pic-<?=$consultant['consultantID']?>" class="consultant-img" src="<?=$CPic?>">
                </div>
               <div>
               <span onclick="document.getElementById('consultant-container-<?= $consultant['consultantID']?>').style.display='none'" class="close" title="Close Modal">&times;</span>
               <form action="config/authActions.php?request=editConsultant" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="consultant-id" readonly value="<?= $consultant['consultantID']?>" >
               <input type="hidden" name="consultant-pic" readonly value="<?=$consultant['consultantPic']?>" >
               <h2> Name: <input class="text-box" type="text" name="consultant-name" placeholder="e.g. Ausca Lai" value="<?= $consultant['consultantName']?>" required> </h2> <br>
               <input type="hidden" name="consultant-email" readonly value="<?= $_SESSION['auth_user']['user_email']?>" >
               <h2> Phone: <input class="text-box" type="text" name="consultant-phone" placeholder="e.g. +60123456789" value="<?= $consultant['consultantPhone']?>" required></h2> <br>
               <h2> Work Hours:  <input class="text-box" type="time" name="consultant-starthours" style="width:30%;"value="<?=$startTime?>" id="startHours"required>-<input class="text-box" type="time" name="consultant-endhours" style="width:30%;"value="<?=$endTime?>" id="endHours" required></h2> <br>
               <h2> Workplace:  <input class="text-box" type="text" name="consultant-place" placeholder="e.g. Sunway College" value="<?= $consultant['consultantPlace']?>" required> </h2><br>
               <h2> About Me (optional): </h2> 
               <textarea name="consultant-about" id="add-about-<?=$consultant['consultantID']?>" class="note-editor"><?=$consultant['consultantAbout']?></textarea><br>
              <script>startEditor2("add-about-<?=$consultant['consultantID']?>");</script>
               <h2>
               <label for="fileUpload-<?=$consultant['consultantID']?>" class="custom-file-upload"><i class="fa fa-cloud-upload"></i> Upload Picture</label><input id="fileUpload-<?=$consultant['consultantID']?>" type="file" name="PicUpload" accept="image/png, image/jpg"/>
               </h2><br>
               <input class="submit-btn" type="submit" value="Update Consultant" name="submit">
               </form>
              </div>
              </div>

          <!--Displays modal for consultants-->
					<?php else: ?>
               <div class="pfp-contained">
                  <img class="consultant-img" src="<?=$CPic?>">
                </div>
               <div>
               <span onclick="document.getElementById('consultant-container-<?= $consultant['consultantID']?>').style.display='none'" class="close" title="Close Modal">&times;</span>
               <h2> Name: &emsp;<?= $consultant['consultantName']?> </h2> <br>
               <h2> Email: &emsp;<?= $consultant['consultantEmail']?></h2> <br>
               <h2> Phone: &emsp;<?= $consultant['consultantPhone']?></h2> <br>
               <h2> Work Hours:  &emsp;<?= $consultant['consultantHours']?></h2> <br>
               <h2> Workplace:  &emsp;<?= $consultant['consultantPlace']?> </h2><br>
               <?php if(!empty($consultant['consultantAbout'])):?>
                <h2> About Me: </h2> <?=$consultant['consultantAbout']?>
               <?php endif;?>

               <!--Members can requests consultants-->
               <?php if($_SESSION['auth_user']['user_type']== "Member"):
                list($start, $end) = explode('-', $consultant['consultantHours']);
                $startTime = date('H:i', strtotime($start));
                $endTime = date('H:i', strtotime($end));?>
               <button class="submit-btn" onclick="document.getElementById('req-consultant-container-<?= $consultant['consultantID']?>').style.display='block'">Request Consultant</button>

               <div id="req-consultant-container-<?= $consultant['consultantID']?>" class="modal">
               <div class="consultant-info">
                <div class="grid-span-2">
                  <h1>Request <?=$consultant['consultantName']?></h1>
                </div>
               <div class="pfp-contained">
                  <img id="consultant-modal-pic-<?=$consultant['consultantID']?>" class="consultant-img" src="<?=$CPic?>">
               </div>
               <div>
               <span onclick="document.getElementById('req-consultant-container-<?= $consultant['consultantID']?>').style.display='none'" class="close" title="Close Modal">&times;</span>
               <form id="user-request" action="config/authActions.php?request=createRequest" method="POST">
               <input type="hidden" name="consultant-selection" readonly value="<?= $consultant['consultantID']?>" >
               <input type="hidden" name="user-id" readonly value="<?= $_SESSION['auth_user']['user_id']?>" >
               <h2> Contact No: <input class="text-box" type="text" name="user-phone" placeholder="e.g. +60123456789" required></h2> <br>
               <h2> Date:  <input class="text-box" type="date" id="booking-date-<?=$consultant['consultantID']?>" name="booking-date" required></h2> <br>
               <h2> Time:  <input class="text-box" type="time" id="booking-time-<?=$consultant['consultantID']?>" name="booking-time" required min="<?=$startTime?>" max="<?=$endTime?>"></h2> <br>
               <h2> Add Note (optional): </h2> <textarea name="message" id="add-note"></textarea><br>	
               <input class="submit-btn" type="submit" value="Request Consultant" name="submit">
               </form>
               </div>
               </div>
               </div>

              <?php endif;?>
              </div>
              </div>
            
        <!-- script to limit date selection to today and after-->
        <script>
         document.addEventListener("DOMContentLoaded", function () {
           const bookingDateInput = document.getElementById("booking-date-<?=$consultant['consultantID']?>");
           const currentUTC = new Date();
           const currentLocal = new Date(currentUTC.getTime() - (currentUTC.getTimezoneOffset() * 60000));
           const localDate = currentLocal.toISOString().split('T')[0];
           bookingDateInput.value = localDate;
           bookingDateInput.min = localDate;
         });
        </script>
        
      <?php endif; ?>
        </div>
        
        <?php 
          if($_SESSION['auth_user']['user_type']=="Admin" || $_SESSION['auth_user']['user_email']==$consultant['consultantEmail']) :
        ?>
        <!--Updates the consultant picture preview in read time when editing consultants picture-->
        <script>
        const image_input<?=$consultant['consultantID']?> = document.querySelector("#fileUpload-<?=$consultant['consultantID']?>");
        const pfpImage<?=$consultant['consultantID']?> = document.querySelector("#consultant-modal-pic-<?=$consultant['consultantID']?>");
        
        image_input<?=$consultant['consultantID']?>.addEventListener("click", function() {
            image_input<?=$consultant['consultantID']?>.value = null; // Clear the file input
            pfpImage<?=$consultant['consultantID']?>.src = $CPic; // Revert to default image
        });
        
        image_input<?=$consultant['consultantID']?>.addEventListener("change", function() {
            const reader = new FileReader();
            reader.addEventListener("load", () => {
                const uploaded_image = reader.result;
                pfpImage<?=$consultant['consultantID']?>.src = uploaded_image;
            });
        
            if (this.files.length > 0) {
                reader.readAsDataURL(this.files[0]);
            } else {
                pfpImage<?=$consultant['consultantID']?>.src = $CPic;
            }
        });</script>
        <?php endif; ?>

        <?php };
        else:?>

        <!--Display none if no request found-->
          
          <button class="consultant-btn" onclick="document.getElementById('consultant-container').style.display='block'">
        <div style="text-align:center" class="consult-btn-text">
          <h1>No Consultants Found</h1>
        </div>
       </button>
        <?php endif;?>
      </div>
    </div>
    
  </div>
</div>

 

</body>

</html>

<script src="js/darkmode.js"></script>
<?php 
if($_SESSION['auth_user']['user_type']=="Admin" || $_SESSION['auth_user']['user_type']=="Consultant") :
?>
<!--Updates the consultant picture preview in read time when editing consultants picture-->
<script>
const imageInput = document.querySelector("#fileUpload");
    const pfpPic = document.querySelector("#consultant-modal-pic");
    // Additional event listener to handle clearing the image input
    imageInput.addEventListener("click", function() {
        imageInput.value = null; // Clear the file input
        pfpPic.src = "img/pfp.jpeg"; // Revert to default image
    });
    imageInput.addEventListener("change", function() {
        const reader = new FileReader();
        reader.addEventListener("load", () => {
            const uploaded_image = reader.result;
            pfpPic.src = uploaded_image;
        });

        if (this.files.length > 0) {
            reader.readAsDataURL(this.files[0]);
        } else {
            pfpPic.src = "img/pfp.jpeg"; // Revert to default image when no file is selected
        }
    });
</script>
<?php endif; ?>
<script type="text/javascript">
  $crisp = [];
  CRISP_TOKEN_ID = '<?php 
  if(!empty($_SESSION['auth_user']['user_token'])){
    echo $_SESSION['auth_user']['user_token'];
  }else{
    echo "";
  }
  ?>';
  CRISP_WEBSITE_ID = 'ad6f3143-98ba-4e8e-9f26-855358541a32';
  CRISP_RUNTIME_CONFIG = {
    session_merge : true
  };
$crisp.push(["set", "user:nickname", ["<?php if(isset($_SESSION['auth_user']['user_name'])){ echo $_SESSION['auth_user']['user_name'];}else{ echo "Guest";}?>"]]);
$crisp.push(["set", "user:email", ["<?php if(isset($_SESSION['auth_user']['user_email'])){echo $_SESSION['auth_user']['user_email'];}else{echo "NONE";}?>"]]);
$crisp.push(["set", "user:avatar", ["<?php if(isset($_SESSION['auth_user']['imgURL'])){ echo $_SESSION['auth_user']['imgURL'];}else{echo "";}?>"]]);
</script>
