//TODO:file upload front end testing 
//variables-----------------------------------------
var controls = {
    "playButton": {},
    "nextButton": {},
    "prevButton": {},
    "progressWrapper": {},
    "played": {},
    "buffered": {},
    "shuffleButton": {},
    "repeatButton": {},
    "volumeLevel": {},
    "indicator": {},
    "volumeIndicator": {},
    "volumeWrapper": {},
    "artistAndTitleContainer": {},
    "timeProgress": {},
    "timeDuration": {},
    "shareButton": {}
};
var VKMusic = {};
var JSONResponse = {};
var fileData = {
    "title": {},
    "artist": {},
    "album": {},
    "year": {},
    "url": {},
    "urlOfArt": {}
};
var playlistList = new Array();
var Playlists = new Array();
cleanedArr = new Array();
var currentMode;
var playSource = "playlist";
var ip;
var currentPlaylist;
var isBeingAnimated;
var currentFile = document.createElement("audio");
var keyboardControl = true;
var swapControl = true;
var playlistOn = true;
var volumePercent = 80;
var loadCss = false;
var loadM3U = false;
var scrollVolumeOn = true;
//================================================================================================
var lengthOfJsonObject;
var timerCount = 0;
var timer;
//================================================================================================
var playlistFile;

var fileNumber = 0;
var shuffle = false;
var repeat = 0;
var seeking = false;
var seekPercent = 0;
var scrollVolControl = 0;
var autoNext = true;
var defaultTheme = "defaultTheme"; //"purchasedTheme";//
var filetype = ".svg";
var theme = {
        "playImg": "/images/play-grey",
        "pauseImg": "/images/pause",
        "nextImg": "/images/next",
        "prevImg": "/images/prev",
        "repeatImg": "/images/repeat",
        "repeatOneImg": "/images/repeatOne",
        "repeatAllImg": "/images/repeatAll",
        "shuffleImg": "/images/shuffle",
        "shuffleActiveImg": "/images/shuffleActive"
    }
    // changeTheme('default','svg');
    // initKplayer();
function initKplayer() {
        $.getJSON("http://jsonip.appspot.com?callback=?",
            function(data) {
                ip = data.ip;
                //alert( "Your ip: " + data.ip);
            });
        // getFromXML('1.xml');
        //--------------------------------------------------------------------------------------------
        controls.playButton = document.getElementsByClassName('play')[0];
        controls.nextButton = document.getElementsByClassName('next')[0];
        controls.prevButton = document.getElementsByClassName('prev')[0];
        controls.progressWrapper = document.getElementById('seekbar');
        controls.played = document.getElementById('played');
        controls.buffered = document.getElementById('buffered');
        controls.shuffleButton = document.getElementsByClassName('shuffle')[0];
        controls.repeatButton = document.getElementsByClassName('repeat')[0];
        controls.shareButton = document.getElementsByClassName('share')[0];
        controls.volumeLevel = document.getElementById('level');
        controls.indicator = document.getElementById('indicator');
        controls.volumeIndicator = document.getElementById('volumeIndicator');
        controls.volumeWrapper = document.getElementById('volume');
        controls.artistAndTitleContainer = document.getElementById('artistAndTitleContainer');
        controls.timeProgress = document.getElementById('timeProgress');
        controls.timeDuration = document.getElementById('timeDuration');

        if (keyboardControl) document.addEventListener("keydown", keyboardControlSong, false);
        if (controls.progressWrapper != null || controls.progressWrapper != undefined) controls.progressWrapper.addEventListener("mousedown", seekbarMouseDown, false);
        if (controls.volumeWrapper != null || controls.volumeWrapper != undefined) controls.volumeWrapper.addEventListener("mousedown", volumeMouseDown, false);
        if (controls.playButton != null || controls.playButton != undefined) controls.playButton.addEventListener("click", playSong, false);
        if (currentFile != null || currentFile != undefined) currentFile.addEventListener("progress", progressUpdate, false);
        if (currentFile != null || currentFile != undefined) currentFile.addEventListener("loadeddata", progressUpdate, false);

        if (currentFile != null || currentFile != undefined) currentFile.addEventListener("loadedmetadata", metaDataLoaded, false);

        if (currentFile != null || currentFile != undefined) currentFile.addEventListener("canplaythrough", progressUpdate, false);
        if (currentFile != null || currentFile != undefined) currentFile.addEventListener("timeupdate", timeupdateSong, false);
        if (currentFile != null || currentFile != undefined) currentFile.addEventListener("ended", songEnded, false);
        addListForSecFunty();

        //scrollVolume------------------------------------------------------------------------------

        var playerScroll = document; //.getElementsByClassName('player')[0];
        mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel"
        $(".playlist, #youtube, #stats, #bgChanger, #uploadFrameDisplayer").on(mousewheelevt, function(e) {
            e.stopPropagation();
        });
        $("#lyricsHolder").on(mousewheelevt, function(e) {
            e.stopPropagation();
        });
        $("#youtube").on(mousewheelevt, function(e) {
            e.stopPropagation();
        });
        $(".facebook").on(mousewheelevt, function(e) {
            e.stopPropagation();
        });
        $(".ui-autocomplete").on(mousewheelevt, function(e) {
            e.stopPropagation();
        });
        $(".playlist").on("dblclick", function(e) {
            e.stopPropagation();
        });
        $("#lyricsHolder >div").on("dblclick", function(e) {
            e.stopPropagation();
        });
        $(".facebook").on("dblclick", function(e) {
            e.stopPropagation();
        });
        $(".settings").on("dblclick", function(e) {
            e.stopPropagation();
        });
        $("#addNewPlaylist").on("click", function(e) {
            e.stopPropagation();
        });
        if (playerScroll.attachEvent && scrollVolumeOn) {
            playerScroll.attachEvent("on" + mousewheelevt, volumeScroll)
        } else if (playerScroll.addEventListener && scrollVolumeOn) {
            playerScroll.addEventListener(mousewheelevt, volumeScroll, false)
        }
        getUser("music");
        if (getCookie("volumeOfPlayer") == "null") {
            volume(80);
        } else {
            volume(getCookie("volumeOfPlayer"));
        }
    } // initKplayer

