<?php
session_start();
$user=$_SESSION['user'];
  $firstTime=round(microtime(true) * 1000);
include 'db.php';
include 'transl.php';
include("getUserObject.php");

$bs=getTransBase();
if(!$user)
{
  echo '{"Response":{"error":"Not logged in"}}';
  exit(0);
}
//get store songs
$storeMusic = selectAllDB('music', 'store');
$storeFiles=array();
while($row = mysql_fetch_array($storeMusic)) {
  $song=null;
  $song->artist=$row['artist'];
  $song->wave=$row['wave'];
  $song->year=$row['year'];
  $song->genre=$row['genre'];
  $song->title=$row['title'];
  $song->id=$row['id'];
  $song->tempo=$row['tempo'];
  $song->volume=$row['volume'];
  $song->pitch=$row['pitch'];
  $song->url=$row['url'];
  $song->urlOfArt=$row['urlOfArt'];
  array_push($storeFiles, $song);
}
$userData = selectAllDB('libraryAnalysis', $user);
$libraryResults = array();
while($libraryResults[] = mysql_fetch_object($userData)) {
}

$artistPriority = array();
$artistPriority['values']=array();
$artistPriority['occurances']=array();
$yearPriority = array();
$yearPriority['values']=array();
$yearPriority['occurances']=array();
$genrePriority = array();
$genrePriority['values']=array();
$genrePriority['occurances']=array();

$priorityRequest = selectAllDB('priority', $user);
if(mysql_num_rows($priorityRequest)){
  while($row = mysql_fetch_array($priorityRequest)) {
    if ($row['type']=='artist') {
      array_push($artistPriority['values'], $row['value'] );
      array_push($artistPriority['occurances'], $row['occurances'] );
    } elseif ($row['type']=='genre') {
      array_push($genrePriority['values'], $row['value'] );
      array_push($genrePriority['occurances'], $row['occurances'] );
    } elseif ($row['type']=='year') {
      array_push($yearPriority['values'], $row['value'] );
      array_push($yearPriority['occurances'], $row['occurances'] );
    }
  }
}
// $indicesOfStoreFilesToDelete=array();
$userSongs =  getUserObject($user, 'object', 'songs');//[0]['id'];
//get rid of songs that a user already has
$stripedStoreFiles=array();
for ($i=0; $i < count($storeFiles); $i++) { 
  // echo $storeFiles[$i]->title.'<br><br>';
  $found=false;
  for ($x=0; $x < count($userSongs); $x++) { 
       if($userSongs[$x]['title']==$storeFiles[$i]->title && $userSongs[$x]['artist']==$storeFiles[$i]->artist){
        $found=true;
       }
  }
  if(!$found){
    array_push($stripedStoreFiles, $storeFiles[$i]);
  }
}
// var_dump($indicesOfStoreFilesToDelete);
// for ($i=0; $i < count($stripedStoreFiles); $i++) { 
//   echo $stripedStoreFiles[$i]->title.'<br><br>';
// }

//Done $stripedStoreFiles has music files not present in a users lib


// ========================================================

$libraryResults = $libraryResults[0];
$tempo = $libraryResults->tempo;
$volume = $libraryResults->volume;
$pitch = $libraryResults->pitch;
$artist = $libraryResults->artistAccuracy;
$genre = $libraryResults->genreAccuracy;
$year = $libraryResults->yearAccuracy;
$distribution = $libraryResults->distribution;
$distributionAccuracy = $libraryResults->distributionAccuracy;
$itemRelevanceArray = array();

$isTempoOn = false;
$isVolumeOn = false;
$isPitchOn = false;
$diffTempo = 0;
$diffVolume = 0;
$diffPitch = 0;
$criteriaValueTempo = 0;
$criteriaValueVolume = 0;
$criteriaValuePitch = 0;

$isArtistOn = false;
$isGenreOn = false;
$isYearOn = false;
$diffArtist = 0;
$diffGenre = 0;
$diffYear = 0;
$criteriaValueArtist = 0;
$criteriaValueGenre = 0;
$criteriaValueYear = 0;

$isDistributionOn = false;
$diffDistribution = 0;
$criteriaValueDistribution = 0;

// check for security later
$params = $_GET['options'];
$optioins = explode(",", $params);
for ($i=0; $i < count($optioins); $i++) { 
  if ($optioins[$i]=='tempo') {
    $isTempoOn = true;
  }
  elseif ($optioins[$i]=='volume') {
    $isVolumeOn = true;
  }
  elseif ($optioins[$i]=='pitch') {
    $isPitchOn = true;
  }
  elseif ($optioins[$i]=='artist') {
    $isArtistOn = true;
  }
  elseif ($optioins[$i]=='genre') {
    $isGenreOn = true;
  }
  elseif ($optioins[$i]=='year') {
    $isYearOn = true;
  }
  elseif ($optioins[$i]=='distribution') {
    $isDistributionOn = true;
  } else {
    $isTempoOn = true;
    $isVolumeOn = true;
    $isPitchOn = true;
    $isArtistOn = true;
    $isGenreOn = true;
    $isYearOn = true;
    $isDistributionOn = true;
  }
}

