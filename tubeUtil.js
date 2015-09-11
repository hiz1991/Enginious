/**
 * =====================================================
 *  jQTubeUtil - jQuery YouTube Search Utility
 * =====================================================
 *  Version: 0.9.0 (11th September 2010)
 *  Author: Nirvana Tikku (ntikku@gmail.com)
 *
 *  Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 *  Documentation: 
 *    http://www.tikku.com/jquery-jQTubeUtil-util
 * =====================================================
 * 
 *  The jQTubeUtil Utility is a wrapper for the YouTube
 *  GDATA API and is built ontop of jQuery. The search 
 *  utility provides the following functionality - 
 * 
 *  BASIC SEARCH:
 * #####################################################
 *
 *  jQTubeUtil.search("some keywords", function(response){})
 *
 *  jQTubeUtil.search({
 *      q: "some keywords",
 *      time: jQTubeUtil.getTimes()[pick one],
 *      orderby: jQTubeUtil.getOrders()[pick one],
 *      max-results: #
 *  },function(response){});
 *	
 *  FEED SEARCH:
 * #####################################################
 *
 *  jQTubeUtil.mostViewed(function(response){});
 *
 *  jQTubeUtil.mostRecent(function(response){});
 *
 *  jQTubeUtil.mostPopular(function(response){});
 *
 *  jQTubeUtil.topRated(function(response){});
 *
 *  jQTubeUtil.topFavs(function(response){});
 *
 *  jQTubeUtil.related(videoID,function(response){});
 *
 *
 *   SUGGESTION SEARCH:
 * #####################################################
 *
 *  jQTubeUtil.suggest("keywords", function(response){});
 *
 *  SEARCH RESPONSE OBJECT:
 * #####################################################
 *
 *  Response = {
 *       version: String,
 *       searchURL: String,
 *       videos: Array, // of YouTubeVideo's (see below)
 *   <! if search/feed, then the following attrs are present !>
 *       startIndex: String,
 *       itemsPerPage: String,
 *       totalResults: String
 *   <!  end search/feed feed attrs present !>
 *  }
 *
 *  FRIENDLY VIDEO OBJECT:
 * #####################################################
 *
 *  YouTubeVideo = { 
 *      videoId: String,
 *      title: String,
 *      updated: String || undefined,
 *      thumbs: Array || undefined,
 *      duration: Number || undefined, (seconds)
 *      favCount: Number || undefined,
 *      viewCount: String || undefined,
 *      category: String || undefined,
 *      categoryLabel: String || undefined,
 *      description: String || undefined,
 *      keywords: String || undefined (comma sep words),
 *      unavailAttributes: Array
 *  }
 *
 */

