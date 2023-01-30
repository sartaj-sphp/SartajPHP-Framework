<?php
namespace Sphp\tools{
/**
* Description of WebApp
*
* @author Sartaj Singh
*/
class WebApp extends SphpApp {
/** @var page */
public $page = "";
public $tempform;
public $maintempform;
public $sjsobj;
public $blnsjsobj = false;
public $JSServer = null;
public $Client = null;
public $dbEngine = null;
public $sphp_api = null;
public $debug = null;
public $phppath = "";
public $respath = "";
public $apppath = "";
public function __construct($tempfile) {}
public function setup($tempobj) {}
public function process($tempobj) {}
/**
* Set Internal Temp File. Internal Temp File Also render Page Components.
* @param TempFile $obj 
*/
public function setTempFile($obj) {}
public function getTempFile() {}
public function showTempFile() {}
public function showNotTempFile() {}
public function onstart() {}
public function onready() {}
public function ontempinit($tempobj) {}
public function ontempprocess($tempobj) {}
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
public function run() {}
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
