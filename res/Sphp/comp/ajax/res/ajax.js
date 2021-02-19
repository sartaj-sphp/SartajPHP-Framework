var servfindex = 0;
var strprocess = "";
// returndatatype variable
var returndataobj;
var onajaxreceive = function($response){
    
};
/*
 * jQuery Ajax Progress - Lightweight jQuery plugin that adds support of `progress` and `uploadProgress` events to $.ajax()
 * Copyright (c) 2018 Alexey Lizurchik <al.lizurchik@gmail.com> (@likerR_r)
 * Licensed under the MIT license https://github.com/likerRr/jq-ajax-progress
 * http://likerrr.mit-license.org/
 */

(function(factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
  } else if (typeof exports === 'object') {
    // Node/CommonJS
    module.exports = factory(require('jquery'));
  } else {
    // Browser globals
    factory(jQuery);
  }
}(function($) {
  var $originalAjax = $.ajax.bind($);

  $.ajax = function (url, options) {
    if (typeof url === 'object') {
      options = url;
      url = undefined;
    }

    options = options || {
      chunking: false
    };

    // Get current xhr object
    var xmlHttpReq = options.xhr ? options.xhr() : $.ajaxSettings.xhr();
    var chunking = options.chunking || $.ajaxSettings.chunking;

    // Make it use our own.
    options.xhr = function () {
      if (typeof options.uploadProgress === 'function') {
        if (!xmlHttpReq.upload) {
          return;
        }

        // this line looks strange, but without it chrome doesn't catch `progress` event on uploading. Seems like chromium bug
        xmlHttpReq.upload.onprogress = null;

        // Upload progress listener
        xmlHttpReq.upload.addEventListener('progress', function (e) {
          options.uploadProgress.call(this, e);
        }, false);
      }

      if (typeof options.progress === 'function') {
        var lastChunkLen = 0;

        // Download progress listener
        xmlHttpReq.addEventListener('progress', function (e) {
          var params = [e],
            chunk = '';

          if (this.readyState === XMLHttpRequest.LOADING && chunking) {
            chunk = this.responseText.substr(lastChunkLen);
            lastChunkLen = this.responseText.length;
            params.push(chunk);
          }

          options.progress.apply(this, params);
        }, false);
      }

      return xmlHttpReq;
    };

    return $originalAjax(url, options);
  };
}));

