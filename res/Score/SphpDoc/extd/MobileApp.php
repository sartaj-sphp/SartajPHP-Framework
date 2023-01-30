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
public $sjsobj = array();
public $blnsjsobj = true;
public $sphp_api = null;
public $cfilename = "";
public $path = "";
public $pathres = "";
public $dir = null;
public function __construct(){}
public function setSpecialMetaTag($val) {}
public function setup($tempobj){}
public function addPage($pageobj) {}
public function addDistLib($folderpath) {}
public function process($tempobj){}
public function processEvent(){}
public function run(){}
public function render(){}
public function setClassPath() {}
}
}
