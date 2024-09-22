<?php

include('config/app.php');
include_once('config/RegisterController.php');

$Err = "";
$pwd = $rptpwd = "";
$logIn = new LoginController;
$register = new RegisterController;

if(isset($_POST['change-password'])){

    $selector = $_POST["selector"];
    $validator = $_POST['validator'];
    $pwd = $_POST["password"];
    $rptpwd = $_POST["Rptpassword"];

    if(empty($pwd)||empty($rptpwd)){
        $Err = "Password cannot be empty!";
    }else if ($pwd != $rptpwd){
        $Err = "Password is not the same!";
    }else if($register->isMinFourChar($pwd) == false){
        $Err = "Minimum 4 characters.";
    }else if(!empty($pwd)||!empty($rptpwd)){
    $currentDate = date("U");

    $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires>=?";
    $stmt = mysqli_stmt_init($dbc);
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "Error";
        exit();
    }else{
        mysqli_stmt_bind_param($stmt,"ss",$selector, $currentDate);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if(!$row = mysqli_fetch_assoc($result)){
            $Err = "You need to re-submit your reset request!";
        }else{
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);

            if($tokenCheck === false){
                $Err = "You need to re-submit your reset request!";
            }elseif($tokenCheck === true){

                $tokenEmail = $row['pwdResetEmail'];

                $sql = "SELECT * FROM user WHERE Email=?;";
                $stmt = mysqli_stmt_init($dbc);
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    echo "Error";
                    exit();
                }else{
                    mysqli_stmt_bind_param($stmt,"s",$tokenEmail);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if(!$row = mysqli_fetch_assoc($result)){
                        $Err = "An unknown error occured, please try again!";
                    }else{
                        $sql = "UPDATE user SET Password=? WHERE Email=?;";
                        $stmt = mysqli_stmt_init($dbc);
                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            echo "Error";
                            exit();
                        }else{
                            $newPwdHash = password_hash($pwd, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt,"ss",$newPwdHash,$tokenEmail);
                            mysqli_stmt_execute($stmt);

                            $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                            $stmt = mysqli_stmt_init($dbc);
                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                echo "Error";
                                exit();
                            }else{
                                mysqli_stmt_bind_param($stmt,"s",$tokenEmail);
                                mysqli_stmt_execute($stmt);
                                header("Location: login.php?newpwd=passwordupdated");
                            } 
                        }
                            
                        }
                    }

                }
            }
        }
    }
 }




?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Sen:wght@400;700;800&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <?php 
    if(!isset($_SESSION['authenticated']) OR $_SESSION['auth_user']['user_type']=="Member"){ ?>
  <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="ad6f3143-98ba-4e8e-9f26-855358541a32";(function(){d=document;s=d.createElement("script");s.src="js/client.crisp.chat.js";s.async=1;var firstScript = document.head.getElementsByTagName("script")[0];
firstScript.parentNode.insertBefore(s, firstScript);})();</script>
  <?php }?>
  <style>.crisp-client .cc-tlyw .cc-kxkl .cc-1hqb .cc-gye0 .cc-11uv .cc-15ak .cc-acjo .cc-nmj4 {display:none !important;}</style>
  <link rel="icon" href="img/logo.png" type="image/x-icon">
  <title>SuicideNeutralizer | Reset Password</title>
</head>

<body>
<?php include('config/navbar.php'); ?>
<div class="centering">
    <div class="login-box">
        <h2>Reset Password</h2>
        <?php 
        if(!empty($_GET['selector']) && !empty($validator = $_GET['validator'])){
        $selector = $_GET['selector'];
        $validator = $_GET['validator'];
            if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ){
                ?>
        <form name="SignUp" id="SignUp" action="create-new-password.php?selector=<?=$selector?>&validator=<?=$validator?>" method="POST">
            <input type="hidden" name="selector" value= "<?=$selector?>">
            <input type="hidden" name="validator" value= "<?=$validator?>">
            <div class="user-box">
                <input type="password" name="password" id="password" required="" value="<?= $pwd; ?>">
                <label>Password<span class="error">*</span></label>
            </div>

            <div class="user-box">
                <input type="password" name="Rptpassword" id="Rptpassword" required="" value="<?= $rptpwd; ?>">
                <label>Repeat Password<span class="error">*</span></label>
            </div>




            <div class="user-box">
                <span class="error"><?= $Err; ?></span>
                <a href="login.php" class="SignUp">Log In</a>
            </div>

            <input type="submit" id="submit" name="change-password" value="Reset Password">

        </form>
        <?php
            }
        }else if(empty($selector)||empty($validator)){
            echo '<span class="error">Could not validate your request!</span>';
            echo '<a href="forgot.php" class="SignUp">Try Again</a>';
        }
        ?>
    </div>
</div>
  </div>
</body>

</html>

<script src="js/darkmode.js"></script>
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