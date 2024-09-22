<link rel="stylesheet" href="css/virtual-select.min.css">
<link rel="stylesheet" href="css/navbar.css" />
<?php include_once('config/RegisterController.php');
include_once('config/Requests.php');
$redirect2 = basename($_SERVER['PHP_SELF']).(isset($_GET['topic_id'])? "?topic_id=".$_GET['topic_id']:"");
$logIn = new LoginController;

if (isset($_POST['logout_btn'])) {
  $checkLoggedOut = $logIn->logout();
  if ($checkLoggedOut) {
    header("Location: home.php");
  }
}

?>
<div class="top-nav">
  <div class="top-nav-container">
  <ul class="menu-list hamburger">
      <li>
      <a><i class="fa-solid fa-bars"></i></a>
      <ul class="subnavmenu">
      <li><a href="home.php" ><i class="fa-solid fa-house"></i> Home</a></li>
        <li><a href="forum.php" ><i class="fa-brands fa-rocketchat"></i> Forum</a></li>
        <li><a href="consultant.php" ><i class="fa-solid fa-address-card"></i> Consultants</a></li>
        <?php if (isset($_SESSION['authenticated'])) : ?>
        <?php if($_SESSION['auth_user']['user_type']=="Consultant" OR $_SESSION['auth_user']['user_type']=="Admin"):?>
        <li><a href="request.php" ><i class="fa-solid fa-person-circle-question"></i> Incoming Requests</a></li>
        <?php else:?>
        <li><a href="request.php" ><i class="fa-solid fa-person-circle-question"></i> Request Consultant</a></li>
        <?php endif;else:?>
        <li><a href="request.php" ><i class="fa-solid fa-person-circle-question"></i> Request Consultant</a></li>
        <?php endif;?>
        <?php if (isset($_SESSION['authenticated'])) : ?>
          <li>
            <form action="" method="POST">
              <button type="submit" name="logout_btn" class="dropdown-btn" onclick="$crisp.push(['do', 'session:reset']);"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</button>
          </form>
          </li>
        <?php else : ?>
          <li class="hamburger-hidden">
              <a href="login.php"><i class="fa-solid fa-arrow-right-to-bracket"></i> Log In</a>
          </li>
          <li class="hamburger-hidden">
              <a href="register.php"><i class="fa-solid fa-user-plus"></i>Register</a>
          </li>
        <?php endif; ?>
          <li class="hamburger-hidden dark-toggle">
            <a>
          <div class="toggle">
            <i class="fa-solid fa-moon toggle-icon"></i>
            <i class="fa-solid fa-sun toggle-icon"></i>
            <div class="toggle-ball"></div>
          </div>
        </a>
        </li>
      </ul>
      </li>
      </ul>

    <div class="logo-container">
      <h1 class="logo"><a href="home.php">SuicideNeutralizer</a></h1>
    </div>
    <div class="nav-menu-container">
      <ul class="menu-list">
        <li class="menu-list-item selected"><a href="home.php">Home</a></li>
        <li class="menu-list-item"><a href="forum.php">Forum</a></li>
        <li class="menu-list-item"><a href="consultant.php">Consultants</a></li>
        <?php if (isset($_SESSION['authenticated'])) : ?>
        <?php if($_SESSION['auth_user']['user_type']=="Consultant" OR $_SESSION['auth_user']['user_type']=="Admin"):?>
        <li class="menu-list-item"><a href="request.php">Incoming Requests</a></li>
        <?php else:?>
        <li class="menu-list-item"><a href="request.php">Request Consultant</a></li>
        <?php endif;else:?>
        <li class="menu-list-item"><a href="request.php">Request Consultant</a></li>
        <?php endif;?>
      </ul>
    </div>
    <div class="pfp-container">
    <?php if (isset($_SESSION['authenticated'])) : ?>
      <?php if (isset($_SESSION['auth_user']['user_pfp'])) : ?>
          <img class="pfp-pic" src="<?=$_SESSION['auth_user']['user_pfp']; ?>" />
        <?php else : ?>
          <img class="pfp-pic" src="img/pfp.jpeg" />
        <?php endif; ?>
      <?php else : ?>
        <img class="pfp-pic" src="img/pfp.jpeg" />
      <?php endif; ?>
      <ul class="pfp-name-display">
        <li class="pfp-text">
          <a>
            <?php if (isset($_SESSION['authenticated'])) : ?>
              <?= $_SESSION['auth_user']['user_name'] ?>
            <?php else : ?>
              Profile
            <?php endif; ?>
            <i class="fa-solid fa-chevron-down"></i></a>

          <ul class="subnavmenu">

            <?php if (isset($_SESSION['authenticated'])) : ?>
              <li>
                <button class="dropdown-btn" onclick="document.getElementById('profile-container').style.display='block'"><i class="fa-solid fa-user"></i> Profile</button>
              </li>

              <div id="profile-container" class="profile-modal">
                <div class="profile-info">
                  <div>
                    <h1>Profile</h1><br>
                    <div class="pfp-contained">
                      <?php if (isset($_SESSION['auth_user']['user_pfp'])) : ?>
                          <img id="pfp-pic-modal" src="<?=$_SESSION['auth_user']['user_pfp']; ?>" />
                      <?php else : ?>
                          <img id="pfp-pic-modal" src="img/pfp.jpeg" />
                      <?php endif; ?>
                    </div>
                  </div>
                    
                  <div>
                  <span onclick="document.getElementById('profile-container').style.display='none'" class="close-modal" title="Close Modal">&times;</span>
                  <br>
                  <h2> Username: &emsp;<?= $_SESSION['auth_user']['user_name'] ?></h2> <br>
                  <h2> Email: &emsp;<?= $_SESSION['auth_user']['user_email'] ?></h2> <br>
                  <h2> User: &emsp;<?= $_SESSION['auth_user']['user_type'] ?></h2> <br>
                  <div id="signUpDate" data-value="<?php echo $_SESSION['auth_user']['user_regDate']; ?>"></div>
                  <h2 id="daysSinceSignUp"></h2>
                  <br>
                  <form action="config/addpfp.php?redirect=<?=$redirect2?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="UserID" readonly value="<?= $_SESSION['auth_user']['user_id']?>" >
                    <input type="hidden" name="pfp" readonly value="<?= $_SESSION['auth_user']['user_pfp']?>" >
                    <h2>
                    <label for="file-upload" class="custom-file-upload"><i class="fa fa-cloud-upload"></i> Upload Picture</label><input id="file-upload" type="file" name="fileUpload" accept="image/png, image/jpg"/>
                    </h2>
                    <br>
                    <span><button class="submit-btn" type="submit" name="updatePFP"><i class="fa-solid fa-pen-to-square"></i> Update Picture</button>&nbsp;<button class="submit-btn" type="submit" name="deletePFP" style="border: 2px solid #f82222;color: #f82222;"><i class="fa-solid fa-trash"></i> Delete Picture</button></span><br>
                  </form>
                  </div>

                </div>
              </div>

              <?php if($_SESSION['auth_user']['user_type']=="Admin"):?>

                <li>
                <button class="dropdown-btn" onclick="document.getElementById('user-editor').style.display='block'"><i class="fa-solid fa-pen-to-square"></i> Edit Users</button>
              </li>

                <div id="user-editor" class="profile-modal">
                <div class="profile-info">
                  <div> 
                    <h1>Edit User</h1><br>
                    <div class="pfp-contained">
                    <img id="user-editor-pic" class="user-img" src="img/pfp.jpeg">
                    </div>
                  </div>
                  
                  <span onclick="document.getElementById('user-editor').style.display='none'" class="close-modal" title="Close Modal">&times;</span>
                  <div>
                  <form action="config/authActions.php?request=editUserType&redirect=<?=$redirect2?>" method="POST" enctype="multipart/form-data">
                  <br><br><br><br><br><br><br>
                    <h2> User: </h2><div id="admin-user-select"></div><br><br>
                    <h2> Account Type:</h2><div id="admin-acctype-select"></div></h2><br>
                    <br>
                    <button class="submit-btn" type="submit" name="updateUser"><i class="fa-solid fa-pen-to-square"></i> Update User</button><br>
                  </form>
                  </div>

                </div>
              </div>
              <?php endif;?>

              <li>
                <form action="" method="POST">
                  <button type="submit" name="logout_btn" class="dropdown-btn" onclick="$crisp.push(['do', 'session:reset']);"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</button>
                </form>
              </li>
            <?php else : ?>
              <li>
                <a href="login.php" ><i class="fa-solid fa-arrow-right-to-bracket"></i> Log In</a>
              </li>
              <li>
                <a href="register.php" ><i class="fa-solid fa-user-plus"></i>Register</a>
              </li>
            <?php endif; ?>
          </ul>
        </li>
      </ul>

      <div class="toggle">
        <i class="fa-solid fa-moon toggle-icon"></i>
        <i class="fa-solid fa-sun toggle-icon"></i>
        <div class="toggle-ball"></div>
      </div>
    </div>
  </div>
