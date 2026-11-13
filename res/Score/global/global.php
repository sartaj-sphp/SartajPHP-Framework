<?php
if(!isset($_SERVER['HTTP_HOST']) || strpos(" " . $_SERVER['HTTP_HOST'], "localhost") !== false) define("autocompkey","FD45A279GH");
if(strpos($slibVersion,".phar") !== false){
    $slibPath = "phar://{$resourcePath}/{$slibVersion}";
}else{
    $slibPath = "{$resourcePath}/{$slibVersion}";
}
$jsLibUrl = "{$resourceUrl}/jslib";
$libPath = "{$resourcePath}/Score/$libVersion";
$compPath = "{$resourcePath}/components";
$slibUrl = "{$resourceUrl}/{$slibVersion}";

// Global Framework Settings
// ------------------------------
// default cache time in sec
$cacheTime = "100";

// Component UI Kit inside Components folder default is uikitdef/bootstrap folder
$uiKitLocation = "/uikitdef/bootstrap"; // Bootstrap

//default company info
$cmpId = "demo";
$cmpName = "Demo";
$cmpEmail = "info@domain.com";
$cmpAddress1 = "Address1 Lane1";
$cmpAddress2 = "Address2 ON Canada";
$cmpPhone1 = "+1000-111-0000";
$cmpPhone2 = "+1000-000-1111";
// for google login, set in comp.php file
$googleOauthClientSecret = "";

// use ms
$ajaxReadyMax = 50;
// 2= defer, 1= async, 0=nop
$defaultFilelinkLoad = 2;
// default security key
$defenceKey = "aHmlP1";
date_default_timezone_set("America/New_York");
// use session state, if false you can not login
$sphpUseSession = true;
// single session app
$sphpUseSessionStorage = false;
// convert session to cookie
$sphpUseSessionCookie = false;
// session settings
$sessionName = 'SPHPID';
$sessionPath = '';
/**
 * db for Database Handler and Redis Server URL for Reds session handler.
 * By Default it will use PHP Settings and no over write
 */
$sessionHandler = '';

// if true it will bypass html cache engine
$sphpAppCmd = false;
// Default Language
$serverLanguage = "ENGLISH"; 
// debug mode 0,1,2,3
$debugMode = 0;
$debugProfiler = "";
//$debugProfiler = "{$resourcePath}/classes/base/debug/SPHP_Profiler3.php";
$errorLog = true;

/* run Framework as Lib so it will be not load any Gate Automatically
 * Run SartajPhp inside other PHP Frameworks.
 */
$sphpRunasLib = false;
$runHdParser = false; // not working under process, remove in future
$translaterMode = false;
$blnEditMode = false; // remove in future only testing purpose
// true mean use of php preload in ini
//opcache.preload=D:/www/res/Sphp/preload_lib.php
//opcache.preload_user=www-data
$blnPreLibCache = false;
// if true load libsphp1.php file
$blnPreLibLoad = false;
// stop output buffering
$blnStopResponse = false;

//$dbEnginePath = $libPath . "/lib/MySQL.php,\\MySQL";
// dbEngine object doc = vendor/sartajphp/sartajphp/res/Score/SphpDoc/Sphp/Lib/MySqliPdo.php
$dbEnginePath = $libPath . "/Sphp/Lib/MySqliPdo.php,\\Sphp\\Lib\\MySqliPdo";
$dbDriver = "";
$dbUser = "root";
$db = "dbplugin";
$dbPass = "";
$dbHost = "localhost:3306";

// admin login user
$adminUser = 'admin';
$adminPass = '1234';

//app mail settings
$mailServer = "mail.domain.com";
$mailUser = "info@domain.com";
$mailPass = "";
$mailPort = "26";

$jsProtection = false;

$masterf = "{$compPath}{$uiKitLocation}/masters/default/master.mast.php";
//$mobimasterf = "{$slibPath}/masters/default/mobimaster.mast.php";
$admmasterf = $masterf;
$mebmasterf = $masterf;
//$softmasterf = "{$slibPath}/masters/default/softmaster.mast.php";

// ------------------------------
// Global Framework Settings End

if (filter_input(INPUT_SERVER, "HTTP_HOST", FILTER_FLAG_EMPTY_STRING_NULL)) {
    if (isset($_SERVER["HTTPS"]) && ( $_SERVER["HTTPS"] == "on" || $_SERVER["HTTPS"] == 1)){
        $projectUrl = "https://".$_SERVER['HTTP_HOST'];
    }else{
        $projectUrl = "http://".$_SERVER['HTTP_HOST'];    
    }
} else {
    $projectUrl = "";
}
$serverPath = $_SERVER['DOCUMENT_ROOT'];

include_once(PROJ_PATH . "/plugin/ccachelist.php");
include_once(PROJ_PATH . "/cachelist.php");
include_once(PROJ_PATH . '/comp.php');
// just interface function remove when need in comp.php file
function getPluginDb(){}
function getSpDb(){}
