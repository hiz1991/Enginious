var total;
var number=0;
var recData={};
var buyButtonLabel;
function counter()
{ 
  number++;
  progressBar(Math.round(number/total*100), $('#progressBar')); 
  if(number==total)
  {
     setTimeout(function() {   //calls click event after a certain time
                           $('#fader').hide();
                           loadStats();
                           }, 500);
  }
}
function pickFlash(){//alert("cloudbeats,js");
	    setCurrentPlaylist("All Music");
		var total;
		filepicker.setKey('A9HiK2hs0S5qs3Rj9KQy3z');
	    filepicker.pickMultiple({
		    mimetypes: ['audio/mpeg','audio/mp3'],
		    container: 'window',
		    services:['COMPUTER', 'DROPBOX', 'GOOGLE_DRIVE', 'GMAIL', 'URL'],
		  },
		  function(FPFile){
		    get(FPFile);
		  },
		  function(FPError){
		    console.log(FPError.toString());
		  }
		);
	    };

	function get(fpfiles){
	out='';names='';
	total=fpfiles.length; 
	progressBar(1, $('#progressBar')); 
	$('#fader').show();
	number=0;
	for(var i=0;i<fpfiles.length;i++)
	{out=fpfiles[i].url;
	 names=fpfiles[i].filename;
	store(out, names);
	};
	
	}
	function store(out, names){
	dataString = out ;
	var jsonString = JSON.stringify(dataString);
	var namesArray = JSON.stringify(names);
	   $.ajax({
	        type: "POST",
	        url: "upload3.php",
	        data: {data : jsonString, fileNames: namesArray}, 
	        cache: false,

	        success: function(answer){
		 counter();//flashObj.tellFlashToIncrease();
   // alert(answer);
setTimeout(rel, 2000);
	        }
	    });
	}
function rel() {   //calls click event after a certain time
                       renewPlaylist();
                           }	
	
function updateIcon(state, name)
{
	if (state=="Playing: ")
	{
		changeFavicon('favicon2.png');
		document.title =state + " " + name;
	}
	else 
	{
		changeFavicon('favicon.png');
		document.title =state + " " + name;
	}
}//player
function changeBackground()
{
	var receivedValue=$("#urlInput").val();
	if (receivedValue!="")
	{
		$("body").css("background", "url('"+receivedValue+"')");
		$("body").css("background-size", "cover");
		  // background-repeat: no-repeat;
        $.ajax({
		    url : "syncServer.php?command=saveBg&argument="+receivedValue,
		    type: "GET",
		    success: function(data)
		     {		     }  
        });// http://localhost:8888/syncServer.php?command=saveBg&argument=images
	}
}
function showbg()
{
	$("#bgChanger").show();
	enableDocClick();
	fetchBgs();
}
function fetchBgs()
{
   syncServer(null, "fetchBgs", null);
}
function bgsThumbsClick(data)
{
	$("#urlInput").val(data.src);
	// console.log(data.src);
}
function changeFavicon(src)
{
       var link = document.createElement('link'),
       oldLink = document.getElementById('dynamic-favicon');
       link.id = 'dynamic-favicon';
       link.rel = 'shortcut icon';
       link.href = src;
       if (oldLink)
       {
          document.head.removeChild(oldLink);
       }
       document.head.appendChild(link);
}	

function logout()
{
         $.ajax({
		 url : "/logout.php",
		//data: args,
		type: "GET",
		success: function()
		 {
		window.location.replace("/");
		 }  //pickFlash();
	      });
	
}
function loadStats()
{

    $.ajax({
		    url : "/analyseLibrary.php",
		    //data: args,
		    type: "GET",
		    success: function(data)
		     {
		        statsShow(data);
		     }  
        });
}
function statsShow(dataPassed)
{
      smth = $.parseJSON(dataPassed);
      $("#statsPane").empty();
      $("#statsPane").append('<p id="statsPaneLabel">'+translate("Library analysis results")+':</p>'); 
      var i=0;
      for(var k in smth.Response)// alert(k);
      {
      	// console.log(jQuery.type(smth.Response[k]));
      	if(jQuery.type(smth.Response[k])!="object"){
      	  if(k=="distribution")
      	  {
      	  	$("#statsPane").append("<div> <div class='statsDescriptors' ><span class='statsSpan'>"+breakCamelCaseAndTransl(k)+"</span></div> <svg class='statsIndicatorsContainersDistribution' height='30px'  id='svgPlace'></svg> </div>");
      	  	drawWaveForm("svgPlace", smth.Response[k], 220, 30);
      	  }
      	  else{
	          if(jQuery.type(smth.Response[k])=="number" && smth.Response[k]<=100){
	            $("#statsPane").append("<div> <div class='statsDescriptors' ><span class='statsSpan'>"+breakCamelCaseAndTransl(k)+"</span></div> <div class='statsIndicatorsContainers' id='container"+i+"'></div><div class='statsNumberContainers' >"+smth.Response[k]+"</div> </div>");
	          	$("#container"+i).append("    <svg class='svg' id='"+"svg"+i+"' style='width: "+$("#container"+i).width()+"px'/></svg>");
	            populateSvg('svg'+i, (smth.Response[k]<=100&&smth.Response[k]!=null)?smth.Response[k]:0);
	          }
	          else{
	          	$("#statsPane").append("<div> <div class='statsDescriptors' ><span class='statsSpan'>"+breakCamelCaseAndTransl(k)+"</span></div> <div class='statsIndicatorsContainers' id='container"+i+"'></div><div class='statsNumberContainers' >"+smth.Response[k]+"</div> </div>");
	          }
	      }
        }
          i++;
      }
      $("#stats").fadeIn();
      enableDocClick();
}

