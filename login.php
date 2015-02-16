<?php
session_start();
include 'db.php';
//-----------------------------------------------------------------------------
$username=mysql_real_escape_string($_POST['loginUsername']);
$password=mysql_real_escape_string($_POST['loginPassword']);
$json=mysql_real_escape_string($_POST['json']);
// $username=mysql_real_escape_string($_GET['loginUsername']);
// $password=mysql_real_escape_string($_GET['loginPassword']);
$correct=false;
$data = selectAllDB("userInfo");;
while($info = mysql_fetch_array( $data ))
{
  if (($info['username']==$username|| $info['email']==$username) && $info['password']==$password)
{
  $_SESSION['user']=$info['username'];
  $_SESSION['lang']=$info['lang'];
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
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=player.php">';
}
//echo $_SESSION['user'];
mysql_close();
?>