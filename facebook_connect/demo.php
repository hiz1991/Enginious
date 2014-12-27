<?php
$currentMenu[1] = 1;
include_once('include/webzone.php');
include_once('include/presentation/header.php');
?>

<div class="container">	
	<div class="row">
		
		<div class="span10">
			
			<?php
			
			$f1 = new Fb_ypbox();
			$f1->loadJsSDK();
			$f1->load_js_functions();
			
			$cookie = $f1->getCookie();
			
			if($cookie!='') {
				
				$user_data = $f1->getUserData();
				
				echo '<p>';
				echo '<img src="'.$user_data['picture'].'" width=36 style="padding-right:10px; vertical-align:middle;">';
				echo '<a href="#" id="fb_box_fb_logout_btn">Disconnect my Facebook account</a>';
				echo '</p>';
				
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
				echo '<h3>My Facebook friends <small>(limited to 24 in this example)</small></h3>';
				$fb_friends_display = $f1->displayUsersIcons(array('users'=>$fb_friends, 'nb_display'=>24));
				echo '<p style="width:420px;">'.$fb_friends_display.'</p>';
				
				//display user's pages or applications
				echo '<h3>My Facebook pages and/or applications</h3>';
				echo '<p>';
				$pages = $f1->getFacebookPages();
				for($i=0; $i<count($pages); $i++) {
					echo $pages[$i]['name'].' - ';
				}
				echo '</p>';
				
				//user's last status
				echo '<h3>My last Facebook status</h3>';
				echo '<p>';
				$f1 = new Fb_ypbox();
				$data = $f1->get_fb_api_results(array('object'=>$user_data['id'], 'connection'=>'posts'));
				for($i=0; $i<count($data['data']); $i++) {
					if($data['data'][$i]['message']!='') {
						$status = $data['data'][$i]['message'];
						$i=count($data['data']);
					}
				}
				echo $status.'<br>';
				echo '<small>'.$data['data'][0]['created_time'].'</small>';
				echo '</p>';
				
				//update status
				echo '<form method=get action="./connect.php">';
				echo '<h3><b>Update my Facebook status</b></h3>';
				echo '<p><textarea id="status" name="status" style="width:360px; height:60px;"></textarea></p>';
				echo '<p><input type="submit" value="Update status" class="btn"></p>';
				echo '</form>';
			}
			
			else {
				echo '<h3>Please click on the link bellow to connect with your Facebook account</h3>';
				echo '<p>';
				echo '<a href="#" id="fb_box_fb_login_btn">Facebook connect</a>';
				echo '</p>';
			}
			
			?>
			
		</div>
				
		<div class="span2" style="text-align:right;">
			
			<p>Some of our other apps</p>
			
			<a href="http://codecanyon.net/item/advanced-php-store-locator/244349?ref=yougapi" target="_blank"><img src="./include/graph/advanced-store-locator-mini.png" style="margin-bottom:10px;"></a>
			<a href="http://codecanyon.net/item/jquery-carousel-evolution-for-wordpress/702228?ref=yougapi" target="_blank"><img src="./include/graph/carousel-wpress-mini.png" style="margin-bottom:10px;"></a>
			&nbsp;<a href="http://codecanyon.net/item/domains-names-checker/3298128?ref=yougapi" target="_blank"><img src="./include/graph/domains-checker-mini.png" style="margin-bottom:10px;"></a>
			<a href="http://codecanyon.net/item/facebook-images-gallery/3281185?ref=yougapi" target="_blank"><img src="./include/graph/fb-gallery-mini.png" style="margin-bottom:10px;"></a>
			
			<br>
			
			<p>Featured mobile apps</p>
			<a href="http://codecanyon.net/item/mobile-site-builder/491023?ref=yougapi" target="_blank"><img src="./include/graph/mobile-builder-mini.png" style="margin-bottom:10px;"></a>
			<a href="http://codecanyon.net/item/mobile-store-locator/239351?ref=yougapi" target="_blank"><img src="./include/graph/mobile-store-locator-mini.png" style="margin-bottom:10px;"></a>
			
		</div>
		
	</div>
</div>

<?php
include_once('include/presentation/footer.php');
?>