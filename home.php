<!DOCTYPE html>
<html>
<head>
        <title>330 Site</title>
</head>
<body>
<h1>Welcome to the News</h1>
<style>
<?php include 'main.css'; ?>
</style>
<?php
session_start();


//run php to connect to database
require 'database.php';

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT author_username, article_title, article_link FROM article_file");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

// Bind the results
$stmt->bind_result($author, $title, $link);

//Display article title w/link and author 
while($stmt->fetch()){
$external_link = "http://" . $link;
$fullstory_link = "viewstory.php?title=" . $title . '&author=' . $author ;
$fullstory_link = str_replace(" ", "+", $fullstory_link);
printf("<div><a href =%s >%s</a> &nbsp By:  %s &nbsp <a href= %s>Full Story</a></div><br>",
                htmlspecialchars($external_link),
                htmlspecialchars($title),
                htmlspecialchars($author),
		htmlspecialchars($fullstory_link));
}

if(!$_SESSION['is_logged_in']){
?>

<form action="fileshare.php" method="POST">
                <p>
                        <input type="submit" value="Login" />
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field -->
		</p>
        </form>         
<?php

}
else{ 
?>
<form action="account.php" method="POST">
                <p>
                        <input type="submit" value="Account" />
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field -->
		</p>
        </form>

<br><h3>Upload Story</h3>
<form action="new_story.php" method="POST">
                <p>
                New Title:<input type="text" name="new_title" required/> <br>
                New Body:<input type="text" name="new_body" required/> <br>
                New Link:<input type="text" name="new_link" required/> <br>
		       <input type="submit" value="Enter" />
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field -->
		</p>
        </form>
<?php
}
?>

</body>
</html>
