<!DOCTYPE html>
<head><title>330 Person Information</title></head>
<body>
<?php
session_start();
//Execute php to access database
require 'database.php';

//Get inputs
$user = htmlentities($_POST['new_username_inputted']);
$pass = htmlentities($_POST['new_password_inputted']);

// Get the username and make sure it is valid
if( !preg_match('/^[\w_\-]+$/', $user) ){
        echo "Invalid username";
        exit;
}
if( !preg_match('/^[\w_\-]+$/', $pass) ){
        echo "Invalid pasword";
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

//Add new username/pass into database
$stmt = $mysqli->prepare("insert into users (username, crypted_password) values (?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('ss', $user, $pass);
$stmt->execute();
$stmt->close();

//Create folder for file uploads
$oldmask = umask(0);
mkdir("/srv/uploads/" . $user, 0777);
umask($oldmask);


echo "Account has been created. You may now sign in from the login page.";
header("Refresh:2, url= fileshare.php");

?>

</body>

</html>