function addListForSecFunty() {
    if (controls.prevButton != null || controls.prevButton != undefined) controls.prevButton.addEventListener("click", prevSong, false);
    if (controls.nextButton != null || controls.nextButton != undefined) controls.nextButton.addEventListener("click", nextSong, false);
    if (controls.shareButton != null || controls.shareButton != undefined) controls.shareButton.addEventListener("click", shareAction, false);
    if (controls.repeatButton != null || controls.repeatButton != undefined) controls.repeatButton.addEventListener("click", repeatSong, false);
    if (controls.shuffleButton != null || controls.shuffleButton != undefined) controls.shuffleButton.addEventListener("click", shuffleSong, false);
}

function removeListForSecFunty() {
    if (controls.prevButton != null || controls.prevButton != undefined) controls.prevButton.removeEventListener("click", prevSong, false);
    if (controls.nextButton != null || controls.nextButton != undefined) controls.nextButton.removeEventListener("click", nextSong, false);
    if (controls.shareButton != null || controls.shareButton != undefined) controls.shareButton.removeEventListener("click", shareAction, false);
    if (controls.repeatButton != null || controls.repeatButton != undefined) controls.repeatButton.removeEventListener("click", repeatSong, false);
    if (controls.shuffleButton != null || controls.shuffleButton != undefined) controls.shuffleButton.removeEventListener("click", shuffleSong, false);
}

function changeMode(mode) {
    if (currentMode == "youtube") toggleYoutubeVideo('hide');
    currentMode = mode;
    $('#lyricsButton').removeClass('buttonPressed');
    $('#artworkButton').removeClass('buttonPressed');
    $('#youtubeButton').removeClass('buttonPressed');
    switch (mode) {
        case "lyrics":
            $('#lyricsButton').addClass('buttonPressed');
            // searchLyricsVK(fileData.title[fileNumber]+" "+fileData.artist[fileNumber]);
            $('#recContainer').empty();
            $('#recContainer').css("background", "url('images/gears.svg') center center no-repeat");
            setTimeout(function() {
                getUser("recs");
            }, 350);
            flip($('#lyricsHolder'));
            break;
        case "artwork":
            $('#artworkButton').addClass('buttonPressed');
            updateArtwork();
            flip($('.artHolder'));
            exitRecommMode();
            break;
        case "youtube":
            $('#youtubeButton').addClass('buttonPressed');
            loadYoutube(fileData.artist[fileNumber] + " " + fileData.title[fileNumber]);
            flip($('#youtube'));
            exitRecommMode();
            break;
    }
    //alert(mode);
}

function flip(div) {
    //$('#youtube').removeClass('flip in').addClass('flip out').hide();
    //alert(div.is(':visible'));
    var pageImage = $('.artHolder');
    var pageLyrics = $('#lyricsHolder');
    var pageYoutube = $('#youtube');
    var toShow = div;
    if (pageImage.is(':visible')) {
        var toHide = pageImage;
    } else if (pageLyrics.is(':visible')) {
        var toHide = pageLyrics;
    } else {
        var toHide = pageYoutube;
    }
    // = pageImage.is(':visible')||pageLyrics.is(':visible')||pageYoutube.is(':visible');//(div.selector==pageLyrics.selector)? pageImage : pageLyrics; 
    console.log(toHide);
    if (!toShow.is(':visible')) {
        toHide.removeClass('flip in').addClass('flip out').hide();
        toShow.removeClass('flip out').addClass('flip in').show();
        // toHide.hide();
        // toShow.show();
    }
    //alert(currentMode);
}
var googleImagesReplacementfound = false;
var googleImagesUrlOfArt;

