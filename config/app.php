<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'fyp');

include_once('DatabaseConnection.php');
$db = new DatabaseConnection;
$dbc = $db->connect();

?>