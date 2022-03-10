<?php

final class SphpJsM{
public function __construct() {
    $this->init();
}
public function init() {
    global $respath;
// load js lib and jquery ready function
//addFileLink("{$respath}/jquery/jquery-min.js",true);
//addFileLink("{$respath}/jquery/jquery-min1.10.js",true,"jquery-min");
//addFileLink("{$respath}/jslib/jquery/jquery-min1.9.1.js",true,"jquery-min");
addFileLink("{$respath}/jslib/jquery/jquery-3.2.1.min.js", true, "jquery-min","js","jquery:3.2.1");



// add jlib
addFileLink("{$respath}/jslib/jquery/jslib.js", true);

// load js migrate lib 
//addFileLink("{$respath}/jquery/jquery-migrate-1.2.1.min.js",true);
addHeaderJSFunction('ready', "$(document).ready(function() {", "});", true);
addHeaderJSFunction('ready', "$(document).ready(function() {", "});");
addHeaderJSFunction('pageload', "$(window).on('load',function() {", "});", true);
addFileLink('sphpjq = window.jQuery = window.$ = jql;',true,"jquery-js-code","js");
// native console = sconsole.log(msg);
addHeaderJSFunction('onconsole', "window['onconsole'] = function(msg,type='l'){var nooutput = false;", " if(!nooutput){switch(type){
            case \"i\": {sconsole.info(msg); break;}
            case \"w\": {sconsole.warn(msg); break;}
            case \"e\": {sconsole.error(msg);break;}
            default: {sconsole.log(msg);break;}
        }
}};", true);

}

public static function addAlertDialog() {
    global $respath;
    addFileLink("{$respath}/jslib/jquery/jquery-confirm.min.css", true);
    addFileLink("{$respath}/jslib/jquery/jquery-confirm.min.js", true);
    addFileLink("{$respath}/jslib/jquery/alertDialog.js", true);
}
public static function addjQueryl($default=false,$replaceVar="") {
    global $respath;
    updateFileLink("{$respath}/jslib/jquery/jquery-3.4.1.min.js", true, "jquery-min","js","jquery:3.4.1");
addHeaderJSFunction('ready', "jql(document).ready(function() {", "});", true);
addHeaderJSFunction('ready', "jql(document).ready(function() {", "});");
addHeaderJSFunction('pageload', "jql(window).on('load',function() {", "});", true);
// use code var jql = $.noConflict(true);
if($default){
    updateFileLink('sphpjq = window.jQuery = window.$ '. $replaceVar .' = jql;',true,"jquery-js-code","js");
}
}
public static function addjQuery2($default=false) {
    global $respath;
    addFileLink("{$respath}/jslib/jquery/jquery-2.2.4.min.js", true, "jquery-min2","js");
addHeaderJSFunction('readyjq2', "jq2(document).ready(function() {", "});", true);
addHeaderJSFunction('readyjq2', "jq2(document).ready(function() {", "});");
addHeaderJSFunction('pageloadjq2', "jq2(window).on('load',function() {", "});", true);
if($default){
    updateFileLink('sphpjq = window.jQuery = window.$ = jq2;',true,"jquery-js-code","js");
}

}
public static function addjQuery1($default=false,$latest=false) {
    global $respath;
    if($latest){
        updateFileLink("{$respath}/jslib/jquery/jquery-min1.10.js", true, "jquery-min","js","jquery:1.10.0");        
    }else{
        addFileLink("{$respath}/jslib/jquery/jquery-min1.10.js", true, "jquery-min1","js");
    }
addHeaderJSFunction('readyjq1', "jq1(document).ready(function() {", "});", true);
addHeaderJSFunction('readyjq1', "jq1(document).ready(function() {", "});");
addHeaderJSFunction('pageloadjq1', "jq1(window).on('load',function() {", "});", true);
if($default){
    if($latest){
    updateFileLink('sphpjq = window.jQuery = window.$ = jq1 = jql;',true,"jquery-js-code","js");        
    }else{
    updateFileLink('sphpjq = window.jQuery = window.$ = jq1;',true,"jquery-js-code","js");
    }
}
//addFileLink("{$respath}/jslib/jquery-ui-1.12.1/jquery-ui.min_jq1.js", true,"jquery-ui");
}
public static function addjQueryUI($version="1.12.1") {
    global $respath;
    addFileLink("{$respath}/jslib/jquery-ui-" . $version . "/jquery-ui.min.css", true);
    //addFileLink("{$respath}/jslib/jquery-ui-" . $version . "/jquery-ui.theme.min.css", true);
    //addFileLink("{$respath}/jslib/jquery-ui-" . $version . "/jquery-ui.structure.min.css", true);
//    addFileLink("{$respath}/jslib/jquery-ui-" . $version . "/jquery-ui-bootstrap.css", true);
    addFileLink("{$respath}/jslib/jquery-ui-" . $version . "/jquery-ui.min.js", true,"jquery-ui","","jqueryui:" . $version);
}

