/* 
 Copyright (C) 2018  Sartaj Singh. (www.sartajphp.com)
 This codes don't come with any permissions. All rights are reserved by Sartaj Singh
 */
var ConnectionN = {UNKNOWN: 1,
    ETHERNET: 2,
    WIFI: 3,
    CELL_2G: 4,
    CELL_3G: 5,
    CELL_4G: 6,
    NONE: 7
};

var sphpstatus = {
    online: false,
    ENVMobile: true
};

var sjsApp = {
    debugMode: false,
    currentPage: "",
    basepath: "",
    apipath: "",
    onBeforeDeviceReady: function(callback){
        // setup native interface
    //window.plugins.insomnia.keepAwake();
    //settings.deviceUUID = device.uuid;
    //SQLiteE = window.plugins.SphpPlugin;
    //SphpPlugin = window.plugins.SphpPlugin;
      //  loadNativeLib(callback);
      return jq_jqm_onBeforeDeviceReady(callback);
    },
    onDeviceReady: function(){
        logMe("ready");
        ModuleObject.trigger("onDeviceReady");
        //onStart();
    },
    onUnload: function(){
        return jq_jqm_onUnload();
    },
    onLine: function(){
        return jq_jqm_onLine();
    },
    onOffLine: function(){
        return jq_jqm_onOffLine();
    },
    onPause: function(){
        return jq_jqm_onPause();
    },
    onResume: function(){
        return jq_jqm_onResume();
    }
};


function setValueTag(obja1, val1) {
    var obj1 = $(obja1);
    var type = obj1.prop('tagName');
    if (type == 'INPUT') {
        obj1.val(val1);
    } else if (type == 'TEXTAREA') {
        obj1.val(val1);
    } else if (type == 'SELECT') {
        obj1.val(val1);
    } else if (type == 'DIV') {
        obj1.html(val1);
    }
}
function getValueTag(obja1) {
    var obj1 = $(obja1);
    var type = obj1.prop('tagName');
    if (type == 'INPUT') {
        return obj1.val();
    } else if (type == 'TEXTAREA') {
        return obj1.val();
    } else if (type == 'SELECT') {
        return obj1.val();
    } else if (type == 'DIV') {
        return obj1.html();
    }
}
var CompObject = {
    objs: {},
    addObject: function (name, obj) {
        CompObject.objs[name] = obj;
    },
    getObject: function (name) {
        return CompObject.objs[name];
    }
};
function compileTemp(pname,targetObj) {
    var $scope1 = new Proxy(targetObj, {
        get: function(obj, prop) {
            var fg2 = $("#" + pname + " [ng-model='" + prop + "']");
            if (fg2.length > 0) {
                fg2.each(function (i, v) {
                    obj[prop] = getValueTag(v);
                    //logMe("found " + getValueTag(v));
                });
            }
            //console.log('A value has been accessed ' + prop);
            return obj[prop]; // Return the value stored in the key being accessed
        },
        set: function (target, key, value) {
            //console.log(`${key} set to value`);
            target[key] = value;
            var fg1a = $("#" + pname + " [ng-options='" + key + "']");
            if (fg1a.length > 0) {
                $.each(value,function(k,v){
                    $(fg1a).append($('<option>', { 
                        value: v,
                        text : k 
                    }));
                });
                //fg1a.html(value);
            }
            var fg1 = $("[ng-bind='" + key + "']");
            if (fg1.length > 0) {
                fg1.html(value);
            }
            var fg2 = $("[ng-model='" + key + "']");
            if (fg2.length > 0) {
                fg2.each(function (i, v) {
                    setValueTag(v, value);
                });
            }
            var fg3 = $("#" + pname + " [ng-click='" + key + "()']");
            if (fg3.length > 0) { 
                //console.log("set click on " + key);
                //logMe("caller is " + arguments.callee.caller.toString());
                fg3.off("click");
                fg3.on("click", value);
            }
            var fg3b = $("#" + pname + " [sj-handler='" + key + "()']");
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
            var fg3a = $("#" + pname + " [ng-change='" + key + "()']");
            if (fg3a.length > 0) {
                fg3a.off("change");
                fg3a.on("change", value);
            }
            var fg3ab = $("#" + pname + " [ng-keyenter='" + key + "()']");
            if (fg3ab.length > 0) {
                fg3ab.off("keyup");
                fg3ab.on("keyup", function(event){
                    if(event.keyCode == 13){
                        value();
                    }
                });
            }
            var fg4 = $("#" + pname + " [ng-class='" + key + "']");
            if (fg4.length > 0) {
                fg4.removeClass(fg4.attr("class")).addClass(value);
            }
            var fg5 = $("#" + pname + " [ng-style='" + key + "']");
            if (fg5.length > 0) {
                fg5.css(value);
            }
            var fg6 = $("#" + pname + " [ng-src='" + key + "']");
            if (fg6.length > 0) {
                fg6.attr("src",value);
            }

            return true;
        }
    });
    $scope1.$digest = function(){};
    return $scope1;
}
var targetObj = {};
var $scope = null;

