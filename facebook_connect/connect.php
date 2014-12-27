<?php
include("include/webzone.php");

$status = $_GET['status'];

if($status!='') {
	$f1 = new Fb_ypbox();
	$cookie = $f1->getCookie();
	$f1->updateFacebookStatus(array('message'=>$status), $cookie['access_token']);
	echo '<b>Your status has been posted</b><br><a href="./">Click here to go back.</a>';
}

?>