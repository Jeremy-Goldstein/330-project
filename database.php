<?php
// Content of database.php

$mysqli = new mysqli('localhost', 'jeremy', 'bgoldstein!', 'news_site');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>
