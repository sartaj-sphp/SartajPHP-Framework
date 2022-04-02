<?php
$sharedpath = "..";
$respath = "../res";
if(!defined("start_path")){
    define("start_path", __DIR__);
}
if(isset($argv) && count($argv)>3){
    chdir(start_path);
    $sharedpath = $argv[3] ;
	$respath = "~rs/res";
}
//$respath = "~up/res/";
$phppath = $sharedpath . "/res";
$slibversion = "Slib";
$libversion = "Sphp";

include_once("{$phppath}/Score/{$libversion}/global/start.php");
