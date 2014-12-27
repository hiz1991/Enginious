<?php
session_start();
//$user=$_SESSION['user'];
include("getid3/getid3.php");
$getID3 = new getID3;
$path=$_GET['path'];
$user=$_GET['user'];
echo 'path is: '.$path.' and the user is: '.$user;
$path= explode('/', $path);
$fileName=$path[1];
//echo $fileName;
//echo $user;
$dir=$user;
$ThisFileInfo = $getID3->analyze($dir.'/'.$fileName);
$len= @$ThisFileInfo['playtime_string'];
$split = explode(':', $len);
$seconds=(($split[0]*60)+$split[1]);
$input=$dir.'/'.$fileName;
$output=$dir.'/samples/'.$fileName;
if ($seconds>30)
{
	$start=$seconds/2;
	$end=$start+30;
	require_once './class.mp3.php';
	$mp3 = new mp3;
	$mp3->cut_mp3($input, $output, $start, $end, 'second', false);
	echo "success";
}
else 
{
	require_once './class.mp3.php';
	$mp3 = new mp3;
	$mp3->cut_mp3($input, $output, 0, -1, 'second', false);
	echo "success 2";
}

?>