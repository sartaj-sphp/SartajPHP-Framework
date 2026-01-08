<?php

$ytetimestart1 = microtime(true);
if (!defined("start_path")) {
    define("start_path", getcwd());
}
if (defined("PHARAPP")) {
    define("PROJ_PATH", PHARAPP);
} else {
    define("PROJ_PATH", start_path);
}

$cacheFileList = array();

/** addCacheList($url, $sec = 0, $type = "Appgate")
 * add Appgate path into cache list.
 * @param String $url <p>
 * add url into cache list
 * </p>
 * @param Int $sec Optional <p>
 * time in seconds
 * </p>
 * @param String $type Optional <p>
 * type = Appgate mean url has Appgate name only and response to all events basis on this Appgate.
 * type = ce mean Appgate-event cache only that event.
 * type = cep mean Appgate-event-evtp cache only that event with that parameter.
 * type = e event on any application will be cash.
 * </p>
 * @link https://sartajphp.com/api4-fun.html?addCacheList
 * @return void
 */
function addCacheList($url, $sec = 0, $type = "Appgate") {
    global $cacheFileList;
    $md5url = md5($url);
    $cacheFileList[$md5url] = array($sec, $type);
}

/** isPharApp()
 * Check if application run as Phar app.
 * @return boolean
 */
function isPharApp() {
    if (defined("PHARAPP")) {
        return true;
    } else {
        return false;
    }
}

/**
 * 
 * @param string $url
 * @return boolean
 */
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
include_once("{$phppath}/Score/global/global.php");
//response mode
$response_method = "NORMAL";
if (defined("PHARAPPW")) {
    $basepath = "";
    $respath = str_replace("..", "../..", $respath);
}
//$stmycache->ytetimestart2 = microtime(true);
// Load Global Settings and functions 
// global constant
define("NEWLINE", "\n");
define("RLINE", "\r");
define("TABCHAR", "\t");

//start interface lib function
/**
 * Read Global variable
 * @param string $param
 * @return mixed
 */
function readGlobal($param) {
    global $$param;
    if (isset($$param)) {
        return $$param;
    } else {
        return "null";
    }
}

/**
 * Write Global variable
 * @param string $param
 * @param object $val
 */
function writeGlobal($param, $val) {
    global $$param;
    $$param = $val;
}

/**
 * include with all global variables in close environment like include in function.
 * @param string $filepath
 */
function includeOnce($filepath) {
    extract($GLOBALS, EXTR_REFS);
    if (!file_exists($filepath)) {
        throw new Exception("File not found: " . $filepath);
    }
    include_once($filepath);
}

/**
 * Experimental don't use. 
 * include with all global variables in close environment like include in function.
 * when sphp_mannually_start_engine defined then it use include otherwise it use include_once
 * @param string $filepath
 */
function includeOnce2($filepath) {
    extract($GLOBALS, EXTR_REFS);
    if (!defined("sphp_mannually_start_engine")) {
        include_once($filepath);
    } else {
        include($filepath);
    }
}

/**
 * Get $GLOBALS PHP Variable
 * @return array
 */
function getGlobals() {
    return $GLOBALS;
}
/**
 * 
 * @param string $strdata
 * @param string $key
 * @return string
 */
function decryptme($strdata, $key = "sartajphp211") {
    $result = "";
    //$strdata = base64_decode($strdata);
    if(strlen($strdata) % 2 == 0){
    $c = 0;
    for ($i = 0; $i < strlen($strdata); $i += 2) {
        $hex = substr($strdata, $i, 2);
        $keychar = substr($key, ($c % strlen($key)) - 1, 1);
        $chara = chr(hexdec($hex) - ord($keychar));
        $result .= $chara;
        $c += 1;
    }
    }
    return $result;
}

