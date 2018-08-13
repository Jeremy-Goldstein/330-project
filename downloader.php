<?php
session_start();

if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die( "Request forgery detected");
}

$username =  htmlentities($_SESSION['username']);
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
                $full_path = sprintf("/srv/uploads/%s/%s", $username, $file);
		$finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($full_path);
                // Finally, set the Content-Type header to the MIME type of the file, and display the file.
#Adapted from: https://stackoverflow.com/questions/32781125/the-file-can-not-be-opened-downloaded-or-is-corrupted-when-forcing-its-download

		header("Content-Type: ".$mime);
		header('Content-Description: File Transfer');
 		header('Content-Type: application/octet-stream');
 		header('Content-Disposition: attachment; filename='.basename($file));
 		header('Content-Transfer-Encoding: binary');
 		header('Expires: 0');
 		header('Cache-Control: must-revalidate');
 		header('Pragma: public');
 		header('Content-Length: ' . filesize($full_path));
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); // required for certain browsers 
		header("Content-Disposition: attachment; filename=\"".basename($file)."\";" );
		ob_end_clean();	
		readfile($full_path);
		exit;
		
                $file_found = true;
        }
    }
    closedir($handle);
}
if(!$file_found){
        echo "Error: File not found. Please try again with one of the filenames displayed on the previous page.";
	header("Location: account.php");
	exit;
}


?>
