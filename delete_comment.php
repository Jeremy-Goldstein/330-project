<?php
session_start();
$new_comment = htmlentities($_POST['new_comment']);
$comment_id =  htmlentities($_POST['comment_id']);
$article_title =  htmlentities($_POST['article_title']);
$article_author =  htmlentities($_SESSION['username']);
$article_id =  htmlentities($_POST['article_id']);


if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

//run php to connect to database
require 'database.php';

// Use a prepared statement
$stmt = $mysqli->prepare("DELETE FROM `news_site`.`article_comments` WHERE `article_comments`.`comment_id` = ?");
if(!$stmt){
        printf("1111 Query Prep Failed: %s\n", $mysqli->error);
        exit;
}

$stmt->bind_param('i', $comment_id);
$stmt->execute();

header("Location: home.php");
exit;
