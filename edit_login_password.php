<?php
session_start();
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

//Execute php to access database
require 'database.php';

//Get inputs
$old_user = $_SESSION['username'];
$user = $_POST['change_username'];
$pass = $_POST['change_password'];

//Make sure inputs are valid
if( !preg_match('/^[\w_\-]+$/', $user) ){
        echo "Invalid username";
        exit;
}
if( !preg_match('/^[\w_\-]+$/', $pass) ){
        echo "Invalid username";
        exit;
}
//Get already existing usernames
$stmt1 = $mysqli->prepare("select username from users");
if(!$stmt1){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
}
$stmt1->execute();
$stmt1->bind_result($existing_login);

//Check if login already exists
while($stmt1->fetch()){
        if ((strcmp($existing_login, $user))==0){
        echo "User already exits. Choose different username.";
        exit;
        }
}

$stmt1->close();

//Encrypt password
$pass = password_hash($pass, PASSWORD_BCRYPT);

$stmt = $mysqli->prepare("UPDATE `news_site`.`users` SET `username` = ?, crypted_password = ? WHERE `users`.`username` = ?");
if(!$stmt){
        printf("1111 Query Prep Failed: %s\n", $mysqli->error);
        exit;
}

$stmt->bind_param('sss', $user, $pass, $old_user);
$stmt->execute();
$stmt->close();

$_SESSION['username'] = $user;
//Rename folder
rename("/srv/uploads/" . $old_user, "/srv/uploads/" . $user);


header("Location: account.php");

?>

