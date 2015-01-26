var total;
var number=0;
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
      $("#statsPane").append('<p id="statsPaneLabel">Library analysis results:</p>'); 
      var i=0;
      for(var k in smth.Response)// alert(k);
      {
          $("#statsPane").append("<div> <div class='statsDescriptors' ><span class='statsSpan'>"+k+"</span></div> <div class='statsIndicatorsContainers' id='container"+i+"'></div><div class='statsNumberContainers' >"+smth.Response[k]+"</div> </div>");
          $("#container"+i).append("    <svg class='svg' id='"+"svg"+i+"' style='width: "+$("#container"+i).width()+"px'/></svg>");
          populateSvg('svg'+i, (smth.Response[k]<=100&&smth.Response[k]!=null)?smth.Response[k]:0);
          i++;
      }
      $("#stats").fadeIn();
}
function remoteIni()
{
  window.setInterval(remoteUpdate, 500);
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
		    case "play": playButton();unset(); break;
		    case "pause": pauseButton();unset(); break;
		    case "next": nextSong();unset(); break;
		    case "prev": prevSong();unset(); break;
		    case "volumeUp": volume(getVolume()+3);unset(); break;
		    case "volumeDown": volume(getVolume()-3);unset(); break;
		  }
		 } 
	      });
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
  }
}
function animatePlayerOnHover()
{
	$( ".player" ).mouseleave(function() {

		  $( "#seekbar, #volume" ).animate({
		    // opacity: 1,
		    bottom: "15px",
		    height: "6px"
		    // margin-top: "15px"
		  }, 80, function() {
		    // Animation complete.
		  });

			$( "#played, #level" ).animate({
		    // opacity: 1,
		    // bottom: "15px",
		    height: "6px"
		    // margin-top: "15px"
		  }, 80, function() {
		    // Animation complete.
		  });


    }).mouseenter(function() {

		  $( "#seekbar, #volume" ).animate({
		    // opacity: 1,
		    bottom: "0px",
		    height: "30px"
		    // margin-top: "15px"
		  }, 80, function() {
		    // Animation complete.
		  });

			$( "#played, #level" ).animate({
		    // opacity: 1,
		    // bottom: "15px",
		    height: "30px"
		    // margin-top: "15px"
		  }, 80, function() {
		    // Animation complete.
		  });

    });
    // height: 6px;
// margin-top: 15px;
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
