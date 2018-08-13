<?php
session_start();
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

$new_comment =  htmlentities($_POST['new_comment']);
$comment_id = htmlentities( $_POST['comment_id']);
$article_title = htmlentities( $_POST['article_title']);
$article_author = htmlentities( $_SESSION['username']);
$article_id =  htmlentities($_POST['article_id']);


//Make sure inputs are valid
if( !preg_match('/^[\w_\-]+$/', $new_comment) ){
        echo "Invalid comment";
        exit;
}

//run php to connect to database
require 'database.php';

// Use a prepared statement
$stmt = $mysqli->prepare("UPDATE `news_site`.`article_comments` SET `comment_content` = ? WHERE `article_comments`.`comment_id` = ?");
if(!$stmt){
        printf("1111 Query Prep Failed: %s\n", $mysqli->error);
        exit;
}

$stmt->bind_param('si', $new_comment, $comment_id);
$stmt->execute();
$stmt->close();

header("Location: home.php");
exit;
?>

