clicked = false;
clickSearch=false;
toggleSlideDownUpBoolean=false;
var dropDownId;
var dropDownHeight;
function DropDown(el)
{
  dropDownId=el;
	this.dd = el;
	this.placeholder = this.dd.children('span');
	this.opts = this.dd.find('ul.dropdown > li');
	this.val = '';
	this.index = -1;
	this.initEvents(); 

  initiateContextMenu(this.opts); 

}
DropDown.prototype = {
  initEvents : function() {
  	var obj = this;
  	obj.dd.on('click', function(event){ 
  		$(this).toggleClass('active');
  		toggleSlideDownUp();
  		//$("#addNewPlaylist").toggleClass('active');
      $(".wrapper-demo").toggleClass('active');
  		// toggleOpacity();
  		return false;
  	});

  	obj.opts.on('click',function(){						 
  		// console.log(this.id+" - ");
  		var opt = $(this); $(".dropdown").trigger(jQuery.Event( "changed" ), [opt.index(), opt.text()]);
  		obj.val = opt.text();
  		obj.index = opt.index();
  		obj.placeholder.text(obj.val);
  	});
  },
  getValue : function() 
  {
  	return this.val;
  },
  getIndex : function()
  {
  	return this.index;
  }
			
}

$(function() {

	$(document).click(function() {
		// all dropdowns
		if(toggleSlideDownUpBoolean)
		{
			toggleSlideDownUpClose();
    }
	});
});

function initiateDropdown(file)
{
  //console.log(file);
      dropDownHeight=0;
      //initiate dropdown for playlists
      var Playlists=file;
      $(".dropdown").empty();
      $(".dropdown").append('<li><a href="#" class="translatable"></i>'+translate("All Music")+'</a></li>');
      if(Playlists.length>0)
      {

        $.each(Playlists, function( index, value)
        {
          $(".dropdown").append('<li><a href="#">'+Playlists[index]+'</a></li>');
        });
      }
        try
        {
          delete dd; delete DropDown; $('#dd').off('click'); $('ul.dropdown > li').off('click'); 
        }
        catch(e){}
        var dd = new DropDown( $('#dd') );
    //poluted
    initiateDropDownEvents();
    // dropDownHeight=$("#dropdownSlider").height()+33; console.log("dropDownHeight"+dropDownHeight);
}

