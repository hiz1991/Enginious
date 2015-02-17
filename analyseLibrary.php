<?php
session_start();
$user=$_SESSION['user'];
include 'db.php';
include 'transl.php';
$bs=getTransBase();
//analyse volume
$musicData = selectAllDB("music", $user);
if(mysql_num_rows($musicData))
{
	// var_dump($row=mysql_fetch_array($musicData));
	$i=0;
	$sumVolume=0;
	$tempArrayVolume=[];
    while($row=mysql_fetch_array($musicData))
    {
        $sumVolume=$sumVolume+calculatePercentTo($row['volume'], 300000);
        $i++;
        array_push($tempArrayVolume, calculatePercentTo($row['volume'], 300000));
    	// echo calculatePercentTo($row['volume'], 30000);
    }
    $meanVolume =round($sumVolume/$i);
    // var_dump(calcDeviation($meanVolume,$tempArrayVolume));
    $toUpdate=['volume', 'volumeAccuracy'];
    $finalAccuracy=100-calculatePercentTo(calcDeviation($meanVolume,$tempArrayVolume), 25);
    $toUpdateValues=[$meanVolume, $finalAccuracy];
    // var_dump(updateDB('libraryAnalysis', $toUpdate, $toUpdateValues,$user));
    updateDB('libraryAnalysis', $toUpdate, $toUpdateValues,$user);
}

$result = selectAllDB('libraryAnalysis', $user);
function cn($value)//check if number
{
   if ($value == NULL) 
   {
   	return "null";
   }
   elseif ($value ==0)
   {
   	return '0';
   }
   else
   {
   	return $value;
   }
}
if(mysql_num_rows($result))
{
    $first = true;
    // $row=mysql_fetch_assoc($result);
    while($row=mysql_fetch_array($result))
    {
      echo '{
            	"Response":
            	{
            			"'.trans("volume", $bs).'":'.cn($row['volume']).',
            			"'.trans("tempo", $bs).'":'.cn($row['tempo']).',
            			"'.trans("genre", $bs).'": '.cn($row['genre']).',
            			"'.trans("year", $bs).'": '.cn($row['year']).',
            			"'.trans("pitch", $bs).'":'.cn($row['pitch']).',
            			"'.trans("rhythm", $bs).'": '.cn($row['rhythm']).',
            			"'.trans("popularity", $bs).'": '.cn($row['popularity']).',
            			"'.trans("distribution", $bs).'": '.cn($row['distribution']).',
            			"'.trans("volume confidence", $bs).'": '.cn($row['volumeAccuracy']).',
            			"'.trans("tempo confidence", $bs).'": '.cn($row['tempoAccuracy']).',
            			"'.trans("genre confidence", $bs).'": '.cn($row['genreAccuracy']).',
            			"'.trans("year confidence", $bs).'": '.cn($row['yearAccuracy']).',
            			"'.trans("pitch confidence", $bs).'": '.cn($row['pitchAccuracy']).',
            			"'.trans("rhythm confidence", $bs).'": '.cn($row['rhythmAccuracy']).',
            			"'.trans("popularity confidence", $bs).'": '.cn($row['popularityAccuracy']).',
            			"'.trans("distribution confidence", $bs).'": '.cn($row['distributionAccuracy']).'
            	}
            }';       
    }
} 
else 
{
    echo '[]';
}

mysql_close($db);

function calculatePercentTo($givenValue, $maxValue)
{
	return round($givenValue*100/$maxValue);
}
function calcDeviation($meanReceived, $arrayReceived)
{
  $sumDistance=0;
  for ($x=0; $x <count($arrayReceived) ; $x++)
  { 
     $sumDistance=$sumDistance+abs($arrayReceived[$x]-$meanReceived); 
  }
  return round($sumDistance/count($arrayReceived));
}
?>