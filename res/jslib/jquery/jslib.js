/*
 * All rights are reserved by SartajPHP. for more info contact on sartajphp.com
 * 
 */
const lsttempfun = {};
function makeFirstUpper(str){
str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    return letter.toUpperCase();
});
return(str);
}
function parseNumber(variable){
    if (jQuery.type(variable) !== "undefined" && jQuery.type(variable) !== "null") {
        if(variable.length !== 'undefined'){ 
            if(variable.length > 0){
                var f1 = parseFloat(variable,10);
                if(f1 !== "NaN"){
                    parseFloat(variable,10);
                }else{
                    return 0.0;
                }
            }else{
                return parseFloat(variable,10);
            }
        }else if(jQuery.isPlainObject(variable)){
            if(Object.keys(variable).length > 0){
                return Object.keys(variable).length;
            }else{
                return 0.0;
            }
        }else if(jQuery.type(variable) === "number"){ 
            return variable;
        }else if(jQuery.type(variable) === "boolean"){ 
            if(variable) return 1;
            return 0.0;
        }else if(jQuery.type(variable) === "object" && Object.keys(variable).length > 0){ 
            return Object.keys(variable).length;
        }else{
            return 0.0;
        }
    
    }else{ 
        return 0.0;
    }
    
}
function callOnceTimeFirstCall(fun,time){
    var now = Date.now();
    var nt = fun.lascalltime || now; 
    if( nt > now ) return false;
    fun.lascalltime = now + time; 
    return true;
}
function callOnceTimeLastCall(fun,time,callback,args){
    var nt = fun.lascalltimer || 0; 
    clearTimeout(nt);
    fun.lascalltimer = setTimeout(function() {
        callback.apply(fun, args);
    }, time);
}
function restrictNumeric(){
    $(".numeric").keypress(function(event) {
  // Backspace, tab, enter, end, home, left, right
  // We don't support the del key in Opera because del == . == 46.
  var controlKeys = [8, 9, 13, 35, 36, 37, 39];
  // IE doesn't support indexOf
  var isControlKey = controlKeys.join(",").match(new RegExp(event.which));
  // Some browsers just don't raise events for control keys. Easy.
  // e.g. Safari backspace.
  if (!event.which || // Control keys in most browsers. e.g. Firefox tab is 0
      (49 <= event.which && event.which <= 57) || // Always 1 through 9
      (48 == event.which && $(this).attr("value")) || // No 0 first digit
      isControlKey) { // Opera assigns values for control keys.
    return;
  } else {
    event.preventDefault();
  }
});
}
$(document).ready(function() {
$.fn.getSelectionRange = function() {
			var e = this.jquery ? this[0] : this;
			return (
				/* mozilla / dom 3.0 */
				('selectionStart' in e && function() {
					var l = e.selectionEnd - e.selectionStart;
					return { start: e.selectionStart, end: e.selectionEnd, length: l, text: e.value.substr(e.selectionStart, l) };
				}) ||

				/* exploder */
				(document.selection && function() {

					e.focus();

					var r = document.selection.createRange();
					if (r == null) {
						return { start: 0, end: e.value.length, length: 0 }
					}

					var re = e.createTextRange();
					var rc = re.duplicate();
					re.moveToBookmark(r.getBookmark());
					rc.setEndPoint('EndToStart', re);

					return { start: rc.text.length, end: rc.text.length + r.text.length, length: r.text.length, text: r.text };
				}) ||

				/* browser not supported */
				function() {
					return { start: 0, end: e.value.length, length: 0 };
				}

			)();


		};

$.fn.insertAtCaret = function(text) {
			var e = this.jquery ? this[0] : this;
			return (

				/* mozilla / dom 3.0 */
				('selectionStart' in e && function() {
					e.value = e.value.substr(0, e.selectionStart) + text + e.value.substr(e.selectionEnd, e.value.length);
					return this;
				}) ||

				/* exploder */
				(document.selection && function() {
					e.focus();
					document.selection.createRange().text = text;
					return this;
				}) ||

				/* browser not supported */
				function() {
					e.value += text;
					return this;
				}

			)();

		};


$.fn.selectRange = function(start, end) {
        return this.each(function() {
                if(this.setSelectionRange) {
                        this.focus();
                        this.setSelectionRange(start, end);
                } else if(this.createTextRange) {
                        var range = this.createTextRange();
                        range.collapse(true);
                        range.moveEnd('character', end);
                        range.moveStart('character', start);
                        range.select();
                }
        });
};

});

