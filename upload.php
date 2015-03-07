<?php
session_start();
$user=$_SESSION['user'];
if (!isset($_SESSION))
{
	header("/index.php");
}
// include("./getGenre.php");
// include("db.php");
//set_time_limit(90); 
require('UploadHandler.php');
// require("infoExtractor.php");
$upload_handler = new UploadHandler(['upload_dir' => $user.'/', 'upload_url'=>'../'.$user.'/' ]);
//echo $_FILES['userfile']['name'];
// file_put_contents("output.txt", $upload_handler => get_file_name());
exit(0);
$data = json_decode(stripslashes($_POST['data']));
$filenames = json_decode(stripslashes($_POST['fileNames']));
$urls =$data; //explode(" ", $data);__
$fnames = str_replace(' ', '_', $filenames); //explode(" ", $filenames);__
//import class
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
function url_get_contents($Url)
{//Alternative to File-get-contents
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}//Alternative to File-get-contents
$fileEx = url_get_contents($urls);
//echo $fileEx;
$file =$fileEx;//file_get_contents($fileEx);//url_get_contents($urls)//
$name =$fnames ;
upload($file, $name, $user, $xml);
//sleep(30);
function upload($file, $OriginalName, $user, $xml)
{
	$upload_directory=$user;
	$url="/";
	$upload_directory_url=$user."/";
	if(!is_null($file))
	{
		echo $OriginalName.'}';
		$tempFile = $file;
		//$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
		$name=$OriginalName;//$user."-".time()."-".$_FILES['Filedata']['name'];
	    $targetFile = $upload_directory."/".$name;
		// Validate the file type
		$fileTypes = array('mp3','wav',); // File extensions
		$fileParts = pathinfo($name);
		$filename=$upload_directory."/" . $name; 
		$img = $upload_directory_url.'artwork/'.$name.'.jpg';
		//echo strlen(file_get_contents($filename)).' ,';
		//echo strlen($tempFile);
		//=null;
		function cutMP3($fileReceieved, $user)
		{
		    $fileReceieved=utf8_encode(trim($fileReceieved, " \t\n\r\0\x0B "));
		    $fileReceieved=mysql_real_escape_string($fileReceieved);
			include("getid3/getid3.php");
			$getID3cut = new getID3;
			$path=$fileReceieved;
			$user=$user;
			echo 'path is: '.$path.' and the user is: '.$user;
			$path= explode('/', $path);
			$fileName=$path[1];
			//echo $fileName;
			//echo $user;
			$dir=$user;
			$ThisFileInfo = $getID3cut->analyze($dir.'/'.$fileName);
			$input=$dir.'/'.$fileName;
			$output=$dir.'/samples/'.$fileName;
			if ($seconds>30)
			{
				$start=$seconds/2;
				$end=$start+30;
				require_once './class.mp3.php';
				$mp3 = new mp3;
				$mp3->cut_mp3($input, $output, $start, $end, 'second', false);
				echo "successful cutting";
			}
			else 
			{
				require_once './class.mp3.php';
				$mp3 = new mp3;
				$mp3->cut_mp3($input, $output, 0, -1, 'second', false);
				echo "success 2";
			}
			
		}
		
		function getCover($fileReceieved, $pathReceived)
		{
		    $fileReceieved=utf8_encode(trim($fileReceieved, " \t\n\r\0\x0B "));
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
		}
		function getWaveform($sample_rate, $playtime, $filePath)
		{
		// echo $filePath;
			$sample_per_second=round($playtime/(1000/$sample_rate));
			echo '  '.$sample_per_second;
			exec('/usr/local/bin/audiowaveform -i '.$filePath.' -o sample.json -z '.$sample_per_second.' --background-color ffffff --waveform-color EF8800  --no-axis-labels -w 1000', $output, $return_var);
			exec('/usr/local/bin/audiowaveform -i '.$filePath.' -o sample.png -z '.$sample_per_second.' --background-color ffffff00 --waveform-color EF8800  --no-axis-labels -w 1000 -h 30', $output, $return_var);

		}
		if (in_array($fileParts['extension'],$fileTypes))
		{
			if(file_exists($filename))
			{
			  if(strlen($tempFile)==strlen(file_get_contents($filename)))
			   {
			   	file_put_contents($targetFile,$tempFile);
				cutMP3($targetFile,$user);
				}
			  else
			   {
			       $filename= $upload_directory."/" . $fileParts['filename'].'_copy'.'.'.$fileParts['extension']; 
			       $img=$upload_directory_url.'artwork/'. $fileParts['filename'].'_copy'.'.'.$fileParts['extension'].'.jpg';  
			       file_put_contents($filename,$tempFile);
			       cutMP3($filename, $user);
			   }
	     	}
	        else
	        {
	        	file_put_contents($targetFile,$tempFile);
		         cutMP3($targetFile, $user);
		    }
		} 
		else 
		{
			exit();
		}
		$mp3file=new MP3_data(); 
		$mp3file->getid3($filename);
	//	include("getid3/getid3.php");
		$getID3 = new getID3; 
	   // Analyze file and store returned data in $ThisFileInfo 
		$ThisFileInfo = $getID3->analyze($upload_directory."/" . $name); 
		getCover($upload_directory_url.$name, $upload_directory_url.'artwork/'.$name.'.jpg');
		$len= @$ThisFileInfo['playtime_string'];  //echo @$ThisFileInfo['audio']['sample_rate'];//print_r(@$ThisFileInfo);
		$split = explode(':', $len);
		$seconds=(($split[0]*60)+$split[1]); echo "playtime ".$seconds;
		getWaveform(@$ThisFileInfo['audio']['sample_rate'], $seconds, $upload_directory_url.$name);
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
	$file=file_get_contents('sample.json');
	$json=json_decode($file);
	for ($i=0; $i < count($json->data); $i++) { 
		$json->data[$i]=abs($json->data[$i]);
	}
	$averageVolume=round(array_sum($json->data)/count($json->data));
	echo ' --------------------------'.$averageVolume;
	echo ' --------------------------'.count($json->data);
    //save average value
    if (isset($_SESSION))
    {    
      $addingUser="INSERT INTO music(url, artist, title, urlOfArt, genre, year, username, wave, volume) VALUES('". mysql_real_escape_string($filename) ."', '". mysql_real_escape_string($mp3file->artist) ."', '". mysql_real_escape_string($mp3file->title) ."', '". mysql_real_escape_string($img) ."' ,'". mysql_real_escape_string($mp3file->genre) ."','". mysql_real_escape_string($mp3file->year) ."', '". mysql_real_escape_string($user) ."', '". mysql_real_escape_string($file)."', '".mysql_real_escape_string($averageVolume)."')";
mysql_query($addingUser) or die (' error'. mysql_error());
		if ($addingUser)
		{//echo "success";
		    mysql_close();
		}
		else
		{
			echo mysql_error();
		}
    }
  }
}
session_write_close(); 
?>