<?php
// global/start.php file 
$cacheFileList = array();
$blnPreLibLoad = false;
$blnPreLibCache = false;
$blnStopResponse = true;
// default variables
$engine = null;
$settings = null;
$sphp_router = null;
$sphp_api = null;
$ctrl = null;
// application path which is call with register Appgate automatically set by application
$appAppgate = $ctrl;
$sphp_request = null;
$sphp_session = null;
$Client = null;
$mysql = null;
$dbEngine = $mysql;
$JSServer = null;
$JSClient = $JSServer;
$JQuery = null;
$page = null;
$debug = null;
$msg = "";
$blngetFront = false;
$formNo = 0;
$showformhead  = "";
$formHead = "";
$formName = "";
$auth = "";
$tblName = "";
$dynData  = "";
$showall = null;
$form2 = null;
$genForm = null;
$currentfrontfile = 'all';
$lst_frontfile = array();
$Components = array();
//end interface lib function
$HTMLParser = null;
$jq = null;
$stmycache = null;
$cacheFileList = array();
$dphppath = "";
$drespath = "";
$sphpJsM = null;

// runtime/startEngine.php file customize

// Load Global Settings and functions 
// global constant
define("NEWLINE","\n");
define("RLINE","\r");
define("TABCHAR","\t");

/*
 * type = Appgate mean url has Appgate name only and response to all events basis on this Appgate
 * type = ce mean Appgate-event cache only that event
 * type = cep mean Appgate-event-evtp cache only that event with that parameter
 * type = e event on any application will be cash
 */

function addCacheList($url, $sec = 0, $type = "Appgate") {
    global $cacheFileList;
    $md5url = md5($url);
    $cacheFileList[$md5url] = array($sec, $type);
}

function isRegisterCacheItem($url) {
    global $cacheFileList;
    $md5url = md5($url);
    if (isset($cacheFileList[$md5url])) {
        return true;
    } else {
        return false;
    }
}

function getCacheItem($url) {
    global $cacheFileList;
    $md5url = md5($url);
    return $cacheFileList[$md5url];
}

// Load Global Settings and functions 
include_once("{$phppath}/global/global.php");
include_once("{$phppath}/global/cachelist.php");

class stmycache {

    public $url_extension = ".html";
    public $act = "";
    public $sact = "";
    public $evtp = "";
    public $ctrl = "";
    public $blnrooturi = true;
    
    public $htmlfileName = "";
    public $blnCash = false;
    public $blnPost = false;
    public $blnCashExp = true;
    
    public $method = "";
    public $mode = "SERVER"; // CMD or CGI
    public $protocol = "";
    public $blnsecure = false;
    public $uri = "";
    public $scriptpath = "";
    public $argv = array();
    public $type = "NORMAL"; // AJAX or SOAP etc