/*
jQuery.fn.testFn = function(options){
    var defaults = {
            validateOPtions1 : '',
            validateOPtions2 : ''
        };
var settings = $.extend({}, defaults, options);
this.each(function(){
        var className = $(this).attr('class');
        $(this).html(className);
    });    
};


// global funvtion start here
jQuery(function(options){
    // [0] gets the first object in array, which is your selected element, you can also use .get(0) in jQuery
    $("#test")[0].addProduct = function(info){
        alert("ID: " + this.id + " - Param: " + info);
    };


    $("#test")[0].addProduct("productid");
});
*/
jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + $(window).scrollLeft()) + "px");
    return this;
}
jQuery.fn.centerHorizontal = function () {
    this.css("position","absolute");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2)) + "px");
    return this;
}
function getPosition(mouseEvent,obj){
    var offs = $(obj).offset();
    var left = mouseEvent.clientX - offs.left;
    var top = mouseEvent.clientY - offs.top; 
    return [left,top];
}
// start global function
function ucwords(str){
str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    return letter.toUpperCase();
});
return(str);
}
function isset2(variable){ 
    if (jQuery.type(variable) !== "undefined" && jQuery.type(variable) !== "null") {
	return true;
    }else{ 
        return false;
    }
}
function is_array(variable){ 
    if(jQuery.type(variable) === "object" && variable.length){ 
        return true;
    }else{
        return false;
    }    
    
}
function is_object(variable){ 
    if(jQuery.isPlainObject(variable)){ 
        return true;
    }else if(jQuery.type(variable) === "object"){ 
        return true;
    }else{
        return false;
    }    
}
function isset(variable){ 
    if (jQuery.type(variable) !== "undefined" && jQuery.type(variable) !== "null") {
        if(variable.length !== 'undefined'){ 
            if(variable.length > 0){
                return true;
            }else{
                return false;
            }
        }else if(jQuery.isPlainObject(variable)){
            if(Object.keys(variable).length > 0){
                return true;
            }else{
                return false;
            }
        }else if(jQuery.type(variable) === "number"){ 
            return true;
        }else if(jQuery.type(variable) === "boolean"){ 
            return true;
        }else if(jQuery.type(variable) === "object" && Object.keys(variable).length > 0){ 
            return true;
        }else{
            return false;
        }
    
    }else{ 
        return false;
    }
}
function get_browser(){
var browsercap = {};
browsercap['appName']=navigator.appName;
var b_version=navigator.appVersion;
browsercap['version']=parseFloat(b_version);
return browsercap;
}
function getAppPath(ctrl){
var loc = new String(window.location);
var url = "";
var hosturl = "";
if(loc.charAt(loc.length-1)=='/'){
hosturl = loc;
url = loc + 'index';
}else{
var sploc = loc;
var lastslashindex = sploc.lastIndexOf('/')+1 ;
var firstqueryindex = sploc.indexOf('?') ;
if(firstqueryindex<0){
    firstqueryindex = loc.length;
}
hosturl = sploc.substr(0,lastslashindex);
var fileurl = sploc.substr(lastslashindex,firstqueryindex - lastslashindex);
 firstqueryindex = fileurl.indexOf('-') ;
if(firstqueryindex<0){
 firstqueryindex = fileurl.indexOf('.') ;
}
var sartajPHPctrl = fileurl.substr(0,firstqueryindex);
url = hosturl + sartajPHPctrl;
}
if(isset(ctrl)){
url = hosturl + ctrl;
}
return url;

}
function getSartajPHPAppURL(ctrl){
var loc = new String(window.location);
var url = "";
var hosturl = "";
if(loc.charAt(loc.length-1)=='/'){
hosturl = loc;
url = loc + 'index';
}else{
var sploc = loc;
var lastslashindex = sploc.lastIndexOf('/')+1 ;
var firstqueryindex = sploc.indexOf('?') ;
if(firstqueryindex<0){
    firstqueryindex = loc.length;
}
hosturl = sploc.substr(0,lastslashindex);
var fileurl = sploc.substr(lastslashindex,firstqueryindex - lastslashindex);
 firstqueryindex = fileurl.indexOf('-') ;
if(firstqueryindex<0){
 firstqueryindex = fileurl.indexOf('.') ;
}
var sartajPHPctrl = fileurl.substr(0,firstqueryindex);
url = hosturl + sartajPHPctrl;
}
if(isset(ctrl)){
url = hosturl + ctrl;
}
return url;

}
$.fn.getClickedElement = function(){
 var obj = this;
$( "*", document.body ).click(function( event ) {
event.stopPropagation();
var domElement = $( this ).get( 0 );
$(obj).text( "Clicked on - " + domElement.nodeName );
});
}

