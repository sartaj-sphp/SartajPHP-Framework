<?php

final class SphpJsM {
    private static $arrJsLibList = array();
    private static $blngetkit = false;

    
    public function __construct() {
        self::$arrJsLibList = array();
        SphpJsM::loadJsLib("jquery",321);
    }
    /**
     * This will set Js Libray to load, overwrite if exists This will automatically Call Loader function 
     * like loadJsLib{strtolower($jsLibName)}{intval($version)}() as global Function on run event.
     * @param type $jsLibName Js Library Name like jquery 
     * @param type $version Version without dot as number like 321
     */
    public static function loadJsLib($jsLibName,$version=1) {
        SphpJsM::$arrJsLibList[strtolower($jsLibName)] = intval($version);        
    }
    /**
     * Advanced internal call function trigger by run event. Actually call Loader 
     * Function in getHeaderHtml method of SphApi
     */
    public static function _run() { 
        foreach (SphpJsM::$arrJsLibList as $libjs => $version) {
            $fun1 = "loadJsLib{$libjs}{$version}";
            $fun1();
        }
    }
    
    public static function setMinimumLib() {
        SphpJsM::loadJsLib("jquery",110);
    }    
    public static function addAlertDialog() {
        SphpJsM::loadJsLib("alertdialog",1);
    }

    public static function getSphpLib() {
        \SphpBase::jsServer()->getAjax();
        addFileLink(\SphpBase::sphpSettings()->uiKitUrl . "/form/assets/validation.js", true);
        addFileLink(\SphpBase::sphpSettings()->uiKitUrl . "/form/assets/jquery.form.js", true);        
    }
    public static function addjQueryl($default = false, $replaceVar = "") {
        global $jsLibUrl;
        updateFileLink("$jsLibUrl/jquery/jquery-3.4.1.min.js", true, "jquery-min", "js", "jquery:3.4.1");
        addHeaderJsFunction('ready', "jql(document).ready(function() {", "});", true);
        addHeaderJsFunction('ready', "jql(document).ready(function() {", "});");
        addHeaderJsFunction('pageload', "jql(window).on('load',function() {", "});", true);
// use code var jql = $.noConflict(true);
        if ($default) {
            updateFileLink('window["sphpjq"] = window.jQuery = window.$ ' . $replaceVar . ' = jql;', true, "jquery-js-code", "js");
        }
        //SphpJsM::$arrJsLibList["jquery"] = 341;
    }

    public static function addjQuery2($default = false) {
        global $jsLibUrl;
        addFileLink("$jsLibUrl/jquery/jquery-2.2.4.min.js", true, "jquery-min2", "js");
        addHeaderJsFunction('readyjq2', "jq2(document).ready(function() {", "});", true);
        addHeaderJsFunction('readyjq2', "jq2(document).ready(function() {", "});");
        addHeaderJsFunction('pageloadjq2', "jq2(window).on('load',function() {", "});", true);
        if ($default) {
            updateFileLink('window["sphpjq"] = window.jQuery = window.$ = jq2;', true, "jquery-js-code", "js");
        }
        //SphpJsM::$arrJsLibList["jquery"] = 224;
    }

