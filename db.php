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
   // error_log("UPDATE `".$tableName."` SET ".$string." WHERE `username` = '".$user."';");
   $result = mysql_query("UPDATE `".$tableName."` SET ".$string." WHERE `username` = '".$user."';");
   return $result;
}
function selectAllDB($tableName='music', $user, $order)
{
   $return="default";
   if($order)//ORDER BY `music`.`id` DESC;
   {
      $return= mysql_query("SELECT * FROM `".$tableName."` WHERE `username`='".$user."' ORDER BY ".$order[0]." ".$order[1].";")
      or die('error At selectAllDB'.mysql_error());

   }
   else
   {

      $return =($user)?mysql_query("SELECT * FROM `".$tableName."` WHERE `username`='".$user."';"):mysql_query("SELECT * FROM `".$tableName."`;")
      or die('error At selectAllDB'.mysql_error());
   }   
   return $return;
}
function selectAllWithSpecificRowDB($tableName='music', $rowAndValueArray)
{
   $return="default";

   $return= mysql_query("SELECT * FROM `".$tableName."` WHERE `".$rowAndValueArray[0]."`='".$rowAndValueArray[1]."';")
   or die('error At selectAllDB'.mysql_error());
   return $return;
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
function deleteAllDB($tableName, $user)
{
   $return= mysql_query("DELETE FROM `".$tableName."` WHERE `username`='".$user."';")
      or die('error At deleteAllDB'.mysql_error());
   return $return;
}
function insertManyDB($tableName, $values, $type, $user)
{
  $keys =array_keys($values);
  $length = count($values);
  $str="";
  for ($i=0; $i < $length ; $i++) { 
     $str=$str."('".$user."', '".$keys[$i]."', ".$values[$keys[$i]].", '".$type."' ),";
  }
  // $str=$str."('".$user."', '".$values[$length]."', ".$length." )";
  $str = substr($str, 0, strlen($str)-1);
  // error_log($str);
   $return = mysql_query("INSERT INTO `".$tableName."` (`username`, `value`, `occurances`, `type`) VALUES ".$str.";")
   or die('error At insertManyDB'.mysql_error());
   return $return;
}
?>