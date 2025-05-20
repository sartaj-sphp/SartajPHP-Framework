<?php
namespace Sphp\tools{
/**
* Description of MobileApp
*
* @author Sartaj Singh
*/
require_once(\SphpBase::sphp_settings()->lib_path . "/lib/DIR.php");
include_once(\SphpBase::sphp_settings()->lib_path . "/lib/HtmlMinifier.php");
class CordovaApp extends BasicApp{
public $mobappname = "HelloCordova";
public $mobappid = "com.sartajphp.hellocordova";
public $mobappversion = "0.0.1";
public $mobappdes = "A sample Apache Cordova application that responds to the deviceready event.";
public $mobappauthor = "Apache Cordova Team";
public $mobappauthoremail = "dev@cordova.apache.org";
public $mobappauthorweb = "https://cordova.apache.org";
public $sjsobj = array();
public $blnsjsobj = true;
public $sphp_api = null;
public $cfilename = "";
public $dir = null;
public function setGenRootFolder($param) {}
public function setSpecialMetaTag($val) {}
/**
* Set Distribute multi js css files rather then single
*/
public function setMultiFiles() {}
public function setup($tempobj){}
public function addPage($pageobj) {}
public function addDistLib($folderpath) {}
public function process($tempobj){}
public function processEvent(){}
protected function createCordovaPlugin($curdirpath) {}
protected function sendRenderData() {}
public function run(){}
public function render(){}
public function setClassPath() {}
}
}
