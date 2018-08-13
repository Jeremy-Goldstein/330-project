<?php

session_start();

//Test for validity of the CSRF token on the server side
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

$username = htmlentities( $_SESSION['username']);
$path = "/srv/uploads/" . $username . "/";
$file_found = false;


// Get the filename and make sure it is valid
if( !preg_match('/^[\w_\.\-]+$/', $_POST['file_name_inputted'])){
        echo "Invalid filename";
        exit;
}


if ($handle = opendir($path)) { #Adapted from: https://stackoverflow.com/questions/4202175/php-script-to-loop-through-all-of-the-files-in-a-directory
    while (false !== ($file = readdir($handle))) {
        if ('.' === $file) continue;
        if ('..' === $file) continue;
        if(strcmp((string)($path . $_POST['file_name_inputted']), (string) ($path . $file))==0){
                $full_path = $path . $file;
                unlink($full_path);
                $file_found = true;
		header("Location: account.php");
		exit;
        }       
    }   
    closedir($handle);
}
if(!$file_found){
        echo "Error: File not found. Please try again with one of the above filenames.";
}


?>
