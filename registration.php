<?php
//-----------------------------------------------------------------------------
session_start();
require 'db.php';
$username=mysql_real_escape_string($_POST['username']);
$password=mysql_real_escape_string($_POST['password']);
$email=mysql_real_escape_string($_POST['email']);
$confirmEmail=mysql_real_escape_string($_POST['confirmEmail']);
$musicPreferences=mysql_real_escape_string($_POST['musicPreferences']);
$agreement=mysql_real_escape_string($_POST['agreement']);
$homeDirectory=$username;
//$lastSong=mysql_real_escape_string("");
$marker=mysql_real_escape_string("0");
$accountType="cloudbeats";
$theme = 'images/bgs/bc-light.jpg';


$data = mysql_query("SELECT * FROM userInfo")
or die('error '.mysql_error());
//$info = mysql_fetch_array($data);
while($info = mysql_fetch_array( $data ))
{
	if ($info['email']==$email)
	{
		$exist=true;
	}
}//while

if ($exist==false)
{


	if ($username!=""&&$username!=""&&$password!=""&&$email!=""&&$marker!="")
	{
//xml
	// $file = $username.'/'.$username.'.xml';
	// if (is_file($file)){
	//   unlink($file);
	// }

		$dir='./'.$homeDirectory;
		if (is_dir($dir)){}
		else
		{
		   mkdir($dir, 0755, true);
		}

// $file = $dir.'/friends.xml';
//  if (is_file($file)){
//    unlink($file);
		//}
		/*file_put_contents($file, '<?xml version="1.0" encoding="utf-8"?><root>', FILE_APPEND | LOCK_EX);*/
// file_put_contents($file, '</root>', FILE_APPEND | LOCK_EX);
//end xml friends

		mkdir('./'.$homeDirectory.'/artwork', 0755, true);
		// mkdir('./'.$homeDirectory.'/artwork/thumb', 0755, true);
		mkdir('./'.$homeDirectory.'/samples', 0755, true);
		mkdir('./'.$homeDirectory.'/waveforms', 0755, true);
        
		$addingUser="INSERT INTO userInfo(username, password, email, accountType, musicPreferences, marker, theme) VALUES('". mysql_real_escape_string($username) ."', '". mysql_real_escape_string($password) ."', '". mysql_real_escape_string($email) ."', '". mysql_real_escape_string($accountType) ."' ,'". mysql_real_escape_string($musicPreferences) ."','". mysql_real_escape_string($marker) ."','". mysql_real_escape_string($theme) ."')";
		mysql_query($addingUser) or die (' error'. mysql_error());

		if ($addingUser)
		{
		// echo 'You have registered as '.$username;
			$_SESSION['user']=$username;
			mysql_close();
			echo 'success';
		}
		else
		{
	// echo 'Please enter all the information correctly';
			echo 'invalid';
		}
	}
}//if1
else
{
	echo "taken";
}
?>