function updateArtwork() {
    // $("#signature").html(fileData.artist[fileNumber]);
    // var img = new Image() ||document.createElement('img');//24/01/2015
    // console.log("error loading");
    // img.src =fileData.urlOfArt[fileNumber];//24/07/2015
    // img.id='artworkBig';//24/07/2015
    var img = fileData.urlOfArt[fileNumber];
    $(".artHolder").css("background", "url('" + img + "') center center");
    $(".artHolder").css("background-size", "contain");
    // img.style.display="none"; //signature.style.display="none";
    // $(".artHolder > img").replaceWith(img);//24/01/2015
    // var img = new Image() ||document.createElement('img'); img.onload = function() {
    // // $('.artHolder > img').css("margin-top", ((Number($(".artHolder").height())-Number($(".artHolder > img").height()))/2)+"px"); 
    // //$('#signature').css("width", $(".artHolder > img").width());// $('#signature').css("height", $(".artHolder > img").height());
    // //$('#signature').css("margin-top", ((Number($(".artHolder").height())-Number($(".artHolder > img").height()))/2)+"px");
    // img.style.display="block"; //signature.style.display="block"; //$('.artHolder > img').css("margin-top", "-400px"); 
    // }
    // img.onerror = function() {
    //    //var res=googleImagesUrlOfArt; console.log("result from fillTheBackgroundOfartwork", res);
    //    var img = new Image() ||document.createElement('img');
    //    console.log("error loading");
    //    img.src =fileData.urlOfArt[fileNumber];
    //    img.id='artworkBig';
    //    // img.style.display="none"; //signature.style.display="none";
    //    $(".artHolder > img").replaceWith(img);

    // };
    //  // var img = new Image() ||document.createElement('img');//----------------replace
    //   $.ajax({
    //   url: "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=photo "+fileData.artist[fileNumber]+"&rsz=8&imgsz=large&userip="+ip,
    //   // data: myData,
    //   type: 'GET',
    //   async: false,
    //   crossDomain: true,
    //   dataType: 'jsonp',
    //   success: function(data) 
    //            {
    //             console.log("Response from Google images"); console.log(data); 
    //             var url;
    //               googleImagesReplacementfound=false;
    //               googleImagesUrlOfArt="";
    //             $.each(data.responseData.results, function( index, value){
    //               var width=Number(data.responseData.results[index].width);
    //               var height = Number(data.responseData.results[index].height);
    //               if(height>300 && height<1200 && width<1200 && width>300 && ((0.5<width/height) && (width/height<1.5))) 
    //               {
    //                 console.log(width,height);
    //                 googleImagesReplacementfound=true;
    //                 googleImagesUrlOfArt= data.responseData.results[index].url;
    //                 // alert(googleImagesReplacementfound);
    //                 return false;
    //               }
    //             });
    //              var res=googleImagesUrlOfArt; console.log("result from fillTheBackgroundOfartwork", res);
    //              // img.src =res?res:fileData.urlOfArt[fileNumber];

    //              img.src=res?res:fileData.urlOfArt[fileNumber];//----------------replace
    //              img.id='artworkBig';
    //              img.style.display="none"; //signature.style.display="none";
    //              $(".artHolder > img").replaceWith(img);//----------------replace
    //            },
    //   error: function() { 
    //     // var img = new Image() ||document.createElement('img');//----------------replace
    //     img.src =fileData.urlOfArt[fileNumber];
    //     img.id='artworkBig';
    //     img.style.display="none"; //signature.style.display="none";
    //     $(".artHolder > img").replaceWith(img);
    //     return false;
    //   },
    //   // beforeSend: setHeader
    // });

    //console.log(fillTheBackgroundOfartwork());
}

function setHeader(xhr) {

    xhr.setRequestHeader('Authorization', token);
}

function getUser(where) {
    switch (where) {
        case "music":
            $.ajax({
                url: "/getJson.php",
                type: "GET",
                success: function(data) {
                    getFromJSON(data, where);
                }
            });
            break;
        case "recs":
            options = ch.getRecommendationOptions();
            var str = "";
            $.each(options, function(key, value) {
                if (value) str += key + ",";
            });
            str = str.slice(0, -1)
            console.log(str);
            $.ajax({
                url: "/getRecommendations.php?options=" + str,
                type: "GET",
                success: function(data) {
                    // console.log(data)
                    getRecsFromJson(data, where);
                }
            });
            break;

    }
}

function syncServer(id, command, arg) {
    switch (command) {
        case "delete":
            $.ajax({
                url: "/syncServer.php" + "?command=delete&id=" + id + "&index=" + arg,
                type: "GET",
                success: function(data) {
                    renewPlaylist();
                    if (data == "not_loggedIn") {
                        alert("You are not logged in");
                        window.location.replace("/");
                    }
                }
            });
            break;
        case "addNewPS":
            $.ajax({
                url: "/syncServer.php" + "?command=addNewPS&name=" + arg,
                type: "GET",
                success: function(data) {
                    renewPlaylist();
                    if (data == "not_loggedIn") {
                        alert("You are not logged in");
                        window.location.replace("/");
                    }
                }
            });
            break;
        case "addPs":
            $.ajax({
                url: "/syncServer.php" + "?command=addPs&id=" + id + "&playlist=" + arg,
                type: "GET",
                success: function(data) {
                    renewPlaylist();
                    if (data == "not_loggedIn") {
                        alert("You are not logged in");
                        window.location.replace("/");
                    }
                }
            });
            break;
        case "fetchBgs":
            var arr = [];
            $.getJSON("/syncServer.php" + "?command=fetchBgs", function(data) {
                $("#bgsThumbsContainer > div").empty();
                $.each(data, function(index, value) {
                    // arr.push(value);
                    $("#bgsThumbsContainer > div").append("<img src='" + value + "' alt='bg' onclick='bgsThumbsClick(this)'></img>")
                });
            });
            // fetchBgsCallBack(arr);
            break;
        case "saveLang":
            // console.log("/syncServer.php"+"?command=saveLang&argument="+arg);
            $.ajax({
                url: "/syncServer.php" + "?command=saveLang&argument=" + arg,
                type: "GET",
                success: function(data) {
                    console.log(data);
                }
            });
            break;
        case "buySong":
            $.ajax({
                url: "/syncServer.php" + "?command=" + command + "&argument=" + arg,
                type: "GET",
                success: function(data) {
                    // console.log("/syncServer.php"+"?command="+command+"&argument="+arg);
                    // console.log(data);
                    renewPlaylist();
                }
            });
            break;


    }
}

function renewPlaylist() {

    $.get("/getJson.php", function(data) {
        $(".playlist").empty();
        console.log("emptied playlist");
        getFromJSON(data);
    });
}

function removeFromFileData(index) {
    var e;
    delete fileData.artist[index];
    e = fileData.artist.splice(index, 1); //console.log(e);
    delete fileData.title[index];
    fileData.title.splice(index, 1);
    delete fileData.url[index];
    fileData.url.splice(index, 1);
    delete fileData.urlOfArt[index];
    fileData.urlOfArt.splice(index, 1);
    delete fileData.album[index];
    fileData.album.splice(index, 1);
    delete fileData.year[index];
    fileData.year.splice(index, 1);
    delete fileData.id[index];
    fileData.id.splice(index, 1);
    delete fileData.wave[index];
    fileData.wave.splice(index, 1);
    delete fileData.genre[index];
    fileData.genre.splice(index, 1); //} catch(e){alert(e);}//console.log(index);
}

