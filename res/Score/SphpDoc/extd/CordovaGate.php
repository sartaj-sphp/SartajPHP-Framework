<?php
namespace Sphp\tools{
/**
* Description of MobileApp
*
* @author Sartaj Singh
*/
require_once(\SphpBase::sphp_settings()->lib_path . "/lib/DIR.php");
include_once(\SphpBase::sphp_settings()->lib_path . "/lib/HtmlMinifier.php");
class CordovaGate extends BasicGate{
public $mobregistergate = "HelloCordova";
public $mobGateid = "com.sartajphp.hellocordova";
public $mobGateversion = "0.0.1";
public $mobGatedes = "A sample Apache Cordova Gate that responds to the deviceready event.";
public $mobGateauthor = "Apache Cordova Team";
public $mobGateauthoremail = "dev@cordova.apache.org";
public $mobGateauthorweb = "https://cordova.apache.org";
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
public function setup($frontobj){}
public function addPage($pageobj) {}
public function addDistLib($folderpath) {}
public function process($frontobj){}
public function processEvent(){}
protected function createCordovaPlugin($curdirpath) {}
protected function sendRenderData() {}
public function run(){}
public function render(){}
public function setClassPath() {}
}
}
