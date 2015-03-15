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
// include "getJson.php";






// $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
// switch ($lang){
//     case "fr":
//         // echo "PAGE FR";
//         // include("index_fr.php");//include check session FR
//         break;
//     case "it":
//         // echo "PAGE IT";
//         // include("index_it.php");
//         break;
//     case "en":
//         // echo "PAGE EN";
//         // include("index_en.php");
//         break;        
//     default:
//         // echo "PAGE EN - Setting Default";
//         // include("index_en.php");//include EN in all other cases of different lang detection
//         break;
// }
// include 'db.php';
// include 'transl.php';
// $bs=getTransBase();
// $json = getTransJson($bs);
// echo $json;
// for ($i=1800; $i <2010 ; $i++) { 
  // echo floor($i/10)*10;
// }




// $bs = selectAllDB('music', 'store');

//  mysql_data_seek($bs, 0);
//  $rs = array();
//  while($rs[] = mysql_fetch_object($bs)) {
//     // you don´t really need to do anything here.
//   }
//      echo json_encode($rs);

// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.

// $ds          = DIRECTORY_SEPARATOR;  //1
 
// $storeFolder = 'shared';   //2
 
// if (!empty($_FILES)) {
     
//     $tempFile = $_FILES['file']['tmp_name'];          //3             
      
//     $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
     
//     $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 
//     move_uploaded_file($tempFile,$targetFile); //6
     