    // Parse Request
    public function __construct() {
        global $argv,$injectProtection,$sphp_app_cmd;
        $qpos = 0;
        $scriptPath = $sp = "";
        // check if php is running on command line or not
        if ($sphp_app_cmd && !isset($_SERVER["SERVER_SOFTWARE"]) && (php_sapi_name() == "cli" || (is_numeric($_SERVER["argc"]) && $_SERVER["argc"] > 0))) { 
            $this->mode = "CLI"; 
            $value = "";
            $next = 0;
            $total = count($argv);
            for ($c = 0; $c < $total; $c++) {
                $next = $c + 1;
                if ($next >= $total) {
                    $next = $total - 1;
                }
                if (strpos($argv[$c], "--") !== FALSE) {
                    if (strpos($argv[$next], "--") !== FALSE) {
                        $value = "";
                        $this->argv[$argv[$c]] = $value;
                    } else {
                        $value = $argv[$next];
                        $this->argv[$argv[$c]] = $value;
                        $c++;
                    }
                }
            }
            if (isset($this->argv["--data"]) && $this->argv["--data"] != "") {
                $_REQUEST["data"] = $this->argv["--data"];
            }
            if (isset($this->argv["--droot"]) && $this->argv["--droot"] != "") {
                $_SERVER['DOCUMENT_ROOT'] = $this->argv["--droot"];
            }
            if (isset($this->argv["--evt"]) && $this->argv["--evt"] != "") {
                $this->uri = "-" . $this->argv["--evt"];
            }
            if (isset($this->argv["--evtp"]) && $this->argv["--evtp"] != "") {
                $this->uri .= "-" . $this->argv["--evtp"];
            }
            if (isset($this->argv["--ctrl"]) && $this->argv["--ctrl"] != "") { 
                $this->uri = $this->argv["--ctrl"] . $this->uri . ".html"; 
            } else { 
                $this->uri = "index" . $this->uri . ".html";
            }

            $this->scriptpath = "/";
            $this->method = "COMMAND";
			//$_SERVER["REQUEST_URI"] =  $this->uri;
			$_SERVER['HTTP_HOST'] = 'sphpdesk';
			$_SERVER['REQUEST_URI'] = '/';
			//$_SERVER["PHP_SELF"] = "";
        } else { 
            /**
             * Checks whether request has been made using ajax
             */
            $this->uri = $_SERVER["REQUEST_URI"];
            $qpos = strpos($this->uri, "?");
            $this->uri = urldecode($_SERVER["REQUEST_URI"]);
            if ($injectProtection) {
                $this->uri = $this->escapetag($this->uri);
            }
            // check ? in url to break url
            if ($qpos) {
                $this->uri = substr($this->uri, 0, $qpos);
            }
            $sp = explode("/", $_SERVER["PHP_SELF"]);
            $a = 0;
            while ($a < count($sp) - 1) {
                $scriptPath .= $sp[$a] . "/";
                $a++;
            }
            if ($scriptPath != "/") {
                $this->uri = str_replace($scriptPath, "", $this->uri);
            } else {
                $this->uri = substr($this->uri, 1);
            }
            $this->scriptpath = $scriptPath;
            $this->method = $_SERVER["REQUEST_METHOD"];
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest") {
                $this->type = "AJAX";
            } elseif (isset($_SERVER["HTTP_SOAPACTION"])) {
                $this->type = "SOAP";
            }
            if (isset($_SERVER["HTTPS"]) && ( $_SERVER["HTTPS"] == "on" || $_SERVER["HTTPS"] == 1) || isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https") {
                $this->protocol = "HTTPS";
                $this->blnsecure = true;
            } else {
                $this->protocol = "HTTP";
            }
        }
        $this->route();
    }
    public function escapetag($str) {
        $badWords = "/(<)|(>)/i";
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = $this->escapetag($val);
            }
        } else {
            $str = preg_replace($badWords, "", $str);
        }
        return $str;
    }
    public function route(){
        global $injectProtection,$respath;
        $req = $req2 = $req3 = "";
        $len = 0;
        $pval = $val = "";
        // convert url
        $req = explode("/",$this->uri);
        $len = count($req);
        if($len>1){
            $this->blnrooturi = false;
            $val = "";
            $a = 0;
            while ($a < $len - 1) {
                if($val!=""){
                    $val .= "-" . $req[$a];
                }else{
                    $val =  $req[$a]; 
                }
                $a++;
//            echo "lreq: " . req[0] . " val:". val . "<br>";
            }
        }
//            echo "req: " . req[0] . " val:". val . "<br>";

        if($this->blnrooturi){
            $req3 = explode("." , $req[$len - 1]);
            $req = $req3;
            $pval = $req[0]; 
//            echo "req: " . req[0] . " pval:". pval . "<br>";
            $this->uri = $this->uri ;
        }else{
            $req[0] = $val;
            $req[1] = $this->url_extension;
            $pval = $req[0];
            $this->uri = $val . $this->url_extension ;
        }
		
        $req2 = explode("-",$req[0]);
        if(count($req2)>1){
            $this->ctrl = $req2[0];
            if($req2[1]=="view"){
                $this->act = "view";
            }elseif($req2[1]=="delete"){
                $this->act = "delete";
            }else{
                $this->act = "evt";
                $this->sact = $this->getURLSafeRet($req2[1]);
            }
            $this->evtp = $this->getURLSafeRet(substr($pval, strlen($req2[0]) + strlen($req2[1]) + 2) );
        }else{
            $this->ctrl = $req2[0];
        }
		
        if(isset( $_REQUEST["ctrl"])){
            $this->ctrl = $_REQUEST["ctrl"];
        }elseif($this->ctrl==""){
            $this->ctrl = "index";
            $this->uri = "index" . $this->url_extension ;
        }
        if(! $this->blnrooturi && strpos($respath, "ttp:") === false){
            $respath = "/" . $respath ;
        }
    }


    public function getURLSafeRet($val) {
        $val = str_replace("_" . ord("-") . "_", "-", $val);
        $val = str_replace("_" . ord(".") . "_", ".", $val);
        return $val;
    }

    public function checkCache() {
        $htmldata = "";
        $val = array();
        $this->htmlfileName = "cache/" . $this->uri;
        // no need to include because it is already in start file
//        includeOnce("{phppath}/global/cachelist.php");
        $val = $this->isCurrentRequestCaching();
        if ($val[1] != "no") { 
            $this->blnCashExp = $this->isCacheExpired($val[0], $this->uri);
            $this->blnCash = true; // permission to cache file
        }
        if (count($_POST) > 0) { 
            $this->blnPost = true;
        }
        //echo $this->htmlfileName;
        if (!$this->blnPost && !$this->blnCashExp && $this->blnCash && file_exists($this->htmlfileName)) {
            $htmldata = file_get_contents($this->htmlfileName);
            //print "$this->htmlfileName read $min1";
            //print "rd err";
            return $htmldata;
        }else{ 
            $this->blnCashExp = true;
            return "";
        }


    }

    private function isCacheExpired($expTime, $filename, $blnAuto = false) {
        $min1 = 0;
        $blnC = false;
        if ($blnAuto || $this->uri == $filename) {
            if (file_exists($this->htmlfileName)) {
                $min1 = time() - filemtime($this->htmlfileName); 
            } else { 
                $min1 = 0;
            }
            if ($min1 >= $expTime) {
                $blnC = true; // ban to include old html file
                //print "recreate";
            }
            return $blnC;
        }
        return false;
    }

    private function isCurrentRequestCaching() {
        $val = array();
        if (isRegisterCacheItem($this->ctrl)) {
            $val = getCacheItem($this->ctrl);
        } elseif (isRegisterCacheItem($this->ctrl . "-" . $this->sact)) {
            $val = getCacheItem($this->ctrl . "-" . $this->sact);
        } elseif (isRegisterCacheItem($this->ctrl . "-" . $this->sact . "-" . $this->evtp)) {
            $val = getCacheItem($this->ctrl . "-" . $this->sact . "-" . $this->evtp);
        } elseif (isRegisterCacheItem("-" . $this->sact . "-")) {
            $val = getCacheItem("-" . $this->sact . "-");
        } else {
            return array(0, "no");

        }
        return $val;
    }

}

