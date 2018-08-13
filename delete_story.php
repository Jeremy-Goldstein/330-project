<?php
session_start();
$article_title =  htmlentities($_POST['article_title']);
$article_author =  htmlentities($_SESSION['username']);
$article_id =  htmlentities($_POST['article_id']);

//run php to connect to database
require 'database.php';

// Use a prepared statement
$stmt = $mysqli->prepare("DELETE FROM `news_site`.`article_file` WHERE `article_file`.`id` = ?");
if(!$stmt){
        printf("1111 Query Prep Failed: %s\n", $mysqli->error);
        exit;
}

$stmt->bind_param('i', $article_id);
$stmt->execute();

header("Location: home.php");
exit;