var PageObject = {
    objs: {},
    addObject: function (name, obj) {
        obj['lstcomp'] = {};
        PageObject.objs[name] = obj;
    },
    addCompName: function (pname, cname) {
        PageObject.objs[pname]['lstcomp'][cname] = cname;
    },
    getObject: function (name) {
        return PageObject.objs[name];
    },
    triggerShow: function (pname) {
        if (isset(PageObject.objs[pname])) {
            targetObj = {};
            $scope = compileTemp(pname,targetObj);
            $(PageObject.objs[pname]['lstcomp']).each(function (key, cnameobj) {
                $.each(cnameobj, function (k, v) {
                    CompObject.getObject(v).onCompShow($scope);
                });
            });
            PageObject.objs[pname].onPageShow($scope);
        }
    },
    triggerHide: function(pname){
        if (isset(PageObject.objs[pname]) && isset(PageObject.objs[pname]["onPageHide"])) {
             PageObject.objs[pname].onPageHide($scope);
        }
    },
    triggerUpdate: function (name) {
        if (isset(PageObject.objs[name])) {
            PageObject.objs[name].onPageUpdate();
        }
    }
};
var ModuleObject = {
    objs: {},
    ar: {},
    addObject: function (name, obj) {
        ModuleObject.objs[name] = obj;
    },
    getObject: function (name) {
        return ModuleObject.objs[name];
    },
    setHandler: function (evt, handler) {
        if (isset(ModuleObject.ar[evt])) {
            ModuleObject.ar[evt].push(handler);
        } else {
            ModuleObject.ar[evt] = [];
            ModuleObject.ar[evt].push(handler);
        }
    },
    trigger: function (evt) {
        if (isset(ModuleObject.ar[evt])) {
            $.each(ModuleObject.ar[evt], function (index, val) {
                val();
            });
        }
    }
};