;jQTubeUtil = (function($){ /* singleton */
	
	var f = function(){};
	var p = f.prototype;
	
	// Constants, Private Scope
	var MaxResults = 10,
		StartPoint = 1,
		// URLs
		BaseURL = "http://gdata.youtube.com",
		FeedsURL = BaseURL + "/feeds/api",
		VideoURL = FeedsURL + "/videos/",
		SearchURL = FeedsURL + "/videos",
		StandardFeedsURL = FeedsURL + "/standardfeeds",
		MostViewed = StandardFeedsURL + "/most_viewed"
		MostPopular = StandardFeedsURL + "/most_popular",
		MostRecent = StandardFeedsURL + "/most_recent",
		TopRated = StandardFeedsURL + "/top_rated",
		TopFavs = StandardFeedsURL + "/top_favorites",
		RecentlyFeatured = StandardFeedsURL + "/recently_featured",
		SuggestURL = "http://suggestqueries.google.com/complete/search",
		// Settings
		Times = ["today","this_week","this_month","all_time"],
		OrderBy = ["relevance", "published", "viewCount", "rating"],
		Categories = ["Film","Autos","Music","Animals","Sports","Travel","Shortmov","Videoblog","Games","Comedy","People","News","Entertainment","Education","Howto","Nonprofit","Tech"];
		
	// Settings _required_ for search
	var SearchDefaults = {
		"q": "",
		"orderby": OrderBy[2],
		"time": Times[3],
		"max-results": MaxResults
	};
	
	// The Feed URL structure _requires_ these
	var CoreDefaults = {
		"key": "", //"", /** NEEDS TO BE SET **/
		"format": 5, // embeddable
		"alt": "json",
		"callback": "?"
	};
	
	// The Autocomplete utility _requires_ these
	var SuggestDefaults = {
		hl: "en",
		ds: "yt",
		client: "youtube",
		hjson: "t",
		cp: 1
	};
	
	/**
	 * Initialize the jQTubeUtil utility
	 */	
	p.init = function(options){
		if(!options.key) throw "jQTubeUtil requires a key!";
		CoreDefaults.key = options.key;
		if(options.orderby) 
			SearchDefaults.orderby = options.orderby;
		if(options.time)
			SearchDefaults.time = options.time;
		if(options.maxResults)
			SearchDefaults["max-results"] = MaxResults = options.maxResults;
		if(options.lang)
			SuggestDefaults.hl = options.lang;
	};
	
	/** public method to get available time filter options */
	p.getTimes = function(){return Times;};
	
	/** public method to get available order filter options */
	p.getOrders = function(){return OrderBy;};
	
	/** public method to get available category filter options */
	p.getCategories = function(){return Categories;};
	
	/**
		 * Autocomplete utility returns array of suggestions
	 * @param input - string
	 * @param callback - function
	 */
	p.suggest = function(input, callback){
		var opts = {q: encodeURIComponent(input)};
		var url = _buildURL(SuggestURL,
			$.extend({}, SuggestDefaults, opts)
		);
		$.ajax({
			type: "GET",
			dataType: "json",
			url: url,
			success: function(xhr){
				var suggestions = [], res = {};
				for(entry in xhr[1]){
					suggestions.push(xhr[1][entry][0]);
				}
				res.suggestions = suggestions;
				res.searchURL = url;
				if(typeof(callback) == "function"){
					callback(res);
					return;
				}
			}
		});
	};
	
	/**
	 * This function is the public method
	 * provided to the user to perform a 
	 * keyword based search
	 * @param input
	 * @param cb
	 */
	p.search = function(input, cb, category){
		if ( typeof(input) == "string" ) 
			input = { "q" : encodeURIComponent(input) };
		if (null != category)
			category = {"category" : category};
		else
			category = {};
		return _search($.extend({}, SearchDefaults, input,category), cb);
	};
	
	/** Get a particular video via VideoID */
	p.video = function(vid, cb){
		return _request(VideoURL+vid+"?alt=json", cb);
	};
	
	/** Get related videos for a VideoID; ex. http://gdata.youtube.com/feeds/api/videos/ZTUVgYoeN_b/related?v=2 */
	p.related = function(vid, cb){
	    return _request(VideoURL+vid+"/related?alt=json", cb);
	};
	
	/** Most Viewed Feed */
	p.mostViewed = function(incoming, callback){
		return _getFeedRequest(MostViewed, getOptions(incoming, true), callback);
	};
	
	/** Most Recent Feed */
	p.mostRecent = function(incoming, callback){
		return _getFeedRequest(MostRecent, getOptions(incoming, false), callback);
	};
	
	/** Most Popular Feed */
	p.mostPopular = function(incoming, callback){
		return _getFeedRequest(MostPopular, getOptions(incoming, true), callback);
	};
	
	/** Top Rated Feed */
	p.topRated = function(incoming, callback){
		return _getFeedRequest(TopRated, getOptions(incoming, true), callback);
	};
	
	/** Top Favorited Feed */
	p.topFavs = function(incoming, callback){
		return _getFeedRequest(TopFavs, getOptions(incoming, true), callback);
	};
	
	/**
	 * Get a feeds request by specifying the URL 
	 * the options and the callback
	 */
	function _getFeedRequest(baseURL, options, callback){
		var reqUrlParams = {
			"max-results": options.max || MaxResults,
			"start-index": options.start || StartPoint
		};
		if(options.time) reqUrlParams.time = options.time;
		var url = _buildURL(baseURL, reqUrlParams);
		return _request(url, options.callback || callback);
	};
	
	/**
	 * Method to get the options for a standard
	 * feed that is then utilized in the URL
	 * building process
	 */
	function getOptions(arg, hasTime){
		switch(typeof(arg)){
			case "function":
				return {
					callback: arg, 
					time: undefined
				};
			case "object":
				var ret = {
					max: arg.max,
					start: arg['start-index']
				};
				if(hasTime) ret.time = arg.time;
				return ret;
			default: return {}; break;
		}
	};
	
	/**
	 * This function builds the URL and makes
	 * the search request
	 * @param options
	 * @param callback
	 */
	function _search(options, callback){ 
		var URL = _buildURL(SearchURL, options);
		return _request(URL, callback);
	};
	
	/**
	 * This method makes the actual JSON request
	 * and builds the results that are returned to 
	 * the callback
	 */
	function _request(url, callback){
		var res = {};
		$.ajax({
			type: "GET",
			dataType: "json",
			url: url,
			success: function(xhr){
				if((typeof(xhr) == "undefined")
					||(xhr == null)) return;
				var videos = [];
				if(xhr.feed){
					var feed = xhr.feed;
					var entries = xhr.feed.entry;
					for(entry in entries)
						videos.push(new YouTubeVideo(entries[entry]));
					res.startIndex = feed.openSearch$startIndex.$t;
					res.itemsPerPage = feed.openSearch$itemsPerPage.$t;
					res.totalResults = feed.openSearch$totalResults.$t;
				} else { 
					videos.push(new YouTubeVideo(xhr.entry));
				}
				res.version = xhr.version;
				res.searchURL = url;
				res.videos = videos;
				if(typeof(callback) == "function") {
					callback(res); // pass the response obj
					return;
				}
			
			},
			error: function(e){
				throw Exception("couldn't fetch YouTube request : "+url+" : "+e);
			}
		});
		return res;
	};
	
	/**
	 * This method builds the url utilizing a JSON 
	 * object as the request param names and values
	 */
	function _buildURL(root, options){
		var ret = "?", k, v, first=true;
		var opts = $.extend({}, options, CoreDefaults);
		for(o in opts){
			k = o;	v = opts[o];
			ret += (first?"":"&")+k+"="+v;
			first=false;
		}
		return root + ret;
	};
	
	/**
	 * Represents the object that transposes the
	 * YouTube video entry from the JSON response
	 * into a usable object
	 */
	var YouTubeVideo = function(entry){
		var unavail = [];
		var id = entry.id.$t;
		var start = id.lastIndexOf('/')+1;
		var end = id.length;
		// set values
		this.videoId = id.substring(start, end);
		this.entry = entry; // give access to the entry itself
		this.title = entry.title.$t;
		try{ this.updated = entry.updated.$t; }catch(e){ unavail.push("updated"); }
		try{ this.thumbs = entry.media$group.media$thumbnail; }catch(e){ unavail.push("thumbs"); }
		try{ this.duration = entry.media$group.yt$duration.seconds; }catch(e){ unavail.push("duration"); }
		try{ this.favCount = entry.yt$statistics.favoriteCount; }catch(e){ unavail.push("favCount"); }
		try{ this.rating = entry.gd$rating; }catch(e){ alert(e); unavail.push("rating"); }
		try{ this.viewCount = entry.yt$statistics.viewCount; }catch(e){ unavail.push("viewCount"); }
		try{ this.category = entry.media$group.media$category[0].$t; }catch(e){ unavail.push("category"); }
		try{ this.categoryLabel = entry.media$group.media$category[0].label; }catch(e){ unavail.push("categoryLabel"); }
		try{ this.description = entry.media$group.media$description.$t; }catch(e){ unavail.push("description"); }
		try{ this.keywords = entry.media$group.media$keywords.$t; }catch(e){ unavail.push("keywords"); }
		this.unavailAttributes = unavail; // so that the user can tell if a value isnt available
	};
	
	return new f();
	
})(jQuery);

