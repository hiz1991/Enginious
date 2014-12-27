<?php
include('include/webzone.php');

echo '<html><head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
</head><body>';

$f1 = new Fb_ypbox();
$f1->loadJsSDK();
$f1->load_js_functions();
$f1->getUserData();
$cookie = $f1->getCookie();

if($cookie!='') {
	
	$user_data = $f1->getUserData();
	
	echo '<p>';
	echo '<img src="'.$user_data['picture'].'" width=36 style="padding-right:10px; vertical-align:middle;">';
	echo '<a href="#" id="fb_box_fb_logout_btn">Disconnect my Facebook account</a>';
	echo '</p>';
	
	echo '<br>';
	
	//display user's information
	echo '<h3>My Facebook information</h3>';
	echo '<p>';
	echo '<b>My name</b>: '.$user_data['name'].'<br>';
	echo '<b>My email</b>: '.$user_data['email'].'<br>';
	echo '<b>My profile URL</b>: <a href="'.$user_data['link'].'" target="_blank">'.$user_data['link'].'</a><br>';
	echo '<b>My Access token</b>: <input type="text" value="'.$cookie['access_token'].'" style="width:340px;"><br>';
	echo '<b>My token expiration</b>: '.$cookie['expires'].'<br>';
	echo '<b>My Facebook id</b>: '.$user_data['id'];
	echo '</p>';
	
	//display user's friends
	$fb_friends = $f1->getFacebookFriends();
	$fb_friends_display = $f1->displayUsersIcons(array('users'=>$fb_friends, 'nb_display'=>0));
	echo $fb_friends_display.'<br><br>';
	

	
}

else {
	echo '<h3>Please click on the link bellow to connect with your Facebook account</h3>';
	echo '<p>';
	echo '<a href="#" id="fb_box_fb_login_btn">Facebook connect</a>';
	echo '</p>';
}

echo '</body></html>';
?>