// }
// echo '{ "Songs":[{"artist":"Shaham & Brandon","title":"Bodyrock","id":"11015","tempo":"113","volume":"207927","pitch":"3434","url":"new\/Bodyrock.mp3","urlOfArt":"new\/artwork\/Bodyrock.mp3.jpg"},{"artist":"One Republic","title":"Counting Stars (PrimeMusic.ru)","id":"11033","tempo":"120","volume":"219325","pitch":"2992","url":"new\/01 Counting Stars (PrimeMusic.ru).mp3","urlOfArt":"new\/artwork\/01 Counting Stars (PrimeMusic.ru).mp3.jpg"},{"artist":"Neyo","title":"Closer","id":"11029","tempo":"125","volume":"180856","pitch":"4298","url":"new\/01 Closer.mp3","urlOfArt":"new\/artwork\/01 Closer.mp3.jpg"},{"artist":"Lady GaGa","title":"Dope","id":"11047","tempo":"112","volume":"206499","pitch":"6004","url":"new\/13 Dope.mp3","urlOfArt":"new\/artwork\/13 Dope.mp3.jpg"},{"artist":"dmitrii_koldun_","title":"_carevna","id":"11021","tempo":"136","volume":"204514","pitch":"5412","url":"new\/01 _carevna.mp3","urlOfArt":"new\/artwork\/01 _carevna.mp3.jpg"},{"artist":"Jay Sean Ft Lil Wayne","title":"Down","id":"11046","tempo":"130","volume":"233274","pitch":"5207","url":"new\/Down.mp3","urlOfArt":"new\/artwork\/Down.mp3.jpg"},{"artist":"Jessie J","title":"Domino","id":"11043","tempo":"125","volume":"224060","pitch":"6046","url":"new\/Domino 4.mp3","urlOfArt":"new\/artwork\/Domino 4.mp3.jpg"},{"artist":"Blue","title":"Breathe Easy","id":"11018","tempo":"122","volume":"203696","pitch":"6784","url":"new\/Breathe Easy.mp3","urlOfArt":"new\/artwork\/Breathe Easy.mp3.jpg"},{"artist":"Molly","title":"Children of the Universe (United Kingdom)","id":"11025","tempo":"128","volume":"250847","pitch":"3842","url":"new\/14 Children of the Universe (United Kingdom).mp3","urlOfArt":"new\/artwork\/14 Children of the Universe (United Kingdom).mp3.jpg"},{"artist":"Jessie J","title":"Do It Like a Dude","id":"11040","tempo":"132","volume":"244629","pitch":"5086","url":"new\/04 Do It Like a Dude.mp3","urlOfArt":"new\/artwork\/04 Do It Like a Dude.mp3.jpg"},{"artist":"Amel Bent","title":"Cette Idee-L\u00a0","id":"11023","tempo":"127","volume":"187898","pitch":"5797","url":"new\/Cette Idee-L.mp3","urlOfArt":"new\/artwork\/Cette Idee-L.mp3.jpg"},{"artist":"Arash feat. Helena","title":"Broken Angel (2010)","id":"11014","tempo":"111","volume":"236843","pitch":"5911","url":"new\/Broken Angel (2010).mp3","urlOfArt":"new\/artwork\/Broken Angel (2010).mp3.jpg"},{"artist":"Austin Mahone","title":"Cant Fight This Love www.mixmp3.net","id":"11020","tempo":"101","volume":"207604","pitch":"2565","url":"new\/01 Cant Fight This Love www.mixmp3.net.mp3","urlOfArt":"new\/artwork\/01 Cant Fight This Love www.mixmp3.net.mp3.jpg"},{"artist":"Swedish House Mafia feat. John Martin","title":"Dont You Worry Child (Radio Edit)","id":"11045","tempo":"126","volume":"245238","pitch":"2940","url":"new\/Dont You Worry Child (Radio Edit).mp3","urlOfArt":"new\/artwork\/Dont You Worry Child (Radio Edit).mp3.jpg"},{"artist":"Gym Class Heroes","title":"Cookie Jar (Ft. The-Dream)","id":"11031","tempo":"112","volume":"247606","pitch":"3131","url":"new\/01 Cookie Jar (Ft. The-Dream).mp3","urlOfArt":"new\/artwork\/01 Cookie Jar (Ft. The-Dream).mp3.jpg"},{"artist":"Alex Hepburn","title":"Dont bury me","id":"11044","tempo":"113","volume":"221960","pitch":"7277","url":"new\/Dont bury me.mp3","urlOfArt":"new\/artwork\/Dont bury me.mp3.jpg"},{"artist":"Leann Rimes","title":"Cant Fight the Moonlight","id":"11019","tempo":"101","volume":"165497","pitch":"4140","url":"new\/Cant Fight the Moonlight.mp3","urlOfArt":"new\/artwork\/Cant Fight the Moonlight.mp3.jpg"},{"artist":"Sting","title":"Desert Rose","id":"11042","tempo":"109","volume":"163283","pitch":"3707","url":"new\/Desert Rose.mp3","urlOfArt":"new\/artwork\/Desert Rose.mp3.jpg"},{"artist":"Justin Timberlake","title":"Cry Me A River (Instrumental)","id":"11035","tempo":"142","volume":"159156","pitch":"4088","url":"new\/Cry Me A River (Instrumental).mp3","urlOfArt":"new\/artwork\/Cry Me A River (Instrumental).mp3.jpg"},{"artist":"Imagine Dragons","title":"Demons","id":"11038","tempo":"115","volume":"266843","pitch":"2077","url":"new\/02 Demons.mp3","urlOfArt":"new\/artwork\/02 Demons.mp3.jpg"},{"artist":"Rihanna www.STREETLiFE.kz","title":"Cry www.STREETLiFE.kz","id":"11036","tempo":"106","volume":"184971","pitch":"8157","url":"new\/Cry www.STREETLiFE.kz.mp3","urlOfArt":"new\/artwork\/Cry www.STREETLiFE.kz.mp3.jpg"},{"artist":"Skillet","title":"Comatose","id":"11030","tempo":"112","volume":"280352","pitch":"1870","url":"new\/05 Comatose.mp3","urlOfArt":"new\/artwork\/05 Comatose.mp3.jpg"},{"artist":"Piano","title":"chandel Piano","id":"11024","tempo":"128","volume":"246573","pitch":"8886","url":"new\/chandel Piano.mp3","urlOfArt":"new\/artwork\/chandel Piano.mp3.jpg"},{"artist":"Elyar Fox","title":"Do It All Over Again","id":"11041","tempo":"114","volume":"282179","pitch":"1625","url":"new\/01 Do It All Over Again.mp3","urlOfArt":"new\/artwork\/01 Do It All Over Again.mp3.jpg"},{"artist":"DJ Alligator","title":"Close To You (Classical Version)","id":"11028","tempo":"129","volume":"131233","pitch":"7135","url":"new\/65535 Close To You (Classical Version).mp3","urlOfArt":"new\/artwork\/65535 Close To You (Classical Version).mp3.jpg"},{"artist":"Christina Aguilera","title":"Castle Walls","id":"11022","tempo":"94","volume":"86291","pitch":"3565","url":"new\/Castle Walls.mp3","urlOfArt":"new\/artwork\/Castle Walls.mp3.jpg"},{"artist":"Akord","title":"Crash Lady","id":"11032","tempo":"107","volume":"84527","pitch":"2672","url":"new\/Crash Lady.mp3","urlOfArt":"new\/artwork\/Crash Lady.mp3.jpg"},{"artist":"Cassius Henry","title":"Closer","id":"11026","tempo":"125","volume":"74212","pitch":"2545","url":"new\/Closer.mp3","urlOfArt":"new\/artwork\/Closer.mp3.jpg"}]}';
// echo '[{"id": 2,"language": "en","username": "hiz1991@mail.ru","name": "Khizir","lastName": "Putcygov","profileImage": "https://pp.vk.me/c308226/v308226161/3927/t02Dm6L0Dw0.jpg","status": "test status","onlineStatus": "Online","salt": null,"hash": null,"createdAt": null,"updatedAt": null},{"id": 3,"language": "en","username": "OilaSupport@mail.ru","name": "Oila","lastName": "Support","profileImage": "http://10.118.195.30:3000/resources/images/logos/i.png","status": "Hey, I am using Oila","onlineStatus": "Online","salt": null,"hash": null,"createdAt": null,"updatedAt": null},{"id": 4,"language": "en","username": "random@mail.ru","name": "Random","lastName": "User","profileImage": null,"status": "Hey, I am using Oila","onlineStatus": "Online","salt": null,"hash": null,"createdAt": null,"updatedAt": null},{"id": 6,"language": "en","username": "test@mail.ru","name": null,"lastName": null,"profileImage": null,"status": "Hey, I am using Oila","onlineStatus": "Online","salt": null,"hash": null,"createdAt": null,"updatedAt": null}]';
// echo '{"id":1,"language":"en","username":"m.k.x@mail.ru","name":"Kiura","lastName":"Magomadov","profileImage":"https://pp.vk.me/c308226/v308226161/3927/t02Dm6L0Dw0.jpg","status":"teststatusKiura","createdAt":"2014-12-03T04:18:02.000Z","updatedAt":"2014-12-03T04:18:02.000Z","ip":"10.118.195.30"}';
// echo '[{"id": 11,"senderId": 1,"receiverId": null,"receiverGroupId": null,"message": null,"file": "http://2.bp.blogspot.com/-U-qkJww9Q78/U_3TlvjJLsI/AAAAAAAADuc/UmGabxzF_7Q/s1600/facepalm.gif","type": "googleimage","thumb": null,"createdAt": "2015-03-12T00:11:13.000Z"},{"id": 12,"senderId": 2,"receiverId": null,"receiverGroupId": null,"message": null,"file": "http://2.bp.blogspot.com/_Vei5yX-Ebio/TOuK-ypV0SI/AAAAAAAAADY/bhBBO2VZ1k4/s1600/WTF__by_UndineCG.jpg","type": "googleimage","thumb": null,"createdAt": "2015-03-12T00:11:59.000Z"},{"id": 13,"senderId": 2,"receiverId": null,"receiverGroupId": null,"message": "%F0%9F%98%8D","file": null,"type": "txt","thumb": null,"createdAt": "2015-03-12T00:12:19.000Z"},{"id": 14,"senderId": 2,"receiverId": null,"receiverGroupId": null,"message": "%F0%9F%93%80","file": null,"type": "txt","thumb": null,"createdAt": "2015-03-12T00:12:30.000Z"},{"id": 15,"senderId": 2,"receiverId": null,"receiverGroupId": null,"message": "%F0%9F%98%93%F0%9F%98%8D%F0%9F%98%8A%F0%9F%98%8B","file": null,"type": "txt","thumb": null,"createdAt": "2015-03-12T00:12:45.000Z"},{"id": 16,"senderId": 2,"receiverId": null,"receiverGroupId": null,"message": null,"file": "http://2.bp.blogspot.com/--bGNp_9rb28/UaLfT6-GggI/AAAAAAAAK6k/87XGAv_7WTA/s1600/4122574WTF_When_you_see_it_XD.jpg","type": "googleimage","thumb": null,"createdAt": "2015-03-12T00:15:28.000Z"},{"id": 17,"senderId": 2,"receiverId": null,"receiverGroupId": null,"message": null,"file": "o3bMSNWoeFw","type": "youtube","thumb": "https://i.ytimg.com/vi/o3bMSNWoeFw/hqdefault.jpg","createdAt": "2015-03-12T00:17:46.000Z"},{"id": 18,"senderId": 1,"receiverId": null,"receiverGroupId": null,"message": "hi there","file": null,"type": null,"thumb": null,"createdAt": "2015-03-12T02:31:56.000Z"},{"id": 19,"senderId": 1,"receiverId": null,"receiverGroupId": null,"message": "dfdsmk","file": null,"type": "txt","thumb": null,"createdAt": "2015-03-12T02:36:01.000Z"}]';
// echo $_POST['senderId'];
echo '[{"createdAt" : "2015-03-13T06:08:37.000Z","file" : null,"id" : 153,"message" : "hi","receiverGroupId" : null,"receiverId" : null,"senderId" : 2,"thumb" : null,"type" : "txt","updatedAt" : null}]'
?>