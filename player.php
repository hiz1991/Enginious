<?php 
include 'db.php';
include 'transl.php';
error_log($_SESSION['lang']);
if(!$_SESSION['lang'])
{
  $_SESSION['lang'] = $_GET['lang'];
}
$clientLang = $_SESSION['lang'];
// error_log($_GET['lang']);
$bs=getTransBase("player.php");?>
<!DOCTYPE html>
<html>
<head>
  <!-- <meta name="viewport" content="width=device-width, user-scalable=no"> -->
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <title>Enginious</title>
  <script type="text/javascript" src="jquery.min.js"></script>
  <script type="text/javascript" src="hui/classie.js"></script>
  <script type="text/javascript" src="jquery.scrollTo-1.4.3.1-min.js"></script>
  <script type="text/javascript" src="snap/snap.svg.js"></script>
  <!-- // <script src="lang/languageswitcher.js"></script> -->
  <script src="lang/language.js"></script>
  <script src="jquery-ui.js"></script>
  <script src="player.js"></script>
  <script src="hui/dropdown.js"></script> 
  <script src="cloudbeats.js"></script>
  <script src="dropzone/dropzone.js"></script>
  <script src="hui/jquery.ui-contextmenu.min.js" type="text/javascript"></script>
  <!-- // <script src="hui/taphold.js" type="text/javascript"></script> -->
  <!-- // <script src="http://vkontakte.ru/js/api/xd_connection.js" type="text/javascript"></script> -->
  <!-- // <script type="text/javascript" src="http://vkontakte.ru/js/api/openapi.js"></script> -->
  <script type="text/javascript" src="vk.js"></script>
  <script type="text/javascript" src="tubeUtil.js"></script>
  <link rel="stylesheet" type="text/css" href="player.css">
  <link rel="stylesheet" type="text/css" href="hui/dropdown.css">
  <link type="text/css" rel="stylesheet" href="hui/jquery-ui.css" />

  <!-- <link rel="stylesheet" href="../lang/languageswitcher.css"> -->
  <!-- // <script src="facebook.js"></script> -->
  <!-- // <script type="text/javascript" src="progressBar/progressbar.js"></script> -->
  <!-- // <script type="text/javascript" src="http://blurjs.com/blur.js"></script> -->
  <!-- <link rel="stylesheet" href="popover/jquery.webui-popover.css"> -->
  <!-- // <script src="popover/jquery.webui-popover.js"></script> -->
  <script src="recPanel/icheck.min.js"></script>
  <link href="recPanel/skins/all.css" rel="stylesheet">
  <link href="recPanel/test.css" rel="stylesheet">
  <script src="recPanel/ch.js"></script>

<script>
  var translObj;
  var language = "<?php echo $clientLang;?>";
  $(document).ready(function()
  {
    initKplayer();
    var el = document.createElement("script");el.type = "text/javascript";el.src = "//vk.com/js/api/openapi.js";el.async = true;document.getElementById("vk_api_transport").appendChild(el); 
     //searchBarText Select
    $("#tags").on("focus",function(e){  keyboardControl=false;  $(this).select();});   
    $("#tags").on("blur",function(e){  keyboardControl=true; $("#ui-id-48").hide();});   
    $("#tags").on("mouseup",function(e){   return false;});

    // setTimeout(function(){loadStats();}, 4000);
    $(".menu.menu--open .morph-shape").css("height", "300px");

    translObj = JSON.parse('<?php  $json = getTransJson($bs); echo $json;?>') ;
    // console.log(translObj); 
      // performTranslation();
    // $("#settingsIcon").webuiPopover({content:$('#bgChangerPane').html()});
    $("#polyglot-language-options").change(function(s) {
      language = $(this).children(":selected").attr("id");
      performTranslation($(".ui-helper-hidden > li > a"));
      translIframe();
      saveLangOnDB();
    })
      // $(".popUp").click(function(str){$("#"+str.target.id+"").fadeOut(200);})
    setTimeout(function(){ 
      updateArtwork();
    }, 1000);
    setTimeout(function(){ 
      translIframe();
    }, 2000);
    var checked = new ch.init('flat','blue') //recc option checker

    remoteIni()

    $(window).on('dragenter', function(){
        $('#uploadFrameDisplayer').show();enableDocClick()
    });

  }); 
