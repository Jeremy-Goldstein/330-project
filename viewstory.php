<style>
<?php include 'main.css'; ?>
</style>

<?php
session_start();


$title = htmlentities($_GET['title']);
$author = htmlentities($_GET['author']);
//run php to connect to database
require 'database.php';

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT author_username, article_title, article_link, article_content, id FROM article_file where author_username = ? AND article_title = ?");
if(!$stmt){
        printf("1111 Query Prep Failed: %s\n", $mysqli->error);
        exit;
}

$stmt->bind_param('ss', $author, $title);
$stmt->execute();

// Bind the results
$stmt->bind_result($author_username, $article_title, $link, $article_content, $article_id);
$stmt->fetch();
$stmt->close();

$_SESSION['test_id'] = $article_id;

//Display article title w/link and author 
$external_link = "http://" . $link;
printf("<div><a href =%s >   <h3>%s</h3>     </a> By:  %s    <p>%s</p>   </div>\n",
                htmlspecialchars($external_link),
                htmlspecialchars($article_title),
                htmlspecialchars($author_username),
		htmlspecialchars($article_content)
        );

if($_SESSION['is_logged_in'] && strcmp($author_username, $_SESSION['username'])==0){
 
?>
<form enctype="multipart/form-data" action="edit_story.php" method="POST">
                <p>     
			<input type='text' name='new_title' placeholder='New Title'/>
			<input type='text' name='new_content' placeholder='New Content'/>
                        <input type='text' name='new_link' placeholder='New Link'/>
			<input type='hidden' name='article_id' value="<?php echo $article_id; ?>"/>
                        <input type="submit" value="Edit Story" />
			<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field -->
                </p>
        </form>

<form enctype="multipart/form-data" action="delete_story.php" method="POST">
                <p>
                        <input type='hidden' name='article_title' value="<?php echo $article_title; ?>"/>
                        <input type='hidden' name='article_id' value="<?php echo $article_id; ?>"/>
                        <input type="submit" value="Delete Story" />
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field -->
		</p>
        </form>
<?php
}
?>
<!--
<form enctype="multipart/form-data" action="mail_story.php" method="POST">
                <p>
                        <input type='email' name='email_address' placeholder='Email Address'/>
                        <input type='hidden' name='article_title' value="<?php echo $article_title; ?>"/>
			<input type='hidden' name='article_content' value="<?php echo $article_content; ?>"/>	
			<input type="submit" value="Email Story" />
               <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
		 </p>
        </form>
-->
<?php


echo "<br><br><br><h3>Comments</h3>";

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT comment_id, comment_content, article_title, comment_username, article_id FROM article_comments where article_id = ?");
if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
}
$stmt->bind_param('i', $article_id);
$stmt->execute();

// Bind the results
$stmt->bind_result($comment_id, $comment_content, $article_title, $comment_username, $article_id);

//Display comments 
while($stmt->fetch()){
printf("<div>   %s :  %s</div>",
                htmlspecialchars($comment_username),
                htmlspecialchars($comment_content)
	);
	if($_SESSION['is_logged_in'] && strcmp($comment_username, $_SESSION['username'])==0){

?>
	
	<form enctype="multipart/form-data" action="delete_comment.php" method="POST">
                <p>
                        <input type='hidden' name='comment_id' value="<?php echo $comment_id; ?>"/>
                        <input type='hidden' name='article_title' value="<?php echo $article_title; ?>"/>
                        <input type='hidden' name='article_id' value="<?php echo $article_id; ?>"/>
                        <input type="submit" value="Delete Comment" />
			<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field -->
                </p>
        </form>

	<form enctype="multipart/form-data" action="edit_comment.php" method="POST">
                <p>
                        <input type='hidden' name='comment_id' value="<?php echo $comment_id; ?>"/> 
                        <input type='hidden' name='article_title' value="<?php echo $article_title; ?>"/>
			<input type='hidden' name='article_id' value="<?php echo $article_id; ?>"/>
			Revise Comment:<input type="text" name="new_comment"/> <br>
                        <input type="submit" value="Enter" />
			<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field -->
                </p>
        </form><br>	
<?php
	}
}

if($_SESSION['is_logged_in']){
?>
    <form enctype="multipart/form-data" action="new_comment.php" method="POST">
                <p>
                       	 <input type='hidden' name='article_author' value="<?php echo $_GET['author']; ?>"/>
			<input type='hidden' name='article_title' value="<?php echo $_GET['title']; ?>"/>
                        <input type='hidden' name='article_id' value="<?php echo $article_id; ?>"/>
                        Comment:<input type="text" name="new_comment"/> <br>
                        <input type="submit" value="Enter" />
			<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field -->
                </p>
        </form>

<?php
}
?>
	<form action="home.php" method="POST">
                <p>
                       <input type="submit" value="Home" />
               <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /> <!-- add a hidden CSRF token field -->
		 </p>
        </form>