    public static function addjQuery1($default = false, $latest = false) {
        global $jsLibUrl;
        if ($latest) {
            updateFileLink("$jsLibUrl/jquery/jquery-min1.10.js", true, "jquery-min", "js", "jquery:1.10.0");
        } else {
            addFileLink("$jsLibUrl/jquery/jquery-min1.10.js", true, "jquery-min1", "js");
        }
        addHeaderJsFunction('readyjq1', "jq1(document).ready(function() {", "});", true);
        addHeaderJsFunction('readyjq1', "jq1(document).ready(function() {", "});");
        addHeaderJsFunction('pageloadjq1', "jq1(window).on('load',function() {", "});", true);
        if ($default) {
            if ($latest) {
                updateFileLink('window["sphpjq"] = window.jQuery = window.$ = window.jq1 = jql;', true, "jquery-js-code", "js");
            } else {
                updateFileLink('window["sphpjq"] = window.jQuery = window.$ = window.jq1 = $.noConflict(true);', true, "jquery-js-code", "js");
            }
        }
        //SphpJsM::$arrJsLibList["jquery"] = 110;
//addFileLink("$jsLibUrl/jquery-ui-1.12.1/jquery-ui.min_jq1.js", true,"jquery-ui");
    }
public static function addBootStrap() {
        global $jsLibUrl;
        if(SphpJsM::getJsLibVersion("bootstrap") == -1){ 
        SphpJsM::addFontAwesome6();
        /*addFileLinkCode('bootstrap5', '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">'
                . '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>');
         */
        SphpJsM::addAlertDialog();
        SphpJsM::loadJsLib("bootstrap", 5);
        }
    }
    public static function addFontAwesome() {
        // ignore if already set version
        if(SphpJsM::getJsLibVersion("fontawesome") == -1){ 
            SphpJsM::loadJsLib("fontawesome",4);
        }
    }

    public static function addFontAwesome6() {
        // support both version 4 and 6
        SphpJsM::loadJsLib("fontawesome",6);
    }


    public static function addAngular() {
        SphpJsM::loadJsLib("angular",126);
    }

    public static function addjQueryMobile() {
        SphpJsM::loadJsLib("jquery_mobile",  145);
    }
    
    public static function addjQueryUI($version = "1.12.1") {
        SphpJsM::loadJsLib("jqueryui", str_replace('\.', '', $version));
    }
    
