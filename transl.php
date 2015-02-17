<?php
session_start();
$user=$_SESSION['user'];
// include 'db.php';
function getTransBase()
{
	 $data = selectAllDB("langs");
	 return $data;
}
function trans($text, $received)
{
   mysql_data_seek($received, 0);
   $base=$received;
   $lang = $_SESSION['lang'];
   if(mysql_num_rows($base))
   {
	    // echo '{"testData":{';

	    // $first = true;
	    // $row=mysql_fetch_assoc($result);
   	    // error_log($text);
	    while($row=mysql_fetch_array($base))
	    {
	    	error_log($row['en']); 
	    	error_log($text);
	    	// error_log($text);
            // for ($i=0; $i <count($row['en']) ; $i++) 
            // { 
	            if($row['en']==$text)
	            {
	            		    	// error_log("$");
		    	// error_log($text);
	            	if(!$row[$lang][$i]==null)
	            	{
	            		// error_log($_SESSION['lang']);
	            		return $row[$lang];
	            	}
	            }
	        // }
	    }
	    // error_log("-----------");
   }
	return $text;
}
function getTransJson($bs)
{
	mysql_data_seek($bs, 0);
 $rs = array();
 while($rs[] = mysql_fetch_object($bs)) {
    // you don´t really need to do anything here.
  }
     return json_encode($rs);
}















?>