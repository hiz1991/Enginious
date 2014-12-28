<?php
$connection = mysql_connect("localhost", "root", "19910728Aa")
    or die('Could not connect: ' . mysql_error());
mysql_select_db("kura_users", $connection)
    or die('Could not select database');
mysql_set_charset('utf8',$connection);
function updateDB($tableName='music', $toUpdateArray, $toUpdateValuesArray, $user)
{//echo $user;
   $string="`".$toUpdateArray[0]."` = '".$toUpdateValuesArray[0]."'";
   for ($y=1; $y <count($toUpdateArray) ; $y++) 
   { 
   	$string=$string.' , '."`".$toUpdateArray[$y]."` = '".$toUpdateValuesArray[$y]."'";
   }
   // echo $string;
   $result = mysql_query("UPDATE `".$tableName."` SET ".$string." WHERE `username` = '".$user."';");
   return $result;
}
function selectAllDB($tableName='music', $user)
{
   return mysql_query("SELECT * FROM `".$tableName."` WHERE `username`=".$user.";");
}
function recordInDB($tableName='music', $toRecordArray, $toRecordValuesArray, $user)
{
   $entries=$toRecordArray[0];
   $values = "'".mysql_real_escape_string($toRecordValuesArray[0])."'";
   for ($y=1; $y <count($toRecordArray) ; $y++) 
   {
   	  $entries=$entries.', '.$toRecordArray[$y];
   	  $values=$values.', '."'".mysql_real_escape_string($toRecordValuesArray[$y])."'";
   }
   //error_log("INSERT INTO ".$tableName."(".$entries.")  VALUES(".$values.")");
   $result = mysql_query("INSERT INTO ".$tableName."(".$entries.")  VALUES(".$values.");"); //error_log($result);
   return $result;
   // error_log($result);
   //$addingUser="INSERT INTO music(url, artist, title, urlOfArt, genre, year, username, wave, volume) VALUES('". mysql_real_escape_string($filename) ."', '". mysql_real_escape_string($mp3file->artist) ."', '". mysql_real_escape_string($mp3file->title) ."', '". mysql_real_escape_string($img) ."' ,'". mysql_real_escape_string($mp3file->genre) ."','". mysql_real_escape_string($mp3file->year) ."', '". mysql_real_escape_string($user) ."', '". mysql_real_escape_string($file)."', '".mysql_real_escape_string($averageVolume)."')";
}
?>