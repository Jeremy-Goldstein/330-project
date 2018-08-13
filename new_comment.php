<?php
session_start();

//Test for validity of the CSRF token on the server side
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

//Execute php to access database
require 'database.php';

//Get inputs
$new_comment = htmlentities($_POST['new_comment']);
$article_title = htmlentities($_POST['article_title']);
$article_id = htmlentities($_SESSION['test_id']);


// Get the username and make sure it is valid
if( !preg_match('/^[\w_\-]+$/', $new_comment) ){
        echo "Invalid username";
        exit;
}
//Add new username/pass into database
$stmt = $mysqli->prepare("insert into article_comments (comment_content, article_title, comment_username, article_id) values (?,?,?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('sssi', $new_comment, $article_title, htmlentities($_SESSION['username']), $article_id);
$stmt->execute();
$stmt->close();


header("Location: home.php");
exit;

?>

