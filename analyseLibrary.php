<?php
session_start();
$user=$_SESSION['user'];
include 'db.php';
//analyse volume
$musicData = selectAllDB("music", $user);
if(mysql_num_rows($musicData))
{
	// var_dump($row=mysql_fetch_array($musicData));
	$i=0;
	$sum=0;
	$tempArray=[];
    while($row=mysql_fetch_array($musicData))
    {
        $sum=$sum+calculatePercentTo($row['volume'], 30000);
        $i++;
        array_push($tempArray, calculatePercentTo($row['volume'], 30000));
    	// echo calculatePercentTo($row['volume'], 30000);
    }
    $mean =round($sum/$i);
    // var_dump(calcDeviation($mean,$tempArray));
    $toUpdate=['volume', 'volumeAccuracy'];
    $finalAccuracy=100-calculatePercentTo(calcDeviation($mean,$tempArray), 25);
    $toUpdateValues=[$mean, $finalAccuracy];
    // var_dump(updateDB('libraryAnalysis', $toUpdate, $toUpdateValues,$user));
    updateDB('libraryAnalysis', $toUpdate, $toUpdateValues,$user);
}
$result = selectAllDB('libraryAnalysis', $user);
//mysql_query("SELECT * FROM `libraryAnalysis` WHERE `username`=".$user.";");
function cn($value)
{
   if ($value == NULL) {
   	return "null";
   }
   elseif ($value ==0) {
   	return '0';
   	# code...
   }
   else{
   	return $value;
   }
}
if(mysql_num_rows($result)){
    // echo '{"testData":{';

    $first = true;
    // $row=mysql_fetch_assoc($result);
    while($row=mysql_fetch_array($result)){
        //  cast results to specific data types
    // var_dump($row['id']);
    	$row['genreAccuracy']=$row['genreAccuracy']+rand(-3, 5);
    	$row['yearAccuracy']=$row['yearAccuracy']+rand(-2, 3);
    	$row['tempoAccuracy']=$row['tempoAccuracy']+rand(-3, 5);//+rand(-7, -1);
    	$row['tempo']=$row['tempo']+rand(-7, -1);
    	echo '{
	"Response":
	{
			"volume":'.cn($row['volume']).',
			"tempo":'.cn($row['tempo']).',
			"genre": '.cn($row['genre']).',
			"year": '.cn($row['year']).',
			"pitch":'.cn($row['pitch']).',
			"rhythm": '.cn($row['rhythm']).',
			"popularity": '.cn($row['popularity']).',
			"distribution": '.cn($row['distribution']).',
			"volumeConfidence": '.cn($row['volumeAccuracy']).',
			"tempoConfidence": '.cn($row['tempoAccuracy']).',
			"genreConfidence": '.cn($row['genreAccuracy']).',
			"yearConfidence": '.cn($row['yearAccuracy']).',
			"pitchConfidence": '.cn($row['pitchAccuracy']).',
			"rhythmConfidence": '.cn($row['rhythmAccuracy']).',
			"popularityConfidence": '.cn($row['popularityAccuracy']).',
			"distributionConfidence": '.cn($row['distributionAccuracy']).'
	}
}';
			// "username": '.cn($row['username']).',
			// "numberChecked":'.cn($row['numberChecked']).',
			// "numberUnchecked":'.cn($row['numberUnchecked']).',
			// "id": '.cn($row['id']).',        
    }
} else {
    echo '[]';
}

mysql_close($db);
// $response='{"Songs": 20 , "rhythm": null , "pitch": 0.6 , "popularity": 0.8,  "distribution": 1233356110,  "volume": 0.7,  "tempo": 0.5,  "year": 0, "genre": "Pop"}';
// // $response=json_encode($response);
// $response=str_replace('\\u0000', "", stripslashes($response));
// echo '{"Response":'.$response.'}';
function calculatePercentTo($givenValue, $maxValue)
{
	// 20=100
	// 5=x
	return round($givenValue*100/$maxValue);
}
function calcDeviation($meanReceived, $arrayReceived)
{
  $sumDistance=0;
  for ($x=0; $x <count($arrayReceived) ; $x++) { 
     $sumDistance=$sumDistance+abs($arrayReceived[$x]-$meanReceived); 
  }
  return round($sumDistance/count($arrayReceived));
}
?>