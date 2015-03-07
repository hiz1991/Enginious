<?php
session_start();
$user=$_SESSION['user'];
include("db.php");
include("getUserObject.php");
if($_GET['action']=="just_user")
{
	echo '{"user":"'.$user.'", "type":"'.$_SESSION['userType'].'"}';
	exit();
}
if(!isset($_SESSION['user']))
{
	echo '{ "Songs":[] , "Playlists":[[]], "User":[{"user":"", "type":""}]}';
	exit();
}
//$firstTime=microtime();
// $data = mysql_query("SELECT * FROM `playlists` WHERE `username`='".$user."';")
echo getUserObject($user);
//echo $secondTime-$firstTime;
?>