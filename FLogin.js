// Load the SDK Asynchronously
      (function(d){
         var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         ref.parentNode.insertBefore(js, ref);
       }(document));
     
      // Init the SDK upon load
     // window.fbAsyncInit = function() { $('.pop').show(); $('.pop').bPopup();
      function initiale(){
        FB.init({
       appId      : '576736129003603', // App ID from the App Dashboard
      channelUrl : 'http://www.cloudbeats.net/channel.html', // Channel File for x-domain c-n
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true  // parse XFBML
        });//init()
        //lets login
        FB.login(function(){}, {scope: 'email,manage_pages'}/*{scope: 'email,read_friendlists,manage_pages,user_photos'}*/);//login
        // listen for and handle auth.statusChange events
        FB.Event.subscribe('auth.statusChange', function(response) {
          if (response.authResponse) {
            // user has authd your app and is logged into Facebook
            userData();
          } else {
           $('.pop').show();
$('.pop').width(300);
$('.pop').height(400);
var xpos=Number((x/2)-(($('.pop').width())/2));
var ypos=Number((y/2)-(($('.pop').height())/2));

$('.pop').bPopup({
            follow: [false, false], //x, y
            position: [xpos, ypos] //x, y
        });
	$('.pop').append($('#reg3'));
	$('#reg3').show();
          }
        });

      } 

		function userData() {
			
		console.log('Welcome!  Fetching your information.... ');
	    FB.api('/me', function(response) {
			friendsData(response.id, response.name, response.email);
	    });
		}//userData
	
		function friendsData(userId, userName, userEmail) {
			
	    FB.api('/me/friends', function(response1) {
	        if(response1.data) {
				//var arr;
				var arrP = jQuery.makeArray(userId);
				var arr = new Array();
				arr.push(userId);
	            $.each(response1.data,function(index,friend) {
					arr.push(friend.id);
					arr.push(friend.name);
					
					
					//var Pic='<img src="'+'https://graph.facebook.com/'+arr+'/picture?type=square'+'">';
	 
	            });
				saveData2(arr, userId, userName, userEmail);
	        } else {
	            alert("Error while getting friends");
	        }
	    });
		}//friendsData
	
	function saveData2(response1, userId, userName, userEmail) {

	dataString = response1;
	var jsonString = JSON.stringify(dataString);
	   $.ajax({
	        type: "POST",
	        url: "../saveFriends.php",
	        data: {data : jsonString}, 
	        cache: false,

	        success: function(answers){
				saveData(userId, userName, userEmail);
	        }
	    });
	
	}//saveData2

	function saveData(userId, userName, userEmail){
										var UID = userId;
										var uMail = userEmail;
										var tick=0;
										$("#result").html("<img src=loading.gif");
										args = "UID="+UID+"&uMail="+uMail+"&musicPreferences="+tick;
										$.ajax({
											   url : "../fregistration.php",
											   data: args,
											   type: "POST",
											   success: function(answer) {
												   if ( answer == "success") 
{
  try{location="../player.html"; }
  catch(g){
         try
         {window.opener.location="../player.html";}
          catch(e)
          {
           window.opener="../player.html";
          }
       }
}
else{
$('.pop').show();
$('.pop').width(300);
$('.pop').height(400);
var xpos=Number((x/2)-(($('.pop').width())/2));
var ypos=Number((y/2)-(($('.pop').height())/2));

$('.pop').bPopup({
            follow: [false, false], //x, y
            position: [xpos, ypos] //x, y
        });
	$('.pop').append($('#reg3'));
	$('#reg3').show();
}
												   }
											   });
									}//saveData
	
  //};//login