function breakCamelCaseAndTransl(str)
{
	var withSpaces=str.replace(/([A-Z])/g, ' $1');
	// withSpaces=str.replace(/([A-Z])/g, function(str){ return str.toLowerCase(); });
	var arr=withSpaces.split(" ");
	console.log(arr);
	var result="";
	$.each(arr, function( index, value)
    {
       	 arr[index] = translate(arr[index]);
       	 result+=arr[index].toLowerCase()+" ";
    });
    return result;

}
function remoteIni()
{
  unset()
  window.setInterval(remoteUpdate, 1000);
  function remoteUpdate()
  {
          $.ajax({
		 url : "/remote.php",
		//data: args,
		type: "GET",
		success: function(answer)
		 {
		  switch(answer)
		  {
		    case "playPause": 
		    	if(isPlaying()){
		    		playButton()
		    		unset(); 
		    		break;
		    	} else {
		    		pauseButton();
		    		unset(); 
		    		break;
		    	}
		    case "pause": pauseButton();unset(); break;
		    case "next": 
		    	if(autoNext){nextSong()}  
		    	unset(); 
		    	break;
		    case "prev":
		    	if(autoNext){prevSong()}
		     	unset(); 
		     	break;
		    case "volumeUp": volume(getVolume()+8);unset(); break;
		    case "volumeDown": volume(getVolume()-8);unset(); break;
		  }
		 } 
	      });

  }
}
function unset()
{
  $.ajax({
		 url : "/remote.php?set=%20",
	 //data: args,
	 type: "GET",
	 success: function()
	  {
	  }  
  });
}
function populateSvg(svgId, percent)
{
	// console.log(container);
	// console.log(svgId);
	var rect = Snap("#"+svgId).rect(0, 0, 1, 30);
	rect.attr({
		fill: "orange",
		rx: "15",
	    ry: "15"
	})
	Snap.animate(0, 10, function (val) {
	rect.animate(val, mina.easein);
	}, 0, mina.easein);

	// in given context is equivalent to
	rect.animate({width:$("#"+svgId).width()*(percent/100), height:30}, 2000, mina.easein);
}
function swfLoaded(value)
{
	console.log("passDataToFlash");
	passDataToFlash();
}

function passDataToFlash()
{
	// console.log(convertToJsonUrl(getCurrentUrl()));
	drawerLaunched=true;
	pauseButton();
	var songUrl = getCurrentUrl();

	var jsonUrl = convertToJsonUrl(songUrl);//"100001430183965/waveforms/Walks Like Rihanna [Radio Rip].json";
	 // window['drawer'].callFlash(jsonUrl, songUrl);
	setTimeout(function(){ 
      window['drawer'].callFlash(jsonUrl, songUrl, translate("Share"));    }, 400);
}
function convertToJsonUrl(str)
{
	str = str.replace("/", '/waveforms/');
	str = str.replace(".mp3",".json");
	return str;
}
function tellJS(arg, arg2)
{
	$('#shareSpanContainer').hide();
	console.log(arg, arg2);
	if(arg=="hello"){
       passDataToFlash();
	}else if(arg=="no cut") {
		$('#shareSpanContainer').show();
		$('#sharePopUpPaneSpan').val('<iframe width="200" height="200" src="http://localhost:8888/share.php?id='+fileData.id[fileNumber]+'" frameborder="0" allowfullscreen></iframe>');
		$('#sharePopUpPaneSpan').select();
    }
	else
	{
		$('#shareSpanContainer').show();
	    $('#sharePopUpPaneSpan').val('<iframe width="200" height="200" src="http://localhost:8888/share.php?id='+fileData.id[fileNumber]+'&begin='+Math.round(arg)+'&end='+Math.round(arg2)+'" frameborder="0" allowfullscreen></iframe>');
		$('#sharePopUpPaneSpan').select();
	}
}
function translIframe(){
	document.getElementById("uploadFrame").contentWindow.postMessage([translObj, language], window.location);
}
function saveLangOnDB()
{
	syncServer(null, "saveLang", language);
}

