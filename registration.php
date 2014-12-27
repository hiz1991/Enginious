<?php
//-----------------------------------------------------------------------------
session_start();
require 'db.php';
// $connection = mysql_connect("localhost", "cloudbea_hiz1991", "19910728Aa")
//     or die('Could not connect: ' . mysql_error());
// mysql_select_db("cloudbea_kura_users", $connection)
//     or die('Could not select database');
//-----------------------------------------------------------------------------
//$connection = mysql_connect("ramen.cs.man.ac.uk", "magomak2", "ku180491RA")
//    or die('Could not connect: ' . mysql_error());
//mysql_select_db("S02_magomak2", $connection)
//    or die('Could not select database');
//-----------------------------------------------------------------------------
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

/*
$username="userInfo";
$tableName=substr($username, 0, 3);

$exist=false;

$dbname = 'cloudbea_kura_users';
$result = mysql_list_tables($dbname);
    if (!$result) {
        print "DB Error, could not list tables\n";
        print 'MySQL Error: ' . mysql_error();
        exit;
    }
    while ($row = mysql_fetch_row($result)) {
           if ($tableName==substr("$row[0]", 0, 3))
			{
				$exist=true;
				echo "yep";
			}
			
    }

    mysql_free_result($result);

if ($exist)
{
	mkdir('./'.$homeDirectory, 0755, true);
	$addingUser="INSERT INTO $tableName(username, password, email, homeDirectory, musicPreferences, marker, lastSong) VALUES('". mysql_real_escape_string($username) ."', '". mysql_real_escape_string($password) ."', '". mysql_real_escape_string($email) ."', '". mysql_real_escape_string($homeDirectory) ."' ,'". mysql_real_escape_string($musicPreferences) ."','". mysql_real_escape_string($marker) ."', '". mysql_real_escape_string($lastSong) ."')";
	mysql_query($addingUser) or die (' error'. mysql_error());

	if ($addingUser){echo 'You have registered as '.$username;

	$_SESSION['user']=$username;
	mysql_close();
	 echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ipod.swf">';
	}
	else{
		echo 'Please enter all the information correctly';
		echo '<META HTTP-EQUIV="Refresh" Content="1; URL=/">';
	}	
}
else {
	
	
	
}
*/
//-----------------------------------------------------------------------------
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

if ($exist==false){


if ($username!=""&&$username!=""&&$password!=""&&$email!=""&&$marker!="")
{
//xml
	$file = $username.'/'.$username.'.xml';
	if (is_file($file)){
	  unlink($file);
	}
	
	$dir='./'.$homeDirectory;
	if (is_dir($dir)){}
	else
	{mkdir($dir, 0755, true);}

$file = $dir.'/friends.xml';
 if (is_file($file)){
   unlink($file);
 }
file_put_contents($file, '<?xml version="1.0" encoding="utf-8"?><root>', FILE_APPEND | LOCK_EX);
file_put_contents($file, '</root>', FILE_APPEND | LOCK_EX);
//end xml friends

mkdir('./'.$homeDirectory.'/artwork', 0755, true);
mkdir('./'.$homeDirectory.'/samples', 0755, true);

$addingUser="INSERT INTO userInfo(username, password, email, accountType, musicPreferences, marker) VALUES('". mysql_real_escape_string($username) ."', '". mysql_real_escape_string($password) ."', '". mysql_real_escape_string($email) ."', '". mysql_real_escape_string($accountType) ."' ,'". mysql_real_escape_string($musicPreferences) ."','". mysql_real_escape_string($marker) ."')";
mysql_query($addingUser) or die (' error'. mysql_error());

if ($addingUser)
	{
		// echo 'You have registered as '.$username;
		$_SESSION['user']=$username;
		mysql_close();
		echo 'success';
}
else{
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