<?php include('config/app.php');
include('config/AuthController.php');
include('config/Consultants.php');
include('config/Requests.php');
$redirect = basename($_SERVER['PHP_SELF']);
$AuthLogin = new AuthenticatorController($redirect); 
$consultants = new Consultant();
$requests = new Requests();?>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/virtual-select.min.css">
  <link rel="stylesheet" href="css/tooltip.min.css">
  <link rel="stylesheet" href="css/navbar.css" />
  <link rel="stylesheet" href="css/consultant.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Sen:wght@400;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="tinymce/tinymce.min.js"></script>
  <script src="js/tinymce_editor.js"></script>
  <link rel="icon" href="img/logo.png" type="image/x-icon">
  <title>SuicideNeutralizer | Request Consultations</title>
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
    <?php if($_SESSION['auth_user']['user_type']=="Consultant" OR $_SESSION['auth_user']['user_type']=="Admin"):?>
    <label style="font-size:30px;font-weight:700;">User Requests</label>
    <?php else:?>
      <label style="font-size:30px;font-weight:700;">Request Consultants</label>
    <?php endif;?>
    <br><br>

    <!-- admins and members can make new consultant requests-->
    <?php if($_SESSION['auth_user']['user_type']!="Consultant"):?>
				<a type="button" class="btn-primary" onclick="document.getElementById('add-request-container').style.display='block'"><span id="compose-btn" >Make New Request</span></a><br>
        <div id="add-request-container" class="modal">
               <div class="consultant-info">
               <div class="grid-span-2">
               <h1>Make a Request</h1>
                </div>
               <div class="pfp-contained">
                  <img id="consultant-modal-pic" class="consultant-img" src="img/pfp.jpeg">
                </div>
               <div>
               <span onclick="document.getElementById('add-request-container').style.display='none'" class="close" title="Close Modal">&times;</span>
               <form action="config/authActions.php?request=createRequest" method="POST">
                <?php if($_SESSION['auth_user']['user_type']=="Admin"):?>
                  <h2> User: <div id="user-select"></div></h2><br>
               <?php else:?>
                <input type="hidden" name="user-id" readonly value="<?= $_SESSION['auth_user']['user_id']?>" >
               <?php endif;?>
               <h2> Consultant: <div id="consult-select"></div></h2><br>
               <h2> Contact No: <input class="text-box" type="text" name="user-phone" placeholder="e.g. +60123456789" required></h2> <br>
               <h2> Date:  <input class="text-box" type="date" id="booking-date" name="booking-date" required></h2> <br>
               <h2> Time:  <input class="text-box" type="time" id="booking-time" name="booking-time" required></h2> <br>
               <?php if($_SESSION['auth_user']['user_type']=="Admin"):?>
                  <h2> Approval: <div id="approve-select"></div></h2><br>
               <?php endif;?>
               <h2> Add Note (optional): </h2> <textarea name="message" id="add-note"></textarea><br>	
               <input class="submit-btn" type="submit" value="Request Consultant" name="submit">
               </form>
              </div>
              </div>
             </div>


    <?php endif;?>

    <!--Search Bar-->
          <form id="search-form" action="" method="POST">
            <input class="Search-box" type="text" name="search" placeholder="Search Requests">
          </form>
        <?php
        $key="";
        if(isset($_POST['search'])){
        $key=$_POST['search'];
        }
        ?>
        <br>

        <div class="consultants-grid">
        <?php
            $result = $requests->getRequestList($key);
            if(mysqli_num_rows($result) > 0):
            while ($request = $result->fetch_assoc()) {
              $consultSelectId = "consult-select-" . $request['requestID'];
              $userSelectId = "user-select-" . $request['requestID'];
              if($_SESSION['auth_user']['user_type']=="Consultant" OR $_SESSION['auth_user']['user_type']=="Admin"){
                if($request['pfp']==NULL){
                  $Pic = "img/pfp.jpeg";
                }else{
                  $Pic = $request['pfp'] ;
                };
              }else{
                if($request['consultantPic']==NULL){
                  $Pic = "img/pfp.jpeg";
                }else{
                  $Pic = $request['consultantPic'] ;
                }
              };
              ?>

              <!--displays requests-->
              <button class="consultant-btn" onclick="document.getElementById('request-container-<?= $request['requestID']?>').style.display='block'">
              <div class="btn-grid">
              <img id="pfp-consultant-btn" src="<?=$Pic?>">
              <div class="consult-btn-text">
              <?php if($_SESSION['auth_user']['user_type']=="Consultant" OR $_SESSION['auth_user']['user_type']=="Admin"):?>
                <h1><?= $request['Name']?></h1>
                <br>
                <?php if($_SESSION['auth_user']['user_type']=="Admin"):?>
                  <p>Requests: <?= $request['consultantName']?> </p>
                  <br>
                <?php endif;?>
                <p>Timeslot: <?= $request['bookingDateTime']?> </p>
                <br>
                <p> <b><?= $request['requestApproval']?></b> </p>
              <?php else:?>
                <h1><?= $request['consultantName']?></h1>
                <br>
                <p>Timeslot: <?= $request['bookingDateTime']?> </p>
                <br>
                <p><b><?= $request['requestApproval']?></b> </p>
              <?php endif;?>
              </div>
             </button>
              

             <!--displays requests modal for admin to edit-->
             <?php if($_SESSION['auth_user']['user_type']=="Admin"):?>
             <div id="request-container-<?= $request['requestID']?>" class="modal">
               <div class="consultant-info">
                <div class="grid-span-2">
               <h1>User Request</h1>
                </div>
               <div class="pfp-contained">
                  <img class="consultant-img" src="<?=$Pic?>">
                <form action="config/authActions.php?request=requestApproval" method="POST">
                  <br>
                <input type="hidden" name="requestID" readonly value="<?= $request['requestID']?>" >
                <button class="submit-btn" type="submit" name="accept" style="border: 2px solid #3cfc2b;color: #3cfc2b;"><i class="fa-solid fa-check"></i> ACCEPT</button>
                <button class="submit-btn" type="submit" name="reject" style="border: 2px solid #f82222;color: #f82222;"><i class="fa-solid fa-xmark"></i> REJECT</button>
                </form>
                <form action="config/authActions.php?request=deleteRequest" method="POST">
                <input type="hidden" name="requestID" readonly value="<?= $request['requestID']?>" >
                <br>
                <button class="btn-default" type="submit" name="submit"><i class="fa-solid fa-trash"></i> Delete Request</button>
                </form>
                </div>
                
               <div>
               <span onclick="document.getElementById('request-container-<?= $request['requestID']?>').style.display='none'" class="close" title="Close Modal">&times;</span>
               <form action='config/authActions.php?request=editRequest' method="POST">
               <input type="hidden" name="requestID" readonly value="<?= $request['requestID']?>" >
                <h2> User: <div id="<?= $userSelectId ?>"></div></h2><br>
                <h2> Consultant: <div id="<?= $consultSelectId ?>"></div></h2><br>
               <h2> Contact No: <input class="text-box" type="text" name="user-phone" placeholder="e.g. +60123456789" value="<?=$request['userPhone']?>"></h2> <br>
               <h2> Date:  <input class="text-box" type="date" id="booking-date-<?= $request['requestID']?>" name="booking-date" required></h2> <br>
               <h2> Time:  <input class="text-box" type="time" id="booking-time-<?= $request['requestID']?>" name="booking-time" required></h2> <br>
               <h2> Approval:  <?=$request['requestApproval']?></h2> <br>
               <h2> Note: </h2> 
               <textarea name="message" id="req-note-<?=$request['requestID']?>" class="note-editor"><?=$request['note']?></textarea><br>
              <script>startEditor2("req-note-<?=$request['requestID']?>");</script>
               <input class="submit-btn" type="submit" value="Edit Request" name="submit">
             </form>
               </div>
              </div>
              </div>

              <!--updates consultants image and limits booking hours in real time-->
              <script>
              function updateUserProfilePicture(userId, modalId) {
                  const modal = document.getElementById(modalId);
                  const profilePictureElement = modal.querySelector('.consultant-img');
              
                  const defaultImagePath = 'img/pfp.jpeg';
              
                  if (!userId) {
                      profilePictureElement.src = defaultImagePath;
                      return;
                  }
                
                  fetch(`config/authActions.php?request=getuserPFP&userID=${userId}`)
                      .then(response => response.text())
                      .then(imagePath => {
                        if (imagePath && imagePath.trim() !== "") {
                              profilePictureElement.src = imagePath;
                          } else {
                              profilePictureElement.src = defaultImagePath;
                          }
                      })
                      .catch(error => {
                          console.error('Error fetching image path:', error);
                      });
              }

              document.addEventListener('DOMContentLoaded', function () {
                  const userSelect = document.querySelector('#user-select-<?=$request['requestID']?>');
                  const requestEditContainer = document.getElementById('request-container-<?=$request['requestID']?>'); 
              
                  userSelect.addEventListener('change', function () {
                      const selectedUserId = userSelect.value;
                      if (requestEditContainer.style.display === 'block') {
                          updateUserProfilePicture(selectedUserId, 'request-container-<?=$request['requestID']?>'); 
                      }
                  });
                
              });
              </script>
              
            <?php 
            $bookingDateTime = $request['bookingDateTime'];
            $dateParts = explode(' ', $bookingDateTime); 
            
            // Set the date part as the value of the input element
            echo '<script>';
            echo 'document.getElementById("booking-date-' . $request['requestID'] . '").value = "' . $dateParts[0] . '";';
            echo 'document.getElementById("booking-time-' . $request['requestID'] . '").value = "' . $dateParts[1] . '";';
            echo '</script>';
          


            elseif($_SESSION['auth_user']['user_type']=="Consultant"):?>

            <!-- shows requests modal to consultants for them to accept or reject-->
              <div id="request-container-<?= $request['requestID']?>" class="modal">
               <div class="consultant-info">
                <div class="grid-span-2">
               <h1>User Request</h1>
                </div>
               <div class="pfp-contained">
                  <img class="consultant-img" src="<?=$Pic?>">
                  <form action="config/authActions.php?request=requestApproval" method="POST">
                  <br>
                <input type="hidden" name="requestID" readonly value="<?= $request['requestID']?>" >
                <button class="submit-btn" type="submit" name="accept" style="border: 2px solid #3cfc2b;color: #3cfc2b;"><i class="fa-solid fa-check"></i> ACCEPT</button>
                <button class="submit-btn" type="submit" name="reject" style="border: 2px solid #f82222;color: #f82222;"><i class="fa-solid fa-xmark"></i> REJECT</button>
                </form>
                <form action="config/authActions.php?request=deleteRequest" method="POST">
                <input type="hidden" name="requestID" readonly value="<?= $request['requestID']?>" >
                <br>
                <button class="btn-default" type="submit" name="submit"><i class="fa-solid fa-trash"></i> Delete Request</button>
                </form>
                </div>
                
               <div>
               <span onclick="document.getElementById('request-container-<?= $request['requestID']?>').style.display='none'" class="close" title="Close Modal">&times;</span>
                <h2> User: <?= $request['Name'] ?></h2><br>
               <h2> Contact No: <?=$request['userPhone']?></h2> <br>
               <h2> Timeslot:  <?=$request['bookingDateTime']?></h2> <br>
               <h2> Approval:  <?=$request['requestApproval']?></h2> <br>
               <?php if(!empty($request['note'])):?>
                <h2> Note: </h2> <?=$request['note']?>
               <?php endif;?>
               </div>
              </div>
              </div>


              <!--shows request modal for users to see their own requests-->
              <?php else:?>

                <div id="request-container-<?= $request['requestID']?>" class="modal">
               <div class="consultant-info">
                <div class="grid-span-2">
               <h1>Requesting <?= $request['consultantName']?></h1>
                </div>
               <div class="pfp-contained">
                  <img class="consultant-img" src="<?=$Pic?>">
                <form action="config/authActions.php?request=deleteRequest" method="POST">
                <input type="hidden" name="requestID" readonly value="<?= $request['requestID']?>" >
                <br>
                <button class="btn-default" type="submit" name="submit"><i class="fa-solid fa-trash"></i> Delete Request</button>
                </form>
                </div>
                
               <div>
               <span onclick="document.getElementById('request-container-<?= $request['requestID']?>').style.display='none'" class="close" title="Close Modal">&times;</span>
                <h2> Consultant: <?= $request['consultantName'] ?></h2><br>
               <h2> Contact No: <?=$request['consultantPhone']?></h2> <br>
               <h2> Timeslot:  <?=$request['bookingDateTime']?></h2> <br>
               <h2> Approval:  <?=$request['requestApproval']?></h2> <br>
               <?php if(!empty($request['note'])):?>
                <h2> Note: </h2> <?=$request['note']?>
               <?php endif;?>
               </div>
              </div>
              </div>

              <?php endif;?>

              <!--display none if no requests found-->
          <?php };
          else:?>
              <button class="consultant-btn" onclick="document.getElementById('request-container').style.display='block'">
              <div style="text-align:center" class="consult-btn-text">
                <h1>No Request Found</h1>
              </div>
             </button>
          <?php endif;?>
    </div>
  </div>
  </div>

