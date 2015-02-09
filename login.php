<?php
session_start();
//-----------------------------------------------------------------------------
//$connection = mysql_connect("mysql6.000webhost.com", "a8787988_cloud", "beats95")
//    or die('Could not connect: ' . mysql_error());
//mysql_select_db("a8787988_users", $connection)
//    or die('Could not select database'. mysql_error());
//-----------------------------------------------------------------------------
$connection = mysql_connect("localhost", "root", "19910728Aa")
    or die('Could not connect: ' . mysql_error());
mysql_select_db("kura_users", $connection)
    or die('Could not select database');
//-----------------------------------------------------------------------------
$username=mysql_real_escape_string($_POST['loginUsername']);
$password=mysql_real_escape_string($_POST['loginPassword']);
$json=mysql_real_escape_string($_POST['json']);
// $username=mysql_real_escape_string($_GET['loginUsername']);
// $password=mysql_real_escape_string($_GET['loginPassword']);
$correct=false;
// echo $username;
//$tableName=substr($username, 0, 3);

//$email=$_POST['email'];
//-----------------------------------------------------------------------------
//$data = mysql_query("SELECT * FROM ".$tableName."")
$data = mysql_query("SELECT * FROM userInfo")
or die('error '.mysql_error());
//$info = mysql_fetch_array($data);
while($info = mysql_fetch_array( $data ))
{
  if (($info['username']==$username|| $info['email']==$username) && $info['password']==$password)
{
  $_SESSION['user']=$info['username'];
  // if($info['accountType']=='facebook'){$_SESSION['userType']='Facebook';}
  $_SESSION['userType'] = $info['accountType'];
  $_SESSION['bg'] = $info['theme'];
  // echo 'success';
  $correct=true;
}
}
if ($correct==false)
{
  if($json=="enabled")
  {
    echo '{"Response":{"status":"fail"}}';
  }
  else echo 'fail';
  /*echo '<META HTTP-EQUIV="Refresh" Content="1; URL=/">';*/
}
if($json=="enabled" && $correct)
{
  echo '{"Response":{"status":"success"}}';
}
else if ($correct)
{
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=player.html">';
}
//echo $_SESSION['user'];
mysql_close();
?>