function pasteHtmlAtCaret(html, selectPastedContent) {
    var sel, range;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();

            // Range.createContextualFragment() would be useful here but is
            // only relatively recently standardized and is not supported in
            // some browsers (IE9, for one)
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) {
                lastNode = frag.appendChild(node);
            }
            var firstNode = frag.firstChild;
            range.insertNode(frag);

            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                if (selectPastedContent) {
                    range.setStartBefore(firstNode);
                } else {
                    range.collapse(true);
                }
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if ( (sel = document.selection) && sel.type != "Control") {
        // IE < 9
        var originalRange = sel.createRange();
        originalRange.collapse(true);
        sel.createRange().pasteHTML(html);
        if (selectPastedContent) {
            range = sel.createRange();
            range.setEndPoint("StartToStart", originalRange);
            range.select();
        }
    }
}
function setValue(obj,val){
    var type = $(obj).prop("tagName");
    switch(type){
        case 'INPUT':{
            $(obj).val(val);
            break;
        }case 'TEXTAREA':{
            $(obj).html(val);
            break;
        }case 'SELECT':{
            obj.options[obj.selectedIndex].value = val;
            break;
        }case 'DIV':{
            $(obj).html(val);
            break;
        }default:{
            $(obj).html(val);  
        }
    }
}
function getValue(obj){
    var a1 = $(obj);
    var type = a1.prop("tagName");
    var a2 = {};
    switch(type){
        case 'INPUT':{
                if(a1.length > 1){
                    $.each(a1,function(i,e){
                        if($(e).attr("type") == "checkbox"){
                            if($(e).prop("checked") ) a2[$(e).attr("id")] = $(e).val();                            
                        }else{
                            a2[$(e).attr("id")] = $(e).val();
                        }
                    });
                    return a2;
                }else{
                    return a1.val();
                }
            break;
        }case 'TEXTAREA':{
            if(a1.length > 1){
                $.each(a1,function(i,e){
                    a2[$(e).attr("id")] = $(e).val();
                });
                return a2;
            }else{
                return a1.val();
            }
            break;
        }case 'SELECT':{
            if(a1.length > 1){
                $.each(a1,function(i,e){
                    a2[$(e).attr("id")] = $(e).options[$(e).selectedIndex].value;
                });
                return a2;
            }else{
                return a1.options[a1.selectedIndex].value;
            }
            break;
        }default:{
            if(a1.length > 1){
                $.each(a1,function(i,e){
                    a2[$(e).attr("id")] = $(e).html();
                });
                return a2;
            }else{
                return a1.html();
            }
        }
    }
}
function selectByValue(obj,val){
$(obj).children('option').removeAttr('selected');
$(obj).find('option[value="' + val + '"]').prop("selected",true);
}
function selectByText(obj,val){
$(obj).children('option').removeAttr('selected');
$(obj).find('option:contains("' + val + '")').prop("selected",true);
}
function toggleFullScreen() {
  if (!document.fullscreenElement &&    // alternative standard method
      !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {  // current working methods
    if (document.documentElement.requestFullscreen) {
      document.documentElement.requestFullscreen();
    } else if (document.documentElement.msRequestFullscreen) {
      document.documentElement.msRequestFullscreen();
    } else if (document.documentElement.mozRequestFullScreen) {
      document.documentElement.mozRequestFullScreen();
    } else if (document.documentElement.webkitRequestFullscreen) {
      document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
    }
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    }
  }
}
function format_date(date) {
  month=date.getMonth();
  month=month+1; //javascript date goes from 0 to 11
  if (month<10) month="0"+month; //adding the prefix

  year=date.getFullYear();
  day=date.getDate();
  hour=date.getHours();
  minutes=date.getMinutes();
  seconds=date.getSeconds();

  return month+"-"+day+"-"+year+" "+hour+":"+minutes+":"+seconds;

}

