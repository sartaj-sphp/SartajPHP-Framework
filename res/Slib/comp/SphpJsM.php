<?php

final class SphpJsM {
    private static $jslib = array();
    
    public function __construct() {
        $this->init();
    }

    public function init() {
        global $jslibpath;
// load js lib and jquery ready function
//addFileLink("{$respath}/jquery/jquery-min.js",true);
//addFileLink("{$respath}/jquery/jquery-min1.10.js",true,"jquery-min");
//addFileLink("$jslibpath/jquery/jquery-min1.9.1.js",true,"jquery-min");
        addFileLink("{$jslibpath}/jquery/jquery-3.2.1.min.js", true, "jquery-min", "js", "jquery:3.2.1");
        SphpJsM::$jslib["jquery"] = 321;

// add jlib
        addFileLink("{$jslibpath}/jquery/jslib.js", true);
        SphpJsM::$jslib["jslib"] = 1;

// load js migrate lib 
//addFileLink("{$respath}/jquery/jquery-migrate-1.2.1.min.js",true);
        addHeaderJSFunction('ready', "$(document).ready(function() {", "});", true);
        addHeaderJSFunction('ready', "$(document).ready(function() {", "});");
        addHeaderJSFunction('pageload', "$(window).on('load',function() {", "});", true);
        addFileLink('sphpjq = window.jQuery = window.$ = jql;', true, "jquery-js-code", "js");
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
        global $jslibpath;
        addFileLink("$jslibpath/jquery/jquery-confirm.min.css", true);
        addFileLink("$jslibpath/jquery/jquery-confirm.min.js", true);
        addFileLink("$jslibpath/jquery/alertDialog.js", true);
        SphpJsM::$jslib["alert_dialog"] = 1;
    }

    public static function addjQueryl($default = false, $replaceVar = "") {
        global $jslibpath;
        updateFileLink("$jslibpath/jquery/jquery-3.4.1.min.js", true, "jquery-min", "js", "jquery:3.4.1");
        addHeaderJSFunction('ready', "jql(document).ready(function() {", "});", true);
        addHeaderJSFunction('ready', "jql(document).ready(function() {", "});");
        addHeaderJSFunction('pageload', "jql(window).on('load',function() {", "});", true);
// use code var jql = $.noConflict(true);
        if ($default) {
            updateFileLink('sphpjq = window.jQuery = window.$ ' . $replaceVar . ' = jql;', true, "jquery-js-code", "js");
        }
        SphpJsM::$jslib["jquery"] = 341;
    }

    public static function addjQuery2($default = false) {
        global $jslibpath;
        addFileLink("$jslibpath/jquery/jquery-2.2.4.min.js", true, "jquery-min2", "js");
        addHeaderJSFunction('readyjq2', "jq2(document).ready(function() {", "});", true);
        addHeaderJSFunction('readyjq2', "jq2(document).ready(function() {", "});");
        addHeaderJSFunction('pageloadjq2', "jq2(window).on('load',function() {", "});", true);
        if ($default) {
            updateFileLink('sphpjq = window.jQuery = window.$ = jq2;', true, "jquery-js-code", "js");
        }
        SphpJsM::$jslib["jquery"] = 224;
    }

    public static function addjQuery1($default = false, $latest = false) {
        global $jslibpath;
        if ($latest) {
            updateFileLink("$jslibpath/jquery/jquery-min1.10.js", true, "jquery-min", "js", "jquery:1.10.0");
        } else {
            addFileLink("$jslibpath/jquery/jquery-min1.10.js", true, "jquery-min1", "js");
        }
        addHeaderJSFunction('readyjq1', "jq1(document).ready(function() {", "});", true);
        addHeaderJSFunction('readyjq1', "jq1(document).ready(function() {", "});");
        addHeaderJSFunction('pageloadjq1', "jq1(window).on('load',function() {", "});", true);
        if ($default) {
            if ($latest) {
                updateFileLink('sphpjq = window.jQuery = window.$ = jq1 = jql;', true, "jquery-js-code", "js");
            } else {
                updateFileLink('sphpjq = window.jQuery = window.$ = jq1;', true, "jquery-js-code", "js");
            }
        }
        SphpJsM::$jslib["jquery"] = 110;
//addFileLink("$jslibpath/jquery-ui-1.12.1/jquery-ui.min_jq1.js", true,"jquery-ui");
    }

