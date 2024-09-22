<?php

include('config/app.php');
include_once('config/RegisterController.php');
include('config/mail.php');
$db = new DatabaseConnection;
$email = "";
$register = new RegisterController;
$logIn = new LoginController;

//Log In
if (isset($_POST['reset-password'])) {

    $email = empty($_POST["email"]) ? "" : $_POST["email"];
    $checkEmail_query = $register->isEmailExist($email); 
    if($checkEmail_query){

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    //$url = "https://www.suicideneutralizer.com/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $url = "http://localhost/fyp/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 600; //expires in 10 mins
    
    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
    $stmt = mysqli_stmt_init($dbc);
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "Error";
        exit();
    }else{
        mysqli_stmt_bind_param($stmt,"s",$email);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($dbc);
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "Error";
        exit();
    }else{
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt,"ssss",$email, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);

        $query = "SELECT Name FROM user WHERE Email = ?";
        $stmt = $dbc->prepare($query);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($name);
            if ($stmt->fetch()) {
                $receipientName = $name;
            }
    }
  }

    mysqli_stmt_close($stmt);
    mysqli_close($dbc);

    $to = $email;
    $subject = "SuicideNeutralizer: Password Reset Request";
    $message = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"nl-container\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #091548;\" width=\"100%\">
    <tbody>
    <tr>
    <td>
    <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"row row-1\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #091548; background-image: url('https://i.ibb.co/fQTM1DN/background-2.png'); background-position: center top; background-repeat: repeat;\" width=\"100%\">
    <tbody>
    <tr>
    <td>
    <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"row-content stack\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000; width: 600px; margin: 0 auto;\" width=\"600\">
    <tbody>
    <tr>
    <td class=\"column column-1\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 15px; padding-left: 10px; padding-right: 10px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;\" width=\"100%\">
    <div class=\"spacer_block block-1\" style=\"height:8px;line-height:8px;font-size:1px;\"> </div>
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"image_block block-2\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt;\" width=\"100%\">
    <tr>
    <td class=\"pad\" style=\"width:100%;\">
    <div align=\"center\" class=\"alignment\" style=\"line-height:10px\"><img src=\"https://i.ibb.co/p27xk0b/logo.png\" style=\"display: block; height: auto; border: 0; max-width: 93px; width: 100%;\" width=\"93\"/></div>
    </td>
    </tr>
    </table>
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"paragraph_block block-3\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;\" width=\"100%\">
    <tr>
    <td class=\"pad\" style=\"padding-bottom:15px;padding-top:10px;\">
    <div style=\"color:#ffffff;font-family:'Varela Round', 'Trebuchet MS', Helvetica, sans-serif;font-size:30px;line-height:120%;text-align:center;mso-line-height-alt:36px;\">
    <p style=\"margin: 0; word-break: break-word;\"><span>Reset Your Password</span></p>
    </div>
    </td>
    </tr>
    </table>
    <table border=\"0\" cellpadding=\"5\" cellspacing=\"0\" class=\"paragraph_block block-4\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;\" width=\"100%\">
    <tr>
    <td class=\"pad\">
    <div style=\"color:#ffffff;font-family:'Varela Round', 'Trebuchet MS', Helvetica, sans-serif;font-size:14px;line-height:150%;text-align:center;mso-line-height-alt:21px;\">
    <p style=\"margin: 0; word-break: break-word;\">We received a request to reset your password.</p>
    <p style=\"margin: 0; word-break: break-word;\">This password reset link is valid for 10 minutes.</p>
    </div>
    </td>
    </tr>
    </table>
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"button_block block-5\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt;\" width=\"100%\">
    <tr>
    <td class=\"pad\" style=\"padding-bottom:20px;padding-left:15px;padding-right:15px;padding-top:20px;text-align:center;\">
    <div align=\"center\" class=\"alignment\"><a href=\"";
    $message .= "$url";
    $message .= "\" style=\"text-decoration:none;display:inline-block;color:#091548;background-color:#ffffff;border-radius:24px;width:auto;border-top:0px solid transparent;font-weight:undefined;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:5px;padding-bottom:5px;font-family:'Varela Round', 'Trebuchet MS', Helvetica, sans-serif;font-size:15px;text-align:center;mso-border-alt:none;word-break:keep-all;\" target=\"_blank\"><span style=\"padding-left:25px;padding-right:25px;font-size:15px;display:inline-block;letter-spacing:normal;\"><span style=\"word-break:break-word;\"><span data-mce-style=\"\" style=\"line-height: 30px;\"><strong>RESET MY PASSWORD</strong></span></span></span></a><!--[if mso]></center></v:textbox></v:roundrect><![endif]--></div>
    </td>
    </tr>
    </table>
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_block block-6\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt;\" width=\"100%\">
    <tr>
    <td class=\"pad\" style=\"padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:10px;\">
    <div align=\"center\" class=\"alignment\">
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt;\" width=\"60%\">
    <tr>
    <td class=\"divider_inner\" style=\"font-size: 1px; line-height: 1px; border-top: 1px solid #5A6BA8;\"><span> </span></td>
    </tr>
    </table>
    </div>
    </td>
    </tr>
    </table>
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"paragraph_block block-7\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;\" width=\"100%\">
    <tr>
    <td class=\"pad\" style=\"padding-bottom:10px;padding-left:25px;padding-right:25px;padding-top:10px;\">
    <div style=\"color:#7f96ef;font-family:'Varela Round', 'Trebuchet MS', Helvetica, sans-serif;font-size:14px;line-height:150%;text-align:center;mso-line-height-alt:21px;\">
    <p style=\"margin: 0; word-break: break-word;\"><strong>Didn't request a password reset?</strong></p>
    <p style=\"margin: 0; word-break: break-word;\">You can safely ignore this message.</p>
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"row row-2\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt;\" width=\"100%\">
    <tbody>
    <tr>
    <td>
    <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"row-content stack\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000; width: 600px; margin: 0 auto;\" width=\"600\">
    <tbody>
    <tr>
    <td class=\"column column-1\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 15px; padding-left: 10px; padding-right: 10px; padding-top: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;\" width=\"100%\">
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_block block-1\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt;\" width=\"100%\">
    <tr>
    <td class=\"pad\" style=\"padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;\">
    <div align=\"center\" class=\"alignment\">
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt;\" width=\"60%\">
    <tr>
    <td class=\"divider_inner\" style=\"font-size: 1px; line-height: 1px; border-top: 1px solid #5A6BA8;\"><span> </span></td>
    </tr>
    </table>
    </div>
    </td>
    </tr>
    </table>
    <table border=\"0\" cellpadding=\"15\" cellspacing=\"0\" class=\"paragraph_block block-2\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;\" width=\"100%\">
    <tr>
    <td class=\"pad\">
    <div style=\"color:#4a60bb;font-family:'Varela Round', 'Trebuchet MS', Helvetica, sans-serif;font-size:12px;line-height:120%;text-align:center;mso-line-height-alt:14.399999999999999px;\">
    <p style=\"margin: 0; word-break: break-word;\"><span>Copyright © 2023 SuicideNeutralizer, All rights reserved.<br/></span><span></span></p>
    </div>
    </td>
    </tr>
    </table>
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"html_block block-3\" role=\"presentation\" style=\"mso-table-lspace: 0pt; mso-table-rspace: 0pt;\" width=\"100%\">
    <tr>
    <td class=\"pad\">
    <div align=\"center\" style=\"font-family:'Varela Round', 'Trebuchet MS', Helvetica, sans-serif;text-align:center;\"><div style=\"height-top: 20px;\"></div></div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>";



    send_mail($to, $receipientName, $subject, $message);
    
    header("Location: forgot.php?reset=success");




    }else{
    header("Location: forgot.php?reset=failed");
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
        <form name="SignUp" id="SignUp" action="forgot.php" method="post">
            <div class="user-box">
                <input type="text" name="email" id="email" required="" value="<?= $email; ?>">
                <label>Email<span class="error">*</span></label>
            </div>

            <div class="user-box">
                <?php if(isset($_GET['reset'])){
                    if ($_GET['reset']=="success"){
                    echo '<span class="success">Check your Inbox/Spam folder!</span>';
                    }elseif($_GET['reset']=="failed"){
                    echo '<span class="error">Couldn\'t find your email!</span>';
                    }}?>
                <a href="login.php" class="SignUp">Log In</a>
            </div>

            <input type="submit" id="submit" name="reset-password" value="Send reset request">

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