<?php
session_start();

//Test for validity of the CSRF token on the server side
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);

// Get the filename and make sure it is valid
$filename = basename($_FILES['uploadedfile']['name']);
if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
	echo "Invalid filename";
	exit;
}

$username = htmlentities($_SESSION['username']);
$full_path = sprintf("/srv/uploads/%s/%s", $username, $filename);
echo $full_path;
if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
	header("Location: account.php");
	exit;
}else{
	echo "File Uploading Error: Please try again.";
	exit;
}

?>