function parseIntoObject(file) {
    // JSONResponse=file;
    console.log(file);
    var response = {};
    response.url = new Array();
    response.title = new Array();
    response.artist = new Array();
    response.album = new Array();
    response.year = new Array();
    response.wave = new Array();

    response.tempo = new Array();
    response.pitch = new Array();
    response.volume = new Array();

    response.genre = new Array();
    response.urlOfArt = new Array();
    response.id = new Array();
    for (var u = 0; u < file.Songs.length; u++) {
        var filet = file.Songs[u]; //alert(u);
        response.url.push(filet.url);
        response.title.push(filet.title);
        response.artist.push(filet.artist);
        response.album.push(filet.album);
        response.year.push(filet.year);

        response.volume.push(filet.volume);
        response.tempo.push(filet.tempo);
        response.pitch.push(filet.pitch);



        response.urlOfArt.push(filet.urlOfArt);
        response.genre.push(filet.genre);
        response.wave.push(filet.wave);
        response.id.push(filet.id);
    }
    return response;
}

function getFromJSON(file, where) {
    file = $.parseJSON(file); //alert(file.User[0].user);
    if (file.User[0].user == "") {
        window.location.replace("/loginSignUp/");
    }
    if (file.User[0].type == "Facebook") {
        facebookIni(file.User[0].user);
    } //alert(user);}
    if (file.User[0].bg) {
        $("body").css("background", "url('" + file.User[0].bg + "')");
        $("body").css("background-size", "cover");
        $("body").css("background-repeat", "initial initial");
    } //=========================fade in
    $("#username").text(' (' + file.User[0].email + ')');
    $("#container").fadeIn();

    fileData = parseIntoObject(file);
    //back up
    fileDataBackUp = JSON.parse(JSON.stringify(fileData)); // alert("happened");
    //autocomplete

    feedAutoComplete();
    //parse playlists
    var mystring = JSON.stringify(file.Playlists[0]);
    mystring = mystring.replace(/"/g, "");
    playlistList = new Array();
    playlistList = mystring.split("]");
    var arr = new Array();
    $.each(playlistList, function(index, value) {
            arr = playlistList[index].split("[");
            if (arr.length > 1) {
                arr = arr[1].split(",");
                playlistList[index] = arr;
            } //alert(playlistList[index][0]);
        }
        // playlistList.pop();
    );
    playlistList.pop(); //deletes { at the end 
    delete arr;
    delete mystring;
    /* fileData.title = file.title;fileData.artist = file.artist;fileData.album = file.album;fileData.year = file.year;fileData.url =file.Songs.url;fileData.urlOfArt = file.urlOfArt;*/
    currentFile.setAttribute("src", fileData.url[0]);
    lengthOfJsonObject = fileData.url.length;
    //pollute playlists selector
    Playlists = Object.keys(file.Playlists[0]); //console.log(Playlists);
    //initiate contextMenu
    initiateContextMenu();
    //look if VK connected
    $.each(Playlists, function(index, value) {
        if (Playlists[index] == "VK") {
            $("#VKConnectbutton").hide();
            //initiateVK();
        }
    });
    initiateDropdown(Playlists);
    //initialise playlist
    playlist(where);

}

function setCurrentPlaylist(playlistReceived) {
    switch (playlistReceived) {
        case "All Music":
            currentPlaylist = "All Music";
            $("#dd >span").text("All Music");
            $(".playlist").empty();
            fileData = JSON.parse(JSON.stringify(fileDataBackUp));
            playlist();
            feedAutoComplete();
            break;
        case "VK":
            currentPlaylist = "VK";
            //show VK search enabler
            $("#VKSearchEnabler").show();
            if (toggleVKSearchEnabled) {
                toggleVKSearchEnabler();
            }
            $("#tags").addClass("tagswithVK");
            //show VK search enabler
            fileData.url = new Array();
            fileData.title = new Array();
            fileData.artist = new Array();
            fileData.album = new Array();
            fileData.year = new Array();
            fileData.urlOfArt = new Array();
            fileData.genre = new Array();
            fileData.wave = new Array();
            fileData.id = new Array();
            for (var u = 0; u < VKMusic.response.length; u++) {
                var filetTemp = VKMusic.response[u]; //alert(u);
                fileData.url.push(filetTemp.url);
                fileData.title.push(filetTemp.title);
                fileData.artist.push(filetTemp.artist);
                fileData.urlOfArt.push("images/vk.jpg");
                fileData.genre.push(filetTemp.genre);
                fileData.id.push(0);
                fileData.wave.push(0);
                fileData.year.push(0);
                fileData.album.push("Unknown");
            }
            //console.log(fileData);
            $(".playlist> div").hide(100);
            $(".playlist").empty();
            playlist();
            feedAutoComplete();
            break;
    }

}

function initiateDropDownEvents() {
        $(".dropdown").on('changed', function(e, indexPl, name) { //alert(name);
            if (name != "VK") //hide VK search enabler
            {
                toggleVKSearchEnabled = false;
                $("#VKSearchEnabler").hide();
                $("#tags").removeClass("tagswithVK");
            }
            if (indexPl == 0) { //$(".playlist > div").css({ opacity: 1}); $(".playlist > div").show();
                setCurrentPlaylist(translate(name, null, "en"));
            } else if (name == "VK") { //alert(VKMusic.response.length);// VK case
                setCurrentPlaylist(name);
            } else {
                if (playlistList[indexPl - 1][0] == "") {
                    $(".playlist > div").hide();
                    fileData = {};
                    feedAutoComplete();
                } //EMPTY PLAYLIST
                else { //alert("pressed");
                    fileData = JSON.parse(JSON.stringify(fileDataBackUp)); //non empty
                    console.log("----------");
                    console.log(fileData.id);
                    console.log("\n");
                    console.log(fileDataBackUp);
                    eachRemove();

                    function eachRemove() {
                            var found = false;
                            $.each(fileData.id, function(index, value) {
                                found = false;
                                for (var i = 0; i < playlistList[indexPl - 1].length; i++) {
                                    console.log(fileData.id[index] + "     " + playlistList[indexPl - 1][i]);
                                    if (fileData.id[index] == playlistList[indexPl - 1][i]) {
                                        var found = true;
                                        break;
                                    }
                                };
                                if (!found) {
                                    removeFromFileData(index);
                                    eachRemove();
                                    return false;
                                } else {
                                    $("#song" + index).fadeIn(100);
                                }
                            });
                        }
                        // timeEnd = (new Date()).getTime();
                    lengthOfJsonObject = (fileData.url.length) ? fileData.url.length : 0; //pauseButton();
                    // console.log(timeEnd-timeStart);
                    $(".playlist").empty();
                    console.log("Here fileData");
                    console.log(fileData);
                    playlist();
                    feedAutoComplete();
                }
            }
        });
    }
    //changed
    //}   
    // function setCurrentPlaylist()
    // {
    //   switch(playlist)
    //   {
    //     case 
    //     break;
    //   }
    // }
function feedAutoComplete() {
    // cleanedArr=fileData.artist.slice(); /* delete unknown artist*/      for (var i=cleanedArr.length-1; i>=0; i--) {/* delete unknown artist*/    if (cleanedArr[i] === "Unknown Artist") {/* delete unknown artist*/        cleanedArr.splice(i, 1);/* delete unknown artist*/    }/* delete unknown artist*/}
    // var forMerge=fileData.title.slice();
    console.log(fileData.title.length);
    var forAutoComplete = [];
    for (var i = 0; i < fileData.title.length; i++) {
        forAutoComplete.push(fileData.artist[i] + " - " + fileData.title[i]);
    };
    $("#tags").autocomplete({
        source: forAutoComplete //$.merge(forMerge, cleanedArr)
    }); //alert(fileData.title);
    //var mousewheelevt=(/Firefox/i.test(navigator.userAgent))? "DOMMouseScroll" : "mousewheel";
    $(".ui-autocomplete").on(mousewheelevt, function(e) {
        e.stopPropagation();
    });
}




function loopPlaylistItemRendering(i, object, table) {
    //console.log(i);         //  create a loop function
    setTimeout(function() {
        if ((object.url.length - (i)) < 31) {
            renderPlaylistItem(i, table, object); //  your code here
            i++; //  increment the counter
        } else {
            renderPlaylistItemBigChunks(i, object, table); //  your code here
            i = i + 30;
        }
        if (i < object.url.length) { //  if the counter < 10, call the loop function
            loopPlaylistItemRendering(i, object, table); //  ..  again which will trigger another 
        } //  ..  setTimeout()
    }, 30)
}

function playlist(table) {
    if (table == undefined) {
        table = "music";
    }
    if (playlistOn) {
        if (fileData.url.length == 0) {
            $(".playlist").append('<div><span>You do not have any music uploaded yet.</span><span id="noSongsPlaceholder" style="color:blue;">Upload music</span> </div>');
            $("#noSongsPlaceholder").on("click", function() {
                $('#uploadFrameDisplayer').show();
            });
        }
        var i = new Date();

        initiateRendering(fileData, table);
        console.log(new Date() - i);
        removeSongBack(0);
        changeSongBack(0);
        lengthOfJsonObject = fileData.url.length;
        fileNumber = 0;
    } //if
}

// function initiateRendering(object, table) {

//     if (object.url.length > 30) {
//         for (var x = 0; x < 30; x++) {
//             renderPlaylistItem(x, table, object);
//         }
//         loopPlaylistItemRendering(30, object, table);
//     } else {
//         for (var x = 0; x < object.url.length; x++) {
//             renderPlaylistItem(x, table, object);
//         }
//     }
// }

function initiateRendering(object, table) {

        for (var x = 0; x < object.url.length; x++) {
            renderPlaylistItem(x, table, object);
        }
        // alert("finshed");

}


function renderPlaylistItem(index, table, object) {
    if (table == "music") {
        $(".playlist").append("<div draggable=true id=song" + index + ">" + "<div class='artInPlaylist'><img src='" + cl(convertToThumbURL(fileData.urlOfArt[index])) //encodeURI(str)
            + "' alt='art' /></div>" + "<div class='spanContainer'><span class='artist'>" + cl(fileData.artist[index]) + "</span>" + "<span class='title'>" + cl(fileData.title[index]) + "</span></div></div>");
        $("#song" + index).on("click", function() {
            setCurrentFile(index);
            playSource = "playlist";
        });
    }
    if (table == "recs") {
        $("#recContainer").append("<div draggable=true id='recomm" 
            + index + "' onclick='playRecomm(this)'>" 
            // + "<div id='recBuyButton" 
            // + index + "' onclick='buyButtonAction(this)' class='recBuyButton translatable'>" 
            // + buyButtonLabel + "</div>" 
             + "<img id='recBuyButton"  + index + "'src='defaultTheme/images/PlusButton.svg'  class='favourite' onclick='buyButtonAction(this)' title='Add to your library' style='bottom: 31px;' id='fav" 
             + index + "'>"

            +"<div class='recArt'><div class='recContainerControls'><img src='defaultTheme/images/play-white.svg' onclick='toggleWhiteControls(this)'></div><img src='"
              + cl(convertToThumbURL(object.urlOfArt[index])) + "' alt='art' /></div>" 
             + "<div><span>" + cl(object.artist[index]) + " - " + cl(object.title[index]) 
             + "</span></div>" 
             + "<img src='defaultTheme/images/statsSvg.svg'  class='favourite recStats'  title='Compare with your music profile' id='fav" 
             + index + "'>" 
             // + "<img src='defaultTheme/images/PlusButton.svg'  class='favourite' onclick='buyButtonAction(this)' style='bottom: 31px;' id='fav" 
             // + index + "'>" 
             + "</div>");
    }

}

function renderPlaylistItemBigChunks(index, object, table) {

    for (var x = index; x < index + 30; x++) {
        renderPlaylistItem(x, table, object);
    }
}

function cl(text) {
    text = text.replace("'", "&#39;");
    text = text.replace('/\0/g', '0').replace('/\(.)/g', '$1').replace('\\', '');
    return text;
}

function convertToThumbURL(str) {
    var filename = str.replace(/^.*[\\\/]/, '');
    str = str.replace(filename, "thumb/" + filename);
    return str;
}

function convertToSampleURL(str) {
    var filename = str.replace(/^.*[\\\/]/, '');
    str = str.replace(filename, "samples/" + filename);
    return str;
}

function changeTheme(customTheme, type) {
    defaultTheme = customTheme;
    if (loadCss) {
        var themeCss = document.createElement("link");
        themeCss.setAttribute("rel", "stylesheet");
        themeCss.setAttribute("type", "text/css");
        themeCss.setAttribute("href", defaultTheme + "/" + defaultTheme + ".css");
        document.getElementsByTagName("head")[0].appendChild(themeCss);
    }

    if (type == "png") {
        filetype = ".png"
    } else if (type == "jpg") {
        filetype = ".jpg"
    } else if (type == "gif") {
        filetype = ".gif"
    } else {
        filetype = ".svg"
    }
}

function changeSongBack(fileNumber) {
    $("#song" + fileNumber).addClass("songActive");
    $("#song" + fileNumber + " span").addClass("spanActive");

}

function removeSongBack(fileNumber) {
    $("#song" + fileNumber).removeClass("songActive");
    $("#song" + fileNumber + " span").removeClass("spanActive");
    //$("#song"+fileNumber).removeAttr('style');
    //$("#song"+fileNumber+" span").removeAttr('style');
}

function setCurrentFile(action) {
        playSource = "playlist";
        if (action == "prev") {
            removeSongBack(fileNumber);
            fileNumber--;
            if (fileNumber < 0) {
                fileNumber = lengthOfJsonObject - 1
            };

            changeSongBack(fileNumber);

            $(".playlist").scrollTo(('#song' + fileNumber), 200, {
                easing: 'linear'
            });
            currentFile.setAttribute("src", fileData.url[fileNumber]);
            playButton();
        } else if (action == "next" && autoNext) {
            removeSongBack(fileNumber);
            if (shuffle) {
                fileNumber = Math.floor(Math.random() * (lengthOfJsonObject));
            }
            fileNumber++;
            if (fileNumber >= lengthOfJsonObject) {
                fileNumber = 0;
            };

            changeSongBack(fileNumber);

            $(".playlist").scrollTo(('#song' + fileNumber), 200, {
                easing: 'linear'
            });
            currentFile.setAttribute("src", fileData.url[fileNumber]);
            playButton();
        } else {
            removeSongBack(fileNumber);
            changeSongBack(action);
            currentFile.setAttribute("src", fileData.url[action]);
            fileNumber = action;
            playButton();
        }
        if (controls.artistAndTitleContainer != null || controls.artistAndTitleContainer != undefined) getArtistAndTitle();
    }
    //Load Progress =====================//
function volumeScroll(e) {
    if (scrollVolumeOn) {
        scrollVolControl = currentFile.volume * 100;
        var e = window.event || e;
        var delta = Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)));
        delta > 0 ? scrollVolControl += 5 : scrollVolControl -= 5;
        volume(scrollVolControl);
    }
}