jQTubeUtil.init({
    key: "AI39si7DGbcdv6vuKW5HkcD2NVNK0c5wy8cs5CnW8X2wMvUYMcQXXErGH-TTh-Rx1kFkI6C6nWclgY8ZRxEyBvDCEoXBHIUgUQ",
    orderby: "relevance",  // *optional -- "viewCount" is set by default
    time: "all_time",   // *optional -- "this_month" is set by default
    maxResults: 9   // *optional -- defined as 10 results by default
  });
youtubeVideoId='f-7Y5XOhGrg';
$(document).ready(function(){
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
});
function onYouTubeIframeAPIReady() {//alert(document.getElementById("YTPlayer")); 
youtubePlayer = new YT.Player('YTPlayer', {
    height: '100%',
    width: '100%',
    videoId: youtubeVideoId,
    // playlist: ids,
    playerVars: { 'showinfo':0,'autoplay': 0, 'controls': 1 ,'disablekb':1, 'iv_load_policy':3,'modestbranding':1},
    events: {
        'onReady': onPlayerReady,
        'onStateChange': onPlayerStateChange
    }
});
function onPlayerReady(event) {

}
function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING) {
        //alert("playing");//
        pauseButton();
    }
    else if (event.data == YT.PlayerState.PAUSED || event.data == YT.PlayerState.ENDED) {
       // pauseButton();
    }
}