jql.fn.getJSON = function(){
    var o = {};
    var a = this.serializeArray();
    jql.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
jql.fn.JSONtoString = function(){
o = "[";
jql.each(this, function(key,val) {
o += "," + JSON.stringify(val);
    });
    o += "]";
    return o;
};

    jql.fn.sleep = function(time){  
        var i = jql(this);  
        i.queue(function(){  
            setTimeout(function(){ 
                i.dequeue(); 
            }, time);  
        });  
    };  

(function( jql ) {
	// Several of the methods in this plugin use code adapated from Prototype
	//  Prototype JavaScript framework, version 1.6.0.1
	//  (c) 2005-2007 Sam Stephenson
	var regs = {
		undHash: /_|-/,
		colons: /::/,
		words: /([A-Z]+)([A-Z][a-z])/g,
		lowUp: /([a-z\d])([A-Z])/g,
		dash: /([a-z\d])([A-Z])/g,
		replacer: /\{([^\}]+)\}/g,
		dot: /\./
	},
		getNext = function(current, nextPart, add){
			return current[nextPart] || ( add && (current[nextPart] = {}) );
		},
		isContainer = function(current){
			var type = typeof current;
			return type && (  type == 'function' || type == 'object' );
		},
		getObject = function( objectName, roots, add ) {
			
			var parts = objectName ? objectName.split(regs.dot) : [],
				length =  parts.length,
				currents = jql.isArray(roots) ? roots : [roots || window],
				current,
				ret, 
				i,
				c = 0,
				type;
			
			if(length == 0){
				return currents[0];
			}
			while(current = currents[c++]){
				for (i =0; i < length - 1 && isContainer(current); i++ ) {
					current = getNext(current, parts[i], add);
				}
				if( isContainer(current) ) {
					
					ret = getNext(current, parts[i], add); 
					
					if( ret !== undefined ) {
						
						if ( add === false ) {
							delete current[parts[i]];
						}
						return ret;
						
					}
					
				}
			}
		},

		str = jql.String = jql.extend( jql.String || {} , {
			getObject : getObject,
			capitalize: function( s, cache ) {
				return s.charAt(0).toUpperCase() + s.substr(1);
			},
			camelize: function( s ) {
				s = str.classize(s);
				return s.charAt(0).toLowerCase() + s.substr(1);
			},
			classize: function( s , join) {
				var parts = s.split(regs.undHash),
					i = 0;
				for (; i < parts.length; i++ ) {
					parts[i] = str.capitalize(parts[i]);
				}

				return parts.join(join || '');
			},
			niceName: function( s ) {
				str.classize(parts[i],' ');
			},

			underscore: function( s ) {
				return s.replace(regs.colons, '/').replace(regs.words, '$1_$2').replace(regs.lowUp, '$1_$2').replace(regs.dash, '_').toLowerCase();
			},
			sub: function( s, data, remove ) {
				var obs = [];
				obs.push(s.replace(regs.replacer, function( whole, inside ) {
					//convert inside to type
					var ob = getObject(inside, data, typeof remove == 'boolean' ? !remove : remove),
						type = typeof ob;
					if((type === 'object' || type === 'function') && type !== null){
						obs.push(ob);
						return "";
					}else{
						return ""+ob;
					}
				}));
				return obs.length <= 1 ? obs[0] : obs;
			}
		});

})(jql);
(function( jql ) {

	// if we are initializing a new class
	var initializing = false,
		makeArray = jql.makeArray,
		isFunction = jql.isFunction,
		isArray = jql.isArray,
		extend = jql.extend,
		concatArgs = function(arr, args){
			return arr.concat(makeArray(args));
		},
		// tests if we can get super in .toString()
		fnTest = /xyz/.test(function() {
			xyz;
		}) ? /\b_super\b/ : /.*/,
		inheritProps = function( newProps, oldProps, addTo ) {
			addTo = addTo || newProps
			for ( var name in newProps ) {
				// Check if we're overwriting an existing function
				addTo[name] = isFunction(newProps[name]) && 
							  isFunction(oldProps[name]) && 
							  fnTest.test(newProps[name]) ? (function( name, fn ) {
					return function() {
						var tmp = this._super,
							ret;
						this._super = oldProps[name];
						ret = fn.apply(this, arguments);
						this._super = tmp;
						return ret;
					};
				})(name, newProps[name]) : newProps[name];
			}
		},

	clss = jql.Class = function() {
		if (arguments.length) {
			clss.extend.apply(clss, arguments);
		}
	};

	/* @Static*/
	extend(clss, {
		callback: function( funcs ) {

			//args that should be curried
			var args = makeArray(arguments),
				self;

			funcs = args.shift();

			if (!isArray(funcs) ) {
				funcs = [funcs];
			}

			self = this;
			
			return function class_cb() {
				var cur = concatArgs(args, arguments),
					isString, 
					length = funcs.length,
					f = 0,
					func;

				for (; f < length; f++ ) {
					func = funcs[f];
					if (!func ) {
						continue;
					}

					isString = typeof func == "string";
					if ( isString && self._set_called ) {
						self.called = func;
					}
					cur = (isString ? self[func] : func).apply(self, cur || []);
					if ( f < length - 1 ) {
						cur = !isArray(cur) || cur._use_call ? [cur] : cur
					}
				}
				return cur;
			}
		},
		getObject: jql.String.getObject,
		newInstance: function() {
			var inst = this.rawInstance(),
				args;
			if ( inst.setup ) {
				args = inst.setup.apply(inst, arguments);
			}
			if ( inst.init ) {
				inst.init.apply(inst, isArray(args) ? args : arguments);
			}
			return inst;
		},
		setup: function( baseClass, fullName ) {
			this.defaults = extend(true, {}, baseClass.defaults, this.defaults);
			return arguments;
		},
		rawInstance: function() {
			initializing = true;
			var inst = new this();
			initializing = false;
			return inst;
		},
		extend: function( fullName, klass, proto ) {
			// figure out what was passed
			if ( typeof fullName != 'string' ) {
				proto = klass;
				klass = fullName;
				fullName = null;
			}
			if (!proto ) {
				proto = klass;
				klass = null;
			}

			proto = proto || {};
			var _super_class = this,
				_super = this.prototype,
				name, shortName, namespace, prototype;
			initializing = true;
			prototype = new this();
			initializing = false;
			// Copy the properties over onto the new prototype
			inheritProps(proto, _super, prototype);

			// The dummy class constructor

			function Class() {
				// All construction is actually done in the init method
				if ( initializing ) return;

				if ( this.constructor !== Class && arguments.length ) { //we are being called w/o new
					return arguments.callee.extend.apply(arguments.callee, arguments)
				} else { //we are being called w/ new
					return this.Class.newInstance.apply(this.Class, arguments)
				}
			}
			// Copy old stuff onto class
			for ( name in this ) {
				if ( this.hasOwnProperty(name) ) {
					Class[name] = this[name];
				}
			}

			// copy new props on class
			inheritProps(klass, this, Class);

			// do namespace stuff
			if ( fullName ) {

				var parts = fullName.split(/\./),
					shortName = parts.pop(),
					current = clss.getObject(parts.join('.'), window, true),
					namespace = current;

				
				current[shortName] = Class;
			}

			// set things that can't be overwritten
			extend(Class, {
				prototype: prototype,
				namespace: namespace,
				shortName: shortName,
				constructor: Class,
				fullName: fullName
			});

			//make sure our prototype looks nice
			Class.prototype.Class = Class.prototype.constructor = Class;

			var args = Class.setup.apply(Class, concatArgs([_super_class],arguments));

			if ( Class.init ) {
				Class.init.apply(Class, args || []);
			}

			/* @Prototype*/
			return Class;
		}

	})


	clss.prototype.
	callback = clss.callback;


})(jql);

