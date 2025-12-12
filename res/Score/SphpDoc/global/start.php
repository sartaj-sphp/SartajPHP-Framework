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
/** addCacheList($url, $sec = 0, $type = "controller")
* add controller path into cache list.
* @param String $url <p>
* add url into cache list
* </p>
* @param Int $sec Optional <p>
* time in seconds
* </p>
* @param String $type Optional <p>
* type = controller mean url has controller name only and response to all events basis on this controller.
* type = ce mean controller-event cache only that event.
* type = cep mean controller-event-evtp cache only that event with that parameter.
* type = e event on any application will be cash.
* </p>
* @link https://sartajphp.com/api4-fun.html?addCacheList
* @return void
*/
function addCacheList($url, $sec = 0, $type = "controller") {}
/** isPharApp()
* Check if application run as Phar app.
* @return boolean
*/
function isPharApp() {}
/**
* 
* @param string $url
* @return boolean
*/
function isRegisterCacheItem($url) {}
function getCacheItem($url) {}
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
* 
* @param string $strdata
* @param string $key
* @return string
*/
function decryptme($strdata, $key = "sartajphp211") {}
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
public function findbdataToStr($str1) {}
public function getPostFormData($data) {}
public function escapetag($str) {}
public function route() {}
public function getURLSafeRet($val) {}
public function checkCache($postdata) {}
}
function startSartajPHPEngine() {}
