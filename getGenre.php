<?php
function getGenre($value=0)
{
  $array=[
"0" => "Blues",
"1" => "Classic Rock",
"2" => "Country",
"3" => "Dance",
"4" => "Disco",
"5" => "Funk",
"6" => "Grunge",
"7" => "Hip-Hop",
"8" => "Jazz",
"9" => "Metal",
"10" => "New Age",
"11" => "Oldies",
"12" => "Other",
"13" => "Pop",
"14" => "R&B",
"15" => "Rap",
"16" => "Reggae",
"17" => "Rock",
"18" => "Techno",
"19" => "Industrial",
"20" => "Alternative",
"21" => "Ska",
"22" => "Death Metal",
"23" => "Pranks",
"24" => "Soundtrack",
"25" => "Euro-Techno",
"26" => "Ambient",
"27" => "Trip-Hop",
"28" => "Vocal",
"29" => "Jazz+Funk",
"30" => "Fusion",
"31" => "Trance",
"32" => "Classical",
"33" => "Instrumental",
"34" => "Acid",
"35" => "House",
"36" => "Game",
"37" => "Sound Clip",
"38" => "Gospel",
"39" => "Noise",
"40" => "AlternRock",
"41" => "Bass",
"42" => "Soul",
"43" => "Punk",
"44" => "Space",
"45" => "Meditative",
"46" => "Instrumental Pop",
"47" => "Instrumental Rock",
"48" => "Ethnic",
"49" => "Gothic",
"50" => "Darkwave",
"51" => "Techno-Industrial",
"52" => "Electronic",
"53" => "Pop-Folk",
"54" => "Eurodance",
"55" => "Dream",
"56" => "Southern Rock",
"57" => "Comedy",
"58" => "Cult",
"59" => "Gangsta",
"60" => "Top 40",
"61" => "Christian Rap",
"62" => "Pop/Funk",
"63" => "Jungle",
"64" => "Native American",
"65" => "Cabaret",
"66" => "New Wave",
"67" => "Psychadelic",
"68" => "Rave",
"69" => "Showtunes",
"70" => "Trailer",
"71" => "Lo-Fi",
"72" => "Tribal",
"73" => "Acid Punk",
"74" => "Acid Jazz",
"75" => "Polka",
"76" => "Retro",
"77" => "Musical",
"78" => "Rock & Roll",
"79" => "Hard Rock"
  ];
  return $array[$value];
  // return "frfr";
}
// include("getid3/get",i"d3" => "php");
// 			$mp3file=new MP3_data(); 
// 		$mp3file->getid3('test.mp3');

// 	//	include("getid3/getid3.php");
// 		$getID3 = new getID3; 
// 			// $ThisFileInfo = $getID3cut->analyze('/Insatiable.mp3');
// 					// $mp3file=new MP3_data(); 
// 		// $ThisFileInfo = $getID3->analyze($upload_directory."/" . $name); 
// 		// $mp3file->getid3('/Insatiable.mp3');
// 		var_dump($mp3file->genre);
// 		echo hexdec($mp3file->genre);


?>