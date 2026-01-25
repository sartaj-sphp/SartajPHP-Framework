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
/**
* Cache a request URL if it doesn't need processing.
* SphpBase::sphp_api()->addCacheList("index",100)
* Cache index application with all events and refersh interval is 100 seconds. Cache will update the index app with
* interval of 100 seconds.
* @param string $url match for cache like cache "index" or "index-page"
* @param int $sec Expiry Time in seconds -1 mean never expire
* @param string $type <p>
* type = Default Appgate mean url has Appgate name only and response to all events basis on this Appgate
* type = ce mean Appgate-event cache only that event
* type = cep mean Appgate-event-evtp cache only that event with that parameter
* type = e event on any application will be use cache
* Cache all index app responses for 1 hour
*  addCacheList("index", 3600);
*
*  Cache specific Appgate + event
*  addCacheList("blog-view", 1800, "ce");
*
*  Cache with Appgate + event + event parameter
*  addCacheList("shop-product-shirt", 3600, "cep");
*
*  Cache only match event from any Appgate and with any event parameter
*  addCacheList("info", 3600, "e");
*
* </p>
*/
function addCacheList($url, $sec = 0, $type = "Appgate") {}
/**
* Check if URL register with cache list
* @param string $url
* @return boolean
*/
function isRegisterCacheItem($url) {}
/**
* Read Cache Item from Cache List
* @param string $url
* @return array
*/
function getCacheItem($url) {}
/**
* Invalidate Cache Item
* @param string $url
*/
function clearCacheItem($url) {}
/** isPharApp()
* Check if application run as Phar app.
* @return boolean
*/
function isPharApp() {}
include_once("{$phppath}/Score/global/global.php");
$response_method = "NORMAL";
if (defined("PHARAPPW")) {
$basepath = "";
$respath = str_replace("..", "../..", $respath);
}
define("NEWLINE", "\n");
define("RLINE", "\r");
define("TABCHAR", "\t");
/**
* Read Global variable
* @param string $param
* @return mixed
*/
function readGlobal($param) {}
/**
* Write Global variable
* @param string $param
* @param object $val
*/
function writeGlobal($param, $val) {}
/**
* include with all global variables in close environment like include in function.
* @param string $filepath
*/
function includeOnce($filepath) {}
/**
* Experimental don't use. 
* include with all global variables in close environment like include in function.
* when sphp_mannually_start_engine defined then it use include otherwise it use include_once
* @param string $filepath
*/
function includeOnce2($filepath) {}
/**
* Get $GLOBALS PHP Variable
* @return array
*/
function getGlobals() {}
/**
* Encrypt String 
* @param string $strdata
* @param string $key Optional Default=sbrtyu837
* @return string
*/
function encryptme($strdata, $key = "sartajphp211") {}
/**
* 
* @param string $strdata
* @param string $key
* @return string
*/
function decryptme($strdata, $key = "sartajphp211") {}
/**
* Convert to secure Value.
* @param string $val
* @param string $key secure key
* @return string
*/
function val2Secure($val, $key = "sartajphp211"){}
/**
* Return true if value is secure with val2secure function
* @param string $sval
*/
function isSecureVal($sval){}
/**
* Restore Secure Value to back.
* @param string $val
* @param string $key secure key
* @return string
*/
function secure2Val($sval, $key = "sartajphp211"){}
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
public $mode = "SERVER"; 
public $protocol = "";
public $blnsecure = false;
public $uri = "";
public $scriptpath = "";
public $argv = array();
public $type = "NORMAL"; 
public $isNativeClient = false;
public $edtmode = false;
public $edtctrl = "";
public $ytetimestart1 = 0;
public $ytetimestart2 = 0;
public function ytetilm(){}
public function findbdataToStr($str1) {}
public function getPostFormData($data) {}
public function escapetag($str) {}
public function route() {}
public function getURLSafeRet($val) {}
public function checkCache($postdata) {}
}
function startSartajPHPEngine() {}
