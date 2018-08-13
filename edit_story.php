<?php
session_start();

if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

$new_content = $_POST['new_content'];
$new_title = $_POST['new_title'];
$new_link = $_POST['new_link'];
$article_id = $_POST['article_id'];

// make sure inputs are valid
if( !preg_match('/^[\w_\-]+$/', $new_title) ){
        exit;
}
if( !preg_match('/^[\S_\-]+$/', $new_link) ){
	echo "Invalid link";
        exit;
}
if( !preg_match('/^[\w_\-]+$/', $new_content) ){
        exit;
}

//run php to connect to database
require 'database.php';

// Use a prepared statement
$stmt = $mysqli->prepare("UPDATE `news_site`.`article_file` SET `article_content` = ?, article_title = ?, article_link = ? WHERE `article_file`.`id` = ?");
if(!$stmt){
        printf("1111 Query Prep Failed: %s\n", $mysqli->error);
        exit;
}

$stmt->bind_param('sssi', $new_content, $new_title, $new_link, $article_id);
$stmt->execute();
$stmt->close();

header("Location: home.php");
exit;
?>