var evtList = {
    ar: {},
    create: function (evt) {
        evtList.ar[evt] = function () {};
    },
    setHandler: function (evt, handler) {
        evtList.ar[evt] = handler;
    },
    trigger: function (evt) {
        if (isset(evtList.ar[evt])) {
            evtList.ar[evt]();
        }
    },
    getHandler: function(evt){
        if (isset(evtList.ar[evt])) {
            return evtList.ar[evt];
        }        
    }
};
var app = {
    currentPage: "",
    prevPage: "",
    showPhoneStatus: function () {
        showAlert(window.device.model + "(" + window.device.platform + " " + window.device.version + ")\nConnection: " + ConnectionN[window.navigator.connection.type], "About");
    },

    // Application Constructor
    initialize: function () {
        document.addEventListener('pause', this.onPause, false);
        document.addEventListener('resume', this.onResume, false);
        document.addEventListener('online', this.onLine, false);
        document.addEventListener('offline', this.onOffLine, false);
        $(window).on("beforeunload", this.sunload);
        $(document).ready(this.onDeviceReady2);
//        $(window).bind('pageshow resize orientationchange', function(e) { });
    },

    // deviceready Event Handler
    //
    // Bind any cordova events here. Common events are:
    // 'pause', 'resume', etc.
    onDeviceReady: function () {
        sjsApp.onBeforeDeviceReady(function(){
        checkConnection();
        window.location.hash = 'homepage';
        $.mobile.initializePage();
        $(":mobile-pagecontainer").on("pagecontainershow", function (event, ui) {
            app.currentPage = ui.toPage.attr("id");
            PageObject.triggerShow(app.currentPage);
            //    logMe( "This page was just hidden: " + ui.prevPage.attr("id") );
                //logMe( "Open Page: " + ui.toPage.attr("id") );
        });
        $(":mobile-pagecontainer").on("pagecontainerhide", function (event, ui) {
            app.prevPage = ui.prevPage.attr("id");
            PageObject.triggerHide(app.prevPage);
                //logMe( "This page was just hidden: " + ui.prevPage.attr("id") );
                //logMe( "Open Page: " + ui.toPage.attr("id") );
        });
        
        sjsApp.onDeviceReady();
        });
    }, 
    onDeviceReady2: function () { 
        sphpstatus.ENVMobile = false;
        if (document.URL.indexOf("http://") === -1 && document.URL.indexOf("https://") === -1) {
            sphpstatus.ENVMobile = true;
        }

        if (sphpstatus.ENVMobile) {
            document.addEventListener('deviceready', app.onDeviceReady.bind(app), false);
        } else {
            app.onDeviceReady();
        }
    },
    sunload: function () {
        return sjsApp.onUnload();
    },
    onLine: function () {
        checkConnection();
        return sjsApp.onLine();
        //logMe("online");
    },
    onOffLine: function () {
        checkConnection();
        return sjsApp.onOffLine();
        //logMe("off line");
    },
    onPause: function () {
        return sjsApp.onPause();
        //logMe("pause");
    },
    onResume: function () {
        return sjsApp.onResume();
        //logMe("resume");
    }


};
function checkConnection() {
    var networkState = navigator.connection.type;
    if (networkState !== ConnectionN.NONE) {
        sphpstatus.online = true;
    } else {
        sphpstatus.online = false;
    }
    var states = {};
    states[ConnectionN.UNKNOWN] = 'Unknown connection';
    states[ConnectionN.ETHERNET] = 'Ethernet connection';
    states[ConnectionN.WIFI] = 'WiFi connection';
    states[ConnectionN.CELL_2G] = 'Cell 2G connection';
    states[ConnectionN.CELL_3G] = 'Cell 3G connection';
    states[ConnectionN.CELL_4G] = 'Cell 4G connection';
    states[ConnectionN.CELL] = 'Cell generic connection';
    states[ConnectionN.NONE] = 'No network connection';

    // logMe('ConnectionN type: ' + states[networkState]);
}
app.initialize();