</body>

</html>

<script src="js/darkmode.js"></script>
<script src="js/virtual-select.min.js"></script>
  <script src="js/tooltip.min.js"></script>
  <!--dropdown search select script-->
  <script>
    
      VirtualSelect.init({
        ele: "#consult-select",
        options: [
          <?php 	$result = $consultants->getConsultantList("");
          while ($consultant = $result->fetch_assoc()) {?>
          { label: "<?= $consultant['consultantName']?>", value: "<?= $consultant['consultantID']?>" },
          <?php }?>
        ],
        search:true,
        required:true,
        noSearchResultsText:"No Consultants Found",
        searchPlaceholderText:"Seach Consultants...",
        placeholder:"Select Consultants",
        name:"consultant-selection",
        dropboxWidth: '78%',
      });
  
      VirtualSelect.init({
        ele: "#user-select",
        options: [
          <?php 	$result = $requests->getMembersList();
          while ($member = $result->fetch_assoc()) {?>
          { label: "<?= $member['Name']?>", value: "<?= $member['UserID']?>" },
          <?php }?>
        ],
        search:true,
        required:true,
        noSearchResultsText:"No Members Found",
        searchPlaceholderText:"Seach Members...",
        placeholder:"Select Members",
        name:"user-id",
        dropboxWidth: '78%',
      });

      VirtualSelect.init({
        ele: "#approve-select",
        options: [
          { label: "Pending", value: "PENDING" },
          { label: "Accept", value: "ACCEPTED" },
          { label: "Reject", value: "REJECTED" },
        ],
        required:true,
        placeholder:"Select Status",
        name:"approval",
        dropboxWidth: '78%',
      });