//nonfunction------------------------------------------------------------------------------
function keyboardControlSong(e) {
    if (keyboardControl) {
        volumePercent = currentFile.volume * 100;
        switch (e.which) {
            case 32:
                currentFile.paused ? playButton() : pauseButton();
                e.preventDefault();
                break; //space
            case 37:
                swapControl ? prevSong() : seek("backward", 10);
                e.preventDefault();
                break; //left
            case 38:
                volumePercent >= 100 ? volumePercent : volumePercent = volumePercent + 5;
                volume(volumePercent);
                e.preventDefault();
                break; //up
            case 39:
                swapControl ? nextSong() : seek("forward", 10);
                e.preventDefault();
                break; //right
            case 40:
                volumePercent <= 0 ? volumePercent : volumePercent = volumePercent - 5;
                volume(volumePercent);
                e.preventDefault();
                break; //down

            case 188:
                swapControl == false ? prevSong() : seek("backward", 10);
                e.preventDefault();
                break; //left
            case 190:
                swapControl == false ? nextSong() : seek("forward", 10);
                e.preventDefault();
                break; //right

        }
    }
}

function seek(action, time) {
    action == "forward" ? currentFile.currentTime += time : currentFile.currentTime -= time;
    $(controls.played).css({
        width: (currentFile.currentTime * 100) / currentFile.duration + "%"
    });
}