public static function addReact() {
    global $respath;
    addFileLink("{$respath}/jslib/react/react.production.min.js", true,"","","react:17");
    addFileLink("{$respath}/jslib/react/react-dom.production.min.js", true,"","","react:17");
}

public static function addBootStrap5() {
    global $respath;
    addFileLink("{$respath}/jslib/twitter/bootstrap5/css/bootstrap.min.css", true,"","","bootstrap:5");
    addFileLink("{$respath}/jslib/twitter/bootstrap5/js/bootstrap.bundle.min.js", true);
    SphpJsM::addFontAwesome();
}
public static function addBootStrap4() {
    SphpJsM::addBootStrap();
}
public static function addBootStrap() {
    global $respath;
    addFileLink("{$respath}/jslib/twitter/bootstrap4/css/bootstrap.min.css", true,"","","bootstrap:4");
    //addFileLink("{$respath}/jslib/twitter/bootstrap4/css/bootstrap-grid.min.css", true);
    //addFileLink("{$respath}/jslib/twitter/bootstrap4/css/bootstrap-reboot.min.css", true);
    //addFileLink("{$respath}/jslib/twitter/bootstrap4/js/popper.min.js", true);
    //addFileLink("{$respath}/jslib/twitter/bootstrap4/js/bootstrap.min.js", true);
    addFileLink("{$respath}/jslib/twitter/bootstrap4/js/bootstrap.bundle.min.js", true);
    //SphpJsM::addFontAwesome();
    SphpJsM::addAlertDialog();
}
public static function addBootStrapKit() {
    global $respath;
    SphpJsM::addFontAwesome();
    addFileLink("{$respath}/jslib/twitter/bootstrap4/css/bootstrap.min.css", true,"","","bootstrap:4");
    addFileLink("{$respath}/jslib/twitter/bootstrap4/css/bootstrap-grid.min.css", true);
    addFileLink("{$respath}/jslib/twitter/bootstrap4/css/bootstrap-reboot.min.css", true);
    addFileLink("{$respath}/jslib/fonts/Roboto.css",true);
    addFileLink("{$respath}/jslib/twitter/bootstrap4/css/mdb.min.css",true);
    addFileLink("{$respath}/jslib/twitter/bootstrap4/css/style.css",true);
    addFileLink("{$respath}/jslib/twitter/bootstrap4/js/popper.min.js", true);
    addFileLink("{$respath}/jslib/twitter/bootstrap4/js/bootstrap.min.js", true);
    addFileLink("{$respath}/jslib/twitter/bootstrap4/js/bootstrap.bundle.min.js", true);
    addFileLink("{$respath}/jslib/twitter/bootstrap4/js/mdb.min.js",true);
}

public static function addFontAwesome() {
    global $respath;
    addFileLink("{$respath}/jslib/fontawesome/css/font-awesome.min.css", true);
}

public static function addBootStrap3() {
    global $respath;
    addFileLink("{$respath}/jslib/twitter/bootstrap3/css/bootstrap.min.css", true,"","","bootstrap:3");
    addFileLink("{$respath}/jslib/twitter/bootstrap3/css/bootstrap-theme.min.css", true);
    addFileLink("{$respath}/jslib/twitter/bootstrap3/js/bootstrap.min.js", true);
}

public static function addAngular() {
    global $respath;
    addFileLink("{$respath}/jslib/angular/angular.js", true);
    addFileLink("{$respath}/jslib/angular/angular-mocks.js", true);
}

public static function addjQueryMobile() {
    global $respath;
    //addFileLink("{$respath}/jslib/jquery.mobile-1.4.5/jquery.mobile.custom.structure.min.css", true);
    addFileLink("{$respath}/jslib/jquery.mobile/jquery.mobile-1.4.5.min.css", true);
    //addFileLink("{$respath}/jslib/jquery.mobile-1.4.5/jquery.mobile-1.5.0-alpha.1.min.js", true,"","","jQueryM:1.5.0");
    addFileLink("{$respath}/jslib/jquery.mobile/jquery.mobile-1.4.5.min.js", true); 
}

}
