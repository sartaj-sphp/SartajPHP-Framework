<?php
$sharedpath = __DIR__ . "/../..";
$resourceUrl = "../../res";
$slibVersion = "Slib";
$libVersion = "SphpLatest";

// not editable start
// <editor-fold defaultstate="collapsed" desc="This is generated code, any changes can effect the application">
if(!defined("START_PATH")){
    define("START_PATH", __DIR__);
}
if(!isset($argvm) && isset($argv)){
global $argvm;
$argvm = array();
    $total = count($argv);
    for ($c = 0; $c < $total; $c++) {
        $next = $c + 1;
        if ($next >= $total) {
            $next = $total - 1;
        }
        if (strpos($argv[$c], "--") !== FALSE) {
            if (strpos($argv[$next], "--") !== FALSE) {
                $value = "";
                $argvm[$argv[$c]] = $value;
            } else {
                $value = $argv[$next];
                $argvm[$argv[$c]] = $value;
                $c++;
            }
        }
    }

}
if(isset($argv) && isset($argvm["--sharedpath"])){
    chdir(START_PATH);
    $sharedpath = $argvm["--sharedpath"];
    $resourceUrl = "~rs/res";
}
//$resourceUrl = "~up/res/";
$resourcePath = $sharedpath . "/res";
include_once("{$resourcePath}/Score/{$libVersion}/global/start.php");
startSartajPhpEngine();

// </editor-fold>
// not editable end
