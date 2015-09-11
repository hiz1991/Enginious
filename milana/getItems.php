<?php
error_reporting(E_ERROR | E_PARSE);
include 'db.php';
$selectAll = selectAllDB("items");
echo parseAsObject($selectAll);
function parseAsObject($bs)
{
 mysql_data_seek($bs, 0);
 $final=array();
 $names = array();
 $urls = array();
 $prices = array();
 $descriptions = array();
 $widths = array();
 $heights = array();

	while($info = mysql_fetch_array( $bs ))
	{
	  array_push($names, $info['name']);
	  array_push($urls, $info['imageUrl']);
	  array_push($prices, $info['price']); 
	  array_push($descriptions, $info['description']); 
	  array_push($widths, $info['imgWidth']);  
	  array_push($heights, $info['imgHeight']);    
	}
	  array_push($final, $names);
	  array_push($final, $urls);
	  array_push($final, $prices); 
	  array_push($final, $descriptions);
	  array_push($final, $widths);
	  array_push($final, $heights);
     return json_encode($final, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
}
?>