    public static function addjQueryUI($version = "1.12.1") {
        global $jslibpath;
        addFileLink("$jslibpath/jquery-ui-" . $version . "/jquery-ui.min.css", true);
        //addFileLink("$jslibpath/jquery-ui-" . $version . "/jquery-ui.theme.min.css", true);
        //addFileLink("$jslibpath/jquery-ui-" . $version . "/jquery-ui.structure.min.css", true);
//    addFileLink("$jslibpath/jquery-ui-" . $version . "/jquery-ui-bootstrap.css", true);
        addFileLink("$jslibpath/jquery-ui-" . $version . "/jquery-ui.min.js", true, "jquery-ui", "", "jqueryui:" . $version);
        SphpJsM::$jslib["jqueryui"] = 1121;
    }

    public static function addReact() {
        global $jslibpath;
        addFileLink("$jslibpath/react/react.production18.min.js", true, "", "", "react:18");
        addFileLink("$jslibpath/react/react-dom.production18.min.js", true, "", "", "reactdom:18");
        addFileLink("$jslibpath/react/babel6.26.0.min.js", true, "", "", "babel:6.26.0");
        //use <script type="text/babel"> tag to code        
        SphpJsM::$jslib["react"] = 18;
        SphpJsM::$jslib["react_babel"] = 6260;
    }

    public static function addBootStrap5() {
        global $jslibpath;
        if(SphpJsM::getJSLibVersion("bootstrap") == -1){ 
        SphpJsM::addFontAwesome6();
        addFileLink("$jslibpath/twitter/bootstrap5/css/bootstrap.min.css", true, "", "", "bootstrap:5");
        addFileLink("$jslibpath/twitter/bootstrap5/css/bootstrap-grid.min.css", true);
        addFileLink("$jslibpath/twitter/bootstrap5/css/bootstrap-reboot.min.css", true);
        addFileLink("$jslibpath/twitter/bootstrap5/js/bootstrap.bundle.min.js", true);
        SphpJsM::addAlertDialog();
        SphpJsM::$jslib["bootstrap"] = 5;
        //SphpJsM::addFontAwesome();
        }
    }

    public static function addBootStrap4() {
        SphpJsM::addBootStrap();
    }

    public static function addBootStrap() {
        global $jslibpath;
        if(SphpJsM::getJSLibVersion("bootstrap") == -1){ 
        addFileLink("$jslibpath/twitter/bootstrap4/css/bootstrap.min.css", true, "", "", "bootstrap:4");
        //addFileLink("$jslibpath/twitter/bootstrap4/css/bootstrap-grid.min.css", true);
        //addFileLink("$jslibpath/twitter/bootstrap4/css/bootstrap-reboot.min.css", true);
        //addFileLink("$jslibpath/twitter/bootstrap4/js/popper.min.js", true);
        //addFileLink("$jslibpath/twitter/bootstrap4/js/bootstrap.min.js", true);
        addFileLink("$jslibpath/twitter/bootstrap4/js/bootstrap.bundle.min.js", true);
        //SphpJsM::addFontAwesome();
        SphpJsM::addAlertDialog();
        SphpJsM::$jslib["bootstrap"] = 4;
        }
    }

    public static function addBootStrapKit() {
        global $jslibpath;
        if(SphpJsM::getJSLibVersion("bootstrap") == -1){ 
        SphpJsM::addFontAwesome();
        addFileLink("$jslibpath/twitter/bootstrap4/css/bootstrap.min.css", true, "", "", "bootstrap:4");
        addFileLink("$jslibpath/twitter/bootstrap4/css/bootstrap-grid.min.css", true);
        addFileLink("$jslibpath/twitter/bootstrap4/css/bootstrap-reboot.min.css", true);
        addFileLink("$jslibpath/fonts/Roboto.css", true);
        addFileLink("$jslibpath/twitter/bootstrap4/css/mdb.min.css", true);
        addFileLink("$jslibpath/twitter/bootstrap4/css/style.css", true);
        addFileLink("$jslibpath/twitter/bootstrap4/js/popper.min.js", true);
        addFileLink("$jslibpath/twitter/bootstrap4/js/bootstrap.min.js", true);
        addFileLink("$jslibpath/twitter/bootstrap4/js/bootstrap.bundle.min.js", true);
        addFileLink("$jslibpath/twitter/bootstrap4/js/mdb.min.js", true);
        SphpJsM::$jslib["bootstrap"] = 4;
        }
    }

