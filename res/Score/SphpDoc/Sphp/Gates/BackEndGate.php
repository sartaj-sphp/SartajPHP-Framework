<?php
namespace Sphp\Gates{
/**
* Description of BackEndGate
*
* @author Sartaj Singh
*/
class BackEndGate extends \Sphp\Tools\SphpGate {
/** @var page */
public $page = "";
public $frontform;
public $mainfrontform;
public $sjsobj;
public $blnsjsobj = false;
public $jsServer = null;
public $client = null;
public $dbEngine = null;
public $sphpApi = null;
public $debug = null;
public $resourcePath = "";
public $resourceUrl = "";
public $gateDirPath = "";
/**
* Constructor
* @param FrontFile $frontfile
*/
/**
* Setup Front File Object
* @param FrontFile $frontobj
*/
/**
* Process Front File Object
* @param FrontFile $frontobj
*/
/**
* Call Page Events
*/
/**
* Set Internal Front File. Internal Front File Also render Page Components.
* @param FrontFile $obj 
*/
public function setFrontFile($obj) {}
/**
* Get Front File Object
* @return FrontFile
*/
public function getFrontFile() {}
/**
* Show Front File
*/
public function showFrontFile() {}
/**
* Show Not Front File
*/
public function showNotFrontFile() {}
/**
* Gate start event handler
*/
public function onstart() {}
/**
* Gate ready event handler
*/
public function onready() {}
/**
* Front File init event handler
* @param FrontFile $frontobj
*/
public function onfrontinit($frontobj) {}
/**
* Front File process event handler
* @param FrontFile $frontobj
*/
public function onfrontprocess($frontobj) {}
/**
* Page submit event handler
*/
public function page_submit() {}
/**
* Page new event handler
*/
public function page_new() {}
/**
* Get Gate event name
* @return string
*/
public function getEvent() {}
/**
* Get Gate event parameter
* @return string
*/
public function getEventParameter() {}
/**
* Gate run event handler
*/
public function onrun() {}
/**
* Gate render event handler
*/
public function onrender() {}
/**
* Run Gate
*/
/**
* Render Gate
*/
public function render() {}
/**
* Set MasterFile
*/
public function setMasterFile($masterFile) {}
/**
* Get MasterFile
* @return string
*/
public function getMasterFile() {}
/**
* Set Table Name
* @param string $tableName
*/
public function setTableName($tableName) {}
/**
* Get Table Name
* @return string
*/
public function getTableName(){}
/**
* Set Authentication
* @param string $authenticates
*/
public function getAuthenticate($authenticates) {}
/**
* Get Session Security
*/
public function getSesSecurity() {}
}
}
