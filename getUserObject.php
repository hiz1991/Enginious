<?php
function getUserObject($user, $returnType, $subObject)
{
	$playlists=array();
	$final=array();
	$ids=array();
	$data= selectAllDB('playlists',$user);
	while($info = mysql_fetch_array( $data ))
	{
		if(array_key_exists($info['name'], $playlists)==false)
			{
				$playlists[$info['name']]=array();
			}
	}

	$data = selectAllDB('music', $user, ["`music`.`id`", "DESC"]); //mysql_query("SELECT * FROM `music` WHERE `music`.`username`='".$user."'  ORDER BY `music`.`id` DESC;")
	while($info = mysql_fetch_array( $data ))
	{
	 //if (!in_array($info['id'], $ids))
	  //{
	  $ids[]=$info['id'];
	  $ur['url']=$info['url']; 
	  $ur['artist']=$info['artist']; 
		  $ur['title']=$info['title'];
		  $ur['genre']=$info['genre'];
		  $ur['wave']=$info['wave'];
		  $ur['id']=$info['id'];

		  $ur['tempo']=$info['tempo'];
		  $ur['volume']=$info['volume'];
		  $ur['pitch']=$info['pitch'];

		  $ur['urlOfArt']=$info['urlOfArt'];
		  array_push($final, $ur); 
		  //}        
	}
	$data =selectAllDB('songsInPlaylists', $user);////mysql_query("SELECT * FROM `songsInPlaylists` WHERE `songsInPlaylists`.`username`='".$user1."';")

	// or die('error '.mysql_error());
	while($info = mysql_fetch_array( $data ))
	{
	    if (!in_array($info['songId'], $playlists[$info['playlistName']]))
	    	{
	    		$playlists[$info['playlistName']][]=$info['songId'];
	    	}
	                   
	 }
	                     
	mysql_close();
	//$secondTime=microtime();// 
	if($returnType=="object"){
		return $final;//return object of songs
	}
	$playls=json_encode($playlists, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
	$songs='';
	$songs=json_encode($final, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
	// $songs=str_replace('\\u0000', "", $songs);
	// $playls=str_replace('\\u0000', "", $playls);
	//$str=explode("\u0000", $str);//gzencode
	return '{   "Songs":'.$songs.'  , "Playlists":['.$playls.'], "User":['.'{"user":"'.$user.'", "type":"'.$_SESSION['userType'].'", "lang":"'.$_SESSION['lang'].'", "email":"'.$_SESSION['email'].'", "bg":"'.$_SESSION['bg'].'"}'.']}';
}
?>