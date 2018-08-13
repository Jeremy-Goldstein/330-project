<?php
//implement password-based user authentication in your web application.

session_start();

$user =  htmlentities($_POST['username']);
$pwd_guess =  htmlentities($_POST['password']);

// Get the username and make sure it is valid
if( !preg_match('/^[\w_\-]+$/', $user) ){
        echo "Invalid username";
        exit;
}
if( !preg_match('/^[\w_\-]+$/', $pwd_guess) ){
        echo "Invalid username";
        exit;
}

//run php to connect to database
require 'database.php';

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), username, crypted_password FROM users WHERE username=?");

// Bind the parameter
$stmt->bind_param('s', $user);
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();


// Compare the submitted password to the actual password hash
if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
	// Login succeeded!
	$_SESSION['username'] = $user_id;
	$_SESSION['is_logged_in'] = true;
	$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
	// Redirect to your target page
       header("Location: home.php");
	exit;
} else{	
	// Login failed; redirect back to the login screen
       $_SESSION['is_logged_in'] = false;
	header("Location: fileshare.php");
	exit;
}


?>