var xmlHttp;
var obj1;
var objProg;

function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp = new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}

function setVald(tagid,val1){
var browser=navigator.appName;
var b_version=navigator.appVersion;
var version=parseFloat(b_version);
obj1 = document.getElementById(tagid);
var type = obj1.tagName;
switch(browser){
case 'Microsoft Internet Explorer':{
if(type=='INPUT'){
obj1.setAttribute(val1);
}
else if(type=='TEXTAREA'){
obj1.innerHTML = val1;
}
else if(type=='SELECT'){
obj1.options[obj1.selectedIndex].value = val1;
}
else if(type=='DIV'){
obj1.innerHTML=val1;
}
break;
}

default:{
if(type=='INPUT'){
obj1.value = val1;
}
else if(type=='TEXTAREA'){
obj1.value = val1;
}
else if(type=='SELECT'){
obj1.options[obj1.selectedIndex].value = val1;
}
else if(type=='DIV'){
jql(obj1).html(val1);
}
break;
}

}// end switch
}

function setActString(){
if (xmlHttp.readyState==4){
     if (xmlHttp.status == 200) {
   var Res = xmlHttp.responseText;
Res = jql.trim(Res);
setVald(obj1,Res);
if(objProg!=''){
eval(objProg+'()');
}
}
else {
            alert('There was a problem with the request.');
         }

}
}


