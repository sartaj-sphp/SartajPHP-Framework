<?php

$sharedpath = __DIR__ . "/..";
$respath = "../res";
$slibversion = "Slib";
$libversion = "Sphp";

// not editable start
// <editor-fold defaultstate="collapsed" desc="This is generated code, any changes can effect the application">
if(!defined("start_path")){
    define("start_path", __DIR__);
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
    chdir(start_path);
    $sharedpath = $argvm["--sharedpath"];
    $respath = "~rs/res";
}
//$respath = "~up/res/";
$phppath = $sharedpath . "/res";
include_once("{$phppath}/Score/{$libversion}/global/start.php");
startSartajPHPEngine();
// </editor-fold>
// not editable end