var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(r){var e,t,o,a,h,d,C,c="",f=0;for(r=Base64._utf8_encode(r);f<r.length;)e=r.charCodeAt(f++),t=r.charCodeAt(f++),o=r.charCodeAt(f++),a=e>>2,h=(3&e)<<4|t>>4,d=(15&t)<<2|o>>6,C=63&o,isNaN(t)?d=C=64:isNaN(o)&&(C=64),c=c+this._keyStr.charAt(a)+this._keyStr.charAt(h)+this._keyStr.charAt(d)+this._keyStr.charAt(C);return c},decode:function(r){var e,t,o,a,h,d,C,c="",f=0;for(r=r.replace(/[^A-Za-z0-9\+\/\=]/g,"");f<r.length;)a=this._keyStr.indexOf(r.charAt(f++)),h=this._keyStr.indexOf(r.charAt(f++)),d=this._keyStr.indexOf(r.charAt(f++)),C=this._keyStr.indexOf(r.charAt(f++)),e=a<<2|h>>4,t=(15&h)<<4|d>>2,o=(3&d)<<6|C,c+=String.fromCharCode(e),64!=d&&(c+=String.fromCharCode(t)),64!=C&&(c+=String.fromCharCode(o));return Base64._utf8_decode(c)},_utf8_encode:function(r){r=r.replace(/\r\n/g,"\n");for(var e="",t=0;t<r.length;t++){var o=r.charCodeAt(t);o<128?e+=String.fromCharCode(o):o>127&&o<2048?(e+=String.fromCharCode(o>>6|192),e+=String.fromCharCode(63&o|128)):(e+=String.fromCharCode(o>>12|224),e+=String.fromCharCode(o>>6&63|128),e+=String.fromCharCode(63&o|128))}return e},_utf8_decode:function(r){for(var e="",t=0,o=c1=c2=0;t<r.length;)(o=r.charCodeAt(t))<128?(e+=String.fromCharCode(o),t++):o>191&&o<224?(e+=String.fromCharCode((31&o)<<6|63&(c2=r.charCodeAt(t+1))),t+=2):(e+=String.fromCharCode((15&o)<<12|(63&(c2=r.charCodeAt(t+1)))<<6|63&(c3=r.charCodeAt(t+2))),t+=3);return e}};

/**
 * Replaces template variables {{var1}} in HTML with values from a JSON object
 * @param {string} templateId - ID of the HTML script Tag containing the html template
 * @param {object} data - JSON object with key-value pairs for template variables
 * @returns {string} - Processed HTML with variables replaced
 */
function renderTemplate(templateId, data) {
    // Get the template HTML
    var template = $('#' + templateId).html();
    
    // If template not found, return empty string
    if (!template) {
        console.error('Template with ID "' + templateId + '" not found');
        return '';
    }
    
    // Replace all {{variable}} placeholders with corresponding values
    var renderedHtml = template.replace(/\{\{(\w+)\}\}/g, function(match, variable) {
        // Check if variable exists in data
        if (data.hasOwnProperty(variable)) {
            return data[variable];
        }
        // If variable not found, return the original placeholder
        console.warn('Variable "' + variable + '" not found in provided data');
        return match;
    });
    
    return renderedHtml;
}
async function checkOnlineStatus(){
  try {
    const online = await fetch("/favicon.ico");
    return online.status >= 200 && online.status < 300; // either true or false
  } catch (err) {
    return false; // definitely offline
  }
}
const getMethods = (obj) => {
  var properties = new Set();
  var currentObj = obj;
  do {
    Object.getOwnPropertyNames(currentObj).map(item => properties.add(item));
  } while ((currentObj = Object.getPrototypeOf(currentObj)))
  return [...properties.keys()].filter(item => typeof obj[item] === 'function');
};
//sjslib code
class SuperClass{
	constructor(){
	this.self2 = this; 
	}
    get myself(){
        return this.self2;
    }
};
class Debug extends SuperClass{
		constructor(){
			super();
		}
		printerr(msg){
			var str1 = this.filterMsg(msg);
			if(str1.length > 2){
				console.log("SNode Err:- " + str1);
			}
		}
		printwarn(msg){
			var str1 = this.filterMsg(msg);
			if(str1.length > 2){
				console.log("SNode Warn:- " + str1);
			}
		}
		println(msg){
			var str1 = this.filterMsg(msg);
			if(str1.length > 2){
				console.log("SNode:- " + str1);
			}
		}
		print_r(msga){
			var myself = this.myself;
			msga.forEach(msg => { 
				console.log("SNodeA:- " + myself.filterMsg(msg));
			});
		}
		filterMsg(msg){
			if (msg != undefined) {
				if(typeof msg === 'object'){
					if(typeof msg.toString === 'function'){
						return msg.toString();						
					}else{
						return this.objToString(msg);
					}
				}else{
					return msg;
				}
			}
			return "";
		}
		objToString(obj){
			//console.dir(obj, { depth: null });
			return JSON.stringify(obj);
		}
		objToString2(obj){
			var str = '';
			for (var p in obj) {
				if (obj.hasOwnProperty(p)) {
					str += p + '::' + obj[p] + '\n';
				}
			}
			return str;
		}
}
const debug = new Debug();
function println(msg){
    debug.println(msg);
}
class SphpClass extends SuperClass{
	constructor(){
		super()
		this.debug = debug;
		this.serverPathi = window.location;
		this.onstart();
	}
	get ServerPath(){
		return this.serverPathi;
	}
	
