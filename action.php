<?php
include('config/app.php');
include('config/AuthController.php');
include_once 'config/Topic.php';
include_once 'config/Post.php';

$topic = new Topic();
$post = new Post();
$redirect = basename($_SERVER['PHP_SELF']);
$AuthLogin = new AuthenticatorController($redirect);

if(!empty($_POST['message']) && $_POST['message'] && $_POST['action'] == 'save') {	
	$post->message = $_POST['message'];	
	$post->topic_id = $_POST['topic_id'];	
	$post->insert();	
}

if(!empty($_POST['action']) && $_POST['action'] == 'createTopic') {
	$topic->topicName = $_POST['topicName'];
	$topic->message = $_POST['message'];
	$topic->insert();	
}






?>