//end start.php

// start server code
//start interface lib function
function readGlobal($param){
    global $$param;
	if(isset($$param)){
		return $$param;
	}else{
		return "null";
	}
}
function writeGlobal($param,$val){
    global $$param;
    $$param = $val;
}
function includeOnce($filepath){
    extract($GLOBALS, EXTR_REFS);
    include_once($filepath);
}
function includeOnce2($filepath){
    extract($GLOBALS, EXTR_REFS);
    include($filepath);
}
function getGlobals(){
	return $GLOBALS;
}
//end interface lib function

/*
get Ready to execute
*/
class SphpBase{
	public static $engine = null;
	public static $sphp_router = null;
	public static $sphp_api = null;
	public static $sphp_request = null;
	public static $sphp_response = null;
	public static $sphp_session = null;
	public static $sphp_settings = null;
	public static $dbEngine = null;
	public static $JSServer = null;
	public static $JQuery = null;
	public static $page = null;
	public static $debug = null;
	public static $dynData = null;
	public static $apppath = "";
	
	public static function setReady($engine){
            self::$engine = $engine;
            self::$sphp_router = $engine->getRouter();
            self::$sphp_api = $engine->getSphpAPI();
            self::$sphp_settings = $engine->getSettings();
            self::$sphp_request = $engine->getRequest();
            self::$sphp_response = $engine->getResponse();
            self::$sphp_session = $engine->getSession();
            self::$dbEngine = $engine->getDBEngine();
            self::$JSServer = $engine->getJSServer();
            self::$JQuery = $engine->getJQuery();
            self::$page = $engine->SphpBase::page();
            self::$debug = $engine->getDebug();
		
	}
}
$etimestart1 = microtime(true);
if(!$blnPreLibCache){ 
if($blnPreLibLoad){
    include_once("{$phppath}/{$libversion}/libsphp1.php");
    //include_once("{$phppath}/{$libversion}/libsphp2.php");
}else{
    include_once("{$phppath}/{$libversion}/runtime/libloader.php");
}
}

include_once("{$phppath}/component/jquery.php");

// end file starengine.php

