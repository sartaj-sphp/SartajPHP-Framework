<?php
//JSON_THROW_ON_ERROR;

namespace Sphp\kit {
    /*
     * Return block doesn't wait for loading files with ajax.
     * Precedence of AJAX blocks
     * 1. JSS block
     * 2. csfl css file links special block
     * 3. css block
     * 4. jsfl js file links special block
     * 5. js1
     * 6. html data as html
     * 7. js all ready js code
     * 8. jsp 
     * 9. jsf function call
     */
    class JSServer {

        public $json = null;
        public $ajaxrender = false;
        private $jsonout = null;
        private $dataout = null;
        public $jsonready = false;
        public $jsonplain = false;
        private $blnajax = false;
        private $type = "jsonweb";
        private static $firstRun = true;

        /**
         * Advance function 
         */
        public function init() {
            $this->json = null;
            $this->ajaxrender = false;
            $this->jsonout = array();
            $this->dataout = null;
            $this->jsonready = false;
            $this->jsonplain = false;
            $this->blnajax = false;
            $this->type = "jsonweb";
        }
        /**
         * Enable ajax JS library.
         */
        public function getAJAX() {
            if (!$this->blnajax) {
                \SphpBase::sphp_api()->addFileLink(\SphpBase::sphp_settings()->res_path . '/' . \SphpBase::sphp_settings()->slib_version . "/comp/ajax/res/ajax.js", true);
                //if(\SphpBase::sphp_request()->type == "NORMAL" && !\SphpBase::sphp_api()->isHeaderJSFunctionExist('frontobjjsbind','global')){
                // add al code into file as global js. so ajaxinit.js not use
                /*
                if (!\SphpBase::sphp_api()->isHeaderJSFunctionExist('frontobjjsbind', 'global')) {
                    addHeaderJSFunction('frontobjjsbind', file_get_contents(\SphpBase::sphp_settings()->slib_path . "/comp/ajax/res/ajaxinit.js"), '', true);
                }
                 * 
                 */
                $this->blnajax = true;
            }
        }
        /**
         * Read json data from browser post key 
         * @param string $post_data_key
         * @return json
         */
        public function getJSON($post_data_key) {
            //$this->json = json_decode(stripslashes($Client->post("data")), true);
            $this->json = \SphpBase::sphp_request()->post($post_data_key);
            return $this->json;
        }
        /**
         * Advance function to enable JSON response
         */
        public function startJSONOutput() {
            $this->jsonready = true;
        }

