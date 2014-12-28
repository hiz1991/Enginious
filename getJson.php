<?php
session_start();
$user=$_SESSION['user'];
$connection = mysql_connect("localhost", "root", "19910728Aa")
or die('Could not connect: ' . mysql_error());
mysql_select_db("kura_users", $connection)
or die('Could not select database');
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
$playlists=array();
//$firstTime=microtime();
$data = mysql_query("SELECT * FROM `playlists` WHERE `username`='".$user."';")
//$data = mysql_query("SELECT * FROM `playlists` WHERE `username`="."store".";");
or die('error At Playlists'.mysql_error());
//$info = mysql_fetch_array($data);
while($info = mysql_fetch_array( $data ))
{
	if(array_key_exists($info['name'], $playlists)==false){$playlists[$info['name']]=array();}
}


$final=array();
$ids=array();
$data = mysql_query("SELECT * FROM `music` WHERE `music`.`username`='".$user."'  ORDER BY `music`.`id` DESC;")
or die('error At Music'.mysql_error());
//$info = mysql_fetch_array($data);
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
	$data = mysql_query("SELECT * FROM `songsInPlaylists` WHERE `songsInPlaylists`.`username`='".$user1."';")
    or die('error '.mysql_error());
	while($info = mysql_fetch_array( $data ))
	{
	                   if (!in_array($info['songId'], $playlists[$info['playlistName']])){$playlists[$info['playlistName']][]=$info['songId'];}
	                   
	 }
                     
	                  // print_r($playlists);
mysql_close();
//$secondTime=microtime();// 
// echo $final[0]['url'];
// $final = mb_convert_encoding($final, "UTF-8", "auto");
// echo json_encode($final, JSON_UNESCAPED_UNICODE);
// echo json_last_error();
$playls=json_encode($playlists);
$songs='';
$songs=json_encode($final);
$songs=str_replace('\\u0000', "", $songs);
$playls=str_replace('\\u0000', "", $playls);
//$str=explode("\u0000", $str);//gzencode
echo '{   "Songs":'.$songs.'  , "Playlists":['.$playls.'], "User":['.'{"user":"'.$user.'", "type":"'.$_SESSION['userType'].'"}'.']}';
//echo $secondTime-$firstTime;
?>