function playRecomm(ev, shorten)
{
	// console.log(ev.id);
	shorten = true;
	playSource="recommend";
	$("#recContainer > div").removeClass("recActive");
	$("#"+ev.id).addClass("recActive")
	$(".playlist > div").removeClass("songActive")
	console.log(recData.url[ev.id.replace("recomm", "")]);
	var url = (shorten)?convertToSampleURL(recData.url[ev.id.replace("recomm", "")]):recData.url[ev.id.replace("recomm", "")];
  	currentFile.setAttribute("src",url);
	//fileNumber=action;
	playButton("autocomplete");
}
function buyButtonAction(ev)
{
   // alert(ev.id);
   // ev.stopPropagation();
   if(confirm(translate("Are you sure you want to buy?")+"\n"+recData.artist[ev.id.replace("recBuyButton", "")]+" - "+recData.title[ev.id.replace("recBuyButton", "")]+"?")){
	   $("#"+ev.parentNode.id).fadeOut();
	   syncServer("", "buySong", recData.id[ev.id.replace("recBuyButton", "")]);
	}
   // getUser('recs');
   // console.log(recData.id[ev.id.replace("recBuyButton", "")])
}
function exitRecommMode(ev)
{
	console.log("exitRecommMode");
	// console.log(ev.id);
	if(playSource!="playlist"){
		pauseButton();
		playSource="playlist";
		// $("#recContainer > div").removeClass("recActive");
		// $("#"+ev.id).addClass("recActive")
		// $(".playlist > div").removeClass("songActive")
	  	currentFile.setAttribute("src",fileData.url[fileNumber]);
	}
	  	$(".secondaryFunctionality").fadeTo("fast",1);
	    nextEnable();
	    addListForSecFunty();
	    $("#recContainer > div").removeClass("recActive");
	    changeSongBack(fileNumber);
	//fileNumber=action;
	// playButton("autocomplete");
}
function shareAction()
{
	$('#sharePopUp').fadeIn(); 
	enableDocClick();
}
function enableDocClick()
{
	$(".popUp").click(function() {$(".popUp").fadeOut(200);});
	$("#sharePopUpPane").on("click", function(e){e.stopPropagation();});
	$("#statsPane").on("click", function(e){e.stopPropagation();});
	$("#bgChangerPane").on("click", function(e){e.stopPropagation();});
	$("#uploadFrameDisplayerPane").on("click", function(e){e.stopPropagation();});
    $("#uploadFrameDisplayer  div").on("click", function(e){e.stopPropagation();});
    $("#showStatsCheck").on("click", function(e){e.stopPropagation();});
	
}
function drawWaveForm(id,string,w,h,strWidth,color){
  var s = Snap("#"+id);
  strWidth = strWidth > 0 ? strWidth : 3;
  color = color || '#ffa500';
 
  var array = string.match(/.{1,2}/g);

  var path = 'M0,'+((array[0]*1)+1)*h/100+'';
  for(var i=0;i<array.length;i++){
    path += ' '+'L'+i*w/50+','+ ((array[i]*1)+1)*h/100;
  }
  
  s.path(path).attr({
      stroke: color,
      fill: 'none',
      strokeWidth: strWidth,
      transform: 's1,-1'
  });
  return s;
}
function getRecsFromJson(file, where){
	buyButtonLabel=translate("Buy");
	file = $.parseJSON(file);
	recData = parseIntoObject(file);
	$("#recContainer").empty();
	initiateRendering( recData, "recs" );
	$(".recBuyButton").on("click", function(e){e.stopPropagation();});
	$(".favourite").on("click", function(e){e.stopPropagation();});
}
function dragoverHandler(e) {
	// console.log(e.)
	$('#uploadFrameDisplayer').show();enableDocClick()
}
function favAction(e) {
	$("#"+e.id).attr("src","defaultTheme/images/fav.svg");
}