        /**
         * Advance function 
         */
        public function sendData($data, $contenttype = "") {
            $this->jsonready = true;
            $this->jsonplain = true;
            if ($contenttype != "") {
                \SphpBase::sphp_response()->addHttpHeader("Content-type", $contenttype);
            } else {
                \SphpBase::sphp_response()->addHttpHeader("Content-type", "text/json");
            }
            $this->dataout = $data;
        }
        /**
         * Send string to browser and display in html tag with an $tagid
         * @param string $tagid <p>
         * HTML Tag ID where to set html
         * </p>
         * @param string $dataar
         */
        public function addJSONHTMLBlock($tagid, $dataar) {
            $this->addJSONBlock("html", $tagid, $dataar);
        }
        /**
         * Advance Function
         * Send and Data type to browser
         * @param string $sact <p>
         * it may be and process order wise:- jss,js1,html,js,jsp,jsf
         * </p>
         * @param type $evtp <p>
         * It is a key of value like in $sact=html then it is a tag id. 
         * If $sact=jsf then it will be JS function name
         * </p>
         * @param mixed $dataar <p>
         * data need to send browser
         * </p>
         */
        public function addJSONBlock($sact, $evtp, $dataar) {
            $this->jsonready = true;
            $assa = array();
            $assa[$evtp] = $dataar;
            $this->jsonout["response"][$sact][] = $assa;
        }
        /**
         * Call JS Function from Server
         * @param string $jsfun
         * @param mixed $dataa
         */
        public function callJsFunction($jsfun, $dataa) {
            $this->jsonready = true;
            $assa = array();
            $assa[$jsfun] = $dataa;
            $this->jsonout["response"]["jsf"][] = $assa;
        }
        /**
         * Send Component object inside a HTML Tag
         * @param \Sphp\tools\Component $obj
         * @param string $outid <p>
         * HTML Tag id where to display html of Component
         * </p>
         * @param boolean $innerHTML Optional <p>
         * Default = false:- Not send Inner Components
         * true:- mean send all Inner Components also
         * </p>
         */
        public function addJSONComp($obj, $outid = "outid", $innerHTML = false) {
            $this->jsonready = true;
            $this->ajaxrender = true;
            $assa = array();
            $htmlp = $obj->frontobj->HTMLParser;
            $assa[$outid] = $htmlp->parseComponent($obj, $innerHTML);
            $this->ajaxrender = false;
            $this->jsonout["response"]["html"][] = $assa;
        }
        /**
         * Send only Inner Components of Object
         * @param \Sphp\tools\Component $obj
         * @param string $outid
         */
        public function addJSONCompChildren($obj, $outid = "outid") {
            $this->addJSONComp($obj, $outid, true);
        }
        /**
         * Get Component HTML Output
         * @param \Sphp\tools\Component $obj
         * @return string
         */
        public function getJSONComp($obj) {
            $this->jsonready = true;
            $this->ajaxrender = true;
            $htmlp = $obj->frontobj->HTMLParser;
            $assa = $htmlp->parseComponent($obj);
            $this->ajaxrender = false;
            return $assa;
        }
        /**
         * Send FrontFile Object to HTML Tag id
         * @param \Sphp\tools\FrontFile $frontobj
         * @param string $outid <p>
         * HTML Tag ID where to display HTML of temfile object
         * </p>
         */
        public function addJSONFront($frontobj, $outid = "outid") {
            $this->jsonready = true;
            $this->ajaxrender = true;
            $assa = array();
            $frontobj->run();
            $this->ajaxrender = false;
            $assa[$outid] = $frontobj->data;
            $this->jsonout["response"]["html"][] = $assa;
        }
        /**
         * Send FrontFile Object with all file links to HTML Tag id
         * @param \Sphp\tools\FrontFile $frontobj
         * @param string $outid <p>
         * HTML Tag ID where to display HTML of temfile object
         * </p>
         */
        public function addJSONFrontFull($frontobj, $outid = "outid") {
            $this->jsonready = true;
            $assa = array();
            $frontobj->run();
            $assa[$outid] = $frontobj->data;
            $this->jsonout["response"]["html"][] = $assa;
        }
        /**
         * Send Data as inter process communication
         * @param string $aname
         * @param array $structure
         */
        public function addJSONIpcBlock($aname, $structure) {
            $this->jsonready = true;
            //$assa = array();
            //$assa["$aname"] = $structure;
            $this->jsonout["response"]["ipc"]["$aname"][] = $structure;
        }
        /**
         * Advance Function         * 
         * @param string $type <p>
         * default is jsonweb. You can create your own custom type also.
         * </p>
         */
        public function setBlockType($type = "jsonweb") {
            $this->type = $type;
        }

// priority jsfl,js,jsp = type
        /**
         * Send JS Code to browser
         * @param string $jsdata <p>
         * JS code as string, send to browser.
         * </p>
         * @param string $type <p>
         * value may be order wise :- jss, jsfl, js, jsp or jsf
         * jss has highest priority
         * </p>
         */
        public function addJSONJSBlock($jsdata = "", $type = "jsp") {
            $this->jsonready = true;
            $assa = array();
            $strout2 = "";
            //$strout2 = getHeaderJS(false,false);
            //$strout2 .= getFooterJS(false,false);
            $assa["proces"] = $strout2 . " $jsdata";
            $this->jsonout["response"][$type][] = $assa;
        }
        /**
         * Send data to getAJAX callback function.
         * getAJAX('index-test.html',{},true,function(ret){
         *  console.log('server return data' + ret);
         * });
         * @param array|string $data
         */
        public function addJSONReturnBlock($data) {
            $this->jsonready = true;
            $this->jsonout["response"]["retobj"] = $data;
        }

        private function addJSONAppBlock() {
            \SphpBase::sphp_api()->getHeaderHTML(false, false);
            \SphpBase::sphp_api()->getFooterHTML(false, false);
        }

