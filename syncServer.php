<?php
session_start();
$user=$_SESSION['user'];
 if (!isset($_SESSION))
 {
 	header("/index.html");
 }
$id = $_GET['id'];
//$index=;
$action=$_GET['command'];
echo $id;
$connection = mysql_connect("localhost", "cloudbea_hiz1991", "19910728Aa")
or die('Could not connect: ' . mysql_error());
mysql_select_db("cloudbea_kura_users", $connection)
or die('Could not select database');
switch ($action) 
{
  case 'delete':
      $addingUser="DELETE FROM `cloudbea_kura_users`.`music` WHERE `music`.`id` = ".$id." AND `music`.`username`=".$user;
      mysql_query($addingUser) or die (' error'. mysql_error());
      if ($addingUser)
      {//echo "success";
          $addingUser2="DELETE FROM `cloudbea_kura_users`.`songsInPlaylists` WHERE `songsInPlaylists`.`songId` =".$_GET['index']." AND `songsInPlaylists`.`username`=".$user;
          mysql_query($addingUser2) or die (' error'. mysql_error());
          if ($addingUser2)
          {echo "success2";
              mysql_close();
          }
          else{
            echo mysql_error(); mysql_close();
              }
      }
      else{
        echo mysql_error(); mysql_close();
          }
      break;
  case 'addPs':
      $addingUser="INSERT INTO `cloudbea_kura_users`.`songsInPlaylists` (`id`, `playlistName`, `songId`, `username`) VALUES (NULL, '".$_GET['playlist']."', '".$id."', '".$user."')";
      mysql_query($addingUser) or die (' error'. mysql_error()); if ($addingUser) {echo "success2"; mysql_close();}  else{ echo mysql_error(); }
      break;
  case 'addNewPS':
      $addingUser="INSERT INTO `cloudbea_kura_users`.`playlists` (`name`, `username`, `id`) VALUES ('".$_GET['name']."', '".$user."', NULL)";
      mysql_query($addingUser) or die (' error'. mysql_error()); if ($addingUser) {echo "success2"; mysql_close();}  else{ echo mysql_error(); }
      break;
}

?>