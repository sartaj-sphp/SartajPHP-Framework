<?php
namespace Sphp\tools{
/**
* Description of BackEndGate
*
* @author Sartaj Singh
*/
class BackEndGate extends SphpGate {
/** @var page */
public $page = "";
public $frontform;
public $mainfrontform;
public $sjsobj;
public $blnsjsobj = false;
public $JSServer = null;
public $Client = null;
public $dbEngine = null;
public $sphp_api = null;
public $debug = null;
public $phppath = "";
public $respath = "";
public $gate_dir_path = "";
/**
* Set Internal Front File. Internal Front File Also render Page Components.
* @param FrontFile $obj 
*/
public function setFrontFile($obj) {}
public function getFrontFile() {}
public function showFrontFile() {}
public function showNotFrontFile() {}
public function onstart() {}
public function onready() {}
public function onfrontinit($frontobj) {}
public function onfrontprocess($frontobj) {}
public function page_delete() {}
public function page_view() {}
public function page_submit() {}
public function page_insert() {}
public function page_update() {}
public function page_new() {}
public function getEvent() {}
public function getEventParameter() {}
public function onrun() {}
public function onrender() {}
public function render() {}
/**
* Set MasterFile
*/
public function setMasterFile($masterFile) {}
public function getMasterFile() {}
public function setTableName($tableName) {}
public function getTableName(){}
public function getAuthenticate($authenticates) {}
public function getSesSecurity() {}
}
}