function getCurrentUrl() {
    return fileData.url[fileNumber];
}

function metaDataLoaded() {
    if (controls.timeDuration != null || controls.timeDuration != undefined) {
        $(controls.timeDuration).text(((Math.floor(currentFile.duration / 60)) < 10 ? "0" + Math.floor(currentFile.duration / 60) : Math.floor(currentFile.duration / 60)) + ":" + ((currentFile.duration - (Math.floor(currentFile.duration / 60)) * 60) < 10 ? "0" + Math.floor(currentFile.duration - (Math.floor(currentFile.duration / 60)) * 60) : Math.floor(currentFile.duration - (Math.floor(currentFile.duration / 60)) * 60)));
    }
    if (controls.timeProgress != null || controls.timeProgress != undefined) {
        $(controls.timeProgress).text("00:00");
    }
    if (controls.artistAndTitleContainer != null || controls.artistAndTitleContainer != undefined) getArtistAndTitle();
}

function getArtistAndTitle() {
    //if (controls.artistAndTitleContainer !=null || controls.artistAndTitleContainer !=undefined) 
    //{
    $(controls.artistAndTitleContainer).text(fileData.artist[fileNumber] + " - " + fileData.title[fileNumber]);
    //}
}

function progressUpdate() {
    if (currentFile.buffered.length > 0) {
        var percent = (currentFile.buffered.end(0) / currentFile.duration) * 100;
        $(controls.buffered).css({
            width: percent + "%"
        });
    }
}

