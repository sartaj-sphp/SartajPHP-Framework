<?php
namespace Sphp\tools{
/**
* Description of MobileApp
*
* @author Sartaj Singh
*/
require_once(\SphpBase::sphp_settings()->lib_path . "/lib/DIR.php");
include_once(\SphpBase::sphp_settings()->lib_path . "/lib/HtmlMinifier.php");
class MobileApp extends BasicApp{
public $mobappname = "HelloSphp";
public $mobappid = "com.sartajphp.view";
public $mobappversion = "0.0.1";
public $mobappdes = "A sample SartajPhp application that run on Android Mobile.";
public $mobappauthor = "SartajPhp Team";
public $mobappauthoremail = "sartaj@sartajsingh.com";
public $mobappauthorweb = "https://sartajphp.com";
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
protected function publishAndroidApp($curdirpath) {}
protected function sendRenderData() {}
public function run(){}
public function render(){}
public function setClassPath() {}
}
}