$sumOfAccuracies = (($isTempoOn?$tempo:0) + ($isVolumeOn?$volume:0) + ($isPitchOn?$pitch:0) 
                  + ($isArtistOn?$artist:0) + ($isGenreOn?$genre:0) + ($isYearOn?$year:0) 
                  + ($isDistributionOn?$distribution:0));

for ($i=0; $i < count($stripedStoreFiles); $i++) {
  $ArtistOccurance = 0;
  $genreOccurance = 0;
  $yearOccurance = 0;

  if ($isTempoOn) {
    $diffTempo = abs($tempo - $stripedStoreFiles[$i]->tempo * 100 / 200);
    $criteriaValueTempo = (100 - $diffTempo) * $tempo;
  }
  if ($isVolumeOn) {
    $diffVolume = abs($volume - $stripedStoreFiles[$i]->volume * 100 / 300000);
    $criteriaValueVolume = (100 - $diffVolume) * $volume;
  }
  if ($isPitchOn) {
    $diffPitch = abs($pitch - $stripedStoreFiles[$i]->pitch * 100 / 10000);
    $criteriaValuePitch = (100 - $diffPitch) * $pitch;
  }
  // needs to be checked
  if ($isArtistOn) {
    $sum = 0;
    for ($j = 0; $j < count($artistPriority['values']); $j++) {
      $sum += $artistPriority['occurances'][$j];
      if ($stripedStoreFiles[$i]->artist == $artistPriority['values'][$j]){
        $ArtistOccurance = $artistPriority['occurances'][$j];
      }
    };
    $occurenceOfArtistPercent = $ArtistOccurance*100/$sum;
    
    $diffArtist = abs(100 - $occurenceOfArtistPercent);
    $criteriaValueArtist = (100 - $diffArtist) * $artist;
  }
  if ($isGenreOn) {
    $sum = 0;
    for ($j = 0; $j < count($genrePriority['values']); $j++) {
      $sum += $genrePriority['occurances'][$j];
      if ($stripedStoreFiles[$i]->genre == $genrePriority['values'][$j]){
        $genreOccurance = $genrePriority['occurances'][$j];
      }
    };
    $occurenceOfGenrePercent = $genreOccurance*100/$sum;
    
    $diffGenre = abs(100 - $occurenceOfGenrePercent);
    $criteriaValueGenre = (100 - $diffGenre) * $genre;
  }
  if ($isYearOn) {

    $sum = 0;
    for ($j = 0; $j < count($yearPriority['values']); $j++) {
      $sum += $yearPriority['occurances'][$j];
      if ($stripedStoreFiles[$i]->year == $yearPriority['values'][$j]){
        $yearOccurance = $yearPriority['occurances'][$j];
      }
    };
    $occurenceOfYearPercent = $yearOccurance*100/$sum;

    $diffYear = abs(100 - $occurenceOfYearPercent);
    $criteriaValueYear = (100 - $diffYear) * $year;
  }
  // deviation
  if ($isDistributionOn) {
    $distribution = str_split($distribution, 2);
    $wave = str_split($stripedStoreFiles[$i]->wave, 2);
    $sum = 0;
    for ($j = 0; $j < count($distribution); $j++) {
      $sum += abs($distribution[$j] - $wave[$j]);
    }
    $diffDistribution = $sum*100/5000;
    $criteriaValueDistribution = (100 - $diffDistribution) * $distributionAccuracy;
  }

  $itemRelevance = $criteriaValueTempo + $criteriaValueVolume + $criteriaValuePitch + $criteriaValueArtist + $criteriaValueGenre + $criteriaValueYear;

  $itemRelevancePercentage = $itemRelevance / $sumOfAccuracies;
  // echo $itemRelevancePercentage.'<br>';
  // array_push($itemRelevanceArray, $itemRelevancePercentage);
  $itemRelevanceArray[$stripedStoreFiles[$i]->id] = $itemRelevancePercentage;
  // echo $itemRelevancePercentage.'<br>';
}
arsort($itemRelevanceArray);
$ids = array_keys($itemRelevanceArray);
// var_dump($ids);
$finalArray=array();
for ($x=0; $x < count($ids); $x++) { 
  for ($i=0; $i <count($stripedStoreFiles) ; $i++) { 
    if($ids[$x]==$stripedStoreFiles[$i]->id){
      array_push($finalArray,$stripedStoreFiles[$i] );
      break;
    }
    # code...
  }
  # code...
}
echo '{   "Songs":'.json_encode($finalArray).'}';
// $secondTime = round(microtime(true) * 1000);
// echo ($secondTime-$firstTime);

mysql_close($db);
?>