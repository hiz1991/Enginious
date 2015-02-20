<?php
session_start();
$user=$_SESSION['user'];
include 'db.php';
include 'transl.php';
  // $firstTime=microtime();
$bs=getTransBase();
//analyse volume
$musicData = selectAllDB("music", $user);
// error_log(getAccuracy($musicData, 'volume', 'volumeAccuracy', 300000)[1]);
$toUpdate=[];
$toUpdateValues=[];
$parametres = ['name'=>['volume','pitch','tempo'], 'maxValues'=>[300000, 10000, 200]];
for ($i=0; $i < count($parametres['name']); $i++) { 
  array_push($toUpdate, $parametres['name'][$i], $parametres['name'][$i].'Accuracy');
  $tempArrayForPushing=getAccuracy($musicData, $parametres['name'][$i], $parametres['name'][$i].'Accuracy', $parametres['maxValues'][$i]);
  array_push($toUpdateValues, $tempArrayForPushing[0], $tempArrayForPushing[1]);
}
$artistPriority=getArtistPriority($musicData, "artist", ["Unknown Artist"]);
deleteAllDB('priority', $user);
insertManyDB('priority', $artistPriority, 'artist', $user);

$genrePriority=getArtistPriority($musicData, "genre", ["Other", "None", ""]);
insertManyDB('priority', $genrePriority, 'genre', $user);

$yearsInDecades = getYearsInDecades($musicData, [0]);
insertManyDB('priority', $yearsInDecades, 'year', $user);
//get and record avergaed distr levels
$averageDistr = convertDistArrayToString(getAverageDistrib($musicData, 50, 2));
array_push($toUpdate, "distribution");
array_push($toUpdateValues, $averageDistr);
//get and record avergaed distr levels
updateDB('libraryAnalysis', $toUpdate, $toUpdateValues,$user);

$result = selectAllDB('libraryAnalysis', $user);
if(mysql_num_rows($result))
{
    $first = true;
    // $row=mysql_fetch_assoc($result);
    while($row=mysql_fetch_array($result))
    {
      // echo '{
      //       	"Response":
      //       	{
      //       			"'.trans("volume", $bs).'":'.cn($row['volume']).',
      //       			"'.trans("tempo", $bs).'":'.cn($row['tempo']).',
      //       			"'.trans("genre", $bs).'": '.cn($row['genre']).',
      //       			"'.trans("year", $bs).'": '.cn($row['year']).',
      //       			"'.trans("pitch", $bs).'":'.cn($row['pitch']).',
      //       			"'.trans("rhythm", $bs).'": '.cn($row['rhythm']).',
      //       			"'.trans("popularity", $bs).'": '.cn($row['popularity']).',
      //       			"'.trans("distribution", $bs).'": '.cn($row['distribution']).',
      //       			"'.trans("volume importance", $bs).'": '.cn($row['volumeAccuracy']).',
      //       			"'.trans("tempo importance", $bs).'": '.cn($row['tempoAccuracy']).',
      //       			"'.trans("genre importance", $bs).'": '.cn($row['genreAccuracy']).',
      //       			"'.trans("year importance", $bs).'": '.cn($row['yearAccuracy']).',
      //       			"'.trans("pitch importance", $bs).'": '.cn($row['pitchAccuracy']).',
      //       			"'.trans("rhythm importance", $bs).'": '.cn($row['rhythmAccuracy']).',
      //       			"'.trans("popularity importance", $bs).'": '.cn($row['popularityAccuracy']).',
      //       			"'.trans("distribution importance", $bs).'": '.cn($row['distributionAccuracy']).'
      //       	}
      //       }';       
    }
} 
else 
{
    echo '[]';
}

// error_log(microtime() - $firstTime);
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
function convertDistArrayToString($averageDistr)
{
  $avDistrToString="";
  for ($i=0; $i <count($averageDistr) ; $i++) { 
    if($averageDistr[$i]<10)
    {
      $avDistrToString.='0'.$averageDistr[$i];
    }
    else
    {
      $avDistrToString.=$averageDistr[$i];
    }
  }
  return $avDistrToString;
}
function convertToDecades($number)
{
   // echo(floor($number/10)*10);
   return (floor($number/10)*10)."";
}
function getMeanForArrayRounded($array)
{
  $sum =0;
  for ($i=0; $i <count($array) ; $i++) { 
    $sum+=$array[$i];
  }
  return round($sum/count($array));
}
function getAccuracy($musicData, $criterion, $critAccuracy, $topValue)
{
  mysql_data_seek($musicData, 0);
  if(mysql_num_rows($musicData))
  {
    // var_dump($row=mysql_fetch_array($musicData));
    $i=0;
    $sumVolume=0;
    $tempArrayVolume=[];
      while($row=mysql_fetch_array($musicData))
      {
          $sumVolume=$sumVolume+calculatePercentTo($row[$criterion], $topValue);
          $i++;
          array_push($tempArrayVolume, calculatePercentTo($row[$criterion], $topValue));
        // echo calculatePercentTo($row['volume'], 30000);
      }
      $meanVolume =round($sumVolume/$i);
      // var_dump(calcDeviation($meanVolume,$tempArrayVolume));
      $finalAccuracy=100-calculatePercentTo(calcDeviation($meanVolume,$tempArrayVolume), 25);
      // var_dump(updateDB('libraryAnalysis', $toUpdate, $toUpdateValues,$user));
      // updateDB('libraryAnalysis', $toUpdate, $toUpdateValues,$user);
      return [$meanVolume, $finalAccuracy];
  }
}
function getArtistPriority($musicData, $criterion, $ignoreArray)
{
  //TODO: need to remove Unknown artist
  mysql_data_seek($musicData, 0);
  $resultPriority=[];
  $result=[];
  if(mysql_num_rows($musicData))
  {
      while($row=mysql_fetch_array($musicData))
      {
          if(!in_array($row[$criterion], $ignoreArray))
          {
            array_push($resultPriority, $row[$criterion]);
          } 
      }
      // $result = array_count_values(explode(',', $resultPriority));
      $result = array_count_values($resultPriority);
      arsort($result);
  }
  return $result;
}
function getYearsInDecades($musicData, $ignoreArray)
{
  $years=[];
  mysql_data_seek($musicData, 0);
  $result=[];
  if(mysql_num_rows($musicData))
  {
      while($row=mysql_fetch_array($musicData))
      {
          if(!in_array($row['year'], $ignoreArray))
          {
            array_push($years, convertToDecades($row['year']));
          } 
      }
      // $result = array_count_values(explode(',', $resultPriority));
      $result = array_count_values($years);
      arsort($result);
  }
  return $result;
}
function getAverageDistrib($musicData, $length=50, $step=2)
{
  $levels=[];
  $result=[];
  for ($i=0; $i < $length; $i++) { 
    $levels[$i] = array();
  }
  mysql_data_seek($musicData, 0);
  if(mysql_num_rows($musicData))
  {
      while($row=mysql_fetch_array($musicData))
      {
            for ($i=0; $i <($length*$step); $i+=$step) { 
              array_push($levels[$i/$step], substr($row['wave'], $i, 2));
            }
      }
      for ($i=0; $i <$length ; $i++) { 
        $result[$i]=getMeanForArrayRounded($levels[$i]);
      }
  }
  // var_dump($levels[49]);
  return $result;//['mean', 'mean', '...'](50)
}
mysql_close($db);
?>