    public static function addReact() {
        SphpJsM::loadJsLib("react",18);
        // use one function to load all react files
        //SphpJsM::loadJsLib("react_babel", 6260);
    }

    
        /**
         * Load jQuery UI kit and register event handler JS functions.
         * @return void
         */
        public function getJQKit() {
            if (!SphpJsM::$blngetkit) {
                \SphpJsM::addjQueryUI();
                //addFileLink("{$jslibUrlUrl}/jquery/themes/base/jquery.ui.all.css",true);
                //addFileLink("{$jslibUrlUrl}/jquery/ui/jquery.ui.core.min.js",true);
                //addFileLink("{$jslibUrlUrl}/jquery/ui/jquery.ui.widget.min.js",true);
                //addFileLink("{$jslibUrlUrl}/jquery/ui/jquery.ui.mouse.min.js",true);
                //addFileLink("{$jslibUrlUrl}/jquery/ui/jquery.ui.draggable.min.js",true);
                //addFileLink("{$jslibUrlUrl}/jquery/ui/jquery.ui.droppable.min.js",true);
                //addFileLink("{$jslibUrlUrl}/jquery/ui/jquery.ui.resizable.min.js",true);
                //addFileLink($jslibUrlUrl.'/jquery/ui/jquery.ui.effect.min.js');

                \SphpBase::sphpApi()->addHeaderJsFunction("jq_drop", " function jq_drop(eventer){ ", " } ", true);
                \SphpBase::sphpApi()->addHeaderJsFunction("jq_drag", " function jq_drag(eventer){ ", "}", true);
                \SphpBase::sphpApi()->addHeaderJsFunction("jq_resize", " function jq_resize(eventer){", "}", true);
                \SphpBase::sphpApi()->addHeaderJsFunction("jq_keyevent", " var ctrl = false;function jq_keyevent(eventer){var keycode = (eventer.event.keyCode ? eventer.event.keyCode : eventer.event.which); if(eventer.evt=='keyup' && keycode == 17){ctrl=false;} if(eventer.evt=='keydown' && keycode == 17){ctrl=true;} var eventer2 = {obj: eventer.obj,evt: eventer.evt,event: eventer.event,ui: eventer.ui,keycode: keycode,ctrl: ctrl};var ret = true; var keychar = eventer.event.key;", "if(ctrl && eventer.evt=='keyup'){ctrl=false;}return ret;}", true);
                \SphpBase::sphpApi()->addHeaderJsFunction("jq_focus", " function jq_focus(eventer){", " }", true);
                \SphpBase::sphpApi()->addHeaderJsFunction("jq_event", " function jq_event(eventer){", " }", true);

                $strcode = "$( \".resizable\" ).resizable({resize: function(event, ui) { ";
                $strcode .= " jq_resize({obj: $(event.target),evt: \"resize\",event: event,ui: ui});} });";
                $strcode .= " $( \".focusin\" ).focusin(function(event, ui) { ";
                $strcode .= " jq_focus({obj: $(event.target),evt: \"focusin\",event: event,ui: ui});}); ";
                $strcode .= "     $( \".focusout\" ).focusout(function(event, ui) { ";
                $strcode .= "     jq_focus({obj: $(event.target),evt: \"focusout\",event: event,ui: ui});});";
                $strcode .= "     $( \".keydown\" ).keydown(function(event, ui) { ";
                $strcode .= "     var rt = jq_keyevent({obj: $(event.target),evt: \"keydown\",event: event,ui: ui}); return rt;});";
                $strcode .= "     $( \".keyup\" ).keyup(function(event, ui) { ";
                $strcode .= "     var rt = jq_keyevent({obj: $(event.target),evt: \"keyup\",event: event,ui: ui}); return rt;});";
                $strcode .= "     $( \".keypress\" ).keypress(function(event, ui) { ";
                $strcode .= "     var rt = jq_keyevent({obj: $(event.target),evt: \"keypress\",event: event,ui: ui}); return rt;});";
                $strcode .= "     $(document).keydown(function(event, ui) { ";
                $strcode .= "     var rt = jq_keyevent({obj: $(event.target),evt: \"keydown\",event: event,ui: ui}); return rt;});";
                $strcode .= "     $(document).keyup(function(event, ui) { ";
                $strcode .= "     var rt = jq_keyevent({obj: $(event.target),evt: \"keyup\",event: event,ui: ui}); return rt;});";
                $strcode .= "     $(\".draggable\").draggable({appendTo: \"body\",helper: \"clone\",";
                $strcode .= "                             start: function(event, ui) {jq_drag({obj: $(event.target),evt: \"dragstart\",event: event,ui: ui});},";
                $strcode .= "                             drag: function(event, ui) {jq_drag({obj: $(event.target),evt: \"drag\",event: event,ui: ui});},";
                $strcode .= "                             stop: function(event, ui) {jq_drag({obj: $(event.target),evt: \"dragstop\",event: event,ui: ui});}";
                $strcode .= "     });";
                $strcode .= "     $(\".droppable\").droppable({";
                $strcode .= "     activeClass: \"ui-state-active\",";
                $strcode .= "     hoverClass: \"ui-state-hover\", greedy: true,";
                $strcode .= "     drop: function( event, ui ) {";
                //$strcode .= "             $(this).addClass( \"ui-state-highlight\" ); ";
                $strcode .= "     jq_drop({obj: $(event.target),evt: \"drop\",event: event,ui: ui}); event.stopPropagation(); event.preventDefault(); return false;";
                $strcode .= "    }";
                $strcode .= "  });";

                \SphpBase::sphpApi()->addHeaderJsFunctionCode("ready", "getjqkit", $strcode, true);
                SphpJsM::$blngetkit = true;
            }
        }

        /**
         * Add IE6 PNG transparency fix JS code.
         * @return void
         */
        public function pngFix() {
            $resourceUrl = \SphpBase::sphpSettings()->getResourceUrl();
            $strcode = "         if ($.browser.msie && $.browser.version == '6.0') {";
            $strcode .= "         try {";
            $strcode .= "            $.each($(\"img[src$=.png],img[src$=.PNG]\"), function () {";
            $strcode .= "                 var img = $(this);";
            $strcode .= "     img.css({\"width\": img.width(),\"height\": img.height(), \"filter\": \"progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\" + img.attr(\"src\") + \", sizingMethod='scale')\"});";
            $strcode .= "                 img.attr(\"src\",\"" . $resourceUrl . "component/jquery/images/blank.gif\");";
            $strcode .= "            });";
            $strcode .= "         } catch(e) {";
            $strcode .= "             alert(e.description)";
            $strcode .= "         }";
            $strcode .= "       }";
            \SphpBase::sphpApi()->addHeaderJsFunctionCode("ready", "pngFix", $strcode);
        }
    
