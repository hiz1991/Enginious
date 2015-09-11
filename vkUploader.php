<?php
session_start();
$user=$_SESSION['user'];
if (!isset($_SESSION))
{
	header("/index.php");
}
include("db.php");
class MP3_data 
{ 
     var $title;var $artist;var $album;var $year;var $comment;var $genre; 
     function getid3 ($file) { 
      if (file_exists($file)) { 
       $id_start=filesize($file)-128; 
       $fp=fopen($file,"r"); 
       fseek($fp,$id_start); 
       $tag=fread($fp,3); 
       if ($tag == "TAG") { 
        $this->title=fread($fp,30); 
        $this->artist=fread($fp,30); 
        $this->album=fread($fp,30); 
        $this->year=fread($fp,4); 
        $this->comment=fread($fp,30); 
        $this->genre=bin2hex(fread($fp,1)); 
        fclose($fp); 
        return true; 
       } else { 
        fclose($fp); 
        return false; 
       } 
      } else { return false; } 
     } 
}

function extractInfo($filePath, $title, $artist, $user)
{
	echo $filePath;
	include("getid3/getid3.php");
	$getID3cut = new getID3;
	 //error_log($filePath,  0);
	// $upload_directory=$user;
	// $url="/";
	// $upload_directory_url=$user."/";
	$fileParts = pathinfo($filePath);
	$fileName = $fileParts["basename"];

	if(!is_null($filePath))
	{
	    $targetFile = $user."/".$fileName;
		// Validate the file type
		// $fileTypes = array('mp3','wav',); // File extensions
		$upload_directory_url =  $user;
		// $user = $fileParts["dirname"];
		$img = $upload_directory_url.'/artwork/'.$fileName.'.jpg';
		//echo strlen(file_get_contents($filename)).' ,';
		$filename=$fileName;
		//echo strlen($tempFile);
		//=null;
		function getWithExiftools($fileName)
		{
			$outputGenre='';
			exec('/usr/local/bin/exiftool '.escapeshellarg($fileName),$output, $return_var);
			for ($i=0; $i <count($output) ; $i++)
			{ 
				if (strpos($output[$i], "Artist                          : ")!== false) 
				{
					$outputArtist =  str_replace('Artist                          : ', '', $output[$i]);
				}
				elseif (strpos($output[$i], "Title                           : ")!== false)
				{
					$outputTitle= str_replace('Title                           : ', '', $output[$i]);
				}
				elseif(strpos($output[$i], "Genre                           : ")!== false)
				{
					$outputGenre= str_replace("Genre                           : ", '', $output[$i]);
				}
			}
			return ['artist'=>$outputArtist, 'title'=>$outputTitle, 'genre'=>$outputGenre];
		}
		function cutMP3($fileReceieved, $user, $seconds)
		{
			$fileParts = pathinfo($fileReceieved);
		    $fileName= $fileParts["basename"];
		    $dir =  $fileParts["dirname"];
			$input=$dir.'/'.$fileName;
			$output=$dir.'/samples/'.$fileName;
			if ($seconds>30)
			{
				// error_log($output, $input);
				$start=$seconds/2;
				$end=$start+30;
				require_once './class.mp3.php';
				$mp3 = new mp3;
				$mp3->cut_mp3($input, $output, $start, $end, 'second', false);
				// error_log( $input);
			}
			else 
			{
				// error_log($output, $input);
				require_once './class.mp3.php';
				$mp3 = new mp3;
				$mp3->cut_mp3($input, $output, 0, -1, 'second', false);
				// echo "success 2";
				// error_log( $input);
			}
			
		}
		
		function getCover($fileReceieved, $pathReceived)
		{
			//TODO:artwork thumb dir not created
		    // $fileReceieved=utf8_encode(trim($fileReceieved, " \t\n\r\0\x0B "));
		    $fileReceieved=mysql_real_escape_string($fileReceieved);
			require_once('getid3/getid3.php');
			$file = $fileReceieved; 
			$path = $pathReceived; 

			$getID3cover = new getID3; 
			$getID3cover->option_tag_id3v2 = true; # Don't know what this does yet 
			$getID3cover->option_tags_images = true;
			$getID3cover->analyze($file); 
			if (isset($getID3cover->info['id3v2']['APIC'][0]['data'])) { 
			$cover = $getID3cover->info['id3v2']['APIC'][0]['data']; 
			} elseif (isset($getID3cover->info['id3v2']['PIC'][0]['data'])) { 
			$cover = $getID3cover->info['id3v2']['PIC'][0]['data']; 
			} else { 
			$cover = null;//file_get_contents('./artwork.jpg'); 
			} 
			if (isset($getID3cover->info['id3v2']['APIC'][0]['image_mime'])) { 
			$mimetype = $getID3cover->info['id3v2']['APIC'][0]['image_mime']; 
			} else { 
			$mimetype = 'image/jpeg'; // I have tried changing this line to $mimetype = 'image/png'; and it still does not work
			} 
			if (!is_null($cover)) { 
			// Send file 
			header("Content-Type: " . $mimetype); 

			if (isset($getID3cover->info['id3v2']['APIC'][0]['image_bytes'])) { 
			header("Content-Length: " . $getID3cover->info['id3v2']['APIC'][0]['image_bytes']); 
			} 
			//$url = $url."cover.php?song=".$name;
			$img = 'artwork.jpg';
			   file_put_contents($path, $cover);
			   //imagedestroy($cover);
			} 
			else
			{
				$cover = file_get_contents('./artwork.jpg');
				file_put_contents($path, $cover);
				//imagedestroy($cover);

			}
			imagedestroy($img);
			include 'createThumb.php';
			$path_partsTemp = pathinfo($path);
            $dirNameTemp = $path_partsTemp['dirname'];
            createThumb( $path, $dirNameTemp.'/thumb/', 80 ); 
		}
		function getWaveform($sample_rate, $playtime, $filePath)
		{
		// echo $filePath;
			//str_replace(" ", "\ ", $filePath);
			//error_log($filePath);
			$sample_per_second=round($playtime/(1000/$sample_rate));
			//echo '  '.$sample_per_second;
		    $path_partsTemp = pathinfo($filePath);
            $dirForWave = $path_partsTemp['dirname'].'/waveforms/'.$path_partsTemp['filename'].'.json';
            $dirForWave=escapeshellarg($dirForWave);
            $filePath=escapeshellarg($filePath);
            // error_log($dirForWave);
            // error_log('/usr/local/bin/audiowaveform -i '.$filePath.' -o '.$dirForWave.' -z '.$sample_per_second.' --background-color ffffff --waveform-color EF8800  --no-axis-labels -w 1000');
			exec('/usr/local/bin/audiowaveform -i '.$filePath.' -o '.$dirForWave.' -z '.$sample_per_second.' --background-color ffffff --waveform-color EF8800  --no-axis-labels -w 1000', $output, $return_var);
			exec('distributionExtractor/distrExtractor '.$dirForWave, $output1, $return_var);
			// error_log('distributionExtractor/distrExtractor '.$dirForWave);
			return $output1[0];

		}
		function getPitch($filePath)
		{
		      $filePath = escapeshellarg($filePath);
		      $output = [];
		      exec('/usr/local/bin/aubiopitch -i '.$filePath.' -l 0.4' , $output, $return_var);
		      // var_dump(count($output));
		      // array_walk($output, 'removeTime');
		      for ($i=0; $i < count($output); $i++) { 
		        // $output[$i] =  round(removeTime($output[$i]));
		           $pieces = explode(" ", $output[$i]);
		           $output[$i] = round($pieces[1]);
		      }
		      $count =0;
		      $sum = 0;
		      for ($x=0; $x <count($output) ; $x++) { 
		        if($output[$x]>200)
		        {
		           $sum = $sum+$output[$x];
		           $count++;
		        }
		      }
		      // echo round(array_sum($output)/count($output));
		      return round($sum/1000);
		      // var_dump($output);
		}
		function getTempo($filePath, $seconds)
		{
		      $filePath = escapeshellarg($filePath);
		      $output = [];
		      exec('/usr/local/bin/aubiotrack -i '.$filePath.' ' , $output, $return_var);
		      return round(count($output)/($seconds/60));
		      // var_dump($output);
		}
		function getVolume($filePath)
		{
			   exec('sox/sox '.escapeshellarg($filePath).' -n stat 2>&1 1> /dev/null', $output, $return_var);
               $outputTempSplit = explode(': ', $output[6]);
               return $outputTempSplit[1]*1000000;
		}
		$mp3file=new MP3_data(); 
		$mp3file->getid3($filePath);
		$getID3 = new getID3;  
		// $firstTime=microtime();
		// $ThisFileInfo = $getID3->analyze($targetFile);
		//TODO:delete this
		// $secondTime=microtime();
		// error_log($secondTime-$firstTime);
		// error_log(mb_detect_encoding($mp3file->title));
		// error_log($mp3file->title); 
        // error_log(utf8_encode($mp3file->title));
        // error_log(utf8_decode($mp3file->title));
        // echo $mp3file->title;
		getCover($filePath, $img);
		$len= @$ThisFileInfo['playtime_string'];  //echo @$ThisFileInfo['audio']['sample_rate'];//print_r(@$ThisFileInfo);
		$split = explode(':', $len);
		$seconds=(($split[0]*60)+$split[1]); //echo "playtime ".$seconds;
		$wave = null;//getWaveform(@$ThisFileInfo['audio']['sample_rate'], $seconds, $targetFile);
		// error_log($wave);
		$pitch = null;//getPitch($targetFile);
		$tempo = null;//getTempo($targetFile, $seconds);
        // cutMP3($targetFile,$user, $seconds);
        $averageVolume = null;//getVolume($targetFile);

	    $mp3file->title=utf8_encode(trim($title, " \t\n\r\0\x0B "));
	    $mp3file->title=mysql_real_escape_string($title);//removes whitespaces
	    $mp3file->artist=utf8_encode(trim($artist, " \t\n\r\0\x0B "));
	    $mp3file->artist=mysql_real_escape_string($artist);//removes whitespaces
		// if($mp3file->title==null||strlen($mp3file->title)==0 || (!preg_match('/[a-z]+/', $mp3file->title)))
		// 	{
		// 		$mp3file->title=mysql_real_escape_string($fileParts['filename']);
		// 	} 
		// else 
		// 	{
		// 		$mp3file->title=utf8_encode($mp3file->title);
		// 	}
		// if($mp3file->artist==null||strlen($mp3file->artist)==0 || (!preg_match('/[a-z]+/', $mp3file->title)))
		// 	{
		// 		$mp3file->artist="Unknown Artist";
		// 	} 
		// else
		// 	{
		// 		$mp3file->artist=utf8_encode($mp3file->artist);
		// 	}
		//$mp3file->album=utf8_encode($mp3file->album);
		//$mp3file->album=utf8_encode(trim($mp3file->album, " \t\n\r\0\x0B "));
		$mp3file->year=mysql_real_escape_string(utf8_encode($mp3file->year));
		$resultFromExiftools = null;//getWithExiftools($targetFile);
		$mp3file->genre=$resultFromExiftools['genre'];
		// $mp3file->artist = (!$resultFromExiftools['artist']==null)?$resultFromExiftools['artist']:$mp3file->artist;
		// $mp3file->title = (!$resultFromExiftools['title']==null)?$resultFromExiftools['title']:$mp3file->title;
		//save average value
		// $file=file_get_contents('sample.json');
		// $json=json_decode($file);
		// for ($i=0; $i < count($json->data); $i++) 
		// { 
		// 	$json->data[$i]=abs($json->data[$i]);
		// }
		// $averageVolume=round(array_sum($json->data)/count($json->data));
		//echo ' --------------------------'.$averageVolume;
		//echo ' --------------------------'.count($json->data);
	    //save average value
        if (isset($_SESSION))
        {    
            // $addingUser="INSERT INTO music(url, artist, title, urlOfArt, genre, year, username, wave, volume) VALUES('". mysql_real_escape_string($filename) ."', '". mysql_real_escape_string($mp3file->artist) ."', '". mysql_real_escape_string($mp3file->title) ."', '". mysql_real_escape_string($img) ."' ,'". mysql_real_escape_string($mp3file->genre) ."','". mysql_real_escape_string($mp3file->year) ."', '". mysql_real_escape_string($user) ."', '". mysql_real_escape_string($file)."', '".mysql_real_escape_string($averageVolume)."')";
            $temporArray=[$filePath, $mp3file->artist, $mp3file->title, $img, $mp3file->genre, $mp3file->year, $user ,$wave, $averageVolume, $pitch, $tempo];
            $addingUser=recordInDB("music", ["url", "artist", "title", "urlOfArt", "genre", "year", "username", "wave", "volume", "pitch", "tempo"], $temporArray, $user);
            mysql_query($addingUser); //or die (' error'. mysql_error());
            // error_log(mysql_error());
		    if ($addingUser)
			 {//echo "success";
			    mysql_close();
			 }
			else
			 {
			 	mysql_close();
				//echo mysql_error();
			 }
        }//if session
    }//if file is null
}
extractInfo($_GET['url'], $_GET['title'], $_GET['artist'], $user);
?>