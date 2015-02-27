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
{
  // console.log(text, text.toUpperCase());
    if (text.charAt(0) == text.charAt(0).toUpperCase()) {
      // console.log("Upper");
     return true;
    }
    if (text.charAt(0) == text.charAt(0).toLowerCase()){
       // console.log("Lower");
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
    $('#document').find("input[type=textarea], input[type=password], textarea").each(function(ev)
      {
          if(!$(this).val()) { 
         $(this).attr("placeholder", translate( $(this).attr("placeholder")));
      }
      });
}