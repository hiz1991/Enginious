<?php
session_start();
$user=$_SESSION['user'];
include("db.php");
$playlists=array();
$final=array();
$ids=array();
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
$data= selectAllDB('playlists',$user);
while($info = mysql_fetch_array( $data ))
{
	if(array_key_exists($info['name'], $playlists)==false)
		{
			$playlists[$info['name']]=array();
		}
}

$data = selectAllDB('music', $user, ["`music`.`id`", "DESC"]); //mysql_query("SELECT * FROM `music` WHERE `music`.`username`='".$user."'  ORDER BY `music`.`id` DESC;")
while($info = mysql_fetch_array( $data ))
{
 //if (!in_array($info['id'], $ids))
  //{
  $ids[]=$info['id'];
  $ur['url']=$info['url']; 
  $ur['artist']=$info['artist']; 
	  $ur['title']=$info['title'];
	  $ur['genre']=$info['genre'];
	  $ur['wave']=$info['wave'];
	  $ur['id']=$info['id'];
	  $ur['urlOfArt']=$info['urlOfArt'];
	  array_push($final, $ur); 
	  //}        
}
$data =selectAllDB('songsInPlaylists', $user);////mysql_query("SELECT * FROM `songsInPlaylists` WHERE `songsInPlaylists`.`username`='".$user1."';")

// or die('error '.mysql_error());
while($info = mysql_fetch_array( $data ))
{
    if (!in_array($info['songId'], $playlists[$info['playlistName']]))
    	{
    		$playlists[$info['playlistName']][]=$info['songId'];
    	}
                   
 }
                     
mysql_close();
//$secondTime=microtime();// 
$playls=json_encode($playlists);
$songs='';
$songs=json_encode($final);
$songs=str_replace('\\u0000', "", $songs);
$playls=str_replace('\\u0000', "", $playls);
//$str=explode("\u0000", $str);//gzencode
echo '{   "Songs":'.$songs.'  , "Playlists":['.$playls.'], "User":['.'{"user":"'.$user.'", "type":"'.$_SESSION['userType'].'", "lang":"'.$_SESSION['lang'].'", "bg":"'.$_SESSION['bg'].'"}'.']}';
//echo $secondTime-$firstTime;
?>