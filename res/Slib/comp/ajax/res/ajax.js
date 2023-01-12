var servfindex = 0;
var sphpajready1 = function(){};
// returndatatype variable
var returndataobj;
var onajaxreceive = function($response){
    
};
window['fileList'] = new Array();
window['fileList2'] = new Array();
const sconsole = console;

const sconsoleLog = {
    log: function(msg,type="l"){
        if(window["onconsole"] !== undefined){
            window["onconsole"](msg,type);
        }else{
            sconsole.log(msg);
        }
    },
    dir: function(msg){sconsole.dir(msg);},
    info: function(msg){sconsoleLog.log(msg,"i");},
    warn: function(msg){sconsoleLog.log(msg,"w")},
    error: function(msg){sconsoleLog.log(msg,"e")},
    time: sconsole.time,
    timeEnd: sconsole.timeEnd,
    timeStamp: sconsole.timeStamp,
    assert: sconsole.assert
    };
console = sconsoleLog;
window.onerror = function (msg, url, line) {
   console.error("Error: " + msg + " url: " + url + " Line: " + line );
};
function logMe(e, msg) {
    if (msg != undefined) {
        console.log(msg);
    }else{
        console.log(objToString(e));
    }
}
function objToString (obj) {
    var str = '';
    if(typeof obj === 'object'){
        for (var p in obj) {
            if (obj.hasOwnProperty(p)) {
                str += p + '::' + obj[p] + '\n';
            }
        }
        return str;
    }else{
        return obj;
    }
}

function compileTemp(targetObj,parentTag='body') {
    var $scope1 = new Proxy(targetObj, {
        get: function(obj, prop) {
            var fg2 = $(parentTag + " [sphp-model='" + prop + "']");
            if (fg2.length > 0) {
                fg2.each(function (i, v) {
                    obj[prop] = getValue(v);
                    //logMe("found " + getValueTag(v));
                });
            }
            fg2 = $(parentTag + " [sphp-modelval='" + prop + "']");
            if (fg2.length > 0) {
                fg2.each(function (i, v) {
                    obj[prop] = $(v).val();
                    //logMe("found " + getValueTag(v));
                });
            }
            //console.log('A value has been accessed ' + prop);
            return obj[prop]; // Return the value stored in the key being accessed
        },
        set: function (target, key, value) {
            //console.log(`${key} set to value`);
            target[key] = value;
            var fg1a = $(parentTag + " [sphp-options='" + key + "']");
            if (fg1a.length > 0) {
                $.each(value,function(k,v){
                    $(fg1a).append($('<option>', {
                        value: v,
                        text : k
                    }));
                });
                //fg1a.html(value);
            }
            var fg1 = $("[sphp-bind='" + key + "']");
            if (fg1.length > 0) {
                fg1.html(value);
            }
            var fg2 = $("[sphp-model='" + key + "']");
            if (fg2.length > 0) {
                fg2.each(function (i, v) {
                    setValue(v, value);
                });
            }
            fg2 = $("[sphp-modelval='" + key + "']");
            if (fg2.length > 0) {
                fg2.each(function (i, v) {
                    $(v).val(value);
                });
            }
            var fg3 = $(parentTag + " [sphp-click='" + key + "()']");
            if (fg3.length > 0) {
                //console.log("set click on " + key);
                //logMe("caller is " + arguments.callee.caller.toString());
                fg3.off("click");
                fg3.on("click", value);
            }
            var fg3b = $(parentTag + " [sj-handler='" + key + "()']");
            if (fg3b.length > 0) {
                $.each(fg3b,function(k,v){
                    if(v.hasAttribute("sj-evt")){
                    var event = $(v).attr("sj-evt").split(',|');
                    $(v).off(event[0]);
                    $(v).on(event[0], function(){
                        if(event.length == 2){
                            value(event[1]);
                        }else if(event.length == 3){
                            value(event[1],event[2]);
                        }else if(event.length == 4){
                            value(event[1],event[2],event[3]);
                        }else{
                            value();
                        }
                    });
                    }
                });
            }
            var fg3a = $(parentTag + " [sphp-change='" + key + "()']");
            if (fg3a.length > 0) {
                fg3a.off("change");
                fg3a.on("change", value);
            }
            var fg3ab = $(parentTag + " [sphp-keyenter='" + key + "()']");
            if (fg3ab.length > 0) {
                fg3ab.off("keyup");
                fg3ab.on("keyup", function(event){
                    if(event.keyCode == 13){
                        value();
                    }
                });
            }
            var fg4 = $(parentTag + " [sphp-class='" + key + "']");
            if (fg4.length > 0) {
                fg4.removeClass(fg4.attr("class")).addClass(value);
            }
            var fg5 = $(parentTag + " [sphp-style='" + key + "']");
            if (fg5.length > 0) {
                fg5.css(value);
            }
            var fg6 = $(parentTag + " [sphp-src='" + key + "']");
            if (fg6.length > 0) {
                fg6.attr("src",value);
            }

            return true;
        }
    });
    return $scope1;
    }
    
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

