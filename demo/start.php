<?php
$respath = "../res/";
$phppath = "../res/";
$sharedpath = "./";
$libversion = "Sphp";
if(isset($argv) && count($argv)>3){
    chdir(__DIR__);
    $sharedpath = $argv[3] . "/";
    $respath = "~rs/res/";
//$respath = "~up/res/";
$phppath = $sharedpath . "res/";
}
include_once("{$phppath}{$libversion}/global/start.php");