        private function getToken() {
            $token = \SphpBase::sphp_request()->cookie("mtoken");
            if ($token != "") {
                return $token;
            } else {
                return "FG546Hjg7";
            }
        }
        /**
         * Advance Function
         * Return all response of Server as JSON
         * @return string
         */
        public function getResponse() {
            try{
            $htmlPageOut = "";
            $val1 = array();
            if ($this->jsonplain) {
                return $this->dataout;
            } else if ($this->jsonready) {
                \SphpBase::sphp_response()->addHttpHeader("Content-type", "text/plain");
                $this->addJSONAppBlock();
                $arbuf1 = ob_get_status(true);
                if(count($arbuf1)>0){
                    $htmlPageOut = ob_get_contents();
                    ob_end_clean();
                }
                ob_start();
                $val1["srvmsg"] = $htmlPageOut;

                $this->jsonout["response"]["id"] = session_id();
                $this->jsonout["response"]["con"] = 0;
                $this->jsonout["response"]["tok"] = $this->getToken();
                $this->jsonout["response"]["type"] = $this->type;
                $this->jsonout["response"]["html"][] = $val1;
                $htmlPageOut = json_encode($this->jsonout,JSON_THROW_ON_ERROR,512) . ",";
                
                if($htmlPageOut == ","){
                    //$this->jsonout["response"]["html"] = array();
                    //$htmlPageOut = json_encode($this->jsonout,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP| JSON_THROW_ON_ERROR,512) . ",";
                }
            }
            }catch (\Exception $e){
                $this->jsonout["response"] = $this->array_map_recursive1(function ($value) {
                    if (is_string($value)) {
                        // Check if string is valid UTF-8
                        if (!mb_check_encoding($value, 'UTF-8')) {
                            // Convert to UTF-8 or replace invalid characters
                            $value = mb_convert_encoding($value, 'UTF-8');
                        }
                        // Remove control characters (e.g., \0, \t)
                        $value = preg_replace('/[\x00-\x1F\x7F]/u', '', $value);
                        return $value;
                    } elseif (is_resource($value) || is_object($value) && !($value instanceof \JsonSerializable)) {
                        // Convert non-serializable objects/resources to string or null
                        return (string)$value ?: null;
                    }
                    return $value;
                }, $this->jsonout["response"]);
                 $val1["srvmsg"] = $e->getMessage();
                 $this->jsonout["response"]["html"][] = $val1;
                $htmlPageOut = json_encode($this->jsonout,512) . ",";
            }
            return $htmlPageOut;
        }
        
        private function array_map_recursive1($callback, $array) {
            if (!is_array($array)) {
                return $callback($array);
            }
            return array_map(function ($item) use ($callback) {
                return $this->array_map_recursive1($callback, $item);
            }, $array);
        }
        /**
         * Advance Function
         * Send all response of Server as JSON to browser.
         * if application run continiously then you can send intermediate data
         *  
         */
        public function flush() {
            if ($this->jsonplain) {
                \SphpBase::sphp_response()->setContent($this->dataout);
            } else if ($this->jsonready) {
                \SphpBase::engine()->engine_start_time = microtime(true);
                $conid = 0;
                $bd = \SphpBase::sphp_request()->request("bdata");
                if ($bd !== "" && isset($bd["wcon"])) {
                    $conid = $bd["wcon"];
                }
                $this->addJSONAppBlock();
                $this->jsonout["response"]["id"] = "none";
                $this->jsonout["response"]["con"] = $conid;
                $this->jsonout["response"]["tok"] = $this->getToken();
                $this->jsonout["response"]["type"] = $this->type;
                $this->jsonout["response"]["html"][] = array();
                \SphpBase::sphp_response()->setContent(json_encode($this->jsonout) . ",");
            }
            if(JSServer::$firstRun){
                JSServer::$firstRun = false;
                //\SphpBase::sphp_response()->addHttpHeader("Content-type", "text/json; charset=utf-8");
                \SphpBase::sphp_response()->addHttpHeader('Connection', 'keep-alive');
                \SphpBase::sphp_response()->addHttpHeader('Content-Encoding', 'chunked');
                \SphpBase::sphp_response()->addHttpHeader('Transfer-Encoding', 'chunked');
                \SphpBase::sphp_response()->addHttpHeader('X-Content-Type-Options', 'nosniff');
                \SphpBase::sphp_response()->send();
            }else{
                \SphpBase::sphp_response()->send(false);                
            }
            $a1 = ob_get_status(false);
            if (count($a1) > 0) {
                \flush();
                ob_flush();
            }
            \SphpBase::sphp_api()->init();
            $this->init();
        }

        public function callServer($jsfun, $url, $imgid = "''") {
            addHeaderJSFunction($jsfun, " function $jsfun(){var data = {};var dataType = 'json';var cache = false; ", "sartajgt(" . $imgid . "," . $url . ",data,cache,dataType); } ");
            return $jsfun . "()";
        }

        public function postServer($url, $data = "{}", $imgid = "''", $cache = false, $dataType = "'json'") {
            if ($cache) {
                $cache2 = "true";
            } else {
                $cache2 = "false";
            }
            $code = "sartajgt(" . $imgid . "," . $url . "," . $data . "," . $cache2 . "," . $dataType . ") ";
            return $code;
        }

    }

