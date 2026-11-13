<?php
/**
* Global bootstrap file for the Sphp engine.
*
* Defines core path constants (START_PATH, PROJ_PATH), response mode,
* newline/tab constants, and provides global helper functions for:
*  - URL request caching (addCacheList, isRegisterCacheItem, getCacheItem, clearCacheItem)
*  - Global variable access (readGlobal, writeGlobal, getGlobals)
*  - File inclusion helpers (includeOnce, includeOnce2, includeMasterFile)
*  - String encryption / secure value helpers (encryptme, decryptme, val2Secure, isSecureVal, secure2Val)
*
* Also declares the stmycache class which parses the incoming request
* (CLI or web server), routes the URL into gate/event/event-parameter
* parts, and checks the response cache.
*
* Finally it provides startSartajPhpEngine() which instantiates the
* request cache object and starts the Sphp engine.
*/
$ytetimestart1 = microtime(true);
/**
* Resolve a path to an absolute path with forward slashes.
*
* @param string $path The path to resolve.
* @return string|false The normalized absolute path, or false if realpath fails.
*/
function safeRealpath(string $path): string|false {}
if (!defined("START_PATH")) {
define("START_PATH", safeRealpath(getcwd()));
}
if (defined("PHARAPP")) {
define("PROJ_PATH", safeRealpath(PHARAPP));
} else {
define("PROJ_PATH", safeRealpath(START_PATH));
}
$cacheFileList = array();
/**
* Cache a request URL if it doesn't need processing.
* SphpBase::sphpApi()->addCacheList("index",100)
* Cache index Gate with all events and refersh interval is 100 seconds. Cache will update the index Gate with
* interval of 100 seconds.
* @param string $url match for cache like cache "index" or "index-page"
* @param int $sec Expiry Time in seconds -1 mean never expire
* @param string $type <p>
* type = Default Gate mean url has Gate name only and response to all events basis on this Gate
* type = ce mean Gate-event cache only that event
* type = cep mean Gate-event-evtp cache only that event with that parameter
* type = e event on any Gate will be use cache
* Cache all index Gate responses for 1 hour
*  addCacheList("index", 3600);
*
*  Cache specific Gate + event
*  addCacheList("blog-view", 1800, "ce");
*
*  Cache with Gate + event + event parameter
*  addCacheList("shop-product-shirt", 3600, "cep");
*
*  Cache only match event from any Gate and with any event parameter
*  addCacheList("info", 3600, "e");
*
* </p>
* @return void
*/
function addCacheList($url, $sec = 0, $type = "Gate") {}
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
* @return void
*/
function clearCacheItem($url) {}
/** isPharApp()
* Check if Gate run as Phar Gate.
* @return boolean
*/
function isPharApp() {}
include_once(__DIR__ . "/../../global/global.php");
$responseMethod = "NORMAL";
if (defined("PHARAPPW")) {
$projectUrl = "";
$resourceUrl = str_replace("..", "../..", $resourceUrl);
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
* @return void
*/
function writeGlobal($param, $val) {}
/**
* include with all global variables in close environment like include in function.
* @param string $filepath
* @return void
*/
function includeOnce($filepath) {}
/**
* Experimental don't use. 
* include with all global variables in close environment like include in function.
* when SPHP_MANUALLY_START_ENGINE defined then it use include otherwise it use include_once
* @param string $filepath
* @return void
*/
function includeOnce2($filepath) {}
/**
* Include a master file (.mast.php) with all global variables available.
* Throws an exception if the file is not a master file.
* @param string $filepath
* @return void
*/
function includeMasterFile($filepath) {}
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
* Decrypt a string encrypted with encryptme().
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
* @return boolean
*/
function isSecureVal($sval){}
/**
* Restore Secure Value to back.
* @param string $val
* @param string $key secure key
* @return string
*/
function secure2Val($sval, $key = "sartajphp211"){}
/**
* Request cache object.
*
* Parses the incoming request (CLI or web server), splits the URL into
* gate / event / event-parameter parts, and checks whether a cached
* response exists for the current request.
*/
class stmycache {
public $urlExtension = ".html";
public $act = "evt"; 
public $sact = "";
public $evtp = "";
public $gate = "";
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
public $scriptPath = "";
public $argv = array();
public $type = "NORMAL"; 
public $isNativeClient = false;
public $edtmode = false;
public $edtctrl = "";
public $ytetimestart1 = 0;
public $ytetimestart2 = 0;
/**
* Parse Request
*
* Detects whether PHP runs on the command line or a web server,
* fills request data (argv, $_REQUEST, $_SERVER, $_COOKIE, etc.),
* and routes the URL into gate/event/event-parameter parts.
*/
/**
* Record the current time into the second timer.
* @return void
*/
public function ytetilm(){}
/**
* Convert a hex-encoded bdata string into request data.
* Handles both multipart form data and simple key=value pairs.
* @param string $str1 hex-encoded bdata string
* @return void
*/
public function findbdataToStr($str1) {}
/**
* Parse a single multipart form-data part and store it in $_REQUEST / $_POST.
* @param string $data the form-data part
* @return void
*/
public function getPostFormData($data) {}
/**
* Remove HTML tags (< and >) from a string or array of strings.
* @param string|array $str
* @return string|array
*/
public function escapetag($str) {}
/**
* Route the request URI into gate / event / event-parameter parts.
* @return void
*/
public function route() {}
/**
* Restore URL-safe encoded characters and urldecode the value.
* @param string $val
* @return string
*/
public function getUrlSafeRet($val) {}
/**
* Check the response cache for the current request.
* Returns the cached HTML content if a valid cache exists, otherwise "".
* @param array $postdata POST data of the request
* @return string cached HTML content or empty string
*/
public function checkCache($postdata) {}
/**
* Check if the cached file for the given filename is expired.
* @param int $expTime expiry time in seconds
* @param string $filename
* @param bool $blnAuto
* @return boolean true if the cache is expired (ban to include old html file)
*/
/**
* Check if the current request is registered in the cache list.
* @return array [expiry seconds, type] or [0, "no"] if not registered
*/
}
/**
* Start the Sphp engine.
*
* Instantiates the stmycache request object, checks the response cache,
* and if no cached response is found, includes startEngine.php and runs
* the engine.
* @return string engine result or empty string
*/
function startSartajPhpEngine() {}
