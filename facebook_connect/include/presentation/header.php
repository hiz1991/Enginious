<!DOCTYPE html>
<head>

<title>Facebook connect and API integration</title> 

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta charset="UTF-8" />

<!-- Include CSS files -->
<link rel="stylesheet" href="include/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="include/css/bootstrap-responsive.min.css" type="text/css">
<link rel="stylesheet" href="include/css/style.css" type="text/css">

<!-- Include JS files -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<script> 
jQuery(document).ready(function() {
	<?php
	echo $jsOnReady;
	?>
})
</script>

</head>

<body>

<div class="container"> 
	<br>
	<a href="http://codecanyon.net/item/facebook-connect-api-integration/143902?ref=yougapi"><img src="include/graph/facebook-connect-mini.png" style="float:left; margin-right:20px;"></a>
	<h1 style="margin-bottom:5px;">Facebook connect and API integration</h1>
	<span style="color: #666;"><a href="http://codecanyon.net/item/facebook-connect-api-integration/143902?ref=yougapi">Download this app</a> (last update: Dec 2012)</span>
	<hr>
	<div id="topMenu">
		<ul>
			<?php
			if($currentMenu[0]==1) echo '<li><a href="./" class="current">Presentation</a></li>';
			else echo '<li><a href="./">Presentation</a></li>';
			if($currentMenu[1]==1) echo '<li><a href="./demo.php" class="current">Demo</a></li>';
			else echo '<li><a href="./demo.php">Demo</a></li>';
			echo '<li><a href="./demo2.php">Minimal styled demo</a></li>';
			echo '<li><a href="http://codecanyon.net/user/yougapi/portfolio?ref=yougapi">Our other apps</a></li>';
			?>
		</ul>
		
	</div>
	
	<hr>
</div>