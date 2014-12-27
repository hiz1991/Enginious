<?php
//-----------------------------------------------------------------------------
session_start();
$connection = mysql_connect("localhost", "cloudbea_hiz1991", "19910728Aa")
    or die('Could not connect: ' . mysql_error());
mysql_select_db("cloudbea_kura_users", $connection)
    or die('Could not select database');
//-----------------------------------------------------------------------------
//$connection = mysql_connect("ramen.cs.man.ac.uk", "magomak2", "ku180491RA")
//    or die('Could not connect: ' . mysql_error());
//mysql_select_db("S02_magomak2", $connection)
//    or die('Could not select database');
//-----------------------------------------------------------------------------
$username=mysql_real_escape_string($_POST['UID']);
$password=mysql_real_escape_string(md5(rand()));
$email=mysql_real_escape_string($_POST['uMail']);
//$confirmEmail=mysql_real_escape_string($_POST['confirmEmail']);
$musicPreferences=mysql_real_escape_string($_POST['musicPreferences']);
//$agreement=mysql_real_escape_string($_POST['agreement']);
$homeDirectory=$username;
$lastSong=mysql_real_escape_string("");
$marker=mysql_real_escape_string("0");
$accountType="facebook";
$correct=false;
$exist=false;
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
  if ($info['username']==$username && $info['email']==$email)
{
  $_SESSION['user']=$username;
  $_SESSION['userType']='Facebook';//_+_+_+_+_+_+_+_+_+_+_//
  echo 'success';
  $correct=true;
mysql_close();
}
if ($info['email']==$email)
{
	$exist=true;
}
}//while

if ($correct==false&&$exist==false){

if ($username!=""&&$username!=""&&$password!=""&&$email!="")
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

$layout='<?xml version="1.0" encoding="utf-8"?>';
$layout.="\n<ipod>\n<playlist>\n<name>All</name>\n";
$layout.="<contents>\n<song>\n<title>Rainfall</title>\n<artist>Magomedov</artist>\n<album>";
$layout.="cloudbeats</album>\n<year>2013</year>\n<url>";
$layout.="http://cloudbeats.net/Rainfall.mp3";
$layout.="</url>\n<urlOfArt>http://cloudbeats.net/Rainfall.jpg</urlOfArt>\n</song>\n";
$layout.="</contents>\n</playlist>\n</ipod>";

file_put_contents($file, $layout, FILE_APPEND | LOCK_EX);	
//end xml
//xml 
$file2 = $username.'/'.$username.'.xml';
$xml = simplexml_load_file($file2);
 // if (is_file($xml)){}
$playlists = $xml->addChild('playlist');
$playlists->addChild('name', 'energeticMusic');
$playlists = $xml->addChild('playlist');
$playlists->addChild('name', 'calmMusic');
$xml->asXml($file2);
echo $xml->asXML();
//end xml

mkdir('./'.$homeDirectory.'/artwork', 0755, true);
mkdir('./'.$homeDirectory.'/samples', 0755, true);

$addingUser="INSERT INTO userInfo(username, password, email, accountType, musicPreferences, marker, lastSong) VALUES('". mysql_real_escape_string($username) ."', '". mysql_real_escape_string($password) ."', '". mysql_real_escape_string($email) ."', '". mysql_real_escape_string($accountType) ."' ,'". mysql_real_escape_string($musicPreferences) ."','". mysql_real_escape_string($marker) ."', '". mysql_real_escape_string($lastSong) ."')";
mysql_query($addingUser) or die (' error'. mysql_error());

if ($addingUser){echo "success";
	
$_SESSION['user']=$username;
$_SESSION['userType']='Facebook';//_+_+_+_+_+_+_+_+_+_+_//
mysql_close();
}
else{
	echo 'error';
}
}// if2
}// if1
?>