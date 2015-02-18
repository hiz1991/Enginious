<?php include '../db.php';
include '../transl.php';
$bs=getTransBase();
$clientLang = "en";
if(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))
  {
    $clientLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
  }
error_log($clientLang);?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title id="title">Enginous</title>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="index.js"></script>
    <script src="blur.js"></script>
    <script src="../lang/languageswitcher.js"></script>
    <link rel="stylesheet" href="clear.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="flip.css">
    <link rel="stylesheet" href="../lang/languageswitcher.css">
    <script type="text/javascript">
      var translObj;
      var language = "<?php echo $clientLang;?>";
      String.prototype.replaceAt=function(index, character) {
        return this.substr(0, index) + character + this.substr(index+character.length);
      }
      function toUpCase(text)
      {
        text = text.replaceAt(0, text.charAt(0).toUpperCase());
        return text;
      }
      function toLowCase(text)
      {
        text = text.replaceAt(0, text.charAt(0).toLowerCase());
        return text;
      }
      function checkifUpperCase(text)
      {console.log(text, text.toUpperCase());
          if (text.charAt(0) == text.charAt(0).toUpperCase()) {
            console.log("Upper");
           return true;
          }
          if (text.charAt(0) == text.charAt(0).toLowerCase()){
             console.log("Lower");
           return false;
          }
      }
      function translate(text, obj, lang)
      {
        if(!obj) obj=translObj;
        if(!lang) lang = language;
        // if(!text) text ="deafult";
        var upperCase = checkifUpperCase(text);
        // console.log(upperCase);
        var returned = text;
        $.each(obj, function(i, v) 
        {
          $.each(obj[i], function (index, value) 
          {
            // console.log(text);
            // console.log(obj[i][index], text);
            if(obj[i][index].toLowerCase()==text.toLowerCase())
            {
              returned = (upperCase)?toUpCase(obj[i][lang]):toLowCase(obj[i][lang]);
              // console.log(obj[i][lang]);
            }
            // console.log(index, value);
          });
        });
        return returned;
      }
      function performTranslation()
      {
          var arr = $(".translatable");
          $.each(arr, function (index, value) 
          { 
              $(arr[index]).text(translate($(arr[index]).text(), translObj, language));
          });
          $('form').find("input[type=textarea], input[type=password], textarea").each(function(ev)
            {
                if(!$(this).val()) { 
               $(this).attr("placeholder", translate( $(this).attr("placeholder")));
            }
            });
      }
     $( document ).ready(function() 
     {  
      translObj = JSON.parse('<?php  $json = getTransJson($bs); echo $json;?>') ; 
      performTranslation();
      $('#polyglotLanguageSwitcher').polyglotLanguageSwitcher({
                effect: 'fade',
                testMode: true,
                onChange: function(evt){
                    // alert("The selected language is: "+evt.selectedItem);
                    language = evt.selectedItem;
                    performTranslation();
                }
               });
     });
    </script>
  </head>
  <body>
   <div id="langContainer" style="position:absolute; width: auto; right:30px; top:30px;">
      <!-- begin language switcher -->
        <div id="polyglotLanguageSwitcher">
        <form action="#">
          <select id="polyglot-language-options">
            <option <?php if($clientLang=="ru") echo 'selected="selected"'; ?> id="ru" value="ru">Русский</option>
            <option <?php if($clientLang=="en") echo 'selected="selected"'; ?> id="en" value="en">English</option>
            <option <?php if($clientLang=="fr") echo 'selected="selected"'; ?> id="fr" value="fr">Fran&ccedil;ais</option>
            <option <?php if($clientLang=="de") echo 'selected="selected"'; ?> id="de" value="de">Deutsch</option>
            <option <?php if($clientLang=="zh-TW") echo 'selected="selected"'; ?> id="zh-TW" value="zh-TW">中國傳統</option>
          </select>
        </form>
      </div>
      <!-- end language switcher -->
    </div>
    <div id="dimScreen"></div>
    <div id="logo"><img src="../images/enginious.png"></div>
    <div id="document">
      <div id="form">
        <h3 id="signUpHeader" class="translatable">Sign up</h3><span class="relative"><span class="icon-user"></span>
          <input id="emailInput" placeholder="Type your email here, please" type="textarea" class="icon-user"></span>
        <div id="emailErrorsDisplayer"><span id="emailErrorsSpan"></span></div><span class="relative"><span class="icon-pass"></span>
          <input id="passwordInput" type="password" placeholder="Password here..." type="textarea" class="icon-pass"></span>
        <div id="passwordErrorsDisplayer"><span id="passwordErrorsSpan"></span></div><span class="relative"><span class="icon-pass"></span>
          <input id="confirmPasswordInput" type="password" placeholder="Retype it here..." type="textarea" class="icon-pass"></span>
        <div id="confirmPasswordErrorsDisplayer"><span id="confirmPasswordErrorsSpan"></span></div>
        <div id="submitButton" class="translatable">Sign up</div>
        <div id="orSignInWrapper"> 
          <h4><span><p class="translatable">Or</p> <a id="orSignIn" href="#" class="translatable">sign in</a></span></h4>
        </div>
      </div>
      <div id="formLogin">
        <form>
          <h3 id="signUpHeader" class="translatable">Sign in</h3><span class="relative"><span class="icon-user"></span>
            <input id="emailInputLogin" name="emailLogin" type="textarea" placeholder="Type your email here, please" class="icon-user"></span>
          <div id="emailErrorsDisplayerLogin"><span id="emailErrorsSpanLogin"></span></div><span class="relative"><span class="icon-pass"></span>
            <input id="passwordInputLogin" type="password" name="passwordLogin" placeholder="Password here..." type="textarea" class="icon-pass"></span>
          <div id="passwordErrorsDisplayerLogin"><span id="passwordErrorsSpanLogin"></span></div>
          <div id="submitButtonLogin" class="buttonActiveBlue translatable" >Sign in</div>
          <div id="orSignUpWrapper"> 
            <h4><span><p class="translatable">Or</p> <a id="orSignUp" href="#" class="translatable">sign up</a></span></h4>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>