function toggleOpacity()
{ 
  if(!clicked)
  {
  clicked=true;
    // $('.playlist').css({ opacity: 0.5 }); ==========================en/dis opacity
  //var filterVal = 'blur(3px)';
  // $('.playlist') // .css('filter',filterVal)  // .css('webkitFilter',filterVal)  // .css('mozFilter',filterVal)  // .css('oFilter',filterVal)  // .css('msFilter',filterVal);
  }
  else
  {
    // clicked=false; $(".playlist").removeAttr('style');==============
  }
}
function toggleSlideDownUp()
{
  if(!toggleSlideDownUpBoolean)
  {
  toggleSlideDownUpBoolean=true;
  // $(".menu").show();
    document.querySelector(".menu").style.opacity = "1";
    $(".wrapper-demo").addClass('shadowless');
    $(".morph-shape").addClass("morph-shape-open");
    rerenderBackground() //console.log(dropDownHeight+33+"px");

    dropDownBackground.open();
    // $("#dropdownSlider").delay(600).fadeIn();
    $("#dropdownSlider").slideDown(600);
  }
  else
  {
    toggleSlideDownUpClose();
  }
}
function toggleSlideDownUpClose()
{
    $(".wrapper-dropdown-3").removeClass("active");
    toggleSlideDownUpBoolean=false; 
    $(".morph-shape-open").removeAttr('style');
    $(".morph-shape").removeClass("morph-shape-open");
    dropDownBackground.close();
    $("#dropdownSlider").slideUp(300, function(){$(".wrapper-demo").removeClass('shadowless');
    // $("#dropdownSlider").slideUp(600);
    document.querySelector(".menu").style.opacity = "0";
});
}
function removeOpacity()
{
 {
   clicked=false; $(".playlist").removeAttr('style');
  }
}
function rerenderBackground(){
  $(".morph-shape-open").css("height", $("#dropdownSlider").height()+33+"px");
}
function initiateContextMenu(options)
{//console.log(Playlists);
         //console.log(Playlists);
	       var arrPlaylistNames=[]; 
	       for (var i=0; i<Playlists.length;i++)
		    {
		    	var tempPlaylist={};//object to insert
		       tempPlaylist.title=Playlists[i]; 
           tempPlaylist.cmd="addPs";
		       arrPlaylistNames.push(tempPlaylist); 
	        }
	       //console.log(Playlists);
	        var CLIPBOARD = "";
        $(document).contextmenu({
        delegate: ".playlist > div",
        preventSelect: true,
        taphold: false,
        show: { effect: "fold", duration: 50},
        hide: { effect: "fold", duration: 50 },
        menu: [ 
            {title: translate("Delete"), cmd: "delete", uiIcon: "ui-icon-scissors"},
            {title: translate("Download"), cmd: "download", uiIcon: "ui-icon-copy"},
            {title: translate("Add to a Playlist"), children:  arrPlaylistNames
           //     {title: "Sub 1 (using callback)", action: function(event, ui) { alert("action callback sub1");} },
           //     {title: "Sub 2", cmd: "sub1"}
                                                   }
           // {title: "Paste", cmd: "paste", uiIcon: "ui-icon-clipboard", disabled: true },
          //  {title: "----"},
          //  {title: "More", children: [
          //      {title: "Sub 1 (using callback)", action: function(event, ui) { alert("action callback sub1");} },
           //     {title: "Sub 2", cmd: "sub1"}
           //     ]}
            ],
        // Handle menu selection to implement a fake-clipboard
        select: function(event, ui) {
            var $target = ui.target;
            var id; if(ui.target[0].id=="") {id=ui.target[0].parentNode.parentNode.id;} else{id=ui.target[0].id;}
            switch(ui.cmd){
            case "delete":
            // alert(id.replace("song","")); 
            if(confirm(translate("Are you sure you want to delete?")+"\n"+fileData.artist[Number(id.replace("song",""))]+" - "+fileData.title[Number(id.replace("song",""))])){
              syncServer(fileData.id[Number(id.replace("song",""))], "delete", Number(id.replace("song",""))); break;
            }
            //deleteSong(fileData.id[Number(id.replace("song",""))]);
            break;
            case "download":
               pauseButton();
               window.open(fileData.url[Number(id.replace("song",""))],  '_blank');
               break;
            case "addPs":
               console.log( fileData.id[Number(id.replace("song",""))]);
               syncServer(fileData.id[Number(id.replace("song",""))], "addPs", event.currentTarget.innerText);
               addToPS(fileData.id[Number(id.replace("song",""))], event.currentTarget.innerText);
               break;
              //  CLIPBOARD = "";
                //break
            } 
            
            // Optionally return false, to prevent closing the menu now
        },
        // Implement the beforeOpen callback to dynamically change the entries
        beforeOpen: function(event, ui) {
            var $menu = ui.menu,
                $target = ui.target;
            $(document)
//              .contextmenu("replaceMenu", [{title: "aaa"}, {title: "bbb"}])
//              .contextmenu("replaceMenu", "#options2")
//              .contextmenu("setEntry", "cut", {title: "Cuty", uiIcon: "ui-icon-heart", disabled: true})
                //.contextmenu("setEntry", "copy", "Copy '" + $target.text() + "'")
                .contextmenu("setEntry", "paste", "Paste" + (CLIPBOARD ? " '" + CLIPBOARD + "'" : ""))
                .contextmenu("enableEntry", "paste", (CLIPBOARD !== ""));

            // Optionally return false, to prevent opening the menu now
        }
    });
}
function appendPlaylists(text)
{
	//alert(text);
  if(text!="")
  {
   //console.log(playlistList);//
   Playlists.push(text);
   var arr=new Array();
   arr[0]="";
   playlistList.push(arr);
   // console.log(playlistList);
   	delete DropDown; $('#dd').off('click'); $('ul.dropdown > li').off('click'); 
   $(".dropdown").append('<li><a href="#">'+text+'</a></li>');
   var dd = new DropDown( $('#dd') );
   rerenderBackground()
   syncServer(null, "addNewPS", text);
 }
}
