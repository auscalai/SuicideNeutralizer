<?php

include('config/app.php');
include_once('config/RegisterController.php');

$emailErr = $passwordErr = "";
$email = $password = "";
$redirect = (isset($_GET['redirect'])?$_GET['redirect']:"");
$logIn = new LoginController;

if(!empty($redirect)){
  $LoginErr = "Please log in first before entering";
}else{
  $LoginErr = "";
}
//Log In
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = empty($_POST["email"]) ? "" : $_POST["email"];
    $password = empty($_POST["password"]) ? "" : $_POST["password"];

    $login_query = $logIn->login($email,$password);
    if($login_query){
      if(!empty($redirect)){
      header("Location: $redirect");
       }else{
        header("Location: home.php");
       }

      echo'";
      </script>';

    }else{
      $LoginErr = "Invalid Email or Password";
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
  <title>SuicideNeutralizer | Log In</title>
</head>

<body>
<?php include('config/navbar.php'); ?>
<div class="centering">
    <div class="login-box">
        <h2>Login</h2>
        <form name="SignUp" id="SignUp" action="login.php?redirect=<?=$redirect?>" method="post">
            <div class="user-box">
                <input type="text" name="email" id="email" required="" value="<?= $email; ?>">
                <label>Email<span class="error">*</span></label>
            </div>

            <div class="user-box">
                <input type="password" name="password" id="password" required="" value="<?= $password; ?>">
                <label>Password<span class="error">*</span></label>
            </div>




            <div class="user-box">
                <span class="error"><?= $LoginErr; ?></span>
                <?php if(isset($_GET['newpwd'])){
                    if ($_GET['newpwd']=="passwordupdated"){
                    echo '<span class="success">Password Changed!</span>';
                    }}?>
                <a href="register.php" class="SignUp">Sign Up</a>
            </div>

            <input type="submit" id="submit" name="submit" value="Log In">
            <br><br>
            <a href="forgot.php" class="SignUp" style="float:left">Forgot Password?</a>

        </form>
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