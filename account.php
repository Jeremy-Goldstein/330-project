<!DOCTYPE html>
<html>
<head>
        <title>330 Site</title>
</head>
<body>
<style>
<?php include 'main.css'; ?>
</style>

<?php
session_start();
$username = htmlentities($_SESSION['username']);
$title =  "<h2>" .htmlentities($username) . "'s Account". "</h2>";
echo $title;
echo "<br><br><br>";
$path = "/srv/uploads/" . $username;
if ($handle = opendir($path)) { #Adapted from: https://stackoverflow.com/questions/4202175/php-script-to-loop-through-all-of-the-files-in-a-directory
    while (false !== ($file = readdir($handle))) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;
	echo $file;
	echo "<br>";
	$_SESSION['full_path'] = sprintf("/srv/uploads/%s/%s", $username, $file);
		
	echo "<br><br>";
    }
    closedir($handle);

	

}


echo "<br><br><br>";

?>

<form action="downloader.php" method="POST">
                <p>
                	File to Download:<input type="text" name="file_name_inputted" required/> <br>
		       <input type="submit" value="Download" />
			<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field --> 
                </p>
        </form>


        <form enctype="multipart/form-data" action="uploader.php" method="POST">
                <p>
                        <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
                        <label for="uploadfile_input">Choose a File to Upload:</label> <input name="uploadedfile" type="file" id="uploadfile_input" required/><br>
                        <input type="submit" value="Upload File" />
			<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field --> 
                </p>
        </form>


<form action="file_deleter.php" method="POST">
                <p>
                	File to Delete:<input type="text" name="file_name_inputted" required/> <br>
                       <input type="submit" value="Delete" />
			<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field --> 
                </p>
        </form>



<form action="edit_login_password.php" method="POST">
                <p>
                	Change Account Credentials:<input type="text" name="change_username" placeholder="New Username" required/>
			<input type="text" name="change_password" placeholder="New Password" required/> <br>
                 	<input type="submit" value="Submit" />
			<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field --> 
                </p>
        </form>

	<form action="logout.php" method="POST">
                <p>
                        <input type="submit" value="Logout" />
			<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field --> 
                </p>
        </form>

<form action="delete.php" method="POST">
                <p>
                        <input type="submit" value="Delete Account" />
        		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field -->
	        </p>
        </form>

  <form action="home.php" method="POST">
                <p>
                       <input type="submit" value="Home" />
               <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field -->
                 </p>
        </form>


</body>
</html>

