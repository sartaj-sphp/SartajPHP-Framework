function getVal(tagid,type){
var browser=get_browser();
var val1='';
obj1 = document.getElementById(tagid);

switch(browser['appName']){
case 'Microsoft Internet Explorer':{
if(type=='TextField'){
val1 = obj1.getAttribute('value');
if(!isset(val1)){
val1 = $(obj1).val();    
}
}
else if(type=='TextArea'){
val1 = obj1.innerHTML;
}
else if(type=='Select'){
val1 = obj1.options[obj1.selectedIndex].value;
}
break;
}

default:{
if(type=='TextField'){
val1 = $(obj1).val();    
}
else if(type=='TextArea'){
val1 = $(obj1).val();    
}
else if(type=='Select'){
val1 = obj1.options[obj1.selectedIndex].value;
}
break;
}

}// end switch
if(val1==null){
	val1 = '';
	}
return val1;
}

function checkmax(ctlText){
var obj1;
var val1;
var msg;
var type;
var returnval = true;
var limit;

for(var c in ctlText){
obj1 = document.getElementById(c);
type = ctlText[c][1];
msg = ctlText[c][0];
limit = ctlText[c][2];
val1 = getVal(c,type);
if(val1.length > limit){
returnval = false;
alert("Please Type less then " + limit + "  chracters in " + msg);
break;
}

}
return returnval;

}

function checkmin(ctlText){
var obj1;
var val1;
var msg;
var type;
var returnval = true;
var limit;

for(var c in ctlText){
obj1 = document.getElementById(c);
type = ctlText[c][1];
msg = ctlText[c][0];
limit = ctlText[c][2];
val1 = getVal(c,type);
if(val1!='' && val1.length < limit){
returnval = false;
displayValidationError(obj1,"Please Type more then or = " + limit + "  chracters in " + msg);
break;
}
}
return returnval;

}

var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i
function checkEmail(e)
{
val1 = e; var returnval = true;
if(val1!=''){
returnval=emailfilter.test(val1);
}
return returnval;
}

function checkemails(ctlText){
var obj1;
var val1;
var msg;
var type;
var returnval = true;
for(var c in ctlText){
obj1 = document.getElementById(c);
type = ctlText[c][1];
msg = ctlText[c][0];
val1 = getVal(c,type);
if(checkEmail(val1)==false ){
returnval = false;
displayValidationError(obj1,ctlText[c][0] + " should be a valid email");
break;
}

}
return returnval;

}

function validNum(e)
{
sText = e;
   var ValidChars = "-0123456789.";
   var IsNumber=true;
   var Char;


   for (i = 0; i < sText.length && IsNumber == true; i++)
      {
	  //alert(i);
      Char = sText.charAt(i);
	  //alert(ValidChars.indexOf(Char));
      if (ValidChars.indexOf(Char) == -1)
         {
         IsNumber = false;
        break;
         }
      }
   return IsNumber;
   }

function checknums(ctlText){
var obj1;
var val1;
var msg;
var type;
var returnval = true;

for(var c in ctlText){
obj1 = document.getElementById(c);
type = ctlText[c][1];
msg = ctlText[c][0];
val1 = getVal(c,type);
if(validNum(val1)==false ){
returnval = false;
displayValidationError(obj1,ctlText[c][0] + " should be a valid Number");
break;
}

}
return returnval;

}

function checkTextEmpty(ctlText){
var obj1;
var val1;
var msg;
var type;
var returnval = true;
for(var c in ctlText){
obj1 = document.getElementById(c);
if(obj1!=null){
type = ctlText[c][1];
msg = ctlText[c][0];
val1 = getVal(c,type);
if(val1 == ''){
returnval = false;
displayValidationError(obj1,msg + " can not Empty! " + c);
break;
}
}

}
return returnval;

}

function displayValidationError(obj,msg){
//clearValidationError(obj);
$(obj).on("keyup",clearValidationError);
$(obj).addClass("valide alert-danger");
$(obj).attr("data-toggle","tooltip");
$(obj).attr("title",msg);
$(obj).attr("data-original-title",msg);
$(function () {
  $(obj).tooltip({title: msg});
  $(obj).tooltip('show');
  if(sphp_versions['bootstrap']==='3'){
      $(obj).tooltip('fixTitle');
  }
});
 
//alert(msg);
obj.focus();
}
function clearValidationError(obj){
$('.valide').removeClass("valide alert-danger");
}