function timeupdateSong() {
        if (!isBeingAnimated) {
            if (seeking == false) {
                var timePercent = (this.currentTime / this.duration) * 100;
                $(controls.played).css({
                    width: timePercent + "%"
                });
            }
        }
        if (controls.timeProgress != null || controls.timeProgress != undefined) {
            $(controls.timeProgress).text(((Math.floor(this.currentTime / 60)) < 10 ? "0" + Math.floor(this.currentTime / 60) : Math.floor(this.currentTime / 60)) + ":" + ((this.currentTime - (Math.floor(this.currentTime / 60)) * 60) < 10 ? "0" + Math.floor(this.currentTime - (Math.floor(this.currentTime / 60)) * 60) : Math.floor(this.currentTime - (Math.floor(this.currentTime / 60)) * 60)));
        }
    }
    //================================================================================================
function startTimer(value, container) {
    timerCount = value * 60;
    var obj = {};
    if (container != undefined || container != null) {
        $(container).text((Math.floor(timerCount / 60) < 10 ? "0" + (Math.floor(timerCount / 60)) : Math.floor(timerCount / 60)) + ":" + ((timerCount - Math.floor(timerCount / 60) * 60) < 10 ? "0" + (timerCount - Math.floor(timerCount / 60) * 60) : timerCount - Math.floor(timerCount / 60) * 60));
    }
    timer = setInterval(function() {
        timerDecrease(container)
    }, 1000);
}

function timerDecrease(container) {
    if (timerCount <= 0) {
        clearInterval(timer);
        pauseButton();
        // if (oncomplete!=undefined || oncomplete!=null) oncomplete();
    } else {
        timerCount--;
        if (container != undefined || container != null) {
            $(container).text((Math.floor(timerCount / 60) < 10 ? "0" + (Math.floor(timerCount / 60)) : Math.floor(timerCount / 60)) + ":" + ((timerCount - Math.floor(timerCount / 60) * 60) < 10 ? "0" + (timerCount - Math.floor(timerCount / 60) * 60) : timerCount - Math.floor(timerCount / 60) * 60));
        }
    }
}

function stopTimer() {
        clearInterval(timer);
    }
    //================================================================================================
function songEnded() {
    console.log("song ended");
    if (repeat == 0 && fileNumber >= lengthOfJsonObject - 1) {
        pauseButton()
    } else if (repeat == 1) {
        currentFile.currentTime = 0;
        currentFile.play();
    } else {
        if (!autoNext) {
            pauseButton();
        } else
            nextSong();
    }
}

//buffered---------------------------------------------
function seekbarMouseDown(e) {
    e.preventDefault();
    //$(controls.indicator).show();
    //$(controls.indicator).css('z-index', 3);
    $(controls.indicator).offset({
        left: e.pageX - ($(controls.indicator).width() / 2)
    });

    document.addEventListener("mousemove", seekbarMouseMove, false);
    document.addEventListener("mouseup", seekbarMouseUp, false);
}

function seekbarMouseUp(e) {
    var relX = Math.round(((e.pageX - $(controls.progressWrapper).offset().left) / $(controls.progressWrapper).width()) * 100);
    relX = relX > 100 ? 100 : relX;

    try {
        currentFile.currentTime = (relX * currentFile.duration) / 100;
    } catch (e) {
        console.log("Please wait until music is loaded");
    }
    //------------------------------------------------------------------------
    $(controls.played).animate({
        width: relX + "%"
    }, 300);

    isBeingAnimated = true;
    setTimeout(function() {
        isBeingAnimated = false;
    }, 350);

    seeking = false;
    if (currentFile.paused) {
        playButton();
    }
    document.removeEventListener("mousemove", seekbarMouseMove, false);
    document.removeEventListener("mouseup", seekbarMouseUp, false);
    // $(controls.indicator).css('z-index', -100);
    $(controls.indicator).hide();
}

function seekbarMouseMove(e) {
        e.preventDefault();
        seeking = true;
        var relX = Math.round(((e.pageX - $(controls.progressWrapper).offset().left) / $(controls.progressWrapper).width()) * 100);
        relX = relX > 100 ? 100 : relX;
        var ind = (e.pageX - ($(controls.indicator).width() / 2));
        var min = ($(controls.progressWrapper).offset().left);
        var max = (($(controls.progressWrapper).offset().left) + $(controls.progressWrapper).width()) - ($(controls.indicator).width() / 2);
        ind = ind > max ? max : ind < min ? min : ind;

        $(controls.indicator).offset({
            left: ind
        });
        $(controls.played).css({
            width: relX + "%"
        });
    }
    //volume--------------------------------------------- 
