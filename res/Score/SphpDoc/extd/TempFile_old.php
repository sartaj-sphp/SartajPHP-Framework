<?php
namespace Sphp\tools{
/**
* Description of TempFile
*
* @author Sartaj Singh
*/
class TempFile {
public $data = "";
public $filePath = "";
public $compList = array();
public $name = "";
public $webapp = null;
public $metadata = array();
public $blncodebehind = false;
public $blncodefront = false;
public $blnshowFront = true;
public $webapppath = "";
public $sjspath = "";
public $appname = "";
public $HTMLParser = null;
public function getData() {}
public function getFilePath() {}
public function getName() {}
public function getWebapp() {}
public function getWebapppath() {}
public function getSjspath() {}
public function getAppname() {}
public function setFilePath($filePath) {}
public function setWebapp($webapp) {}
public function setWebapppath($webapppath) {}
public function setSjspath($sjspath) {}
public function getBlncodebehind() {}
public function setBlncodebehind($blncodebehind) {}
public function setBlncodefront($blncodefront) {}
public function setBlnshowFront($blnshowFront) {}
public function getBlncodefront() {}
public function getBlnshowFront() {}
public function setAppname($appname) {}
public function __construct($TempFilePath, $blnStringData = false, $backfileobj = null) {}
public function addMetaData($key, $value) {}
public function getMetaData($key) {}
public function __get($name) {}
public function getComponent($key) {}
public function setComponent($key,$obj) {}
public function registerTempFile() {}
public function getFile($TempFilePath, $blnStringData = false, $backfileobj = null, $use_sjs_file = false) {}
public function run() {}
public function render() {}
public function runit() {}
public function renderit() {}
}
}
