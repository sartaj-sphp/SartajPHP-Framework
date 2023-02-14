var tempobj = {
    websocket: null,
    websockethost: location.host,
    onwsopen: function(){},
    onwsclose: function(){},
    onwsmsg: function(msg){},
    ar: {},
    getSphpSocket: function(callback){
        if(tempobj.websocket === null){
            let protocol = 'ws';
            if (location.protocol === 'https:') protocol = 'wss';
            tempobj.websocket = new sphp_wsocket(protocol + "://" + tempobj.websockethost + "/sphp.ws",function(msg){
                if(msg == "sopen"){
                    tempobj.onwsopen();
                    console.log(msg);
                    callback(tempobj.websocket)
                }else if(msg == "sclose"){
                    tempobj.websocket = null;
                    tempobj.onwsclose();
                    console.log(msg);
                }else{
                    tempobj.onwsmsg(msg);
                    console.log(msg);      
                }
            });

        }else{
            callback(tempobj.websocket);
        }
    },

    registerEvent: function (evt) {
        tempobj.ar[evt] = {bind: false,triggered: false,handlers: {}};
    },
    addHandler: function (evt, name, handler) {
        if (isset(tempobj.ar[evt])) {
            tempobj.ar[evt].handlers[name] = handler;
            tempobj.ar[evt].bind = true;
            if(tempobj.ar[evt].triggered) handler();
        }
    },
    trigger: function (evt) {
        if (isset(tempobj.ar[evt])) {
            tempobj.ar[evt].triggered = true;
            $.each(tempobj.ar[evt].handlers, function(key,fun){
                fun();   
            });
        }
    },
    getHandler: function(evt,name){
        if (isset(tempobj.ar[evt].handlers[name])) {
            return tempobj.ar[evt].handlers[name];
        }
    },
propbagback: {},propbag: null};
var sjsobj = {};

tempobj["propbag"] = compileTemp(tempobj["propbagback"]);
function bindJsVarRefresh(){
    $.each(tempobj["propbagback"], function (k, v) {
        tempobj["propbag"][k] = v;
    });
}
function TempFile(){
    let compList = {};
    this.addComponent = function(key){
        if(! Object.prototype.hasOwnProperty.call(compList, key)){
            compList[key] = null;
        }
    };
    this.setComponent = function(key,obj){
        if(compList[key] === null){
            compList[key] = obj;
        }
    };
    this.getComponent = function(key){
        return compList[key];
    };
    
}
function sartajgt(idimg,url,data,cache,dataType){
    let sphp_ajax2 = new sphp_ajax();
sphp_ajax2.ajaxcall(idimg,url,data,cache,dataType);
}
function getURL(url,data,runbackground){
    let sphp_ajax2 = new sphp_ajax();
sphp_ajax2.ajaxcall('',url,data,true,'json',true,runbackground);
}
async function getAJAX(url,data,runbackground,callback){
    let sphp_ajax2 = new sphp_ajax();
    let promise1 = new Promise((resolvea1,rejecta1)=>{
    sphp_ajax2.ajaxcall('',url,data,true,'json',true,runbackground,function(r1){
        callback(r1); 
        resolvea1(1);
    });        
    });
    let result = await promise1;
    return result;
}
function getAJAXChunkUpload(url,data={},callback,chunkstart=0,chunkend=0){
    let sphp_ajax2 = new sphp_ajax();
    data["chunkstart"] = chunkstart;
    data["chunkend"] = chunkend;
    sphp_ajax2.ajaxcall('',url,data,false,'json',true,true,callback);
}
function parseSphpResponse(data,callback){
    let sphp_ajax2 = new sphp_ajax();
    sphp_ajax2.sartajpro(data,callback);
}
function sartajpro(data,callback){
    let sphp_ajax2 = new sphp_ajax();
    sphp_ajax2.sartajpro(data,callback);
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
    let jsonobjar = [];
    try{
        jsonobjar = JSON.parse("[" + valm + "{}]");
    }catch(e){
       console.log("Invalid AJAX Response:- " + valm); 
    }
    for(let c=0;c<jsonobjar.length - 1;c++){
        this.sartajprom(jsonobjar[c],callback);
    }
};
this.sartajprom = function(val,callback){
    MySelf.sartajpro2(val);
if(val.response.retobj!= undefined){ 
    callback(val.response.retobj);
}else{
    callback();
}    
};
this.sartajpro2 = function(val){
if(val.response.jss!= undefined){ 
jql.each(val.response.jss, function(keym2, valuem2) {
jql.each(valuem2, function(key, value) {
MySelf.sartajproc('jss',key,value,val);
});
});
MySelf.sartajpro3(val);
}else{
MySelf.sartajpro3(val);    
}

};
this.sartajpro3 = function(val){
if(val.response.csfl!= undefined){ 
jql.each(val.response.csfl, function(keym2, valuem2) {
jql.each(valuem2, function(key, value) {
//MySelf.sartajproc('csfl',key,value,val);
servfindex = 0;
loadFiles(fileList2,'css',MySelf.sartajpro4,val);    
});
});
}else{
MySelf.sartajpro4(val);    
}
};
this.sartajpro4 = function(val){
if(val.response.css!= undefined){ 
jql.each(val.response.css, function(keym2, valuem2) {
jql.each(valuem2, function(key, value) {
MySelf.sartajproc('css',key,value,val);
});
});
MySelf.ldjs(val);    
}else{
MySelf.ldjs(val);    
}

};
this.ldjs = function(val){
if(val.response.jsfl!= undefined){ 
jql.each(val.response.jsfl, function(keym2, valuem2) {
jql.each(valuem2, function(key, value) {
//MySelf.sartajproc('jsfl',key,value,val);
servfindex = 0; 
loadFiles(fileList,'jsfl',MySelf.ldmid,val);    
});
});
}else{
MySelf.ldmid(val);    
}
};
this.ldmid = function(val){
if(val.response.js1!= undefined){ 
jql.each(val.response.js1, function(keym2, valuem2) {
jql.each(valuem2, function(key, value) {
MySelf.sartajproc('js1',key,value,val);
});
});
}
if(val.response.html!= undefined){ 
jql.each(val.response.html, function(keym2, valuem2) {
jql.each(valuem2, function(key, value) {
if(key!= undefined){ 
//MySelf.sartajproc('html',key,value,val);
//jql('#'+key).html(value);
setVald('#'+key,value);
}
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
if(key!= undefined){ 
MySelf.sartajproc2(key,value);
}
});
});
}

window['sphpajready1']();
};
this.sartajproc2 = function(key,value){
try{
 if(key!= undefined){ 
//var funCall = key + "(" + value + ");";
window[key](value);
//jql.globalEval(funCall);
}
}catch(error){
  console.error(error);  
}finally{ }    
};
this.sartajproc = function(keym,key,value,val){
    //console.log(keym + '- ' + key + ' - ' );
    try{
if(key!= undefined){ 
switch(key){
    case 'proces' :{ 
    eval(value);
/* jql.globalEval(value);
var l1 = Function(value);
l1(); */
break;
    }
    }
}
}catch(error){
  console.error(error);  
}finally{ }    
};
};
