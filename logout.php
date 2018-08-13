<?php
session_start();

//Test for validity of the CSRF token on the server side
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
	$_SESSION['is_logged_on'] = false;
	$_SESSION['username'] = "^";
	session_destroy();
	header("Location: fileshare.php");
	exit;
?>
