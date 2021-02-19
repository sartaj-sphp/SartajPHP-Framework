<?php
// cache time in sec
$mintime = "0";
$midtime = "0";
$maxtime = "0";
$defenckey = "aHmlP1";
date_default_timezone_set("America/New_York");
// set session state, if false you can not login
$sphp_use_session = true;
$sphp_use_session_storage = false;

$sphp_app_cmd = false;
// Default Language
$serv_language = "ENGLISH"; 
// debug mode
$debugmode = false;
//$debugprofiler = "{$phppath}classes/base/debug/FirePHPCore/SPHP_Profiler2.php";
$debugprofiler = "{$phppath}classes/base/debug/SPHP_Profiler3.php";
$errorLog = true;
$sphpRunasLib = false;
$run_hd_parser = false;
$translatermode = false;
$blnPreLibLoad = false;
$blnPreLibCache = false;
$blnStopResponse = false;

$jquerypath = "{$respath}jslib/jquery/";
$comppath = "{$phppath}controls/";
$libpath = "{$phppath}{$libversion}/";

$db_engine_path = $libpath . "kit/MySQL.php,\\DbEngine";
$ddriver = "";
$duser = "root";
$db = "dbplugin";
$dpass = "";
$dhost = "localhost";

$injectProtection = true;

$masterf = "{$phppath}temp/default/master.php";
$mobimasterf = "{$phppath}temp/default/mobimaster.php";
$admmasterf = "{$phppath}temp/default/admmaster.php";
$mebmasterf = "{$phppath}temp/default/admmaster.php";
$softmasterf = "{$phppath}temp/default/softmaster.php";

if (filter_input(INPUT_SERVER, "HTTP_HOST", FILTER_FLAG_EMPTY_STRING_NULL)) {
    if (isset($_SERVER["HTTPS"]) && ( $_SERVER["HTTPS"] == "on" || $_SERVER["HTTPS"] == 1)){
        $basepath = "https://".$_SERVER['HTTP_HOST']."/";
    }else{
        $basepath = "http://".$_SERVER['HTTP_HOST']."/";    
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

include 'comp.php';
