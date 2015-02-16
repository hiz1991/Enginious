<?php 
// class MP3_data 
// { 
//      var $title;var $artist;var $album;var $year;var $comment;var $genre; 
//      function getid3 ($file) { 
//       if (file_exists($file)) { 
//        $id_start=filesize($file)-128; 
//        $fp=fopen($file,"r"); 
//        fseek($fp,$id_start); 
//        $tag=fread($fp,3); 
//        if ($tag == "TAG") { 
//         $this->title=fread($fp,30); 
//         $this->artist=fread($fp,30); 
//         $this->album=fread($fp,30); 
//         $this->year=fread($fp,4); 
//         $this->comment=fread($fp,30); 
//         $this->genre=bin2hex(fread($fp,1)); 
//         fclose($fp); 
//         return true; 
//        } else { 
//         fclose($fp); 
//         return false; 
//        } 
//       } else { return false; } 
//      } 
// }
// include("getid3/getid3.php");
// include("./getGenre.php");
// 			$mp3file=new MP3_data(); 
// 		$mp3file->getid3('test.mp3');

// 	//	include("getid3/getid3.php");
// 		$getID3 = new getID3; 
// 			// $ThisFileInfo = $getID3cut->analyze('/Insatiable.mp3');
// 					// $mp3file=new MP3_data(); 
// 		// $ThisFileInfo = $getID3->analyze($upload_directory."/" . $name); 
// 		// $mp3file->getid3('/Insatiable.mp3');
// 		var_dump($mp3file->genre);
// 		echo getGenre(hexdec($mp3file->genre));
// 		0.Blues
// 1.Classic Rock
// 2.Country
// 3.Dance
// 4.Disco
// 5.Funk
// 6.Grunge
// 7.Hip-Hop
// 8.Jazz
// 9.Metal
// 10.New Age
// 11.Oldies
// 12.Other
// 13.Pop
// 14.R&B
// 15.Rap
// 16.Reggae
// 17.Rock
// 18.Techno
// 19.Industrial
// 20.Alternative
// 21.Ska
// 22.Death Metal
// 23.Pranks
// 24.Soundtrack
// 25.Euro-Techno
// 26.Ambient
// 27.Trip-Hop
// 28.Vocal
// 29.Jazz+Funk
// 30.Fusion
// 31.Trance
// 32.Classical
// 33.Instrumental
// 34.Acid
// 35.House
// 36.Game
// 37.Sound Clip
// 38.Gospel
// 39.Noise
// 40.AlternRock
// 41.Bass
// 42.Soul
// 43.Punk
// 44.Space
// 45.Meditative
// 46.Instrumental Pop
// 47.Instrumental Rock
// 48.Ethnic
// 49.Gothic
// 50.Darkwave
// 51.Techno-Industrial
// 52.Electronic
// 53.Pop-Folk
// 54.Eurodance
// 55.Dream
// 56.Southern Rock
// 57.Comedy
// 58.Cult
// 59.Gangsta
// 60.Top 40
// 61.Christian Rap
// 62.Pop/Funk
// 63.Jungle
// 64.Native American
// 65.Cabaret
// 66.New Wave
// 67.Psychadelic
// 68.Rave
// 69.Showtunes
// 70.Trailer
// 71.Lo-Fi
// 72.Tribal
// 73.Acid Punk
// 74.Acid Jazz
// 75.Polka
// 76.Retro
// 77.Musical
// 78.Rock & Roll
// 79.Hard Rock]
// function getPitch($filePath)
// {
//       $filePath = escapeshellarg($filePath);
//       $output = [];
//       exec('/usr/local/bin/aubiopitch -i '.$filePath.' -l 0.4' , $output, $return_var);
//       // var_dump(count($output));
//       // array_walk($output, 'removeTime');
//       for ($i=0; $i < count($output); $i++) { 
//         // $output[$i] =  round(removeTime($output[$i]));
//            $pieces = explode(" ", $output[$i]);
//            $output[$i] = round($pieces[1]);
//       }
//       $count =0;
//       $sum = 0;
//       for ($x=0; $x <count($output) ; $x++) { 
//         if($output[$x]>200)
//         {
//            $sum = $sum+$output[$x];
//            $count++;
//         }
//       }
//       // echo round(array_sum($output)/count($output));
//       return round($sum/1000);
//       // var_dump($output);
// }
  // include("getid3/getid3.php");
  // $getID3cut = new getID3;
  //   function getWaveform($sample_rate, $playtime, $filePath)
  //   {
  //   // echo $filePath;
  //     $filePath=escapeshellarg($filePath);//str_replace(" ", "\ ", $filePath);
  //     //error_log($filePath);
  //     $sample_per_second=2;//round($playtime/(1000000/$sample_rate));
  //     //echo '  '.$sample_per_second;
  //     $points = $sample_rate*$playtime;
  //     exec('/usr/local/bin/audiowaveform -i '.$filePath.' -o /Users/macbook/Dropbox/sample.json -z '.$sample_per_second.' --background-color ffffff --waveform-color EF8800  --no-axis-labels -w '.$points.' -h 15 ', $output, $return_var);
  //     echo '/usr/local/bin/audiowaveform -i '.$filePath.' -o /Users/macbook/Dropbox/sample.json -z '.$sample_per_second.' --background-color ffffff --waveform-color EF8800  --no-axis-labels -w '.$points.' -h 15 ';
  //     // exec('/usr/local/bin/audiowaveform -i '.$filePath.' -o /Users/macbook/Dropbox/sample.png -z '.$sample_per_second.' --background-color ffffff00 --waveform-color EF8800  --no-axis-labels -w 30000 -h 15', $output, $return_var);

  //   }
  //     $mp3file=new MP3_data(); 
  //   $mp3file->getid3($filename);
  //   $getID3 = new getID3; 
    //$filePath = "/Applications/MAMP/htdocs/store/Знакводолея.mp3"; 
  //   $ThisFileInfo = $getID3->analyze($targetFile); 

  //   // getCover($upload_directory_url.$name, $img);
  //   $len= @$ThisFileInfo['playtime_string']; // echo @$ThisFileInfo['audio']['sample_rate'];//print_r(@$ThisFileInfo);
  //   $split = explode(':', $len);
  //   $seconds=(($split[0]*60)+$split[1]); //echo "playtime ".$seconds;
  //   getWaveform(@$ThisFileInfo['audio']['sample_rate'], $seconds, $targetFile);
    // $filePath="/Users/macbook/Dropbox/sample.json";
  //     exec('/Users/macbook/xcode/analyzeTempo/analyzeTempo/built/volumeAverage/usr/local/bin/volumeAverage '.$filePath.'', $output, $return_var);
  //   echo $output[0];
  //   // $file=file_get_contents('/Users/macbook/Dropbox/sample.json');
  //   // $json=json_decode($file);
  //   // for ($i=0; $i < count($json->data); $i++) 
  //   // { 
  //   //   $json->data[$i]=abs($json->data[$i]);
  //   // }
  //   // var_dump($json->data);
  //   // $averageVolume=round(array_sum($json->data)/count($json->data));
  //   // echo $averageVolume;
  //   // echo "  ".count($json->data);
   // createThumb( "100001430183965/artwork/02 My Kind Of Love.mp3.jpg", "100001430183965/artwork/thumb/", 80 );   
   // exec('sox/sox '.escapeshellarg($filePath).' -n stat 2>&1 1> /dev/null', $output, $return_var);
   // $outputTempSplit = explode(': ', $output[6]);
   //             echo $outputTempSplit[1]*1000000;
// error_log($_GET['key']);
// exec('/usr/local/bin/exiftool /Applications/MAMP/htdocs/store/Знакводолея.mp3',$output, $return_var);
// $outputEnd =  str_replace('Artist                          : ', '', $output[25]);
// $outputEnd1= str_replace('Title                           : ', '', $output[24]);
// error_log($outputEnd);
// error_log($outputEnd1);
include "getJson.php";
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
switch ($lang){
    case "fr":
        echo "PAGE FR";
        // include("index_fr.php");//include check session FR
        break;
    case "it":
        echo "PAGE IT";
        // include("index_it.php");
        break;
    case "en":
        echo "PAGE EN";
        // include("index_en.php");
        break;        
    default:
        echo "PAGE EN - Setting Default";
        // include("index_en.php");//include EN in all other cases of different lang detection
        break;
}

?>