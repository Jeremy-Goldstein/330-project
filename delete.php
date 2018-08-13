<?php
session_start();
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	echo "Request forgery detected";
	exit;
}

$user =  htmlentities($_SESSION['username']);
$path = "/srv/uploads/" . $user;
if ($handle = opendir($path)) { #Adapted from: https://stackoverflow.com/questions/4202175/php-script-to-loop-through-all-of-the-files-in-a-directory
    while (false !== ($file = readdir($handle))) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;
	$full_path = $path . "/" . $file;
	
	unlink($full_path);	
    }
    closedir($handle);
rmdir($path);
}


$username = htmlentities( $_SESSION['username']);

//run php to connect to database
require 'database.php';

// Use a prepared statement
$stmt = $mysqli->prepare("DELETE FROM `news_site`.`users` WHERE `users`.`username` = ?");
if(!$stmt){
        printf("1111 Query Prep Failed: %s\n", $mysqli->error);
        exit;
}

$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->close();

session_destroy();
header("Location: fileshare.php");
exit;


?>