// addEvent(document.getElementById("video"), 'mousemove', mouseMoveVideoContainer, false);
}
    
function loadYoutube(titileAndArtist){
jQTubeUtil.search(titileAndArtist, function(response){ console.log(response);
					  $("#youtubeThumbsContainer").empty();
					  // $("#youtube").append("<div id='containterYoutubeOutMost'></div>");
 					  // $("#containterYoutubeOutMost").append("<div id='youtubeThumbsContainer'></div>");
 					  //remove youtube help
 					  response.videos.shift()
	                  for (var i = 0; i < response.videos.length; i++) 
	                  {
	                  	$("#youtubeThumbsContainer").append("<div class='youtubeResultContainer' id='youtubeSerachReasultDiv"+i+"'><img src='"+response.videos[i].thumbs[2].url+"'/><br><span>"+response.videos[i].title+"</span></div>");
	                  	$("#youtubeSerachReasultDiv"+i).on("click", function(e){
	                  		var numbOfYoutubeDiv=e.target.id||e.target.parentNode.id||e.target.parentNode.parentNode.id;
	                  		var numbOfYoutubeDivTemp=Number(numbOfYoutubeDiv.replace("youtubeSerachReasultDiv",""));
	                  		pauseAllMusicExcept("youtube");
	                  		youtubePlayer.loadVideoById(response.videos[numbOfYoutubeDivTemp].videoId); 
	                  		youtubePlayer.setVolume(getVolume());
	                  	});
	                  }
	                  //$("#youtube").append("<div id='youtubeContainer'></div>");
	                  // $("#youtubeThumbsContainer").css("width", response.videos.length*145+"px"); //resize the containre to avoid redundant scrolling================removed the size from youtube container
	                   //setTimeout(function(){ getFromYoutube("youtubeContainer",response.videos[0].videoId,0);} , 500);
	                    if(response.videos.length>0) 
	                    	{
	                    		$("#YTPlayer").show();loadYoutubeVideoByIdAndVolume(response.videos[0].videoId)
	                    	}
	                    else
	                    	{
	                    		toggleYoutubeVideo//
	                    		$("#YTPlayer").hide();//pause and hide the video
	                    		$("#youtubeThumbsContainer").css("width","100%");
	                    		$("#youtubeThumbsContainer").append("<div style='margin-left:40%;margin-top:30px;font-family:myFirstFont;'>"+translate("No videos found")+" (:</div>");
	                    	}
	             }, "Music");
}
function toggleYoutubeVideo(state) {
   youtubePlayer.pauseVideo();
}
function loadYoutubeVideoByIdAndVolume(id)
{
   youtubePlayer.cueVideoById(id);
   youtubePlayer.setVolume(getVolume());
} 
