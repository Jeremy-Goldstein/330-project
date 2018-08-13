<!DOCTYPE html>
<html>
<head>
	<title>330 Login</title>
</head>
<body>
<style>
<?php include 'main.css'; ?>
</style>

	<h2>Login/Create Account</h2>

	<form enctype="multipart/form-data" action="login.php" method="POST">
		<p>
			Username:<input type="text" name="username"/> <br>
			Password:<input type="text" name="password"/> <br>
			<input type="submit" value="Enter" />
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field -->
		</p>
	</form>

	<form action="create_user.php" method="POST">
                <p>
                New Username:<input type="text" name="new_username_inputted"/> <br>
		New Password:<input type="text" name="new_password_inputted"/> <br>
                       <input type="submit" value="Enter" />
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field -->
                </p>
        </form>

	<form action="home.php" method="POST">
                <p>
                       <input type="submit" value="Home" />
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field -->
                </p>
        </form>

<?php
session_start();
$_SESSION['is_logged_in'] = false;
$_SESSION['username'] = "^";
?>

</body>
</html>

