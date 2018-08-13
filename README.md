# README #

A <a href="http://ec2-34-207-71-8.compute-1.amazonaws.com/~jeremy/fileshare.php">demo</a> of a news site where users can post links to media they find interesting and others can comment upon others' posts, modeled after <a href='http://digg.com/'>Digg</a> or <a href='http://slashdot.org/'>Slashdot</a>. 


Functionality: 
- Users can register for accounts and then log in to the website.
- Accounts should have both a username and a secure password.
- Registered users can submit story commentary.
- A link can be associated with each story
- Registered users can comment on any story.
- Unregistered users can only view stories and comments.
- Registered users can edit and delete their stories and comments.
- All data kept in a MySQL database (user information, stories, comments, and links).

Web Security Best Practices
- Safe from SQL Injection attacks (2 points)
- Site follows the FIEO philosophy (3 points)
- CSRF tokens are passed when creating, editing, and deleting comments and stories


