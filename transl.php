<?php
session_start();
$user=$_SESSION['user'];
// include 'db.php';
function my_ucfirst($string, $e ='utf-8') 
{ 
    if (function_exists('mb_strtoupper') && function_exists('mb_substr') && !empty($string)) 
    { 
        // $string = mb_strtolower($string, $e); 
        $upper = mb_strtoupper($string, $e); 
        preg_match('#(.)#us', $upper, $matches); 
        $string = $matches[1] . mb_substr($string, 1, mb_strlen($string, $e), $e); 
    } 
    else
    { 
        $string = ucfirst($string); 
    } 
    return $string; 
} 
function my_lcfirst($string, $e ='utf-8') 
{ 
    if (function_exists('mb_strtolower') && function_exists('mb_substr') && !empty($string)) 
    { 
        // $string = mb_strtolower($string, $e); 
        $lower = mb_strtolower($string, $e); 
        preg_match('#(.)#us', $lower, $matches); 
        $string = $matches[1] . mb_substr($string, 1, mb_strlen($string, $e), $e);  
    } 
    else 
    { 
        $string = ucfirst($string); 
    } 
    return $string; 
} 
function starts_with_upper($str) 
{
    $chr = mb_substr ($str, 0, 1, "UTF-8");
    return mb_strtolower($chr, "UTF-8") != $chr;
}
function getTransBase($page)
{
	if($page)
	{
		$data = selectAllWithSpecificRowDB("langs", ["page", $page]);
	 	return $data;
	}
	else{
			$data = selectAllDB("langs");
	 		return $data;
	}

}
function trans($text, $received)
{
   $uppercase = starts_with_upper($text);
   mysql_data_seek($received, 0);
   $base=$received;
   $lang = $_SESSION['lang'];
   if(mysql_num_rows($base))
   {
	    while($row=mysql_fetch_array($base))
	    {
	            if($row['en']==$text)
	            {
	            	if(!$row[$lang][$i]==null)
	            	{
	            		return ($uppercase==1)?my_ucfirst($row[$lang]):my_lcfirst($row[$lang]);
	            	}
	            }
	    }
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
     return json_encode($rs, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
}

?>