<?php
include("getGenre.php");
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

function extractInfo($filePath)
{
	include("getid3/getid3.php");
	$getID3cut = new getID3;
	 //error_log($filePath,  0);
	// $upload_directory=$user;
	// $url="/";
	// $upload_directory_url=$user."/";
	if(!is_null($filePath))
	{
	    $targetFile = $filePath;
		// Validate the file type
		// $fileTypes = array('mp3','wav',); // File extensions
		$fileParts = pathinfo($filePath);
		$name= $fileParts["basename"];
		$upload_directory_url =  $fileParts["dirname"].'/';
		$user = $fileParts["dirname"];
		$img = $upload_directory_url.'artwork/'.$name.'.jpg';
		//echo strlen(file_get_contents($filename)).' ,';
		$filename=$filePath;
		//echo strlen($tempFile);
		//=null;
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
				// echo "successful cutting";
			}
			else 
			{
				error_log($output, $input);
				require_once './class.mp3.php';
				$mp3 = new mp3;
				$mp3->cut_mp3($input, $output, 0, -1, 'second', false);
				// echo "success 2";
				// error_log($output, $input);
			}
			
		}
		
		function getCover($fileReceieved, $pathReceived)
		{
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
			$filePath=escapeshellarg($filePath);//str_replace(" ", "\ ", $filePath);
			//error_log($filePath);
			$sample_per_second=round($playtime/(1000/$sample_rate));
			//echo '  '.$sample_per_second;
			exec('/usr/local/bin/audiowaveform -i '.$filePath.' -o sample.json -z '.$sample_per_second.' --background-color ffffff --waveform-color EF8800  --no-axis-labels -w 1000', $output, $return_var);
			exec('/usr/local/bin/audiowaveform -i '.$filePath.' -o sample.png -z '.$sample_per_second.' --background-color ffffff00 --waveform-color EF8800  --no-axis-labels -w 1000 -h 30', $output, $return_var);

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
		$mp3file->getid3($filename);
		$getID3 = new getID3;  
		$ThisFileInfo = $getID3->analyze($targetFile); 

		getCover($upload_directory_url.$name, $img);
		$len= @$ThisFileInfo['playtime_string'];  //echo @$ThisFileInfo['audio']['sample_rate'];//print_r(@$ThisFileInfo);
		$split = explode(':', $len);
		$seconds=(($split[0]*60)+$split[1]); //echo "playtime ".$seconds;
		getWaveform(@$ThisFileInfo['audio']['sample_rate'], $seconds, $targetFile);
		$pitch = getPitch($targetFile);
		$tempo = getTempo($targetFile, $seconds);
        cutMP3($targetFile,$user, $seconds);

	    $mp3file->title=utf8_encode(trim($mp3file->title, " \t\n\r\0\x0B "));
	    $mp3file->title=mysql_real_escape_string($mp3file->title);//removes whitespaces
	    $mp3file->artist=utf8_encode(trim($mp3file->artist, " \t\n\r\0\x0B "));
	    $mp3file->artist=mysql_real_escape_string($mp3file->artist);//removes whitespaces
		if($mp3file->title==null||strlen($mp3file->title)==0)
			{
				$mp3file->title=mysql_real_escape_string($fileParts['filename']);
			} 
		else 
			{
				$mp3file->title=utf8_encode($mp3file->title);
			}
		if($mp3file->artist==null||strlen($mp3file->artist)==0)
			{
				$mp3file->artist="Unknown Artist";
			} 
		else
			{
				$mp3file->artist=utf8_encode($mp3file->artist);
			}
		//$mp3file->album=utf8_encode($mp3file->album);
		//$mp3file->album=utf8_encode(trim($mp3file->album, " \t\n\r\0\x0B "));
		$mp3file->genre=mysql_real_escape_string(utf8_encode(getGenre(hexdec($mp3file->genre))));
		$mp3file->year=mysql_real_escape_string(utf8_encode($mp3file->year));
		//save average value
		// $file=file_get_contents('sample.json');
		// $json=json_decode($file);
		// for ($i=0; $i < count($json->data); $i++) 
		// { 
		// 	$json->data[$i]=abs($json->data[$i]);
		// }
		// $averageVolume=round(array_sum($json->data)/count($json->data));
		$averageVolume = getVolume($targetFile);
		//echo ' --------------------------'.$averageVolume;
		//echo ' --------------------------'.count($json->data);
	    //save average value
        if (isset($_SESSION))
        {    
            // $addingUser="INSERT INTO music(url, artist, title, urlOfArt, genre, year, username, wave, volume) VALUES('". mysql_real_escape_string($filename) ."', '". mysql_real_escape_string($mp3file->artist) ."', '". mysql_real_escape_string($mp3file->title) ."', '". mysql_real_escape_string($img) ."' ,'". mysql_real_escape_string($mp3file->genre) ."','". mysql_real_escape_string($mp3file->year) ."', '". mysql_real_escape_string($user) ."', '". mysql_real_escape_string($file)."', '".mysql_real_escape_string($averageVolume)."')";
            $temporArray=[$filename, $mp3file->artist, $mp3file->title, $img, $mp3file->genre, $mp3file->year, $user ," ", $averageVolume, $pitch, $tempo];
            $addingUser=recordInDB("music", ["url", "artist", "title", "urlOfArt", "genre", "year", "username", "wave", "volume", "pitch", "tempo"], $temporArray, $user);
            mysql_query($addingUser); //or die (' error'. mysql_error());
            error_log(mysql_error());
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
?>