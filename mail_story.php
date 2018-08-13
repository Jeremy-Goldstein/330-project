<?php

#//Test for validity of the CSRF token on the server side
#if(!hash_equals($_SESSION['token'], $_POST['token'])){
#	die("Request forgery detected");
#}

$to = $_POST['email_address'];
$subject = $_POST['article_title'];
$txt = $_POST['article_content'];
$headers = "From: webmaster@example.com";

mail($to,$subject,$txt);

header("Location: home.php");
exit;
?>
