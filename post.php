<?php include('config/app.php'); 
include('config/AuthController.php');
include_once 'config/Topic.php';
include_once 'config/Post.php';

$topics = new Topic();
$posts = new Post();
$posts2 = new Post();
$redirect = basename($_SERVER['PHP_SELF']).(isset($_GET['topic_id'])? "?topic_id=".$_GET['topic_id']:"");
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
<script src="bootstrap.min.js"></script>
<script src="tinymce/tinymce.min.js"></script>

<script src="js/tinymce_editor.js"></script>
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
		<div class="small-container">		
			
		<br>
		<div id="postLsit">				
		<?php if(!empty($_GET['topic_id'])) { ?>	   
		   <div class="posts list">
				<?php 
				$topics->topic_id = $_GET['topic_id'];
				$topicDetails = $topics->getTopic();
				?>
				<span style="font-size:20px;"><a href="forum.php"><< <?php echo $topicDetails['subject']; ?></a></span>
				<br><br>
				<?php if($_SESSION['auth_user']['user_type'] == "Admin"){?>
				<div class="text-right" id="button_section">
							<a class="btn btn-default btn-sm" href="config/authActions.php?request=deleteTopic&topicID=<?=$_GET['topic_id'];?>"><i class="fa-solid fa-trash"></i> Delete Topic</a>
				</div>
				<br>
				<?php } ?>
				<?php				
				$result = $topics->getPosts();
				while ($post = $result->fetch_assoc()) {
					$date = date_create($post['created']);
					$posterName = $post['name'];
					if($posterName == '') {
						$posterName = $post['name'];
					}
				?>
				<article class="row" id="postRow_<?php echo $post['post_id']; ?>">
					<div class="col-md-2 col-sm-2 hidden-xs">
					  <figure class="thumbnail">
						<img class="img-responsive" src="<?= $posts->getPFP($post['post_id']);?>" /> 
						<figcaption class="text-center">
							<?php if($post['accType']=="Consultant"):?>
							<a href="consultant.php?consultant=<?=$post['email']; ?>">
							<?php endif;?>
								<?php echo ucwords($posterName); ?></a>
							<br> <?=$post['accType']?></figcaption>
					  </figure>
					</div>
					<div class="col-md-10 col-sm-10">
					  <div class="panel panel-default arrow left">
						<div class="panel-body">
						  <header class="text-left">
							<div class="comment-user"><i class="fa fa-user"></i>
								<?php if($post['accType']=="Consultant"):?>
									<a href="consultant.php?consultant=<?=$post['email']; ?>">
								<?php endif;?>
									By: <?php echo $posterName; ?></a></div>
							<time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> <?php echo date_format($date, 'd M Y H:i:s'); ?></time>
						  </header>
						  <br>					  
						  <div class="comment-post"  id="post_message_<?php echo $post['post_id']; ?>">
							
							<?php echo $post['message']; ?>
							
						  </div>
						  
						  <textarea name="message" data-topic-id="<?php echo $post['topic_id']; ?>" id="<?php echo $post['post_id']; ?>" style="visibility: hidden;"></textarea><br>
						  

						  <?php if($_SESSION['auth_user']['user_type'] == "Admin"){?>
						  <div class="text-right" id="button_section_<?php echo $post['post_id']; ?>">
							<a class="btn btn-default btn-sm" href="config/authActions.php?request=deletePost&topicID=<?=$_GET['topic_id'];?>&postID=<?=$post['post_id'];?>"><i class="fa-solid fa-trash"></i> Delete</a>
						  </div>

						  <?php } ?>
						  
								
						</div>					
				
					  </div>
					</div>
				</article>	
				<?php } ?>
				
		   </div>	   
	   <?php } ?>
		
	
			
		
	
	
		<form id="posts" name="posts" method="post">
			<textarea name="message" id="message"></textarea><br>	
			<input type="hidden" name="action" id="action" value="save" />
			<input type="hidden" name="topic_id" value="<?php echo $_GET['topic_id']; ?>">
			<button type="submit" id="save" name="save" class="btn btn-info saveButton">Post</button>
		</form>
	
	
	<div id="postHtml" class="hidden">					
		<article class="row">
			<div class="col-md-2 col-sm-2 hidden-xs">
			  <figure class="thumbnail">
				<img class="img-responsive"  src="PICTURE" />
				<figcaption class="text-center">
					<?php if($_SESSION['auth_user']['user_type']=="Consultant"):?>
						<a href="consultant.php?consultant=EMAIL">
					<?php endif;?>
						USERNAME</a><br>ACCTYPE</figcaption>
			  </figure>
			</div>
			<div class="col-md-10 col-sm-10">
			  <div class="panel panel-default arrow left">
				<div class="panel-body">
				  <header class="text-left">
					<div class="comment-user"><i class="fa fa-user"></i>
					<?php if($_SESSION['auth_user']['user_type']=="Consultant"):?>
						<a href="consultant.php?consultant=EMAIL">
					<?php endif;?>
						By: USERNAME</a></div>
					<time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> POSTDATE</time>
				  </header>
				  <br>
				  <div class="comment-post" id="post_message_POSTID">					
					POSTMESSAGE					
				  </div>
				  <textarea name="message" id="POSTID" style="visibility: hidden;"></textarea><br>
				  <?php if($_SESSION['auth_user']['user_type'] == "Admin"){?>
				  <div class="text-right" id="button_section_POSTID">
					<a class="btn btn-default btn-sm" href="config/authActions.php?request=deletePost&topicID=TOPICID&postID=POSTID"><i class="fa-solid fa-trash"></i> Delete</a>
				  </div>
				  <?php } ?>
				</div>
			  </div>
			</div>
		</article>		
	</div>	
	
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
$crisp.push(["set", "user:avatar", ["<?php if(isset($_SESSION['auth_user']['imgURL'])){ echo $_SESSION['auth_user']['imgURL'];}else{echo "";}?>"]]);</script>
