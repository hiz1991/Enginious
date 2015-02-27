<?php
session_start();
$user=$_SESSION['user'];
include 'db.php';
include 'transl.php';
  // $firstTime=microtime();
$bs=getTransBase();
if(!$user)
{
  echo '{"Response":{"error":"Not logged in"}}';
  exit(0);
}
//analyse volume
$storeMusic = selectAllDB('music', 'store');
$fetchedObject = array();
while($fetchedObject[] = mysql_fetch_object($storeMusic)) {
    // you don´t really need to do anything here.
}
$userData = json_decode(file_get_contents($user.'/library.txt'));
$result;
$result['userData']=$userData;
$result['storeData'] = $fetchedObject;
file_put_contents($user.'/analysis.txt', json_encode($result));


function calcDeviationInPercent($meanValue, $arrayReceived, $assoc)
{
  $localMean;
  $localSum;
  $nonAssocArray = [];
  $keys=array_keys($arrayReceived);
  if($meanValue==null)
  {
    if($assoc){
       for ($i=0; $i <count($arrayReceived) ; $i++) { 
       $localSum+=$arrayReceived[$keys[$i]];
       array_push($nonAssocArray, $arrayReceived[$keys[$i]]);
       }
       //replace assoc array with non assoc array
       // var_dump($nonAssocArray);
       $arrayReceived = $nonAssocArray;
    }
    $meanValue = $localSum/count($arrayReceived);
    // echo $meanValue;
  }
  return  100-calculatePercentTo(calcDeviation($meanValue,$arrayReceived), 25);
}
function calculatePercentTo($givenValue, $maxValue)
{
  return $givenValue*100/$maxValue;
}
function calcDeviation($meanReceived, $arrayReceived)
{
  $sumDistance=0;
  for ($x=0; $x <count($arrayReceived) ; $x++)
  { 
   $sumDistance=$sumDistance+abs($arrayReceived[$x]-$meanReceived); 
 }
 return $sumDistance/count($arrayReceived);
}
function ratioInPercent($value)//check if number
{
  return 100 - $value*100;
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
    $sum=0;
    $tempArray=[];
    while($row=mysql_fetch_array($musicData))
    {
      $sum=$sum+calculatePercentTo($row[$criterion], $topValue);
      $i++;
      array_push($tempArray, calculatePercentTo($row[$criterion], $topValue));
        // echo calculatePercentTo($row['volume'], 30000);
    }
    $meanValue =$sum/$i;
      // var_dump(calcDeviation($meanValue,$tempArray));
    $finalAccuracy=calcDeviationInPercent($meanValue, $tempArray);//100-calculatePercentTo(calcDeviation($meanValue,$tempArray), 25);
      // var_dump(updateDB('libraryAnalysis', $toUpdate, $toUpdateValues,$user));
      // updateDB('libraryAnalysis', $toUpdate, $toUpdateValues,$user);
    return [$meanValue, $finalAccuracy];
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