</script>

</head>
<body>
  <ul id="options" style="display: none;z-index:5000; position:absolute;">
    <li><a href="#action1"><span class="ui-icon custom-icon-firefox"></span>Action 1</a>
      <li>----
        <li><a>Extra</a>
          <ul>
            <li><a href="#action4">sub4</a>
              <li><a href="#action5">sub5</a>
              </ul>
            </ul>
            <!-- <div id="test" style="width:500px; height:500px;top:0;position:absolute; z-index:100000; background:white"></div> -->
            <div id="container"> 

              <div class="settings">
           <!--
          <div class="selector">
          <select><option value="not loaded">Playlists not loaded</option></select>
          </div>
        -->
        <div class="selector">
         <div class="wrapper-demo">


          <nav id="menu" class="menu" >
            <div class="morph-shape" data-morph-open="M260,500H0c0,0,8-120,8-250C8,110,0,0,0,0h260c0,0-8,110-8,250C252,380,260,500,260,500z">
              <svg width="100%" height="100%" viewBox="0 0 260 500" preserveAspectRatio="none">
                <path fill="none" d="M260,500C260,500,0,500,0,500C0,500,0,380,0,250C0,110,0,0,0,0C0,0,260,0,260,0C260,0,260,110,260,250C260,380,260,500,260,500C260,500,260,500,260,500"></path>
                <desc>Created with Snap</desc><defs></defs></svg>
              </div>
            </nav>



            <div id="dd" class="wrapper-dropdown-3" tabindex="1">
             <img src="images/playlists.svg" alt="playlists" style="vertical-align: sub;"></img>
             <span class="button translatable" style="box-shadow:none; margin:0px;padding: 0px;"><?php echo trans("Playlists", $bs); ?></span>
             <div id="dropdownSlider">
              <ul class="dropdown">
                <li><a href="#">No Playlists</a></li>
              </ul>
              <div id="addNewPlaylist">
               <input id="newPlaylistName" />
               <div class="button translatable" style="padding:4px; height:22;" onclick="appendPlaylists($('#newPlaylistName').val());"><?php echo trans("Add", $bs); ?></div>
             </div>
           </div>
         </div>
       </div>
       <div id="VKSearchEnabler" class="button" onclick="toggleVKSearchEnabler()">VK
       </div>
       <div class="searchBar">
         <input id="tags" class="tagsSearchImage"/>
       </div>
       <div id="uploadIcon" class="button" onclick="$('#uploadFrameDisplayer').show();enableDocClick()">
         <img src="defaultTheme/images/upload.svg">
       </div>
     </div>
     <div id="lyricsButton" class="button" onclick="changeMode('lyrics');"><span class="translatable"><?php echo trans("Store", $bs); ?></span></div>
              <!-- <div id="artworkButton" class="button buttonPressed" onclick="changeMode('artwork');" style="opacity:0.01;"><span>Artwork</span></div>
              <div id="youtubeButton" class="button" onclick="changeMode('youtube');" style="opacity:0.01;"><span>Youtube</span></div> -->
              <div id="artworkButton" class="button buttonPressed" onclick="changeMode('artwork');" ><span class="translatable"><?php echo trans("Artwork", $bs); ?></span></div>
              <div id="youtubeButton" class="button" onclick="changeMode('youtube');" ><span class="translatable"><?php echo trans("Youtube", $bs); ?></span></div>

              <div id="VKConnectbutton" class="button" onclick="initiateVKButton();"><span>Connect to VK</span></div>
              <!--               <div id="Upload" class="button" onclick="pickFlash();"><span>Upload Music</span></div> -->
              <!-- <div id="Upload" class="button" onclick="$('#uploadFrameDisplayer').show();"><span class="translatable"><?php echo trans("Upload Music", $bs); ?></span></div> -->
              <div id="settingsIcon" style="display:inline-block;float: right;" onclick="showbg()" class="button">
              <!-- onclick="showbg()" -->
                <img src="images/settings.svg" height="22px" style="vertical-align: sub;" />
              </div>
              
            </div><!-- settings -->
            <div class="playlist">
            </div> 

            <div class="art">
              <div class="artHolder">
                <!-- <img id="artworkBig" src="images/artwork.svg" /> -->
                <!-- <div id="signature">Default</div> -->
              </div> 
              <div id="lyricsHolder"><!-- <div id="lyricsContainer">No Lyrics found. Sorry(:</div> -->
                    <div id='recommendationFilterContainer' class='recommendationFilterContainer' style="position:absolute;">
                      <span class="recommendation translatable"><?php echo trans("Recommendations: ", $bs); ?></span>
                      <span id='checkboxesButton' class='checkboxesButton'>
                        <span id="checkboxesValues" class="translatable"><?php echo trans("All", $bs); ?></span>
                        <img src="recPanel/da.svg" alt="Down arrow">
                      </span>

                      <div id="checkboxesContainer" class="checkboxesContainer">
                        <label class="translatable" for="checkbox1" ><?php echo trans("Artist", $bs); ?></label>
                        <input type="checkbox" id='checkbox1'checked>
                        <label class="translatable" for="checkbox2" ><?php echo trans("Volume", $bs); ?></label>
                        <input type="checkbox" id='checkbox2' checked>

                        <label class="translatable" for="checkbox3" ><?php echo trans("Tempo", $bs); ?></label>
                        <input type="checkbox" id='checkbox3'checked>
                        <label class="translatable" for="checkbox4" ><?php echo trans("Pitch", $bs); ?></label>
                        <input type="checkbox" id='checkbox4' checked>

                        <label class="translatable" for="checkbox5" ><?php echo trans("Genre", $bs); ?></label>
                        <input type="checkbox" id='checkbox5' checked>
                        <label class="translatable" for="checkbox6" ><?php echo trans("Year", $bs); ?></label>
                        <input type="checkbox" id='checkbox6'checked>
                        <img src="recPanel/refresh.svg" onclick="getUser('recs')">
                      </div>
                    </div>
               <div id="recContainer"></div>
              </div>
            <div id="youtube">
              <div id='containterYoutubeOutMost'>
                <div id='youtubeThumbsContainer'></div>
              </div>
              <div id="YTPlayer"></div>
            </div>
             <!-- <iframe src="http://www.azlyrics.com/lyrics/rihanna/unfaithful.html"  sandbox="allow-forms allow-scripts" width="500px%" height="500px" align="center" allowTransparency > -->
            <!-- </iframe> -->
          </div> 
          <div class="player">
            <div class="prev secondaryFunctionality">
              <img src="defaultTheme/images/bc.svg"  alt="previous"/>
            </div>
            <!--prev-->
            <!-- <a class="play">&#x25BA;</a> -->
            <div class="play">
              <img src="defaultTheme/images/play-grey.svg"  id="playButton" alt="play"/>
              <img src="defaultTheme/images/pause.svg" id="pauseButton" alt="pause"/>
              <!-- &#x25BA; -->
            </div>
            <div class="next secondaryFunctionality">
              <img src="defaultTheme/images/ff.svg"  alt="next"/>
              <!--next-->
            </div>
            <div id="seekbar">
              <div id="indicator" style="display:none;">
              </div>
              <!-- <a id="seeker">seeker</a> -->
              <div id="playedContainer">
                <div id="played">
                  <!--seeker-->
                </div>                        
              </div>
              <div id="buffered">
               <!-- progress-->
             </div>
           </div>
           <div id="volume">
            <div id="volumeIndicator" style="display:none;">
              <!--  indi-->
            </div>
            <div id="level">
              <!--level-->
            </div>
          </div>
          <div class="repeat secondaryFunctionality">
            <img src="defaultTheme/images/repeat.svg" alt="repeat"/>
            <!--repeat-->
          </div>
          <div class="shuffle secondaryFunctionality">
            <img src="defaultTheme/images/shuffle.svg" alt="repeat"/>
            <!--shuffle-->
          </div>
          <div class="share secondaryFunctionality">
            <img src="defaultTheme/images/share.svg" alt="share"/>
            <!--share-->
          </div>
        </div>
        <div id="fader">   <p>Processing...</p>
          <div id="progressBar" class="jquery-ui-like">
            <div class="jquery-ui-like-content">
            </div>
          </div>
        </div>
        <div id="stats" class="popUp">
          <div id='statsPane'>
          </div>  
          <div class="button" style="position:absolute; bottom:11%;right:25%;color:white; background:#4da6ff;z-index:1001" onclick='$("#stats").fadeOut();'>Ok</div>                 
        </div>
        <div id="sharePopUp" class="popUp">
          <div id='sharePopUpPane'>
            <object type="application/x-shockwave-flash" data="drawer.swf" width="1000" height="453" id="drawer" style="float: none; vertical-align:middle">
              <param name="movie" value="drawer.swf" />
              <param name="quality" value="high" />
              <param name="bgcolor" value="#ededed" />
              <param name="play" value="true" />
              <param name="loop" value="true" />
              <param name="wmode" value="window" />
              <param name="scale" value="showall" />
              <param name="menu" value="true" />
              <param name="devicefont" value="false" />
              <param name="salign" value="" />
              <param name="allowScriptAccess" value="sameDomain" />
              <a href="http://www.adobe.com/go/getflash">
                <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
              </a>
            </object>
            <div id="shareSpanContainer">
              <textarea id="sharePopUpPaneSpan"></textarea>
            </div>
          </div> 
          <div class="button" style="position:absolute; bottom:11%;right:16%;color:white; background:#4da6ff;z-index:1001" onclick='$("#sharePopUp").fadeOut();'>Ok</div>                 
        </div>
        <div id="bgChanger" class="popUp">
        <!-- <div class="arrow"></div> -->
         <div id='bgChangerPane'>
           <div id="logout" class="button" onclick="logout();" style="float:right;margin: 10px;display: inline-block;">
              <span class="translatable"><?php echo trans("Logout", $bs); ?></span>
              <div id="username" style="margin-left:6px;display: inline-block;"></div>
           </div>
           <p id='settingsPaneLabel' class="translatable"><?php echo trans("Settings:", $bs); ?></p>
           <p class="settingsHeadings translatable" ><?php echo trans("Background", $bs); ?></p>
           <div>
             <input id="urlInput" type="textarea" placeholder="<?php echo trans("type URL", $bs); ?>" />
           </div>
           <div id="bgsThumbsContainer">
             <div>
             </div> 
           </div>
           <p class="settingsHeadings translatable"><?php echo trans("Language", $bs); ?></p>
           <div id="polyglotLanguageSwitcher">
            <form action="#">
              <select id="polyglot-language-options">
                <option <?php if($clientLang=="ru") echo 'selected="selected"'; ?> id="ru" value="ru">Русский</option>
                <option <?php if($clientLang=="en") echo 'selected="selected"'; ?> id="en" value="en">English</option>
                <option <?php if($clientLang=="fr") echo 'selected="selected"'; ?> id="fr" value="fr">Fran&ccedil;ais</option>
                <option <?php if($clientLang=="de") echo 'selected="selected"'; ?> id="de" value="de">Deutsch</option>
                <option <?php if($clientLang=="zh-TW") echo 'selected="selected"'; ?> id="zh-TW" value="zh-TW">中國傳統</option>
              </select>
            </form>
          </div>
        </div>  
        <div class="button translatable" style="position:absolute; bottom:11%;right:25%;color:white; background:#4da6ff;z-index:1001" onclick='$("#bgChanger").fadeOut();
        setTimeout(function(){changeBackground();}, 500);

        '><?php echo trans("Save", $bs); ?></div>                 
      </div>

      <div id="uploadFrameDisplayer" class="popUp">
        <div id='uploadFrameDisplayerPane'>
          <iframe id = "uploadFrame" src="/uploader/index.html" FRAMEBORDER=0 style="position:absolute; width:100%; height:90%; "> </iframe>
              <!-- <form id="upload" method="post" action="upload.php" enctype="multipart/form-data"> -->
              <!-- <div id="drop" style="display:block;"> -->
                <!-- Drop Here -->

                <!-- <a>Browse</a> -->
                <!-- <input type="file" name="upl" multiple /> -->
              <!-- </div> -->
<!-- 
              <ul>
                The file uploads will be shown here
              </ul>

            </form> -->
                
            <!-- JavaScript Includes -->
            <!-- // <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->

        </div>  
        <div>
         <div style="    position: absolute;     z-index: 50000;     color: black;     margin-left: 27%; bottom: 11%; font-family: myFirstFont;"><input type="checkbox" id="showStatsCheck" > <span class="translatable"><?php echo trans("Show stats on complete", $bs); ?></span>
         </div>
         <div class="button translatable" style="position:absolute; bottom:11%;right:26.2%;color:white; background:#4da6ff;z-index:1001" onclick='$("#uploadFrameDisplayer").fadeOut();
         setTimeout(function(){renewPlaylist();}, 300);
         if($("#showStatsCheck").is(":checked")){
         setTimeout(function(){loadStats();}, 2000);
       };'><?php echo trans("Hide", $bs); ?></div>    
     </div>

<!--           <div class="facebook">
</div> -->
<div id="vk_api_transport"></div>
</div> <!-- container -->
<script>
  var dropDownBackground;
  (function() {
    function SVGDDMenu( el, options ) {
      this.el = el;
      this.init();
    }

    SVGDDMenu.prototype.init = function() {
      this.shapeEl = this.el.querySelector( 'div.morph-shape' );

      var s = Snap( this.shapeEl.querySelector( 'svg' ) );
      this.pathEl = s.select( 'path' );
      this.paths = {
        reset : this.pathEl.attr( 'd' ),
        open : this.shapeEl.getAttribute( 'data-morph-open' )
      };

      this.isOpen = false;

    // this.initEvents();
  };

  SVGDDMenu.prototype.close = function() {
    var self = this;

    classie.remove( self.el, 'menu--open' );
    this.pathEl.stop().animate( { 'path' : this.paths.open }, 150, mina.easeinout, function() {
      self.pathEl.stop().animate( { 'path' : self.paths.reset }, 150, mina.elastic );
    } );
  };

  SVGDDMenu.prototype.open = function() {
    var self = this;

    classie.add( self.el, 'menu--open' );
    this.pathEl.stop().animate( { 'path' : this.paths.open }, 150, mina.easeinout, function() {
      self.pathEl.stop().animate( { 'path' : self.paths.reset }, 150, mina.elastic );
    } );
  };
  // SVGDDMenu.prototype.initEvents = function() {
  //   // dd.addEventListener( 'click', this.toggle.bind(this) );

  //   // For Demo purposes only
  //   [].slice.call( this.el.querySelectorAll('a') ).forEach( function(el) {
  //     el.onclick = function() { return false; }
  //   } );
  // };

  SVGDDMenu.prototype.toggle = function() {
    var self = this;

    if( this.isOpen ) {
      classie.remove( self.el, 'menu--open' );
    }
    else {
      classie.add( self.el, 'menu--open' );
    }

    this.pathEl.stop().animate( { 'path' : this.paths.open }, 500, mina.easeinout, function() {
      self.pathEl.stop().animate( { 'path' : self.paths.reset }, 300, mina.elastic );
    } );

    this.isOpen = !this.isOpen; 
  };

  dropDownBackground = new SVGDDMenu( document.getElementById( 'menu' ) );
  // menuBg.toggle();
})();
</script>
</body>
</html>