    /**
     * Get JS Lib Version add by Framework
     * @param string $arrJsLibList_name like jquery, bootstrap, react, angular, jquery_ui
     * @return int -1 mean not found
     */
    public static function getJsLibVersion($arrJsLibList_name) { 
        if(isset(SphpJsM::$arrJsLibList[$arrJsLibList_name])){
            return SphpJsM::$arrJsLibList[$arrJsLibList_name];
        }
        return -1;
    }
}

   function loadJsLibjquery321(){
       global $jsLibUrl;
        // load js lib and jquery ready function
        //addFileLink("{$resourceUrl}/jquery/jquery-min.js",true);
        //addFileLink("{$resourceUrl}/jquery/jquery-min1.10.js",true,"jquery-min");
        //addFileLink("$jsLibUrl/jquery/jquery-min1.9.1.js",true,"jquery-min");
        addFileLink("{$jsLibUrl}/jquery/jquery-3.2.1.min.js", true, "jquery-min", "js", "jquery:3.2.1");
        // add jlib
        addFileLink("{$jsLibUrl}/jquery/jslib.js", true,"sphp-jslib","js","jslib: 1.0.1");

        // load js migrate lib 
        //addFileLink("{$resourceUrl}/jquery/jquery-migrate-1.2.1.min.js",true);
        addHeaderJsFunction('ready', "$(document).ready(function() {", "});", true);
        addHeaderJsFunction('ready', "$(document).ready(function() {", "});");
        addHeaderJsFunction('pageload', "$(window).on('load',function() {", "});", true);
        addFileLink('window["sphpjq"] = window.jQuery = window.$ = jql;', true, "jquery-js-code", "js");
        // native console = sconsole.log(msg);
        addHeaderJsFunction('onconsole', "window['onconsole'] = function(msg,type){var nooutput = false;", " if(!nooutput){switch(type){
            case \"i\": {sconsole.info(msg); break;}
            case \"w\": {sconsole.warn(msg); break;}
            case \"e\": {sconsole.error(msg);break;}
            default: {sconsole.log(msg);break;}
        }
        }};", true);

   }
   function loadJsLibjquery110() {
        global $jsLibUrl;
        updateFileLink("{$jsLibUrl}/jquery/jquery-min1.10.js", true, "jquery-min", "js");
        updateFileLink('var jql = $;', true, "jquery-js-code", "js");
        updateFileLink("{$jsLibUrl}/jquery/jslib_old_browser.js",true,'sphp-jslib');
    }    
    
    function loadJsLibalertdialog1() {
        global $jsLibUrl;
        addFileLink("$jsLibUrl/jquery/jquery-confirm.min.css", true);
        addFileLink("$jsLibUrl/jquery/jquery-confirm.min.js", true);
        addFileLink("$jsLibUrl/jquery/alertDialog.js", true,"sphp-jslib");
    }
    function loadJsLibbootstrap5() {
        global $jsLibUrl;
        addFileLink("$jsLibUrl/twitter/bootstrap5/bootstrap.min.css", true, "", "", "bootstrap:5");
        addFileLink("$jsLibUrl/twitter/bootstrap5/bootstrap.bundle.min.js", true);
    }

    function loadJsLibfontawesome4() {
        global $jsLibUrl;
        addFileLink("$jsLibUrl/fontawesome/css/font-awesome.min.css", true,"","","fontasm:5",["$jsLibUrl/fontawesome"]);
    }

    function loadJsLibfontawesome6() {
        global $jsLibUrl;
        // support both version 4 and 6
        addFileLink("$jsLibUrl/fontawesome6/css/all.min.css", true,"","","fontasm:6");
        addFileLink("$jsLibUrl/fontawesome6/css/v4-shims.min.css", true);
    }


    function loadJsLibangular126() {
        global $jsLibUrl;
        addFileLink("$jsLibUrl/angular/angular.js", true);
        addFileLink("$jsLibUrl/angular/angular-mocks.js", true);
    }

    function loadJsLibjquerymobile145() {
        global $jsLibUrl;
        //addFileLink("$jsLibUrl/jquery.mobile-1.4.5/jquery.mobile.custom.structure.min.css", true);
        addFileLink("$jsLibUrl/jquery.mobile/jquery.mobile-1.4.5.min.css", true,"","","jquerymob:4",["$jsLibUrl/jquery.mobile"]);
        //addFileLink("$jsLibUrl/jquery.mobile-1.4.5/jquery.mobile-1.5.0-alpha.1.min.js", true,"","","jQueryM:1.5.0");
        addFileLink("$jsLibUrl/jquery.mobile/jquery.mobile-1.4.5.min.js", true);
    }
    
    function loadJsLibjqueryui1121() {
        global $jsLibUrl;
        addFileLink("$jsLibUrl/jquery-ui-" . $version . "/jquery-ui.min.css", true);
        //addFileLink("$jsLibUrl/jquery-ui-" . $version . "/jquery-ui.theme.min.css", true);
        //addFileLink("$jsLibUrl/jquery-ui-" . $version . "/jquery-ui.structure.min.css", true);
    //addFileLink("$jsLibUrl/jquery-ui-" . $version . "/jquery-ui-bootstrap.css", true);
        // crass with bootstrap so change name to jquery-ui2 fix in future
        addFileLink("$jsLibUrl/jquery-ui-" . $version . "/jquery-ui.min.js", true, "jquery-ui2", "", "jqueryui:" . $version);
    }
    
    function loadJsLibreact18() {
        global $jsLibUrl;
        addFileLink("$jsLibUrl/react/react.production18.min.js", true, "", "", "react:18");
        addFileLink("$jsLibUrl/react/react-dom.production18.min.js", true, "", "", "reactdom:18");
        addFileLink("$jsLibUrl/react/babel6.26.0.min.js", true, "", "", "babel:6.26.0");
        //use <script type="text/babel"> tag to code        
    }


    /**
     * Description of JQuery
     *
     */
    class JQuery {

        private $jsfun = "ready";
        private $jsfunpublic = false;
        private $blngetkit = false;
        public $jq = null;

        /**
         * Create a new jq helper object.
         * @return void
         */
        public function __construct() {
            $this->jq = new jq();
            //    $this->jsonout["response"][0] = array();
        }

        /**
         * Set the JS function name and whether it is public.
         * @param string $jsfun
         * @param bool $funtype
         * @return void
         */
        public function setJSFunctionName($jsfun, $funtype = false) {
            $this->jsfun = $jsfun;
            $this->jsfunpublic = $funtype;
        }

        /**
         * Remove single and double quotes from a value.
         * @param string $val
         * @return string
         */
        public function stripQuot($val) {
            $str = str_replace("\"", "", $val);
            $str = str_replace("'", "", $str);
            return $str;
        }

        /**
         * Escape dots in a value for safe use in JS strings.
         * @param string $val
         * @return string
         */
        public function safeJSString($val) {
            $str = str_replace(".", "\.", $val);
            return $str;
        }

        /**
         * Convert a value to a safe single quoted JS string.
         * @param string $val
         * @return string
         */
        public function getJSString($val) {
            $val = SphpBase::sphpApi()->stripNewLineChar($val);
            $val = str_replace(".", "\.", $val);
            $val = str_replace("'", "\'", $val);
            return "'" . $val . "'";
        }

        /**
         * Add a console.log message to the ready JS function.
         * @param string $msg
         * @return void
         */
        public function log($msg) {
            addHeaderJsFunctionCode('ready', '', SphpBase::sphpApi()->consoleMsg($msg,"log"));
        }

        /**
         * Add a console.info message to the ready JS function.
         * @param string $msg
         * @return void
         */
        public function info($msg) {
            addHeaderJsFunctionCode('ready', '', SphpBase::sphpApi()->consoleMsg($msg,"info"));
        }

        /**
         * Add a console.warn message to the ready JS function.
         * @param string $msg
         * @return void
         */
        public function warn($msg) {
            addHeaderJsFunctionCode('ready', '', SphpBase::sphpApi()->consoleMsg($msg,"warn"));
        }

        /**
         * Add a console.error message to the ready JS function.
         * @param string $msg
         * @return void
         */
        public function error($msg) {
            addHeaderJsFunctionCode('ready', '', SphpBase::sphpApi()->consoleMsg($msg,"error"));
        }

        /**
         * Register the jq_event JS function for event handling.
         * @return void
         */
        public function setEventHandler() {
            \SphpBase::sphpApi()->addHeaderJsFunction("jq_event", " function jq_event(args){ ", " } ", true);
        }

        /**
         * Execute a SQL query on server and return result as JSON string.
         * @param string $sql
         * @param int $timesec
         * @return string
         */
        public function fetchQuery($sql, $timesec = 0) {
            $sql = $this->stripQuot($sql);
            $timesec = $this->stripQuot($timesec);
            $res = \SphpBase::dbEngine()->fetchQuery($sql, $timesec);
            return json_encode($res);
        }

        /**
         * Add an ajax call JS code to the current JS function.
         * @param string $fun
         * @param string $url
         * @param string $data
         * @param bool $cache
         * @return void
         */
        public function ajax($fun, $url, $data = "''", $cache = false) {
            $cache2 = "false";
            if ($cache) {
                $cache2 = "true";
            }
            \SphpBase::sphpApi()->addHeaderJsFunctionCode($this->jsfun, "", "ajaxcall(" . $fun . ",'" . $url . "'," . $data . "," . $cache2 . ");");
        }

        /**
         * Start a JS timeline array for timed commands.
         * @param string $aname
         * @return string
         */
        public function StartTimeLine($aname) {
            $aname2 = $this->stripQuot($aname);
            \SphpBase::sphpApi()->addHeaderJsFunction($aname2, "var $aname2 = [ ", " {atTime: 0,command: function(){ } } ];");
            return "jq.flush()";
        }

        /**
         * Add a timed command to a JS timeline.
         * @param string $aname
         * @param string $atTime
         * @param string $val
         * @return string
         */
        public function addTimeLineCMD($aname, $atTime, $val) {
            $aname2 = $this->stripQuot($aname);
            $code = "{atTime: " . $atTime . ",command: function(){ " . $val . " } }, ";
            \SphpBase::sphpApi()->addHeaderJsFunctionCode($aname2, "", $code);
            return "jq.flush()";
        }

        /**
         * Build a JS function definition from arguments.
         * @return string
         */
        public function fun() {
            $total = "";
            $count = 1;
            $args = func_get_args();
            foreach ($args as $arg) {
                if ($count == 1) {
                    $aname = $this->stripQuot($arg);
                } else if ($count == 2) {
                    $argf = $this->stripQuot($arg);
                } else {
                    $total .= $arg . " ; ";
                }
                $count += 1;
            }
            return "function " . $aname . "(" . $argf . "){ " . $total . " } jq.flush()";
        }

        /**
         * Build a JS function definition from arguments without flush call.
         * @return string
         */
        public function funseq() {
            $total = "";
            $count = 1;
            $args = func_get_args();
            foreach ($args as $arg) {
                if ($count == 1) {
                    $aname = $this->stripQuot($arg);
                } else if ($count == 2) {
                    $argf = $this->stripQuot($arg);
                } else {
                    $total .= $arg . " ; ";
                }
                $count += 1;
            }
            return "function " . $aname . "(" . $argf . "){ " . $total . " } ";
        }

        /**
         * Join arguments into a single quoted JS argument string.
         * @return string
         */
        public function funargs() {
            $total = "";
            $blnf = false;
            $args = func_get_args();
            foreach ($args as $arg) {
                if ($blnf) {
                    $total .= "," . $arg;
                } else {
                    $total .= $arg;
                    $blnf = true;
                }
            }
            return "'" . $total . "'";
        }

        /**
         * Build JS code to run a timeline.
         * @param string $aname
         * @return string
         */
        public function runTimeLine($aname) {
            $aname2 = $this->stripQuot($aname);
            return "time_next(" . $aname2 . ")";
        }

        /**
         * Create a JS queue element for an element id.
         * @param string $aname
         * @return string
         */
        public function Queue($aname) {
            $aname2 = $this->stripQuot($aname);
            \SphpBase::sphpApi()->addHeaderJsCode($aname2 . "que", "var " . $aname2 . "que = $('<p>');");
            return "jq.flush()";
        }

        /**
         * Add a command to a JS queue.
         * @param string $aname
         * @param string $val
         * @return string
         */
        public function addQueue($aname, $val) {
            $aname2 = $this->stripQuot($aname);
            $code = $aname2 . "que.queue(\"" . $aname2 . "\",function( next ){" . $val . ";next(); } )";
            return $code;
        }

        /**
         * Add fade out/in effect JS code for an element id.
         * @param string $id
         * @return string
         */
        public function addFade($id) {
            \SphpBase::sphpApi()->addHeaderJsCode("jsfade", " function jsfade(obj){ $(obj).fadeOut(500,function(){ $(obj).fadeIn(500);});} ");
            //addHeaderJsFunctionCode($this->jsfun,"","jsfade("$id")");
            return "jsfade(" . $id . ")";
        }

        /**
         * Add explode effect JS code for an element id.
         * @param string $id
         * @return string
         */
        public function addExplode($id) {
            //addFileLink($jslibUrlUrl.'/jquery/ui/jquery.ui.effect.min.js');
            //addFileLink($jslibUrlUrl.'/jquery/ui/jquery.ui.effect-explode.min.js');
            \SphpBase::sphpApi()->addHeaderJsCode("jsexplode", " function jsexplode(obj){ $(obj).effect('explode',{},300,function() { $(obj).fadeIn(10);}); } ");
            //addHeaderJsFunctionCode($this->jsfun,"","jsexplode('$id')");
            return "jsexplode(" . $id . ")";
        }

        /**
         * Add bounce effect JS code for an element id.
         * @param string $id
         * @return string
         */
        public function addBounce($id) {
            //addFileLink($jslibUrlUrl.'/jquery/ui/jquery.ui.effect.min.js');
            //addFileLink("{$jslibUrlUrl}/jquery/ui/jquery.ui.effect-bounce.min.js");
            \SphpBase::sphpApi()->addHeaderJsCode("jsbounce", " function jsbounce(obj){ $(obj).effect('bounce',{},300,function(event, ui) {jq_event({obj: $(obj),evt: 'bounce'});}); } ");
            //addHeaderJsFunctionCode($this->jsfun,"","jsbounce('$id')");
            return "jsbounce(" . $id . ")";
        }

        /**
         * Split a comma separated string into an array.
         * @param string $strpara
         * @return array
         */
        public function stringtoargu($strpara) {
            $strparaa = explode(",", $strpara);
            return $strparaa;
        }

        /**
         * Split a comma separated string into an array of PHP string values.
         * @param string $strpara
         * @return array
         */
        public function stringtophpargu($strpara) {
            $strparaa = explode(",", $strpara);
            foreach ($strparaa as $key => $value) {
                $strparaa[$key] = $this->phpstring($value);
            }
            return $strparaa;
        }

        /**
         * Remove surrounding quotes from a string.
         * @param string $str
         * @return string
         */
        public function phpstring($str) {
            $str = substr($str, 1, strlen($str) - 2);
            return $str;
        }

    }