    public static function addBootStrapKit5() {
        global $jslibpath;
        if(SphpJsM::getJSLibVersion("bootstrap") == -1){ 
        SphpJsM::addFontAwesome6();
        addFileLink("$jslibpath/twitter/bootstrap5/css/bootstrap.min.css", true, "", "", "bootstrap:5");
        addFileLink("$jslibpath/twitter/bootstrap5/css/bootstrap-grid.min.css", true);
        addFileLink("$jslibpath/twitter/bootstrap5/css/bootstrap-reboot.min.css", true);
        addFileLink("$jslibpath/twitter/bootstrap5/css/mdb.min.css", true);
        addFileLink("$jslibpath/twitter/bootstrap5/css/style.css", true);
        //addFileLink("$jslibpath/twitter/bootstrap5/js/popper.min.js", true);
        //addFileLink("$jslibpath/twitter/bootstrap5/js/bootstrap.esm.min.js", true);
        addFileLink("$jslibpath/twitter/bootstrap5/js/bootstrap.bundle.min.js", true);
        // js file click twice bug in firefox
        //addFileLink("$jslibpath/twitter/bootstrap5/js/mdb.min.js", true);
        SphpJsM::addAlertDialog();
        SphpJsM::$jslib["bootstrap"] = 5;
        }
    }

    public static function addFontAwesome() {
        global $jslibpath;
        if(SphpJsM::getJSLibVersion("fontawesome") == -1){ 
        addFileLink("$jslibpath/fontawesome/css/font-awesome.min.css", true);
        SphpJsM::$jslib["fontawesome"] = 4;
        }
    }

    public static function addFontAwesome6() {
        global $jslibpath;
        // support both version 4 and 6
        addFileLink("$jslibpath/fontawesome6/css/all.min.css", true);
        addFileLink("$jslibpath/fontawesome6/css/v4-shims.min.css", true);
        SphpJsM::$jslib["fontawesome"] = 6;
    }
    
    public static function addBootStrap3() {
        global $jslibpath;
        if(SphpJsM::getJSLibVersion("bootstrap") == -1){ 
        addFileLink("$jslibpath/twitter/bootstrap3/css/bootstrap.min.css", true, "", "", "bootstrap:3");
        addFileLink("$jslibpath/twitter/bootstrap3/css/bootstrap-theme.min.css", true);
        addFileLink("$jslibpath/twitter/bootstrap3/js/bootstrap.min.js", true);
        SphpJsM::$jslib["bootstrap"] = 3;
        }
    }

    public static function addAngular() {
        global $jslibpath;
        addFileLink("$jslibpath/angular/angular.js", true);
        addFileLink("$jslibpath/angular/angular-mocks.js", true);
        SphpJsM::$jslib["angular"] = 126;
    }

    public static function addjQueryMobile() {
        global $jslibpath;
        //addFileLink("$jslibpath/jquery.mobile-1.4.5/jquery.mobile.custom.structure.min.css", true);
        addFileLink("$jslibpath/jquery.mobile/jquery.mobile-1.4.5.min.css", true);
        //addFileLink("$jslibpath/jquery.mobile-1.4.5/jquery.mobile-1.5.0-alpha.1.min.js", true,"","","jQueryM:1.5.0");
        addFileLink("$jslibpath/jquery.mobile/jquery.mobile-1.4.5.min.js", true);
        SphpJsM::$jslib["jquery_mobile"] = 145;
    }
    /**
     * Get JS Lib Version add by Framework
     * @param string $jslib_name like jquery, bootstrap, react, angular, jquery_ui
     * @return int -1 mean not found
     */
    public static function getJSLibVersion($jslib_name) { 
        if(isset(SphpJsM::$jslib[$jslib_name])){
            return SphpJsM::$jslib[$jslib_name];
        }
        return -1;
    }
    /**
     * add lib and it's Version, overwrite if exists
     * @param string $jslib_name
     * @param int $version default is 1
     */
    public static function setJSLibVersion($jslib_name,$version=1) {
        SphpJsM::$jslib[$jslib_name] = intval($version);
    }
}
