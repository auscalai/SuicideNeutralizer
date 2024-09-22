<?php include('config/app.php'); 
include('config/AuthController.php');
include_once 'config/Topic.php';
include_once 'config/Post.php';

$topics = new Topic();
$redirect = basename($_SERVER['PHP_SELF']);
$AuthLogin = new AuthenticatorController($redirect);
?>


<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Sen:wght@400;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="tinymce/tinymce.min.js"></script>
<script src="js/tinymce_editor.js"></script>
<script src="js/topics.js"></script>
  <link rel="stylesheet" href="css/forum.css" />
  <link rel="stylesheet" href="css/navbar.css" />
  <link rel="icon" href="img/logo.png" type="image/x-icon">
  <title>SuicideNeutralizer | Forum</title>
  <?php 
    if(!isset($_SESSION['authenticated']) OR $_SESSION['auth_user']['user_type']=="Member"){ ?>
  <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="ad6f3143-98ba-4e8e-9f26-855358541a32";(function(){d=document;s=d.createElement("script");s.src="js/client.crisp.chat.js";s.async=1;var firstScript = document.head.getElementsByTagName("script")[0];
firstScript.parentNode.insertBefore(s, firstScript);})();</script>
  <?php }?>
  <style>.crisp-client .cc-tlyw .cc-kxkl .cc-1hqb .cc-gye0 .cc-11uv .cc-15ak .cc-acjo .cc-nmj4 {display:none !important;}</style>
</head>

<body>

  <?php include('config/navbar.php'); ?>
  <div class="container">		
	<div class="row">
	<div class="single category">
		<br>
		<span style="font-size:20px;"><a href="forum.php"><< Back</a></span>
		<br><br>
		<div id="createNewtopic">	
			<form id="topicForm" name="topicForm" method="post">
				<div class="form-group">
					<label for="email">Topic Name:</label>
					<input type="text" name="topicName" id="topicName" class="form-control" required>
				</div>	
				<div class="form-group">
					<label for="email">Message:</label>
					<textarea name="message" id="message"></textarea>
				</div>	
				<input type="hidden" name="action" value="createTopic">
				<button type="submit" id="saveTopic" name="saveTopic" class="btn btn-info">Create Topic</button>
			</form>	
		</div>		
	</div>	
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
