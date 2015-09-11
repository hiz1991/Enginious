<?php
include 'db.php';
$name = $_POST['name'];
$description = $_POST['description'];
$imgUrl = $_POST['imageUrl'];
$price = $_POST['price'];
$size = getimagesize($imgUrl);
// error_log($name."  ".$description."  ". $imgUrl );
$res = recordInDB("items", ["name", "description", "imageUrl", "price", "imgWidth", "imgHeight"],
	[$name, $description, $imgUrl, $price, $size[0], $size[1]]);
if($res) echo "success";
else echo "failure";
?>