    /**
     * Description of JQuery
     *
     * @author Sartaj Singh
     */
    class JQuery {

        private $jsfun = "ready";
        private $jsfunpublic = false;
        private $blngetkit = false;
        public $jq = null;

        public function __construct() {
            $this->jq = new jq();
            //    $this->jsonout["response"][0] = array();
        }

        public function setJSFunctionName($jsfun, $funtype = false) {
            $this->jsfun = $jsfun;
            $this->jsfunpublic = $funtype;
        }

        public function stripQuot($val) {
            $str = str_replace("\"", "", $val);
            $str = str_replace("'", "", $str);
            return $str;
        }

        public function safeJSString($val) {
            $str = str_replace(".", "\.", $val);
            return $str;
        }

        public function stripNewLineChar($val) {
            $str = str_replace(array(RLINE . NEWLINE, RLINE, NEWLINE), "", $val);
            return $str;
        }

        public function getJSString($val) {
            $val = str_replace(array(RLINE . NEWLINE, RLINE, NEWLINE), "", $val);
            $val = str_replace(".", "\.", $val);
            $val = str_replace("'", "\'", $val);
            return "'" . $val . "'";
        }

        public function log($msg) {
            addHeaderJSFunctionCode('ready', '', 'console.log(' . $this->getJSString($msg) . ');');
        }

        public function info($msg) {
            addHeaderJSFunctionCode('ready', '', 'console.info(' . $this->getJSString($msg) . ');');
        }

        public function warn($msg) {
            addHeaderJSFunctionCode('ready', '', 'console.warn(' . $this->getJSString($msg) . ');');
        }

        public function error($msg) {
            addHeaderJSFunctionCode('ready', '', 'console.error(' . $this->getJSString($msg) . ');');
        }

        public function setEventHandler() {
            \SphpBase::sphp_api()->addHeaderJSFunction("jq_event", " function jq_event(args){ ", " } ", true);
        }

        public function fetchQuery($sql, $timesec = 0) {
            $sql = $this->stripQuot($sql);
            $timesec = $this->stripQuot($timesec);
            $res = \SphpBase::dbEngine()->fetchQuery($sql, $timesec);
            return json_encode($res);
        }

        public function ajax($fun, $url, $data = "''", $cache = false) {
            $cache2 = "false";
            if ($cache) {
                $cache2 = "true";
            }
            \SphpBase::sphp_api()->addHeaderJSFunctionCode($this->jsfun, "", "ajaxcall(" . $fun . ",'" . $url . "'," . $data . "," . $cache2 . ");");
        }

        public function StartTimeLine($aname) {
            $aname2 = $this->stripQuot($aname);
            \SphpBase::sphp_api()->addHeaderJSFunction($aname2, "var $aname2 = [ ", " {at_time: 0,command: function(){ } } ];");
            return "jq.flush()";
        }

        public function addTimeLineCMD($aname, $at_time, $val) {
            $aname2 = $this->stripQuot($aname);
            $code = "{at_time: " . $at_time . ",command: function(){ " . $val . " } }, ";
            \SphpBase::sphp_api()->addHeaderJSFunctionCode($aname2, "", $code);
            return "jq.flush()";
        }

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

        public function runTimeLine($aname) {
            $aname2 = $this->stripQuot($aname);
            return "time_next(" . $aname2 . ")";
        }

        public function Queue($aname) {
            $aname2 = $this->stripQuot($aname);
            \SphpBase::sphp_api()->addHeaderJSCode($aname2 . "que", "var " . $aname2 . "que = $('<p>');");
            return "jq.flush()";
        }

        public function addQueue($aname, $val) {
            $aname2 = $this->stripQuot($aname);
            $code = $aname2 . "que.queue(\"" . $aname2 . "\",function( next ){" . $val . ";next(); } )";
            return $code;
        }

        public function addFade($id) {
            \SphpBase::sphp_api()->addHeaderJSCode("jsfade", " function jsfade(obj){ $(obj).fadeOut(500,function(){ $(obj).fadeIn(500);});} ");
            //addHeaderJSFunctionCode($this->jsfun,"","jsfade("$id")");
            return "jsfade(" . $id . ")";
        }

        public function addExplode($id) {
            //addFileLink($jquerypath.'ui/jquery.ui.effect.min.js');
            //addFileLink($jquerypath.'ui/jquery.ui.effect-explode.min.js');
            \SphpBase::sphp_api()->addHeaderJSCode("jsexplode", " function jsexplode(obj){ $(obj).effect('explode',{},300,function() { $(obj).fadeIn(10);}); } ");
            //addHeaderJSFunctionCode($this->jsfun,"","jsexplode('$id')");
            return "jsexplode(" . $id . ")";
        }