function setVald(obj,val){
    var type = $(obj).prop("tagName");
    var dtype = $.type(val);
    switch(type){
        case 'INPUT':{
            $(obj).val(val);
            break;
        }case 'TEXTAREA':{
            $(obj).html(val);
            break;
        }case 'SELECT':{ 
            if(dtype === "array"){ 
                $(obj).html('');
                $.each(val,function(index,d){
                    if($.type(d) === "array"){ 
                        $(obj).append('<option value="'+ d[1] +'">'+ d[0] +'</option>');
                    }else{
                        $(obj).append('<option>'+ d +'</option>');                        
                    }
                });
            }else if(dtype === "number"){ 
                $(obj).find("option").filter(function(){
                    if($(this).text().indexOf(val) !== -1){
                        $(this).prop('selected', true);
                        $(this).change();
                    }else{
                        $(this).prop('selected', false);                        
                    }
                });
            }else if(val.indexOf("<") > -1){ 
                $(obj).html(val);
            }else{ 
                $(obj).find("option").filter(function(){
                    if($(this).text().toLowerCase().indexOf(val.toLowerCase()) !== -1){
                        $(this).prop('selected', true);
                        $(this).change();
                    }else{
                        $(this).prop('selected', false);                        
                    }
                });
            }    
            break;
        }case 'DIV':{
            $(obj).html(val);
            break;
        }default:{
            $(obj).html(val);  
        }
    }

}

function setActString(){
if (xmlHttp.readyState==4){
     if (xmlHttp.status == 200) {
   var Res = xmlHttp.responseText;
Res = jql.trim(Res);
setVald('#' + obj1,Res);
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
function bin2hex(str){
    let bytes = new TextEncoder("UTF-8").encode(str);
    return Array.from(bytes,byte => byte.toString(16).padStart(2, "0")).join("");
}
function hex2bin(strhex){
    let bytes = new Uint8Array(strhex.length / 2);
    for (let i = 0; i !== bytes.length; i++) {
        bytes[i] = parseInt(strhex.substr(i * 2, 2), 16);
    }
    return bytes;
    //return new TextDecoder("UTF-8").decode(bytes);
}
function sphp_wsocket(url="ws://127.0.0.1:8000/sphp.ws",callBackNativem){
var myself = this;
this.status = false;
this.socket = new WebSocket(url);
this.socket.onopen = function (event) {
myself.status = true;
callBackNativem("sopen");
//myself.callProcess("indexc2","evt","evtp",{"test":"val"});
  //console.log(event);
};
this.socket.onmessage = function (event) {
	//console.log("onmsg " + event.data);
	parseSphpResponse(event.data,function(ret){
		callBackNativem(ret);
	});
};
this.socket.onclose = function (event) {
myself.status = false;
	callBackNativem("sclose");
  //console.log("close by server ");
};
this.socket.onerror = function (event) {
  console.log("socket error " + event);
};
this.sendMsg = function(ctrl,msg){
	data = {};
	data["wsmsg"] = msg;
	myself.callProcessApp(ctrl,"","",data);
}
this.callGlobalApp = function(ctrl,evt="",evtp="",data={}){
	var data2 = {}; 
	data2['ctrl'] = ctrl;
	data2['evt'] = evt;
	data2['evtp'] = evtp;
	data2['type'] = "";
	data2['typeappobj'] = "s";
	data2['token'] = "";
	data2['bdata'] = data;
	if(myself.status){
            myself.socket.send(JSON.stringify(data2));
	}
};
this.callProcessApp = function(ctrl,evt="",evtp="",data={}){
	var data2 = {}; 
	data2['ctrl'] = ctrl;
	data2['evt'] = evt;
	data2['evtp'] = evtp;
	data2['type'] = "";
	data2['typeappobj'] = "m";
	data2['token'] = "";
	data2['bdata'] = data;
	if(myself.status){
            myself.socket.send(JSON.stringify(data2));
	}
};
this.processApp = function(ctrl,data={}){
    this.callProcessApp(ctrl,"","",data);
};

}


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

