<?php

include('config/app.php');
include_once('config/RegisterController.php');

$emailErr = $passwordErr = $rptpasswordErr = $nameErr = $captchaErr =  "";
$name = $email = $password = $rptpassword =  "";



//	Sign Up validate
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $go = true;

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $go = false;
    } elseif(strlen($_POST["name"])>15){
        $nameErr = "Name should be lesser than 15 characters";
        $go = false;
        $name = $_POST["name"];
    }else {
        $name = $_POST["name"];
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $go = false;
    } else {
        $email = $_POST["email"];
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
        $go = false;
    } else {
        $password = $_POST["password"];
    }

    if (empty($_POST["rptpassword"])) {
        $rptpasswordErr = "Password is required";
        $go = false;
    } else if ($_POST["rptpassword"] != $_POST["password"]) {
        $rptpasswordErr = "Incorrect password";
        $go = false;
    }

    if (empty($_POST["g-recaptcha-response"])) {
        $captchaErr = "Please complete captcha verification";
        $go = false;
    } else{
        $secret = "6Le3L6AnAAAAAK9GRln0Xwg9nLvfLJ_XqdfKU1ZN";

        $reponse =file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret'.$secret.'&response='.$_POST["g-recaptcha-response"]);
    }



    //check email format
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
        $emailErr = "Fill in a correct email.";
        $go = false;
    }


    //minimum 4 characters

    $register = new RegisterController;
    
    $checkPasswordLength = $register->isMinFourChar($password);
    if(!$checkPasswordLength){
        $passwordErr = "Minimum 4 characters.";
        $go = false;
    }
    $checkNameLength = $register->isMinFourChar($name);
    if (!$checkNameLength) {
        $nameErr = "Minimum 4 characters.";
        $go = false;
    }


    //check if email is taken
    $checkEmail_query = $register->isEmailExist($email); 
    if($checkEmail_query){
        $emailErr = "Email is taken";
        $go= false;
    }

    $checkName_query = $register->isUsernameExist($name); 
    if($checkName_query){
        $nameErr = "Username is taken";
        $go= false;
    }
    //if all is good. sign up account
    if ($go) {

        $regDate = $_POST["registerDate"];
        //password encryption
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        //add into database
        $register_query = $register->registration($name, $email, $password, $regDate);

        if ($register_query) {
            echo '<script type="text/javascript">
                window.location ="login.php";
                alert("You have successfully Signed Up");
                </script>';
        } else {
            echo "Error";
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
  <title>SuicideNeutralizer | Register</title>
</head>

<body>
<?php include('config/navbar.php'); ?>
<div class="centering">
    <div class="login-box">
        <h2>Sign Up</h2>
        <form name="SignUp" id="SignUp" action="register.php" method="post">
            <input type="hidden" name="registerDate" readonly value="<?= date('Y-m-d'); ?>" >
            <div class="user-box">
                <input type="text" name="name" id="name" required="" value="<?= $name; ?>">
                <label>Username<span class="error">* <?= $nameErr; ?></span></label>
            </div>

            <div class="user-box">
                <input type="text" name="email" id="email" required="" value="<?= $email; ?>">
                <label>Email<span class="error">* <?= $emailErr; ?></span></label>
            </div>

            <div class="user-box">
                <input type="password" name="password" id="password" required="" value="<?= $password; ?>">
                <label>Password<span class="error">* <?= $passwordErr; ?></span></label>
            </div>

            <div class="user-box">
                <input type="password" name="rptpassword" id="rptpassword" required="" value="<?= $rptpassword; ?>">
                <label>Repeat Password<span class="error">* <?= $rptpasswordErr; ?></span></label>
            </div>
            <div class="g-recaptcha" data-sitekey="6Le3L6AnAAAAAMd4MlODLxkGSeTE_wFoUwgKxNRS"></div>
            <span class="error"><?= $captchaErr; ?></span>
            <br>


            <div class="user-box">
                <a href="login.php" class="SignUp">Log In</a>
            </div>

            <input type="submit" id="submit" name="submit" value="Sign Up">

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