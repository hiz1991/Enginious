<?php
//-----------------------------------------------------------------------------
session_start();
require 'db.php';
$username=mysql_real_escape_string($_POST['username']);
$password=mysql_real_escape_string($_POST['password']);
$confirmEmail=mysql_real_escape_string($_POST['confirmEmail']);
$lang=mysql_real_escape_string($_POST['lang']);
$check = mysql_real_escape_string($_POST['check']);
$homeDirectory=$username;
//$lastSong=mysql_real_escape_string("");
$marker="0";
$accountType="internal";
$theme = 'images/bgs/bc-light.jpg';
$exist = false;

$data = selectAllDB('userInfo');
while($info = mysql_fetch_array( $data )){
	// error_log($info['email']);
	if ($info['username']==$username){
		$exist=true;
	}
}//while
if($check=="true"){
	if ($exist==true) {
		echo '{"Response":"exists"}';
	}
	else{
		echo '{"Response":"does not exist"}';
	}
	exit(0);
}
if ($exist==false){
	if ($username!=""&&$username!=""&&$password!=""&&$marker!=""){
		$dir=$homeDirectory;
		if (is_dir($dir)){
			echo '{"Response":"error"}';
			exit(0);
		}else{
		    mkdir($dir, 0755, true);
			mkdir('./'.$homeDirectory.'/artwork', 0755, true);
			mkdir('./'.$homeDirectory.'/artwork/thumb', 0755, true);
			mkdir('./'.$homeDirectory.'/samples', 0755, true);
			mkdir('./'.$homeDirectory.'/waveforms', 0755, true);
            recordInDB('userInfo', ['username', 'password', 'accountType', 'marker', 'theme', 'lang'], [$username, $password, $accountType, $marker, $theme, $lang], "");

			$_SESSION['user']=$username;
			$_SESSION['lang']=$lang;
			// if($info['accountType']=='facebook'){$_SESSION['userType']='Facebook';}
			$_SESSION['userType'] = $accountType;
			$_SESSION['bg'] = $theme;
			$_SESSION['email'] =$$username;

            echo "cool";

		}
	}
}//if1
else{
	echo '{"Response":"unchecked exists"}';
}
?>