        public function addBounce($id) {
            //addFileLink($jquerypath.'ui/jquery.ui.effect.min.js');
            //addFileLink("{$jquerypath}/ui/jquery.ui.effect-bounce.min.js");
            \SphpBase::sphp_api()->addHeaderJSCode("jsbounce", " function jsbounce(obj){ $(obj).effect('bounce',{},300,function(event, ui) {jq_event({obj: $(obj),evt: 'bounce'});}); } ");
            //addHeaderJSFunctionCode($this->jsfun,"","jsbounce('$id')");
            return "jsbounce(" . $id . ")";
        }

        public function getJQKit() {
            if (!$this->blngetkit) {
                \SphpJsM::addjQueryUI();
                //addFileLink("{$jquerypath}/themes/base/jquery.ui.all.css",true);
                //addFileLink("{$jquerypath}/ui/jquery.ui.core.min.js",true);
                //addFileLink("{$jquerypath}/ui/jquery.ui.widget.min.js",true);
                //addFileLink("{$jquerypath}/ui/jquery.ui.mouse.min.js",true);
                //addFileLink("{$jquerypath}/ui/jquery.ui.draggable.min.js",true);
                //addFileLink("{$jquerypath}/ui/jquery.ui.droppable.min.js",true);
                //addFileLink("{$jquerypath}/ui/jquery.ui.resizable.min.js",true);
                //addFileLink($jquerypath.'ui/jquery.ui.effect.min.js');

                \SphpBase::sphp_api()->addHeaderJSFunction("jq_drop", " function jq_drop(eventer){ ", " } ", true);
                \SphpBase::sphp_api()->addHeaderJSFunction("jq_drag", " function jq_drag(eventer){ ", "}", true);
                \SphpBase::sphp_api()->addHeaderJSFunction("jq_resize", " function jq_resize(eventer){", "}", true);
                \SphpBase::sphp_api()->addHeaderJSFunction("jq_keyevent", " var ctrl = false;function jq_keyevent(eventer){var keycode = (eventer.event.keyCode ? eventer.event.keyCode : eventer.event.which); if(eventer.evt=='keyup' && keycode == 17){ctrl=false;} if(eventer.evt=='keydown' && keycode == 17){ctrl=true;} var eventer2 = {obj: eventer.obj,evt: eventer.evt,event: eventer.event,ui: eventer.ui,keycode: keycode,ctrl: ctrl};var ret = true; var keychar = eventer.event.key;", "if(ctrl && eventer.evt=='keyup'){ctrl=false;}return ret;}", true);
                \SphpBase::sphp_api()->addHeaderJSFunction("jq_focus", " function jq_focus(eventer){", " }", true);
                \SphpBase::sphp_api()->addHeaderJSFunction("jq_event", " function jq_event(eventer){", " }", true);

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

                \SphpBase::sphp_api()->addHeaderJSFunctionCode("ready", "getjqkit", $strcode, true);
                $this->blngetkit = true;
            }
        }

        public function pngFix() {
            $respath = \SphpBase::sphp_settings()->getRes_path();
            $strcode = "         if ($.browser.msie && $.browser.version == '6.0') {";
            $strcode .= "         try {";
            $strcode .= "            $.each($(\"img[src$=.png],img[src$=.PNG]\"), function () {";
            $strcode .= "                 var img = $(this);";
            $strcode .= "     img.css({\"width\": img.width(),\"height\": img.height(), \"filter\": \"progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\" + img.attr(\"src\") + \", sizingMethod='scale')\"});";
            $strcode .= "                 img.attr(\"src\",\"" . $respath . "component/jquery/images/blank.gif\");";
            $strcode .= "            });";
            $strcode .= "         } catch(e) {";
            $strcode .= "             alert(e.description)";
            $strcode .= "         }";
            $strcode .= "       }";
            \SphpBase::sphp_api()->addHeaderJSFunctionCode("ready", "pngFix", $strcode);
        }

        public function stringtoargu($strpara) {
            $strparaa = explode(",", $strpara);
            return $strparaa;
        }

        public function stringtophpargu($strpara) {
            $strparaa = explode(",", $strpara);
            foreach ($strparaa as $key => $value) {
                $strparaa[$key] = $this->phpstring($value);
            }
            return $strparaa;
        }

        public function phpstring($str) {
            $str = substr($str, 1, strlen($str) - 2);
            return $str;
        }

    }

}
