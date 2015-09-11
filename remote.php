<?php
session_start();
$user=$_SESSION['user'];
include("db.php");
if(!$user)
{
  echo '{"Response":{"error":"Not logged in"}}';
  exit(0);
}
if($_GET['set']!=null)
{
$get=$_GET['set'];
 $sql = "UPDATE `userInfo` SET `remoteAction`='";
	        $sql.= $get."'";
	        $sql.= " WHERE `username`='";
	        $sql.= $user."';";
mysql_query($sql) or die (' error'. mysql_error());
mysql_close();
}
else
{
  	$data = mysql_query("SELECT username,remoteAction FROM userInfo")
	or die('error '.mysql_error());
	while($info = mysql_fetch_array( $data ))
	{
        if ($info['username']==$user)
		{
			echo $info['remoteAction'];
		}
	}
mysql_close();
}
//echo "user=$user";
//$user='kura';
//echo "user=$user&account=$account";
?>