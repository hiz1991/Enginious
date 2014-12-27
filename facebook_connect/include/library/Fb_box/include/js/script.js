/*! 
Author: Yougapi Technology | http://yougapi.com/license/
License: A valid license is required to use this script or "Yougapi" written permission
This script is protected by International laws on copyright
*/

function onFbSdkCallbackFB_box() {
	FB.getLoginStatus(function(response) {
	  if (response.status === 'connected') {
	  	//alert(JSON.stringify(response));
	    var uid = response.authResponse.userID;
	    var accessToken = response.authResponse.accessToken;
	    if(Fb_ypbox.token=='') {
	    	window.location.reload();
	    }
	  } 
	  else if (response.status === 'not_authorized') {
	    //alert('not authorized');
	  } 
	  else {
	    //alert('not logged');
	  }
	});
}

//Update user status
//Callback function: update_status_callback
function update_user_status(obj) {
	var user_id = obj.user_id;
	var token = obj.token;
	var message = obj.message;
	var link = obj.link;
	var image = obj.image;
	
	if(obj.user_id==undefined) user_id = '';
	if(obj.token==undefined) token = '';
	if(obj.message==undefined) message = '';
	if(obj.link==undefined) link = '';
	if(obj.image==undefined) image = '';
	
	if(user_id=='' || token=='') {
		alert('Token and/or user_id missing');
	}
	else {
		$.ajax({
		  type: 'POST',
		  dataType: 'json',
		  url: Fb_ypbox.ajaxurl + '/index.php?q=updateStatus',
		  data: 'user_id=' + user_id + '&token=' + token + '&message=' + message + '&link=' + escape(link) + '&image=' + escape(image),
		  success: function(msg){
		  	update_status_callback(msg);
		  }
		});		
	}
}

/*
START Facebook login logout functionalities
*/

$('#fb_box_fb_login_btn').live('click', function(event) {
	event.preventDefault();
	fb_box_fb_login();
});

$('#fb_box_fb_logout_btn').live('click', function(event) {
	event.preventDefault();
	fb_box_fb_logout();
});

function fb_box_fb_logout() {
	FB.logout(function(response) {
		if(Fb_ypbox.logout_redirect!='') window.location = Fb_ypbox.logout_redirect;
		else window.location.reload(true);
	});
}

function fb_box_fb_login() {
	FB.login(function(response) {
	
	if ($.browser.opera) {
        FB.XD._transport="postmessage";
        FB.XD.PostMessage.init();
	}
	
	if (response.authResponse) {
		if(Fb_ypbox.connect_redirect!='') window.location = Fb_ypbox.connect_redirect;
		else window.location.reload(true);
	}
	else {
	}
	}, {scope:Fb_ypbox.scope});
}

/*
END Facebook login logout functionalities
*/
