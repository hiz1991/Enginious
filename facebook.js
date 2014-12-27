function puaseTrigger(){pauseButton();}
function pauseFacebook()
{
  aFile.pause();$(currentlyPlaying+" > img").replaceWith("<img src='images/play-grey.svg' />");
}
var aFile = document.createElement("audio");
var lastSongUrls;
var currentlyPlaying;
function playOrpause(element, index) 
{
    aFile.paused?playFaceSong(element,index):pauseFaceSong(element, index);
}
function pauseFaceSong(element, index)
{
    aFile.pause();
    $(currentlyPlaying+" > img").replaceWith("<img src='images/play-grey.svg' />");
    if(element!=currentlyPlaying){playFaceSong(element, index);}
}
function playFaceSong(element, index)
{ 
   //alert(parseInt(getVolume())/100);
    $(currentlyPlaying+" > img").replaceWith("<img src='images/play-grey.svg' />");
    aFile.setAttribute("src", lastSongUrls[index]);
    aFile.volume=parseInt(getVolume())/100;
    aFile.play(); 
    currentlyPlaying="#friendSong"+index;
    $(currentlyPlaying+" > img").replaceWith("<img src='images/pause.svg' />");
}
function facebookIni(user)
{

     
        var data = 
    {
        "names":"Unknown Names",
        "ids":"3",
    };
  
    loadFriendsFromXML(user+'/friends.xml'); //pickFlash();
 
    function loadFriendsFromXML(xmlFile) 
    {
      $.get(xmlFile, function(xml)
      {  
         data.names = $(xml).find('name'); 
         data.ids = $(xml).find('id'); 
         loadLastSongs();
    
      });
   }
   function buldLists(lastSongs, lastSongUrls)
   {
      $.each(data.ids, function( index, value ) 
    {
    var whatToAdd = "";
    if(lastSongUrls[index]!="" && lastSongUrls[index]!="null"){whatToAdd="<img src='images/play-grey.svg' alt='play' />"}

      $(".facebook").append("<div id=friend"+index+">"
        +"<div class='artInPlaylist'><img src='https://graph.facebook.com/"+data.ids.eq(index).text()+"/picture?width=300&height=300"
        +"'alt='art' /></div>"
        +"<div class='spanContainer'><span class='artist'>"
        +data.names.eq(index).text()+"</span>"
        +"<span class='title'>"
        +lastSongs[index]+"</span></div><div class='miniPlayer' id=friendSong"+index+">"+whatToAdd+"</div></div>");

      if(lastSongUrls[index]!="" && lastSongUrls[index]!="null")
      {
              $("#friendSong"+index).on("click", function()
              {//alert(lastSongUrls[index]);
              puaseTrigger();
             // if(aFile.paused){
              //aFile.setAttribute("src", "http://cloudbeats.net/100001430183965/samples/01_Incomplete.mp3");}
              //currentlyPlaying="#friendSong"+index;
              playOrpause("#friendSong"+index, index);
              });
      }

      
    });
   }
  function changeSongBackFacebook(fileNumber)
  {
     $("#song"+fileNumber).css({background: "#7abcff"});
	$("#song"+fileNumber).css({background: "-moz-linear-gradient(top, #7abcff 0%, #60abf8 44%, #4096ee 100%)"});
	$("#song"+fileNumber).css({background: "-webkit-gradient(linear, left top, left bottom, color-stop(0%,#7abcff), color-stop(44%,#60abf8), color-stop(100%,#4096ee))"});
	$("#song"+fileNumber).css({background: "-webkit-linear-gradient(top, #7abcff 0%,#60abf8 44%,#4096ee 100%)"});
	$("#song"+fileNumber).css({background: "-o-linear-gradient(top, #7abcff 0%,#60abf8 44%,#4096ee 100%)"});
	$("#song"+fileNumber).css({background: "-ms-linear-gradient(top, #7abcff 0%,#60abf8 44%,#4096ee 100%)"});
	$("#song"+fileNumber).css({background: "linear-gradient(to bottom, #7abcff 0%,#60abf8 44%,#4096ee 100%)"});
	$("#song"+fileNumber).css({filter: "progid:DXImageTransform.Microsoft.gradient( startColorstr='#7abcff', endColorstr='#4096ee',GradientType=0 )"});
	$("#song"+fileNumber+" span").css('color', '#ffffff');
  }

  function removeSongBackFacebook(fileNumber)
  {
   $("#song"+fileNumber).removeAttr('style');
   $("#song"+fileNumber+" span").removeAttr('style');
  }

  function loadLastSongs()
  {
   var url = "http://cloudbeats.net/friendsLastSong.php?action=getSong&users=";
   $.each(data.ids, function( index, value )
   {
     url=url+data.ids.eq(index).text()+"/__/";
   });
   //alert(url);
   loadXMLDoc(url);
       function loadXMLDoc(url)
       {
       var xmlhttp;
       if (window.XMLHttpRequest)
       {// code for IE7+, Firefox, Chrome, Opera, Safari
       xmlhttp=new XMLHttpRequest();
       }
       else
       {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
       }
       xmlhttp.onreadystatechange=function()
       {
       if (xmlhttp.readyState==4 && xmlhttp.status==200)
       {
        var first = xmlhttp.responseText.split("&");
        var second=first[0].split("=");
        var three=second[1]; 
        var lastSongs = three.split("<__>"); //alert(lastSongs);
        
        first = xmlhttp.responseText.split("&");
        second=first[1].split("=");
        three=second[1]; 
        lastSongUrls = three.split("<__>"); //alert(lastSongUrls);
        $.each(lastSongs, function( index, value )
        {
           if(lastSongs[index]=="null" || lastSongs[index]=="")
           {
	           lastSongs[index]="No music ";
           }
           else{ lastSongs[index]=lastSongs[index].replace("/__/", " - ");}
           
        });
        
        buldLists(lastSongs, lastSongUrls);
       }
       }
       xmlhttp.open("GET",url,true);
      xmlhttp.send();
       }
  }//loadLastSongs()
};