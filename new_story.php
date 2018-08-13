<?php
session_start();

//Test for validity of the CSRF token on the server side
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

//Execute php to access database
require 'database.php';

//Get inputs
$new_title = htmlentities($_POST['new_title']);
$new_link = htmlentities($_POST['new_link']);
$new_body = htmlentities($_POST['new_body']);

// make sure inputs are valid
if( !preg_match('/^[\w_\-]+$/', $new_title) ){
        exit;
}
if( !preg_match('/^[\S_\-]+$/', $new_link) ){
	echo "Invalid link";
        exit;
}
if( !preg_match('/^[\w_\-]+$/', $new_body) ){
        exit;
}

//Add new username/pass into database
$stmt = $mysqli->prepare("insert into article_file (article_content, article_link, article_title, author_username) values (?,?,?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('ssss', $new_body, $new_link, $new_title, htmlentities( $_SESSION['username']));
$stmt->execute();
$stmt->close();

header("Location: home.php");
exit;

?>