</script>

        <?php
        if($_SESSION['auth_user']['user_type']=="Admin") :
        $resultRequests = $requests->getRequestList($key); 

        while ($request = $resultRequests->fetch_assoc()) {
          $consultSelectId = "consult-select-" . $request['requestID'];
          $userSelectId = "user-select-" . $request['requestID'];

          $resultConsultants = $consultants->getConsultantList(""); 
          $resultMembers = $requests->getMembersList(); 
          ?>
          <script>
              VirtualSelect.init({
              ele: "#<?= $consultSelectId ?>",
              options: [
              <?php while ($consultant = $resultConsultants->fetch_assoc()) { ?>
                { label: "<?= $consultant['consultantName'] ?>", value: "<?= $consultant['consultantID'] ?>" },
              <?php } ?>
              ],
              search:true,
              required:true,
              noSearchResultsText:"No Consultants Found",
              searchPlaceholderText:"Seach Consultants...",
              placeholder:"Select Consultants",
              name:"consultant-selection",
              dropboxWidth: '78%',
              selectedValue: <?=$request['consultID']?>,
              });
  
              VirtualSelect.init({
              ele: "#<?= $userSelectId ?>",
              options: [
              <?php while ($member = $resultMembers->fetch_assoc()) { ?>
              { label: "<?= $member['Name'] ?>", value: "<?= $member['UserID'] ?>" },
               <?php } ?>
               ],
              search:true,
              required:true,
              noSearchResultsText:"No Members Found",
              searchPlaceholderText:"Seach Members...",
              placeholder:"Select Members",
              name:"user-id",
              dropboxWidth: '78%',
              selectedValue: <?= $request['userID']?>,
              });
            </script>
        <?php }endif;?>

        <!--limit booking date to today and after-->
        <script>
              document.addEventListener("DOMContentLoaded", function () {
                const bookingDateInput = document.getElementById("booking-date");
                const currentUTC = new Date();
                const currentLocal = new Date(currentUTC.getTime() - (currentUTC.getTimezoneOffset() * 60000));
                const localDate = currentLocal.toISOString().split('T')[0];
                bookingDateInput.value = localDate;
                bookingDateInput.min = localDate;
              });
        </script>
<script src="js/updateProfilePicture.js"></script>
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