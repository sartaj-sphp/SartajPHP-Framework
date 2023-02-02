<?php
// cache time in sec
$mintime = "0";
$midtime = "0";
$maxtime = "0";
// use ms
$ajaxready_max = 300;
if(!isset($_SERVER['HTTP_HOST']) || strpos(" " . $_SERVER['HTTP_HOST'], "localhost") !== false) define("autocompkey","FD45A279GH");
$defenckey = "aHmlP1";
date_default_timezone_set("America/New_York");
// set session state, if false you can not login
$sphp_use_session = true;
// single session app
$sphp_use_session_storage = false;
// convert session to cookie
$sphp_use_session_cookie = false;

$sphp_app_cmd = false;
// Default Language
$serv_language = "ENGLISH"; 
// debug mode 0,1,2
$debugmode = 0;
$debugprofiler = "";
//$debugprofiler = "{$phppath}/classes/base/debug/SPHP_Profiler3.php";
$errorLog = true;
$sphpRunasLib = false;
$run_hd_parser = false; // not working under process
$translatermode = false;
$blnEditMode = true;
// true mean use of php preload in ini
//opcache.preload=D:/www/res/Sphp/preload_lib.php
//opcache.preload_user=www-data
$blnPreLibCache = false;
// if true load libsphp1.php file
$blnPreLibLoad = true;
$blnStopResponse = false;

if(strpos($slibversion,".phar") !== false){
    $slibpath = "phar://{$phppath}/{$slibversion}";
    $jslibpath = "{$respath}/jslib_lib.phar";
}else{
    $slibpath = "{$phppath}/{$slibversion}";
    $jslibpath = "{$respath}/jslib";
}
$libpath = "{$phppath}/Score/$libversion";
$jquerypath = "{$jslibpath}/jquery";
$comppath = "{$phppath}/controls";
$slibrespath = "{$respath}/{$slibversion}";

$db_engine_path = $libpath . "/lib/MySQL.php,\\MySQL";
$ddriver = "";
$duser = "root";
$db = "dbplugin";
$dpass = "";
$dhost = "localhost:3306";

$jsProtection = false;

$masterf = "{$slibpath}/temp/default/master.php";
$mobimasterf = "{$slibpath}/temp/default/mobimaster.php";
$admmasterf = "{$slibpath}/temp/default/admmaster.php";
$mebmasterf = "{$slibpath}/temp/default/master.php";
$softmasterf = "{$slibpath}/temp/default/softmaster.php";

if (filter_input(INPUT_SERVER, "HTTP_HOST", FILTER_FLAG_EMPTY_STRING_NULL)) {
    if (isset($_SERVER["HTTPS"]) && ( $_SERVER["HTTPS"] == "on" || $_SERVER["HTTPS"] == 1)){
        $basepath = "https://".$_SERVER['HTTP_HOST'];
    }else{
        $basepath = "http://".$_SERVER['HTTP_HOST'];    
    }
} else {
    $basepath = "";
}
$serverpath = $_SERVER['DOCUMENT_ROOT'];
$SESSION_NAME = 'SPHPID';
$SESSION_PATH = '';
// admin login user
$admuser = 'admin';
$admpass = '1234';

include_once(PROJ_PATH . "/plugin/ccachelist.php");
include PROJ_PATH . '/comp.php';