function volumeMouseDown(e) {
    e.preventDefault();
    //$(controls.volumeIndicator).show();
    //$(controls.volumeIndicator).css('z-index', 3);
    $(controls.volumeIndicator).offset({
        left: e.pageX - ($(controls.volumeIndicator).width() / 2)
    });

    var relX = Math.round(((e.pageX - $(controls.volumeWrapper).offset().left) / $(controls.volumeWrapper).width()) * 100);
    volume(relX);

    document.addEventListener("mousemove", volumeMouseMove, false);
    document.addEventListener("mouseup", volumeMouseUp, false);
}

function volumeMouseUp(e) {
        document.removeEventListener("mousemove", volumeMouseMove, false);
        document.removeEventListener("mouseup", volumeMouseUp, false);

        $(controls.volumeIndicator).hide();
    } // volumeMouseUp
    //--------------------------------------------------------------------- 

function volumeMouseMove(e) {
        e.preventDefault();

        var relX = Math.round(((e.pageX - $(controls.volumeWrapper).offset().left) / $(controls.volumeWrapper).width()) * 100);
        volume(relX);

        var ind = (e.pageX - ($(controls.volumeIndicator).width() / 2));
        var min = ($(controls.volumeWrapper).offset().left);
        var max = (($(controls.volumeWrapper).offset().left) + $(controls.volumeWrapper).width()) - ($(controls.volumeIndicator).width() / 2);
        ind = ind > max ? max : ind < min ? min : ind;

        $(controls.volumeIndicator).offset({
            left: ind
        });

    } // volumeMouseMove

//functionality---------------------------------------------
function volume(vol) {
    vol = vol > 100 ? 100 : vol < 0 ? 0 : vol;
    currentFile.volume = vol / 100;
    volumePercent = vol;
    $(controls.volumeLevel).css({
        width: vol + "%"
    });
    setCookie("volumeOfPlayer", vol, 365);
}

$(document).dblclick(function() {
    playSong();
});

function playSong() {
    currentFile.paused ? playButton() : pauseButton();
}

function repeatSong() {
    // console.log("rep: "+repeat);
    repeat++;
    repeat = repeat > 2 ? 0 : repeat;

    if (repeat == 0) {
        $(".repeat > img").replaceWith("<img src='" + defaultTheme + theme.repeatImg + filetype + "' />");
    } else if (repeat == 1) {
        $(".repeat > img").replaceWith("<img src='" + defaultTheme + theme.repeatOneImg + filetype + "' />");
    } else {
        $(".repeat > img").replaceWith("<img src='" + defaultTheme + theme.repeatAllImg + filetype + "' />");
    }
    // currentFile.loop=currentFile.loop?false:true;
}

function shuffleSong() {
    shuffle = shuffle ? false : true;
    shuffle ? $(".shuffle > img").replaceWith("<img src='" + defaultTheme + theme.shuffleActiveImg + filetype + "' />") : $(".shuffle > img").replaceWith("<img src='" + defaultTheme + theme.shuffleImg + filetype + "' />");
}

function playButton(source) {
    //hide unnec functionality
    if (source == "autocomplete") {
        $(".secondaryFunctionality").fadeTo("fast", 0.3);
        nextDisable();
        removeListForSecFunty();
    } else {
        // if(playSource=="playlist"){
        exitRecommMode();
        // }
    }
    currentFile.play();
    $("#playButton").hide();
    $("#pauseButton").show();
    pauseAllMusicExcept("player");
    if (currentFile.currentTime == 0 && source != "autocomplete") {
        updateIcon("Playing: ", fileData.title[fileNumber] + " - " + fileData.artist[fileNumber]);
        if ($('#lyricsHolder').is(':visible')) searchLyricsVK(fileData.title[fileNumber] + " " + fileData.artist[fileNumber]);
        if ($('.artHolder').is(':visible')) updateArtwork();
        if ($('#youtube').is(':visible')) loadYoutube(fileData.artist[fileNumber] + " " + fileData.title[fileNumber]);
    }
}

function pauseButton() {
    // $(".play > img").replaceWith("<img src='"+defaultTheme+theme.playImg+filetype+"' />");
    currentFile.pause();
    $("#playButton").show();
    $("#pauseButton").hide();
    updateIcon("Paused: ", fileData.title[fileNumber] + " - " + fileData.artist[fileNumber]);
}

function pauseAllMusicExcept(module) {
    switch (module) {
        case "player":
            // pauseFacebook();
            // youtubePlayer.pauseVideo();
            break;
        case "facebook":
            youtubePlayer.pauseVideo();
            pauseButton();
            break;
        case "youtube":
            pauseButton();
            pauseButton();
            break;
    }
}

function prevSong() {
    setCurrentFile("prev");
    playButton();
}

function nextSong() {
    setCurrentFile("next");
    playButton();
}

function getVolume() {
    return volumePercent;
}

function setCookie(c_name, value, exdays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
    document.cookie = c_name + "=" + c_value;
}

function getCookie(c_name) {
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1) {
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1) {
        c_value = null;
    } else {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1) {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start, c_end));
    }
    return c_value;
}

function keyControlOn(value) {
    keyboardControl = value;
}

function controlType(value) {
    value != "seek" ? swapControl = true : swapControl = false;
}

function loadPlaylist(value) {
    playlistOn = value;
}

function loadCSS(value) {
    loadCss = value;
}

function loadM3U(value) {
    loadM3U = value;
}

function togglePlaylist() {
    $(".playlist").toggle();
}

function hidePlaylist() {
    $(".playlist").hide();
}

function showPlaylist() {
    $(".playlist").show();
}

function allowScrollVolume(value) {
    scrollVolumeOn = value;
}

function nextDisable() {
    autoNext = false;
}

function nextEnable() {
    autoNext = true;
}

function isPlaying() {
    return currentFile.paused
}

function isNextEnabled() {
    return autoNext
}
// var whiteControlState=true
function toggleWhiteControls(item){
    // if(whiteControlState)
        $(item).attr("src","defaultTheme/images/pause-white.svg");
}
