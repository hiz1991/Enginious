<?php
session_start();
$user=$_SESSION['user'];
include 'db.php';
include 'transl.php';
  // $firstTime=microtime();
$id = $_GET['id'];
$begin  = $_GET['begin'];
$end = $_GET['end'];
$bs=getTransBase();
$foundExactMatch=false;
$musicData = selectByIdDB("music", $id);
// var_dump($musicData);
$obj = mysql_fetch_object($musicData);
// echo $obj->url;
$date = date("Y-m-d-H-i-s");//date("Y-m-d-H-i-s",2);
$url = 'shared/'.$date.rand(0, 20000000000).'.mp3'; 
if($begin || $end)
{
    // echo $url;
    $shares = selectAllWithSpecificRowDB('share', ['songId', $id]);
    if(mysql_num_rows($shares)){
       while($row=mysql_fetch_array($shares)){
          if($row['begin']==$begin && $row['end']==$end){
            $foundExactMatch = true;
            $obj->url=$row['url'];
          }
       }
    }
    if(!$foundExactMatch){
      require_once './class.mp3.php';
      $mp3 = new mp3;
      $mp3->cut_mp3($obj->url, $url, round($begin/1000), round($end/1000), 'second', false);
      $obj->url = $url;
      recordInDB('share', ['songId', 'begin', 'end', 'url'], [$id, $begin, $end, $url]);
    }
}

// echo var_dump($obj);
// echo json_encode($obj);
mysql_close($db);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<!-- Website Design By: www.happyworm.com -->
<title>Enginous</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="JPlayer/lib/circle-player/skin/circle.player.css">
<script type="text/javascript" src="JPlayer/lib/jquery.min.js"></script>
<script type="text/javascript" src="JPlayer/dist/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="JPlayer/lib/circle-player/js/jquery.transform2d.js"></script>
<script type="text/javascript" src="JPlayer/lib/circle-player/js/jquery.grab.js"></script>
<script type="text/javascript" src="JPlayer/lib/circle-player/js/mod.csstransforms.min.js"></script>
<script type="text/javascript" src="JPlayer/lib/circle-player/js/circle.player.js"></script>
<style type="text/css">
  body{
    margin: 0px;
  }
  #spanArtistName
  {
    position: absolute;
    top: 10px;
    z-index: 5;
    color: grey;
    text-align: center;
    margin-left: 16px;
    padding: 0px;
    width: 170px;
  }
</style>

<script type="text/javascript">
//<![CDATA[

$(document).ready(function(){

  /*
   * Instance CirclePlayer inside jQuery doc ready
   *
   * CirclePlayer(jPlayerSelector, media, options)
   *   jPlayerSelector: url - The css selector of the jPlayer div.
   *   media: Object - The media object used in jPlayer("setMedia",media).
   *   options: Object - The jPlayer options.
   *
   * Multiple instances must set the cssSelectorAncestor in the jPlayer options. Defaults to "#cp_container_1" in CirclePlayer.
   *
   * The CirclePlayer uses the default supplied:"m4a, oga" if not given, which is different from the jPlayer default of supplied:"mp3"
   * Note that the {wmode:"window"} option is set to ensure playback in Firefox 3.6 with the Flash solution.
   * However, the OGA format would be used in this case with the HTML solution.
   */
  var obj = JSON.parse('<?php  echo json_encode($obj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);?>') ;
  console.log(obj.url);
  var myCirclePlayer = new CirclePlayer("#jquery_jplayer_1",
  {
    m4a: obj.url, 
    mp3: obj.url
    // m4a: "http://www.jplayer.org/audio/m4a/Miaow-07-Bubble.m4a",
    // oga: "http://www.jplayer.org/audio/ogg/Miaow-07-Bubble.ogg"
  }, {
    cssSelectorAncestor: "#cp_container_1",
    swfPath: "JPlayer/dist/jplayer",
    wmode: "window",
    keyEnabled: true
  });
});
  // console.log(obj); 
//]]>
</script>
</head>
<body>

      <!-- The jPlayer div must not be hidden. Keep it at the root of the body element to avoid any such problems. -->
      <div id="jquery_jplayer_1" class="cp-jplayer"></div>
      <span id="spanArtistName" ><?php echo $obj->artist.' - '.$obj->title; ?></span>

      <!-- The container for the interface can go where you want to display it. Show and hide it as you need. -->

      <div id="cp_container_1" class="cp-container">
        <div class="cp-buffer-holder"> <!-- .cp-gt50 only needed when buffer is > than 50% -->
          <div class="cp-buffer-1"></div>
          <div class="cp-buffer-2"></div>
        </div>
        <div class="cp-progress-holder"> <!-- .cp-gt50 only needed when progress is > than 50% -->
          <div class="cp-progress-1"></div>
          <div class="cp-progress-2"></div>
        </div>
        <div class="cp-circle-control"></div>
        <ul class="cp-controls">
          <li><a class="cp-play" tabindex="1">play</a></li>
          <li><a class="cp-pause" style="display:none;" tabindex="1">pause</a></li> <!-- Needs the inline style here, or jQuery.show() uses display:inline instead of display:block -->
        </ul>
      </div>

</body>

</html>