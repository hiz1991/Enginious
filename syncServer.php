<?php
session_start();
// echo "arg1";
$user=$_SESSION['user'];
//  if (!isset($_SESSION))
//  {
//  	header("index.php");
//  }
if($_GET['id']) 
  $id = $_GET['id'];
$argument;
if($_GET['argument']) 
{
  $argument = $_GET['argument'];
}
//$index=;
$action=$_GET['command'];

// echo $id;
include("db.php");
switch ($action) 
{
  case 'delete':
      // $addingUser="DELETE FROM `music` WHERE `music`.`id` = ".$id." AND `music`.`username`=".$user;
      // mysql_query($addingUser) or die (' error'. mysql_error());
      // if ($addingUser)
      // {//echo "success";
      //     $addingUser2="DELETE FROM `songsInPlaylists` WHERE `songsInPlaylists`.`songId` =".$_GET['index']." AND `songsInPlaylists`.`username`=".$user;
      //     mysql_query($addingUser2) or die (' error'. mysql_error());
      //     if ($addingUser2)
      //     {echo "success2";
      //         mysql_close();
      //     }
      //     else{
      //       echo mysql_error(); mysql_close();
      //         }
      // }
      // else{
      //   echo mysql_error(); mysql_close();
      //     }
      break;
  case 'addPs':
      // $addingUser="INSERT INTO `songsInPlaylists` (`id`, `playlistName`, `songId`, `username`) VALUES (NULL, '".$_GET['playlist']."', '".$id."', '".$user."')";
      // mysql_query($addingUser) or die (' error'. mysql_error()); if ($addingUser) {echo "success2"; mysql_close();}  else{ echo mysql_error(); }
      break;
  case 'addNewPS':
      // $addingUser="INSERT INTO `playlists` (`name`, `username`, `id`) VALUES ('".$_GET['name']."', '".$user."', NULL)";
      // mysql_query($addingUser) or die (' error'. mysql_error()); if ($addingUser) {echo "success2"; mysql_close();}  else{ echo mysql_error(); }
      break;
  case 'fetchBgs':
      // echo "arg1";
      $bgsdir = 'images/bgs';
      $arr=[];
      // array_push($arr, "entry");
      if ($handle = opendir($bgsdir)) 
      {
          while (false !== ($entry = readdir($handle))) {
              // echo "$entry\n";
            if (preg_match('#^\.#', $entry) === 0) {
               array_push($arr, $bgsdir.'/'.$entry);
            }
          }
          closedir($handle);
      }
      echo json_encode($arr);
      // var_dump($arr);
      break;
  case 'saveBg':
      $value = $argument;
      $tmparrWheretoSave = [];
      $tmparrWhat = [];
      array_push($tmparrWheretoSave, "theme");
      array_push($tmparrWhat, $value);
      $saveBgquery = updateDB($tableName='userInfo', $tmparrWheretoSave, $tmparrWhat, $user);
      mysql_query($saveBgquery); //or die (' error'. mysql_error());
      if($saveBgquery){$_SESSION['bg']=$value;}
      mysql_close();
      echo $_SESSION['bg'];
      break;
}

?>