function setAJAXForm(id) {
    $('#' + id).ajaxForm();
}
function loadAllPages(callback) {
    /*
     $("#divcodriver").load( "https://proj.itkruze.com/mobileapp/apploader/index-loadform-login-co-driver.html" );
     $("#mySidenav").load( "https://proj.itkruze.com/mobileapp/apploader/index-loadform-sidenav.html" );
     $("#divstatuslog").load( "https://proj.itkruze.com/mobileapp/apploader/index-loadform-statuslog.html" );
     $("#divpretrip").load( "https://proj.itkruze.com/mobileapp/apploader/index-loadform-pretrip.html" );
     $("#divsettings").load( "https://proj.itkruze.com/mobileapp/apploader/index-loadform-settings.html" );
     $("#edtFormHolder").load( "https://proj.itkruze.com/mobileapp/apploader/index-loadform-dashboard.html", function(){
     setTimeout(callback, 1000);
     } );
     */
    getAJAX("https://proj.itkruze.com/mobileapp/apploader/index-loadall.html", {}, false, function () {
        setTimeout(callback, 1000);
    });
//    changePage('#details','flip');
//    initChart();

}
function showError(msg) {
    document.getElementById('errmsg').innerHTML += '<br />' + msg;
}
function showAlert(type, msg) {
    if (type == "warning") {
        $("#sphpwarningmsg").html(msg);
        runanierr(type);
    } else if (type == "error") {
        $("#sphperrormsg").html(msg);

    } else if (type == "info") {
        $("#sphpinfomsg").html(msg);
        runanierr(type);

    } else if (type == "success") {
        $("#sphpsuccessmsg").html(msg);
        runanierr(type);
    }
}
function runanierr(type) {
    $("#sphp" + type).fadeIn(1);
    $("#sphp" + type).css("display", "block");
    $("#sphp" + type).delay(5000).fadeOut("slow", function () {
        $(this).css("display", "none");
    });
}
function stopPropagate(e) {
    if (!e)
        var e = window.event;
    e.cancelBubble = true;
    if (e.stopPropagation)
        e.stopPropagation();
}
function confirmDel(link, jsajax) {
    var ans = confirm('Are You Sure to Delete This Record !');
    if (ans) {
        if (jsajax) {
            getURL(link);
        } else {
            window.location = link;
        }
    }
}
function changePage(page, ani) {
    $(':mobile-pagecontainer').pagecontainer('change', page, {
        transition: "none", 
        changeHash: false,
        reverse: true,
        showLoadMsg: true
    });

}
function getPage(page) {
    getURL(sjsApp.basepath + page + "-loadpage-divPager.html");
}
function getPageFull(page) {
    getURL(sjsApp.basepath + page + "-loadpagefull-divPager.html");
}
function logMe(e, msg) {
    if (msg != undefined) {
        console.log(msg);
    }
    console.log(e);
    if(sjsApp.debugMode){
        console.log("caller is " + arguments.callee.caller.toString());
    }
}
    console.everything = [];
function pushLog(val){
    if(console.everything.length > 100){
        console.everything.length = 0;
        console.everything = [];
    }
    console.everything.push(val);
}
    console.defaultLog = console.log.bind(console);
    console.log = function(){
        pushLog({"type":"log", "datetime":Date().toLocaleString(), "value":Array.from(arguments)});
        console.defaultLog.apply(console, arguments);
    }
    console.defaultError = console.error.bind(console);
    console.error = function(){
        pushLog({"type":"error", "datetime":Date().toLocaleString(), "value":Array.from(arguments)});
        console.defaultError.apply(console, arguments);
    }
    console.defaultWarn = console.warn.bind(console);
    console.warn = function(){
        pushLog({"type":"warn", "datetime":Date().toLocaleString(), "value":Array.from(arguments)});
        console.defaultWarn.apply(console, arguments);
    }
    console.defaultDebug = console.debug.bind(console);
    console.debug = function(){
        pushLog({"type":"debug", "datetime":Date().toLocaleString(), "value":Array.from(arguments)});
        console.defaultDebug.apply(console, arguments);
    }
    window.onerror = function(error, url, line) {
        pushLog({"type":"winerr", "datetime":Date().toLocaleString(), "value":Array.from(arguments)});
    };

function readConsole(){
   //read console record by record
   //console.everything.forEach(msg => {
   //});
    var data = {};
    data["jserrmsg"] = msg;
    getURL("index.html",data);
}
function getParmFromHash(url, parm) {
    var re = new RegExp("#.*[?&]" + parm + "=([^&]+)(&|$)");
    var match = url.match(re);
    return(match ? match[1] : "");
}

function getParameterByName(name) {
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}

var externalLinkHandler = function (link) {
    var newWindow = window.open(link, '_blank');
    // If the window links to another page on your domain, it's not an external link
    // so you can immediately close the new window you opened in your webview. The new
    // external link will remain open in the system browser window opened when Cordova
    // detected you were changing pages to an external link.
    if (window.location.host === 'mobile.myapp.com') {
        newWindow.close();
    }
}

function getCurrentHash() {
    return window.location.hash || "#undefined";
}
function showAlert(message, title) {
    if (window.navigator.notification) {
        window.navigator.notification.alert(message, null, title, 'OK');
    } else {
        alert(title ? (title + ": " + message) : message);
    }
}
//logMe("caller is " + arguments.callee.caller.toString());