//end interface lib function

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
    public $isNativeClient = false;
    public $edtmode = false;
    public $edtctrl = "";
    //timer
    public $ytetimestart1 = 0;
    public $ytetimestart2 = 0;

    // Parse Request
    public function __construct() {
        global $argv, $argvm, $response_method, $sphp_use_session, $sphp_use_session_storage, $sphp_use_session_cookie, $basepath, $serverpath, $ytetimestart1;
        $qpos = 0;
        $scriptPath = $sp = "";
        $this->ytetimestart1 = $ytetimestart1;
        $this->ytetimestart2 = microtime(true);

        // check if php is running on command line or not
        if (!isset($_SERVER["SERVER_SOFTWARE"]) && (php_sapi_name() == "cli" || (is_numeric($_SERVER["argc"]) && $_SERVER["argc"] > 0))) {
            $this->mode = "CLI";
            $value = "";
            $next = 0;
            if(!isset($_SESSION)){
                $_SESSION = array();
            }
            $_SERVER['HTTP_HOST'] = 'sphp';
            $_SERVER['REQUEST_URI'] = '/';
            // these settings control by comp.php
            //$sphp_use_session = false; same session.savepath() and so session can share by cli and apache2
            //$sphp_use_session_storage = true;
            //$sphp_use_session_cookie = true;
            if (isset($argvm)) {
                $this->argv = $argvm;
            } else {
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
            }

            $this->method = "COMMAND";
            // fill argv from environment var
            $idata = getenv("idata"); 
            if($idata !== false){putenv('idata'); unset($_SERVER["idata"]); $this->argv["--idata"] = $idata;}
            $idata = getenv("cdata");
            if($idata !== false){putenv('cdata'); unset($_SERVER["cdata"]); $this->argv["--cdata"] = $idata;}
            $idata = getenv("bcookies");
            if($idata !== false){putenv('bcookies'); unset($_SERVER["bcookies"]); $this->argv["--bcookies"] = $idata;}
            $idata = "";
            
            if (isset($this->argv["--data"]) && $this->argv["--data"] != "") {
                $_REQUEST["data"] = $this->argv["--data"];
            }
            if (isset($this->argv["--idata"]) && $this->argv["--idata"] != "") {
                $_REQUEST["idata"] = hex2bin($this->argv["--idata"]);
                $arhed = json_decode($_REQUEST["idata"], true);
                $this->method = $arhed["Method"];
                $arurl = explode("?", $arhed["URL"], 2); 
                if (count($arurl) > 1) {
                    parse_str($arurl[1], $arurl2);
                    foreach ($arurl2 as $key => $value) {
                        $_REQUEST[$key] = urldecode($value);
                        $_GET[$key] = $_REQUEST[$key];
                    }
                }
                // $arhed["Header"] not in use
                // process server variables
                if (isset($arhed["Server"])) {
                    // caller need data in wrapper json object + header + sessions
                    $response_method = "HEX";
                    //$sphp_use_session_cookie = true;
                    foreach ($arhed["Server"] as $keysp1 => $valuesp1) {
                        $_SERVER[$keysp1] = $valuesp1;
                    }
                    if ((isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest") || isset($_REQUEST["sphpajax"])) {
                        $this->type = "AJAX";
                    } elseif (isset($_SERVER["HTTP_SOAPACTION"])) {
                        $this->type = "SOAP";
                    }
                }
            }
            //old method may be not use later
            if (isset($this->argv["--bdata"]) && $this->argv["--bdata"] != "") {
                //$_REQUEST["bdata"] = $this->argv["--bdata"];
                $this->findbdataToStr($this->argv["--bdata"]);
            }
            if (isset($this->argv["--cdata"]) && $this->argv["--cdata"] != "") {
                $_REQUEST["cdata"] = hex2bin($this->argv["--cdata"]);
                $arhed = json_decode($_REQUEST["cdata"], true);
                if (isset($arhed["--edtmode"])) {
                    $this->edtmode = true;
                    if (isset($arhed["--edtctrl"])) $this->edtctrl = $arhed["--edtctrl"]; 
                }
                if (isset($arhed["sargv"])) {
                    $_REQUEST["sargv"] = $arhed["sargv"];
                }
                if (isset($arhed["postdata"])) {
                    foreach ($arhed["postdata"] as $keysp1 => $valuesp1) {
                        if (is_string($valuesp1)) {
                            //$_REQUEST[$keysp1] = urldecode($valuesp1);
                            $_REQUEST[$keysp1] = $valuesp1;
                        } else {
                            $_REQUEST[$keysp1] = $valuesp1;
                        }
                        $_POST[$keysp1] = $_REQUEST[$keysp1];
                    }
                }
            }
            if (isset($this->argv["--bcookies"]) && $this->argv["--bcookies"] != "") {
                $arhed = json_decode(hex2bin($this->argv["--bcookies"]), true);
                foreach ($arhed as $keycok => $valuecok) {
                    $_COOKIE[$keycok] = $valuecok;
                }
            }
            if (isset($this->argv["--droot"]) && $this->argv["--droot"] != "") {
                $this->isNativeClient = true;
                $_SERVER['DOCUMENT_ROOT'] = $this->argv["--droot"];
                $serverpath = $_SERVER['DOCUMENT_ROOT'];
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

            //$_SERVER["REQUEST_URI"] =  $this->uri;
            //$_SERVER["PHP_SELF"] = "";

        } else { // end of cli
            /**
             * Checks whether request has been made using ajax
             */
            $this->uri = $_SERVER["REQUEST_URI"];
            $qpos = strpos($this->uri, "?");
            $this->uri = urldecode($_SERVER["REQUEST_URI"]);
            $this->uri = $this->escapetag($this->uri);
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
            if ((isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest") || isset($_REQUEST["sphpajax"])) {
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

    public function findbdataToStr($str1) {
        $str1 = hex2bin($str1);
        $_REQUEST["bdata"] = urldecode($str1);
        $strAr1 = explode("Content-Disposition:", $str1);
        $str2 = "";
        if (count($strAr1) > 1) {
            foreach ($strAr1 as $index => $val) {
                if (strpos($val, "form-data;") !== false) {
                    $this->getPostFormData($val);
                }
            }
        } else {
            $strAr1 = explode("&", $str1);
            foreach ($strAr1 as $index => $val) {
                if (strpos($val, "=") !== false) {
                    $ar1 = explode("=", $val, 2);
                    $_REQUEST[$ar1[0]] = urldecode($ar1[1]);
                    $_POST[$ar1[0]] = $ar1[1];
                }
            }
        }
    }

    public function getPostFormData($data) {
        $endpoint = strpos($data, "------WebKit");
        if ($endpoint !== false) {
            $str2 = substr($data, 11, $endpoint - 11);
            $str2 = str_replace("\r", "", $str2);
            $str2 = str_replace("\n", "(nsphp)", $str2);
            $strAr2 = explode("(nsphp)", $str2);
            $aname = substr($strAr2[0], 7, strlen($strAr2[0]) - 8);
            $_REQUEST[$aname] = urldecode($strAr2[2]);
            $_POST[$aname] = $strAr2[2];
        }
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

    public function route() {
        global $respath,$defenckey;
        $req = $req2 = $req3 = "";
        $len = 0;
        $pval = $val = "";
        // convert url
        $req = explode("/", $this->uri);
        $len = count($req);
        if ($len > 1) {
            $this->blnrooturi = false;
            $val = "";
            $a = 0;
            while ($a < $len - 1) {
                if ($val != "") {
                    $val .= "-" . $req[$a];
                } else {
                    $val = $req[$a];
                }
                $a++;
//            echo "lreq: " . req[0] . " val:". val . "<br>";
            }
        }
//            echo "req: " . req[0] . " val:". val . "<br>";

        if ($this->blnrooturi) {
            $req3 = explode(".", $req[$len - 1]);
            $req = $req3;
            $pval = $req[0];
//            echo "req: " . req[0] . " pval:". pval . "<br>";
            $this->uri = $this->uri;
        } else {
            $req[0] = $val;
            $req[1] = $this->url_extension;
            $pval = $req[0];
            $this->uri = $val . $this->url_extension;
        }

        $req2 = explode("-", $req[0]);
        if (count($req2) > 1) {
            $this->ctrl = $req2[0];
            if ($req2[1] == "view") {
                $this->act = "view";
            } elseif ($req2[1] == "delete") {
                $this->act = "delete";
            } else {
                $this->act = "evt";
                $this->sact = $this->getURLSafeRet($req2[1]);
            }
            $this->evtp = $this->getURLSafeRet(substr($pval, strlen($req2[0]) + strlen($req2[1]) + 2));
            if(substr($this->evtp,0,2) == "a@"){
                $this->evtp = decryptme(substr($this->evtp,2), $defenckey);
                $this->evtp = str_replace('a8b1]' ,'', $this->evtp);
            }
        } else {
            $this->ctrl = $req2[0];
        }

        if (isset($_REQUEST["ctrl"])) {
            $this->ctrl = $_REQUEST["ctrl"];
        } elseif ($this->ctrl == "") {
            $this->ctrl = "index";
            $this->uri = "index" . $this->url_extension;
        }
        if (!$this->blnrooturi && strpos($respath, "ttp:") === false) {
            $respath = "/" . $respath;
        }
    }

    public function getURLSafeRet($val) {
        $val = str_replace("_" . ord("-") . "_", "-", $val);
        $val = str_replace("_" . ord(".") . "_", ".", $val);
        return urldecode($val);
    }

    public function checkCache($postdata) {
        $htmldata = "";
        $val = array();
        $this->htmlfileName = PROJ_PATH . "/cache/" . $this->uri;
        // no need to include because it is already in start file
//        includeOnce("{phppath}/global/cachelist.php");
        $val = $this->isCurrentRequestCaching();
        if ($val[1] != "no") {
            $this->blnCashExp = $this->isCacheExpired($val[0], $this->uri);
            $this->blnCash = true; // permission to cache file
        }
        if (count($postdata) > 0) {
            $this->blnPost = true;
        }
        //echo $this->htmlfileName;
        if (!$this->blnPost && !$this->blnCashExp && $this->blnCash && file_exists($this->htmlfileName)) {
            $htmldata = file_get_contents($this->htmlfileName);
            //print "$this->htmlfileName read $min1";
            //print "rd err";
            return $htmldata;
        } else {
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

function startSartajPHPEngine() {
    extract($GLOBALS, EXTR_REFS);
    global $stmycache,$sphp_app_cmd,$sphp_use_session;
//$stmycache = null;
    $stmycache = new stmycache();
    $blnrunapp = false;
// this section can be blocked by server module
    if (!defined("sphp_mannually_start_engine")) {

        if (!$sphp_app_cmd) { 
            $outp = $stmycache->checkCache($_POST);
            if ($outp != "") {
                echo $outp;
            } else {
                $blnrunapp = true;
            }
        } else {
            //$sphp_use_session = false;
            $blnrunapp = true;
        }
    } else { 
        //$sphp_use_session = false;
        //$sphp_use_session_storage = true;
        $blnrunapp = true;
    }
    
    if($blnrunapp){
        include_once(__DIR__ . "/startEngine.php");
        return runSartajPHPEngine();        
    }
    return "";
}
