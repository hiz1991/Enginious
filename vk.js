var VKId;
var toggleVKSearchEnabled=false;
function initiateVKButton()
{
  //Playlists.push("VK"); //console.log("playlists",Playlists);
  initiateVK();
}
function initiateVK() {
    VK.init({
      apiId: 4148557
    });
    loginVK(); //alert("wonder");
  };
  setTimeout(function() {
    var el = document.createElement("script");
    el.type = "text/javascript";
    el.src = "//vk.com/js/api/openapi.js";
    el.async = true;
    //document.getElementById("vk_api_transport").appendChild(el);
  }, 0);
  // setTimeout(function() {
  //   loginVK();
  // }, 8000);
  function loginVK(){window.scrollTo(0, 1);//alert("triggered"); 
  VK.Auth.getLoginStatus(function(answer){console.log(answer);
  if(answer.status=="connected" && answer.session!=null)
  {
    if($("#VKConnectbutton").is(':visible')) 
    {
        syncServer(null, "addNewPS", "VK");
        $("#VKConnectbutton").hide();
    }
    VKgetMusic(answer);
  }
    else
      {
        VK.Auth.login(authInfoVK,8); //alert("hi");
      }
  });
}
  function authInfoVK(response) { console.log(response);
  if (response.session) {
        if($("#VKConnectbutton").is(':visible')) 
        {
            syncServer(null, "addNewPS", "VK");
            $("#VKConnectbutton").hide();
        }
    //alert('user: '+response.session.mid);console.log(response.settings);
        setTimeout(function() 
                  {
                     VKId=response.session.mid;
                     VKgetMusic(response);
                   }, 3000)
        }
   else {
    //alert('not auth');
  }
}
function VKgetMusic(source)
{

  VK.api("audio.get", {uid:VKId}, function(data) {console.log(data);
    VKMusic = data; 
    if(source=="handleVKAdding")
    {
      setCurrentPlaylist("VK");
    }
  });
   
 }
 function searchLyricsVK(name, source)
 {
   VK.api("audio.search", {q:name, auto_complete:1, lyrics:1, performer_only:0, sort:2, search_own:0, offset:0,count:10}, function(response){
      //console.log(response); 
          function displayNoLyrics()
          {
           $("#lyricsContainer").empty(); 
           strTempTemp='No Lyrics found. Sorry(:';
           $("#lyricsContainer").append(strTempTemp); 
          }
          if(response.response.length==1)//not found
          {
             displayNoLyrics();
          }
          else if(response.response[1].lyrics_id!=null && response.response.length>=2)//found
          {
           //console.log(response.response);
              var foundLongLyrics=false;
              //for(var i=0, l=response.response.length; i<l;i++)
              var count=0;
              function fetchLyrics()
              {
                if(count<response.response.length)
                { 
                  if(foundLongLyrics){}
                  else
                  {
                    VK.api("audio.getLyrics", {lyrics_id:response.response[count+1].lyrics_id}, checkLength);
                    count++;
                  }
                }
              } 
              fetchLyrics();
              function checkLength(lyrResp)
              {//console.log(lyrResp);//alert("called");
              if(lyrResp.response)
               { 
                  if(lyrResp.response.text.length>500)
                  {
                    console.log(foundLongLyrics);
                    foundLongLyrics=true;
                   $("#lyricsContainer").empty();
                   $("#lyricsContainer").append(lyrResp.response.text.replace(/\n/g, '<br />'));
                   // console.log(lyrResp.response.text.length);
                   $(".lyricsHolder").animate({ scrollTop: 0}, 'slow');
                   //flip($('.lyricsHolder'));
                  }
                  else fetchLyrics();
                }
              else return false;//error received
              }
              setTimeout(function(){ 
                                    console.log("found",foundLongLyrics);
                                    if(!foundLongLyrics)
                                    {
                                      displayNoLyrics();
                                    }
                      }
              , 1000);
          }
  }) //http://vk.com/dev/audio.search
     
 }
function toggleVKSearchEnabler()
{ 
  if(!toggleVKSearchEnabled)
  {
  toggleVKSearchEnabled=true;
  $("#VKSearchEnabler").addClass("buttonPressed");
  $( "#tags" ).autocomplete({
      source: "VK"//$.merge(forMerge, cleanedArr)
    });
  }
  else
  {
    toggleVKSearchEnabled=false; 
    $("#VKSearchEnabler").removeClass("buttonPressed");
    feedAutoComplete();
  }
}
function handleVKAdding(id,owner_id)
{//alert('handleVKAdding');
  VK.api("audio.add", {aid:id, oid:owner_id}, function(data){
    VKgetMusic("handleVKAdding");
  });
}