function getPostData(url,objID,objShow,MIMEType,parameters){
if (url.length==0)
  {
  return;
  }
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
obj1 = objID ;
if(MIMEType!=''){
xmlHttp.overrideMimeType(MIMEType);
}
if(objShow!=''){
objProg = objShow;
}else{
objProg = '';
    }
xmlHttp.onreadystatechange = setActString;
xmlHttp.open('POST', url, true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.setRequestHeader("Content-length", parameters.length);
xmlHttp.setRequestHeader("Connection", "close");
xmlHttp.send(parameters);

}
function getData(url,objID,objShow){
if (url.length==0)
  {
  return;
  }
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
obj1 = objID ;
if(objShow!=''){
objProg = objShow;
}else{
objProg = '';
    }
xmlHttp.onreadystatechange = setActString;
xmlHttp.open('GET', url, true);
xmlHttp.send(null);

}
function createOverlay(text) {
    jql("<table id='overlay'><tbody><tr><td>" + text + "</td></tr></tbody></table>").css({
        "position": "fixed",
        "top": 0,
        "left": 0,
        "width": "100%",
        "height": "100%",
        "background-color": "rgba(0,0,0,.5)",
        "z-index": 10000,
        "vertical-align": "middle",
        "text-align": "center",
        "color": "#fff",
        "font-size": "30px",
        "font-weight": "bold",
        "cursor": "wait"
    }).appendTo("body");
}
function displayOverlay(id) {
    jql("#" + id).css({
        "position": "fixed",
        "top": 0,
        "left": 0,
        "width": "100%",
        "height": "100%",
        "background-color": "rgba(0,0,0,.5)",
        "z-index": 10000,
        "vertical-align": "middle",
        "text-align": "center",
        "color": "#fff",
        "font-size": "30px",
        "font-weight": "bold",
        "cursor": "wait",
        "display": "block",
        "visibility": "visible"
    });
//    setTimeout(function(){
//        hideOverlay(id);
//    },10000);
    }
function removeOverlay() {
    jql("#overlay").remove();
}
function hideOverlay(id) {
    jql("#" + id).css({
        "display": "none",
        "visibility": "hidden"
    });
}
function sartajgt(idimg,url,data,cache,dataType){
    let sphp_ajax2 = new sphp_ajax();
sphp_ajax2.ajaxcall(idimg,url,data,cache,dataType);
}
function getURL(url,data,runbackground){
    let sphp_ajax2 = new sphp_ajax();
sphp_ajax2.ajaxcall('',url,data,true,'json',true,runbackground);
}
function getAJAX(url,data,runbackground,callback){
    let sphp_ajax2 = new sphp_ajax();
sphp_ajax2.ajaxcall('',url,data,true,'json',true,runbackground,callback);
}
function getAJAXStream(url,data,runbackground,callback){
    let sphp_ajax2 = new sphp_ajax();
sphp_ajax2.ajaxcallchunk('',url,data,true,'json',true,runbackground,callback);
}
function parseSphpResponse(data,callback){
    let sphp_ajax2 = new sphp_ajax();
    sphp_ajax2.sartajpro(data,callback);
}
function sartajpro(data,callback){
    let sphp_ajax2 = new sphp_ajax();
    sphp_ajax2.sartajpro(data,callback);
}

function sphp_wsocket(url="ws://127.0.0.1:8000/sphp.ws",callBackNativem){
var myself = this;
this.status = false;
this.esocket = new WebSocket(url);
this.esocket.onopen = function (event) {
myself.status = true;
callBackNativem("sopen");
//myself.callProcess("indexc2","evt","evtp",{"test":"val"});
  //console.log(event);
};
this.esocket.onmessage = function (event) {
	//console.log("onmsg " + event.data);
	parseSphpResponse(event.data,function(ret){
		callBackNativem(ret);
	});
};
this.esocket.onclose = function (event) {
myself.status = false;
	callBackNativem("sclose");
  console.log("close by server ");
};
this.esocket.onerror = function (event) {
  console.log("socket error " + event);
};
this.sendMsg = function(ctrl,msg){
	data = {};
	data["wsmsg"] = msg;
	myself.callProcessApp(ctrl,"","",data);
}
this.callGlobalApp = function(ctrl,evt,evtp,data){
	var data2 = {}; 
	data2['ctrl'] = ctrl;
	data2['evt'] = evt;
	data2['evtp'] = evtp;
	data2['type'] = "";
	data2['typeappobj'] = "s";
	data2['token'] = "";
	data2['bdata'] = data;
	if(myself.status){
            myself.esocket.send(JSON.stringify(data2));
	}
};
this.callProcessApp = function(ctrl,evt,evtp,data){
	var data2 = {}; 
	data2['ctrl'] = ctrl;
	data2['evt'] = evt;
	data2['evtp'] = evtp;
	data2['type'] = "";
	data2['typeappobj'] = "m";
	data2['token'] = "";
	data2['bdata'] = data;
	if(myself.status){
            myself.esocket.send(JSON.stringify(data2));
	}
};
this.processApp = function(ctrl,data){
    this.callProcessApp(ctrl,"","",data);
};

}

function sphp_ajax() {
    let MySelf = this;
this.ajaxcall = function(idimg,url,data2,cache,dataType,async,runbackground1,callback){
var async2 = true;
var runbackground = false;
if(async==false){
async2 = false;
}
if(runbackground1==true){
runbackground = true;
}
if(runbackground==false){
if(idimg!=''){
//document.getElementById(idimg).style.visibility = 'visible';
displayOverlay(jql("#" + idimg).html());
}else if(document.getElementById("ajax_loader")!=null){
idimg = "ajax_loader";
//document.getElementById(idimg).style.visibility = 'visible';	
displayOverlay(idimg);
}
}
jql.ajax({
type: "POST",
url: url,
dataType: "text",
data: data2,
cache: cache,
async: async2,
success: function(html)
{
if(runbackground==false && idimg!=''){
hideOverlay(idimg);
//document.getElementById(idimg).style.visibility = 'hidden';
}
if(callback != undefined){
MySelf.sartajpro(html,callback); 
}else{
MySelf.sartajpro(html,onajaxreceive); 
}
}
});
};
this.ajaxcallchunk = function(idimg,url,data2,cache,dataType,async,runbackground1,callback){
var async2 = true;
var runbackground = false;
if(async==false){
async2 = false;
}
if(runbackground1==true){
runbackground = true;
}
if(runbackground==false){
if(idimg!=''){
//document.getElementById(idimg).style.visibility = 'visible';
displayOverlay(jql("#" + idimg).html());
}else if(document.getElementById("ajax_loader")!=null){
idimg = "ajax_loader";
//document.getElementById(idimg).style.visibility = 'visible';	
displayOverlay(idimg);
}
}
jql.ajax({
type: "POST",
url: url,
dataType: "text",
data: data2,
cache: cache,
async: async2,
chunking: true,
 progress: function(e, part) {
if(callback != undefined){
MySelf.sartajpro(part,callback); 
}else{
MySelf.sartajpro(part,onajaxreceive); 
}
     
 },
success: function(html)
{
if(runbackground==false && idimg!=''){
hideOverlay(idimg);
//document.getElementById(idimg).style.visibility = 'hidden';
}
if(callback != undefined){
//MySelf.sartajpro(html,callback); 
}else{
//MySelf.sartajpro(html,onajaxreceive); 
}
}
});
};
this.sartajpro = function(valm,callback){
    let jsonobjar = JSON.parse("[" + valm + "{}]");
    for(let c=0;c<jsonobjar.length - 1;c++){
        this.sartajprom(jsonobjar[c],callback);
    }
}
this.sartajprom = function(val,callback){
    MySelf.sartajpro2(val);
if(val.response.retobj!= undefined){ 
    callback(val.response.retobj);
}else{
    callback();
}    
};
this.sartajpro2 = function(val){
if(val.response.css!= undefined){ 
jql.each(val.response.css, function(keym2, valuem2) {
jql.each(valuem2, function(key, value) {
MySelf.sartajproc('css',key,value,val);
});
});
}else{
MySelf.ldjs(val);    
}

};
this.ldjs = function(val){
if(val.response.jsfl!= undefined){ 
jql.each(val.response.jsfl, function(keym2, valuem2) {
jql.each(valuem2, function(key, value) {
MySelf.sartajproc('jsfl',key,value,val);
});
});
}else{
MySelf.ldmid(val);    
}
};
this.ldmid = function(val){
if(val.response.html!= undefined){ 
jql.each(val.response.html, function(keym2, valuem2) {
jql.each(valuem2, function(key, value) {
MySelf.sartajproc('html',key,value,val);
});
});
}
if(val.response.js!= undefined){ 
jql.each(val.response.js, function(keym2, valuem2) {
jql.each(valuem2, function(key, value) {
MySelf.sartajproc('js',key,value,val);
});
});
}
if(val.response.jsp!= undefined){ 
jql.each(val.response.jsp, function(keym2, valuem2) {
jql.each(valuem2, function(key, value) {
MySelf.sartajproc('jsp',key,value,val);
});
});
}
if(val.response.jsf!= undefined ){ 
jql.each(val.response.jsf, function(keym2, valuem2) {
jql.each(valuem2, function(key, value) {
MySelf.sartajproc('jsf',key,value,val);
});
});
}

};
this.sartajproc = function(keym,key,value,val){
if(key!= undefined){ 
switch(key){
    case 'proces' :{ 
jql.globalEval(value);
break;
    }
    case 'csslink' :{
servfindex = 0;
loadFiles(fileList2,keym,MySelf.ldjs,val);    
break;
    }
    case 'jslink' :{
servfindex = 0; 
loadFiles(fileList,keym,MySelf.ldmid,val);    
break;
    }
}
if(keym=="html"){ 
jql('#'+key).html(value);
}else if(keym=="jsf"){ 
var funCall = key + "(" + value + ");";
jql.globalEval(funCall);
}

}
};
};


function loadFiles(fileListn,ftype,complete,val){
if(fileListn.length > servfindex){
furl = fileListn[servfindex];
var link = null;
if(ftype == 'css'){
if(include_once(furl,'css')){
link = jql("<link />");
link.appendTo(jql('head')).attr({load: function() {
servfindex += 1;
//console.log('download ' + furl + ' done');
loadFiles(fileListn,ftype,complete,val);
},type: "text/css",rel: 'stylesheet',href: furl});

//jql("head").append( link ); 
}else{
servfindex += 1;
//console.log('already download ' + furl + ' done');
loadFiles(fileListn,ftype,complete,val);    
}
}
else if(ftype == 'jsfl'){
if(include_once(furl,'jsfl')){
link = jql('<script></script>');
link.attr({
        type: "text/javascript",
        load: function() {
servfindex += 1;
//alert(servfindex + ' ' + furl);
//console.log('download ' + furl + ' done');
},
src: furl
});
jql("body").append( link ); 
//alert(servfindex + ' ap ' + jql(link));
loadFiles(fileListn,ftype,complete,val);

}else{
servfindex += 1;
//console.log('already download ' + furl + ' done');
loadFiles(fileListn,ftype,complete,val);    
}
}
}else{
//console.log('download ' + ftype + ' done');
	complete(val);
	}
}


var jq = {
    get: function( obj ) { 
    return jql(obj);
    },
    flush: function() { }
  };
var jsfilelinks = {};
function include_once(url,ftype) {    
var blnF = true;
if(ftype=='jsfl'){
if (jql('head').find('script[src="' + url + '"]').length>0) {
//jql('head script').each(function() {
//    stuff[jql(this).attr('value')] = jql(this).attr('checked');
//console.log('file js yes ' + jql(this).attr('src') + ' done ');
//});
blnF = false;
    }
else if (jsfilelinks[url]!= undefined) {
blnF = false;
    }
else{
jsfilelinks[url] = url;    
}
}else if(ftype=='css'){
if (jql('head').find('link[href="' + url + '"]').length>0) {
//console.log('file css yes ' + url + ' done');
blnF = false;
    }
}
return blnF;
}
function time_next(jqtimeline) {
jql(jqtimeline).each(function(index) {
var at_time = jql(this)[0].at_time;
var command = (jql(this)[0].command);
 if(at_time != 'undefined'){
    setTimeout(function () {
var command2 = command;
        command2();
    }, at_time);
 }

});

}
jql.Class("Row",{},{
	init: function(key,drow,tblName){
		this.key = key;
		this.tblName = tblName;
		this.data = drow;
		},
status: '',
        getJSONObject: function(key){
            var dt = {};
            dt['key'] = this.key;
            dt['data'] = this.data;
            dt['tblName'] = this.tblName;
            dt['status'] = this.status;
            return dt;
        }        
    }
);
jql.Class("Recordset",
// static properties
{
  count: 0  
},
// prototype properties
{
  // constructor function
  init : function(key,tblName){
    //save the name
    this.key = key;
    this.tblName = tblName;
    this.Class.count++;
  },
rows: [],
addRow: function(key,drow,tblName){
if(this.rows[key]==undefined){
var	mrow = new Row(key,drow,tblName);
mrow.status = 'new';
this.rows[key] = mrow;
}else{alert(key + ', This Record can not overwrite!');}
	},
addRowServ: function(key,drow,tblName){
if(this.rows[key]==undefined){
var	mrow = new Row(key,drow,tblName);
mrow.status = 'news';
this.rows[key] = mrow;
}
	},
isRecordExist: function(key){
if(this.rows[key]!=undefined){
    return true;
}else{
    return false;
}
},
updateRow: function(key,drow,tblName){
if(this.rows[key]!=undefined){
if(this.rows[key].status=='new'){this.rows[key].status='insert'}
if(this.rows[key].status=='insert'){this.rows[key].status='insert'}
if(this.rows[key].status=='news'){this.rows[key].status='update'}
this.rows[key].key = key;
this.rows[key].data = drow;
this.rows[key].tblName = tblName;
}else{alert(key + ', This Record is not Exist!');}
	},
deleteRow: function(key,drow,tblName){
if(this.rows[key]!=undefined){
if(this.rows[key].status=='new'){this.rows[key].status=''}
if(this.rows[key].status=='insert'){this.rows[key].status=''}
if(this.rows[key].status=='news'){this.rows[key].status='delete'}
this.rows[key].key = key;
this.rows[key].data = drow;
this.rows[key].tblName = tblName;
}else{alert(key + ', This Record is not Exist!');}
	},
getJSONString: function(){
var o = "[";
for (var i in this.rows){
if(this.rows[i].status!='news'){
//this.rows[i].status = 'news';
if(o=="["){
o +=  JSON.stringify(this.rows[i]);    
}else{
o +=  "," + JSON.stringify(this.rows[i]);        
}
}
}
    o += "]";
    return o;
},
getUpdateData: function(){
 var recm = {};
for (var i in this.rows){
if(this.rows[i].status!=='news'){
recm[i] = this.rows[i].getJSONObject();
}
}
return recm;    
},
serverUpdateDone: function(){
for (var i in this.rows){
if(this.rows[i].status!='news'){
this.rows[i].status = 'news';
}
}
    
},
postData: function(data){
data[this.key] = this.getJSONString();
},
clearData: function(){
this.rows = [];
}

});
jql.fn.outerHTML = function() 
{
  $t = jql(this);
  if( "outerHTML" in $t[0] ) return $t[0].outerHTML; 
  else return $t.clone().wrap('<p>').parent().html(); 
}