function setupsphpEngine(){
    extract($GLOBALS, EXTR_REFS);
    $etimestart1 = microtime(true);
    $stmycache = new stmycache();
    //run engine start
$engine = new Sphp\Engine();
$settings = $engine->getSettings();
//$settings->blnEditMode = $blnEditMode;
$settings->res_path = $respath;
$settings->php_path = $phppath;
$settings->jquery_path = $jquerypath;
$settings->comp_path = $comppath;
$settings->lib_path = $libpath;
$settings->lib_version = $libversion;
$settings->base_path = $basepath;
$settings->server_path = $serverpath;
$settings->use_session = $sphp_use_session;
$settings->session_name = $SESSION_NAME;
$settings->session_path = $SESSION_PATH;
$settings->serv_language = $serv_language;
$settings->debug_mode = $debugmode;
$settings->debug_profiler = $debugprofiler;
$settings->enable_log = $errorLog;
$settings->inject_protection = $injectProtection;
$settings->ddriver = $ddriver;
$settings->duser = $duser;
$settings->db = $db;
$settings->dpass = $dpass;
$settings->dhost = $dhost;
$settings->run_mode_not_extension = true;
$settings->run_hd_parser = $run_hd_parser;
$settings->blnPreLibLoad = $blnPreLibLoad;
$settings->blnStopResponse = $blnStopResponse;

//Sphp\Engine::registerRouter($srouter);

$engine->start();
// default variables
$sphp_router = $engine->getRouter();
$sphp_api = $engine->getSphpAPI();
$ctrl = $sphp_router;
// application path which is call with register Appgate automatically set by application
$appAppgate = $ctrl;
$sphp_request = $engine->getRequest();
$sphp_session = $engine->getSession();
$Client = $sphp_request;
$mysql = $engine->getDBEngine();
$dbEngine = $mysql;
$JSServer = $engine->getJSServer();
$JSClient = $JSServer;
$JQuery = $engine->getJQuery();
$page = $engine->SphpBase::page();
$debug = $engine->getDebug();
SphpBase::setReady($engine);
$HTMLParser = new Sphp\tools\HTMLParser();
$jq = new Sphp\kit\jq();
$sphpJsM = new SphpJsM();


}
function runSphpApp(){
extract($GLOBALS, EXTR_REFS);
//$debugprofiler = "{$phppath}/classes/base/debug/FirePHPCore/SPHP_Profiler2.php";
/*
$debugprofiler = "";
$jquerypath = "{$respath}/jslib/jquery/";
$comppath = "{$phppath}/component/";
$libpath = "{$phppath}/{$libversion}/";
$masterf = "{$phppath}/front/default/master.php";
$mobimasterf = "{$phppath}/front/default/mobimaster.php";
$admmasterf = "{$phppath}/front/default/admmaster.php";
$mebmasterf = "{$phppath}/front/default/admmaster.php";
$softmasterf = "{$phppath}/front/default/softmaster.php";
 * 
 */
$sphp_notglobalapp = $engine->executeinit();

if(!$sphp_notglobalapp[0]){
    //echo "app " .$sphp_notglobalapp[1];
    include($sphp_notglobalapp[1]);
    $engine->execute(true); 
}else{
    $engine->execute();
}
return SphpBase::engine()->getResponse();
  
	
}



    function mime_content_type2($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );
        $ad = explode('.',$filename);
        $ext = strtolower(array_pop($ad));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }



require 'vendor/autoload.php';
use React\Http;

$loop = React\EventLoop\Factory::create();

$server = new React\Http\Server(function (Psr\Http\Message\ServerRequestInterface $request) {

    $p1 = $request->getUri()->getPath();
    $ext1 = pathinfo($p1,PATHINFO_EXTENSION);
    //$ext1 = "hj";
    //$body = $ext1;
    if($ext1 == "html"){
    //file_put_contents("reqt.txt", json_encode($request));
    $_SERVER['HTTP_HOST'] = "127.0.0.1:8000";
    $_SERVER["REQUEST_URI"] = $request->getUri();
    $_SERVER["PHP_SELF"] = $_SERVER["REQUEST_URI"];
    $_SERVER["REQUEST_METHOD"] = $request->getMethod();
    $_SERVER["SCRIPT_NAME"] =  getcwd(). "/start.php";
    $_SERVER["SCRIPT_FILENAME"] = $_SERVER["SCRIPT_NAME"];
    setupsphpEngine();
    $resp = runSphpApp();
    $header1 = array();
        if(count($resp->getHeader()) < 1){
            $resp->addHttpHeader("Content-Type: text/html");
        }
        foreach ($resp->getHeader() as $key => $value) { 
            $a = explode(':',$value[0]);
            $header1[$a[0]] = $a[1];
        }

        

    //$body = "The requested path is: " . $request->getUri()->getPath();
    return new React\Http\Response(
        200,
        $header1,
        $resp->getContent() 
        //$body
    );
    }else{
    return new React\Http\Response(
        200,
        array(
            'Content-Type' => mime_content_type2("." . $p1)
            //'Content-Type' => 'text/html'
        ),
 file_get_contents("." . $p1)
            //"hello " . $p1
    );
        
    }
    
     
  
});

$socket = new React\Socket\Server('127.0.0.1:8000', $loop);
$server->listen($socket);

$loop->run();



