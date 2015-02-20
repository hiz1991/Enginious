///*global document:false, $:false */
//    $( document).click(function() {
//     flip($("#form"),$("#formLogin")) });
var animationSpeed=300;
var emailError=true;
var passwordError=true;
var confirmPasswordError=true;
$( document ).ready(function() 
{     
    //autologin
        $.ajax({
        url : "../getJson.php",
        success: function(check) 
        {
          var resp = JSON.parse(check);
          // console.log(resp.User[0].user);
          if (resp.User[0].user)
            window.open ('../player.php?lang='+language,'_self',false);
        }
});
    //autologin
 //  setTimeout(function(){flip($("#form"),$("#formLogin")) },2000);
    $("#orSignUp, #orSignIn").click(function(){ flip($("#form"),$("#formLogin")); }); 
    $("#submitButtonLogin").click(function(){ 
      logEnter();
    });
    //add Enter click listener
    $('#emailInputLogin, #passwordInputLogin').keypress(function(e) {
      if(e.which == 13) {
        logEnter();
      }
    });
      $("#fLoginButton").on('click',function()
    {
    initiale();
    });
    $( "#emailInput" )
     .focusout(function() {
          var message=checkEmail($( "#emailInput" ).val());
          if(message!="ok")
          {
              emailError=true;
              showError("#emailErrorsDisplayer", "redColor", message, "#emailErrorsSpan");
          }
          else
          {
              if($( "#emailInput" ).val().length>4)
              {
                  showError("#emailErrorsDisplayer", "greenColor", "Checking if already registered...", "#emailErrorsSpan");
                  checkIfUserExists("#emailErrorsDisplayer");
                  emailError=false;
              }
              
          }
          checkIfCanProceed();
      })
     .focusin(function() {
        closeDisplayer("#emailErrorsDisplayer");
      });
//-----------------------------------------------------------------    
   $( "#passwordInput" )
     .focusout(function() {
          var message=checkPwd($( "#passwordInput" ).val());
          if(message!="ok")
          {
              passwordError=true;
              showError("#passwordErrorsDisplayer", "redColor", message, "#passwordErrorsSpan");
          }
          else
          {
              closeDisplayer("#passwordErrorsDisplayer");
              passwordError=false;
          }
          checkIfCanProceed();
      })
     .focusin(function() {
         closeDisplayer("#passwordErrorsDisplayer");
      });
//------------------------------------------------------------------
    $( "#confirmPasswordInput" )
     .focusout(function() {
          if(passwordError==true || $("#passwordInput").val()!=$("#confirmPasswordInput").val())
          {
              confirmPasswordError=true;
              showError("#confirmPasswordErrorsDisplayer", "redColor", "Passwords must match or incorrect", "#confirmPasswordErrorsSpan");
          }
          else
          {
              closeDisplayer("#confirmPasswordErrorsDisplayer");
              confirmPasswordError=false;
          }
          checkIfCanProceed();
      })
     .focusin(function() {
         closeDisplayer("#confirmPasswordErrorsDisplayer");
      });
 //-------------------------------------------------------------------   

     $( "#emailInputLogin" )
     .focusin(function() {
         closeDisplayer("#emailErrorsDisplayerLogin");
      });

 //-------------------------------------------------------------------
     $("#submitButton").click(function(){
         // $.ajax("/registration.php"
          // );
            $.ajax({
            type: "POST",
            url: "/registration.php",
            data: { username: $("#emailInput").val(), password: $("#passwordInput").val(),
                   email: $("#emailInput").val(), confirmEmail: $("#confirmPasswordInput").val(),
                   musicPreferences: 0 }
          })
            .done(function( msg ) {
              if (msg=="success") {window.location.href="/player.php"}
                else if(msg=="taken"){alert("Email already registered!")}
                  else{alert("Input values incorrect")}
              console.log( "Data Saved: " + msg );
            });
     });
 //-------------------------------------------------------------------  
  // $('#form').blurjs({
  // source: 'body',
  // radius: 2,
  // overlay: 'rgba(255,255,255,0.2)'
  //  });
  //   $('#formLogin').blurjs({
  // source: 'body',
  // radius: 2,
  // overlay: 'rgba(255,255,255,0.2)'
  //  });

});
function checkIfCanProceed()
{
    console.log(emailError, passwordError, confirmPasswordError);
    if(!emailError && !passwordError && !confirmPasswordError)
        $("#submitButton").addClass("buttonActiveBlue");
    else
        $("#submitButton").removeClass("buttonActiveBlue");
}

function checkEmail(value)
{//console.log(value);
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(value.length<4)
    {
        return "Email is too short";
    }
    else if(value.length>60)
    {
        return "Email is too long";
    }
    else if(!regex.test(value))
    {
        return "Provide a valid email, please";
    }
    return "ok";
}
function checkPwd(str) {
    if (str.length < 6) {
        return("Password too short");
    } else if (str.length > 50) {
        return("Password too long");
    } else if (str.search(/[a-zA-Z]/) == -1) {
        return("Password must contain letters");
    } else if (str.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\.\_\+]/) != -1) {
        return("Password contains unsafe characters, !@#$%^&*()_ are allowed");
    }
    return("ok");
} 
function showError(received, classReceived, message, span)
{
    $(received).fadeTo(animationSpeed,1);
    (classReceived=="redColor")?$(received+" span").addClass(classReceived):$(received+" span").removeClass("redColor");//#emailErrorsSpan
    $(span).text(translate(message));
}
function closeDisplayer(received)
{
    $(received).fadeTo(animationSpeed,0);
}
function checkIfUserExists(received)
{
    closeDisplayer(received);
//    showError("#emailErrorsDisplayer", "redColor", "This email is already registered", "#emailErrorsSpan");

}
function flip(div1, div2)
{  
  if(div1.is(':visible'))
  {
      var toHide=div1; 
      var toShow = div2; 
  }
  else
  {
      var toHide=div2; 
      var toShow = div1; 
  }
  console.log(toHide);
  if(!toShow.is(':visible'))
  {
    toHide.removeClass('flip in').addClass('flip out').hide();
    toShow.removeClass('flip out').addClass('flip in').show();
    // toHide.hide();
    // toShow.show();
  }
}
function resetSignUp()
{
    var emailError=true;
    var passwordError=true;
    var confirmPasswordError=true;
}
function ajax(reqUrl, reqType, callback)
{
    $.ajax({
          type: reqType,
          url: reqUrl
           })
    .done(function( msg ) {
          callback(msg);
    })
    .fail(function(msg){
          callback(msg);
    });
    
}

//---------------------------------------------End of basic functionality
//---------------------------------------------Functionality

function logEnter() {
    var username = $("#emailInputLogin").val() ;
    var pas = $("#passwordInputLogin").val() ;
    //$("#result").html("<img src=../loading.gif");
    args = "loginUsername=" + username+"&loginPassword="+pas;
    $.ajax({
      url : "../login.php",
      data: args,
      type: "POST",
      success: function(lCheck) {
        if ( lCheck == "fail")
          {
            if (username=="" && pas=="")
               {
                showError("#emailErrorsDisplayerLogin", "redColor", "Please enter username and password!", "#emailErrorsSpanLogin");
              }
            else
               {
                 showError("#emailErrorsDisplayerLogin", "redColor", "The username or password is wrong!", "#emailErrorsSpanLogin");
               }
          }
          else {window.open ('/player.php?lang='+language,'_self',false);}
      }
    });
                  }//logEnter