	onstart(){}
};

class Router extends SphpClass{
		constructor(){
			super();
			this.lstregapps = {};
		}
		registerApp(ctrl,path){
			this.lstregapps[ctrl] = path;
		}
		get ListRegApps(){
			return this.lstregapps;
		}
}

const router = new Router();
function registerApp(ctrl,path){
	router.registerApp(ctrl,path);
}
class StQueue extends SphpClass{
    onstart(){
        this.lst = [];
    }
    addInQueue(promise){
        this.lst.push(promise);
    }
    wait(callback,fail){
         Promise.all(this.lst).then(callback).catch(fail);
    }
}
class BasicApp extends SphpClass{
		page_new(){}
                getQueue(){
                    return new StQueue();
                }
}
class CompApp extends SphpClass{
		constructor(){
			super();
                    var myself = this;
			this.state = {};
                        var textNode = $("body")[0];
                        if (textNode.addEventListener) {
                            textNode.addEventListener ('DOMNodeInserted', function(e){myself._onupdate(e)}, false);
                            textNode.addEventListener ('DOMNodeInsertedIntoDocument', function(e){myself._onupdate(e)}, false);
                            //textNode.addEventListener ('DOMNodeRemoved', function(e){myself._onupdate(e)}, false);
                            //textNode.addEventListener ('DOMNodeRemovedFromDocument', function(e){myself._onupdate(e)}, false);
                        }
                        myself._setupEventHnadlers();
		}
                _onupdate(e){
                    //debug.println("node insert");
                    //console.log(e);
                    //myself._setupEventHnadlers();
                }
                _setupEventHnadlers(){
                    var myself = this;
                    var fun1 = getMethods(this);
                    $.each(fun1,function(index,funname){
                        var fun2 = funname.split("_");
                        if(fun2[0] === "comp"){
                            var compselector = fun2[2];
                            var compevent = fun2[3];
                            if(fun2[1] == "class"){
                                compselector = "." + compselector;
                            }else if(fun2[1] == "id"){
                                compselector = "#" + compselector;
                            }
                            $(compselector).on(compevent,function(e){
                                myself[funname](e);
                            });
                        }
                    });
                    //debug.println("node removed document");
                }
                setState(val){
                    var myself = this;
                    this.state = $.extend(myself.state,val); 
                }
                lcomp_class_headerbar_click(e){
                    var str = 'hello, <b id="bd1" data-text="red">my name is</b> jQuery.';
                    var html = $.parseHTML( str );
                    $.each( html, function( i, el ) {
                        if(el.nodeName !== "#text"){
                       //console.log("<li>" + el.nodeName + "</li>");
                       sconsole.dir(el.attributes);
                        }
                    });
                }
		page_new(){}
                getQueue(){
                    return new StQueue();
                }
}
class StartEngine {
		constructor(){
			this.projectDir = window.location;
			this.lstappsobj = {};
			this.debug = debug
		}
		get serverPath(){
			return this.projectDir;
		}
		getEventTrigger(evt,evtp,ctrl){
			var obj2 = this.getApp(ctrl);
			var fcall = 'page_event_' + evt ;
			try{
			return obj2[fcall](evtp);
			}catch(e){
				this.debug.println(ctrl + " Application doesn't have event handler " + evt + " or error " + e);
			}

		}
		getAppTrigger(ctrl){
			var obj2 = this.getApp(ctrl);
			return obj2.page_new();
		}
		getApp(ctrl){
			if(this.lstappsobj[ctrl]){
				return this.lstappsobj[ctrl];
			}else{
				var obj1 = router.ListRegApps[ctrl];
				this.lstappsobj[ctrl] = new obj1();
				return this.lstappsobj[ctrl];
			}
		}
                getEventPara(event,ui,aname){
                    return {obj: $(event.target),evt: aname,event: event,ui: ui};
                }
}
const sphp_api = new StartEngine();


