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
        addFileLink("{$jslibpath}/jquery/jslib.js", true,"sphp-jslib","js","jslib: 1.0.1");
        SphpJsM::$jslib["jslib"] = 1;

// load js migrate lib 
//addFileLink("{$respath}/jquery/jquery-migrate-1.2.1.min.js",true);
        addHeaderJSFunction('ready', "$(document).ready(function() {", "});", true);
        addHeaderJSFunction('ready', "$(document).ready(function() {", "});");
        addHeaderJSFunction('pageload', "$(window).on('load',function() {", "});", true);
        addFileLink('window["sphpjq"] = window.jQuery = window.$ = jql;', true, "jquery-js-code", "js");
// native console = sconsole.log(msg);
        addHeaderJSFunction('onconsole', "window['onconsole'] = function(msg,type){var nooutput = false;", " if(!nooutput){switch(type){
            case \"i\": {sconsole.info(msg); break;}
            case \"w\": {sconsole.warn(msg); break;}
            case \"e\": {sconsole.error(msg);break;}
            default: {sconsole.log(msg);break;}
        }
}};", true);
        
    }

    public static function setMinimumLib($jquerypath="") {
        global $jslibpath;
        if($jquerypath != ""){
            updateFileLink($jquerypath, true, "jquery-min", "js");
        }else{
            updateFileLink("{$jslibpath}/jquery/jquery-min1.10.js", true, "jquery-min", "js");
        }
        updateFileLink('var jql = $;', true, "jquery-js-code", "js");
        updateFileLink("{$jslibpath}/jquery/jslib_old_browser.js",true,'sphp-jslib');
    }    
    public static function addAlertDialog() {
        global $jslibpath;
        addFileLink("$jslibpath/jquery/jquery-confirm.min.css", true);
        addFileLink("$jslibpath/jquery/jquery-confirm.min.js", true);
        addFileLink("$jslibpath/jquery/alertDialog.js", true,"sphp-jslib");
        SphpJsM::$jslib["alert_dialog"] = 1;
    }

    public static function getSphpLib() {
        \SphpBase::JSServer()->getAJAX();
        addFileLink(\SphpBase::sphp_settings()->comp_uikit_res_path . "/form/assets/validation.js", true);
        addFileLink(\SphpBase::sphp_settings()->comp_uikit_res_path . "/form/assets/jquery.form.js", true);        
    }
    public static function addjQueryl($default = false, $replaceVar = "") {
        global $jslibpath;
        updateFileLink("$jslibpath/jquery/jquery-3.4.1.min.js", true, "jquery-min", "js", "jquery:3.4.1");
        addHeaderJSFunction('ready', "jql(document).ready(function() {", "});", true);
        addHeaderJSFunction('ready', "jql(document).ready(function() {", "});");
        addHeaderJSFunction('pageload', "jql(window).on('load',function() {", "});", true);
// use code var jql = $.noConflict(true);
        if ($default) {
            updateFileLink('window["sphpjq"] = window.jQuery = window.$ ' . $replaceVar . ' = jql;', true, "jquery-js-code", "js");
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
            updateFileLink('window["sphpjq"] = window.jQuery = window.$ = jq2;', true, "jquery-js-code", "js");
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
                updateFileLink('window["sphpjq"] = window.jQuery = window.$ = window.jq1 = jql;', true, "jquery-js-code", "js");
            } else {
                updateFileLink('window["sphpjq"] = window.jQuery = window.$ = window.jq1 = $.noConflict(true);', true, "jquery-js-code", "js");
            }
        }
        SphpJsM::$jslib["jquery"] = 110;
//addFileLink("$jslibpath/jquery-ui-1.12.1/jquery-ui.min_jq1.js", true,"jquery-ui");
    }
public static function addBootStrap() {
        global $jslibpath;
        if(SphpJsM::getJSLibVersion("bootstrap") == -1){ 
        SphpJsM::addFontAwesome6();
        /*addFileLinkCode('bootstrap5', '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">'
                . '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>');
         */
        addFileLink("$jslibpath/twitter/bootstrap5/bootstrap.min.css", true, "", "", "bootstrap:5");
        addFileLink("$jslibpath/twitter/bootstrap5/bootstrap.bundle.min.js", true);
        SphpJsM::addAlertDialog();
        SphpJsM::$jslib["bootstrap"] = 5;
        //SphpJsM::addFontAwesome();
        }
    }
    public static function includeRequired() { 
        include_once(SphpBase::sphp_settings()->comp_uikit_path . "/assets_loader.php");
        includeRequired();
    }
    
    public static function includeFull() { 
        include_once(SphpBase::sphp_settings()->comp_uikit_path . "/assets_loader.php");
        includeFull();
    }
    
    public static function addFontAwesome() {
        global $jslibpath;
        if(SphpJsM::getJSLibVersion("fontawesome") == -1){ 
        addFileLink("$jslibpath/fontawesome/css/font-awesome.min.css", true,"","","fontasm:5",["$jslibpath/fontawesome"]);
        SphpJsM::$jslib["fontawesome"] = 4;
        }
    }

    public static function addFontAwesome6() {
        global $jslibpath;
        // support both version 4 and 6
        addFileLink("$jslibpath/fontawesome6/css/all.min.css", true,"","","fontasm:6");
        addFileLink("$jslibpath/fontawesome6/css/v4-shims.min.css", true);
        SphpJsM::$jslib["fontawesome"] = 6;
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
        addFileLink("$jslibpath/jquery.mobile/jquery.mobile-1.4.5.min.css", true,"","","jquerymob:4",["$jslibpath/jquery.mobile"]);
        //addFileLink("$jslibpath/jquery.mobile-1.4.5/jquery.mobile-1.5.0-alpha.1.min.js", true,"","","jQueryM:1.5.0");
        addFileLink("$jslibpath/jquery.mobile/jquery.mobile-1.4.5.min.js", true);
        SphpJsM::$jslib["jquery_mobile"] = 145;
    }
    
    public static function addjQueryUI($version = "1.12.1") {
        global $jslibpath;
        addFileLink("$jslibpath/jquery-ui-" . $version . "/jquery-ui.min.css", true);
        //addFileLink("$jslibpath/jquery-ui-" . $version . "/jquery-ui.theme.min.css", true);
        //addFileLink("$jslibpath/jquery-ui-" . $version . "/jquery-ui.structure.min.css", true);
    //addFileLink("$jslibpath/jquery-ui-" . $version . "/jquery-ui-bootstrap.css", true);
        // crass with bootstrap so change name to jquery-ui2 fix in future
        addFileLink("$jslibpath/jquery-ui-" . $version . "/jquery-ui.min.js", true, "jquery-ui2", "", "jqueryui:" . $version);
        SphpJsM::$jslib["jqueryui"] = str_replace('\.', '', $version);
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