</div>

<div class="content-container">

<script src="js/displaypfp.js"></script>
<script src="js/virtual-select.min.js"></script>
<?php if(isset($_SESSION['auth_user']) && $_SESSION['auth_user']['user_type']=="Admin"):?>
  <script>
document.addEventListener("DOMContentLoaded", function () {
  VirtualSelect.init({
        ele: "#admin-user-select",
        options: [
          <?php 	
          $requests1 = new Requests();
          $result = $requests1->getUsersList($_SESSION['auth_user']['user_id']);
          while ($member = $result->fetch_assoc()) {?>
          { label: "<?= $member['Name']?>, <?= $member['Email']?>", value: "<?= $member['UserID']?>" },
          <?php }?>
        ],
        search:true,
        required:true,
        noSearchResultsText:"No Users Found",
        searchPlaceholderText:"Seach Users...",
        placeholder:"Select Users",
        name:"admin-select-user-id",
      });
      VirtualSelect.init({
        ele: "#admin-acctype-select",
        options: [
          { label: "Admin", value: "Admin" },
          { label: "Consultant", value: "Consultant" },
          { label: "Member", value: "Member" },
        ],
        required:true,
        placeholder:"Select Account Type",
        name:"admin-select-acctype",
      });
});
</script>
<script>
    function updateAdminSelectedProfilePicture(userId) {
    const profilePictureElement = document.querySelector('#user-editor-pic');
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
                console.log(imagePath);
            } else {
                profilePictureElement.src = defaultImagePath;
                console.log("no image set to default");
            }
        })
        .catch(error => {
            console.error('Error fetching image path:', error);
        });
}

document.addEventListener('DOMContentLoaded', function () {
    const adminUserSelect = document.querySelector('#admin-user-select');
    adminUserSelect.addEventListener('change', function () {
        const adminUserSelectedId = adminUserSelect.value;
            updateAdminSelectedProfilePicture(adminUserSelectedId);
    });
});
</script>
<?php endif;?>
