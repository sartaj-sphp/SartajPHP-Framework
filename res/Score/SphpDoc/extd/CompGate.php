<?php
namespace Sphp\tools {
/**
* Description of CompApp
*
* @author Sartaj Singh
*/
class CompGate extends SphpGate {
public $parentFrontObj = null;
public $parentComponent = null;
public $parentgate = null;
/** @var \Sphp\kit\Page page */
public $page = "";
/** @var FrontFile frontform */
public $frontform;
/** @var FrontFile mainfrontform */
public $mainfrontform;
public $gate_dir_path = "";
public $mypath = "";
public $myrespath = "";
public $phppath = "";
public $respath = "";
public $nameprefix = "";
/** @var \Sphp\kit\JSServer JSServer */
public $JSServer = null;
/** @var \Sphp\kit\Request Client */
public $Client = null;
/** @var \Sphp\kit\MySQL dbEngine */
public $dbEngine = null;
/** @var \Sphp\core\DebugProfiler debug */
public $debug = null;
/**
* 
* @param string $filepath front file path
* @param boolean $noprefix false mean add prefix as parent-component name to all Components
* @return \Sphp\tools\FrontFile
*/
public function createFrontFile($filepath,$noprefix=false) {}
public function setup($frontobj) {}
public function process($frontobj) {}
public function processEvent() {}
/**
* Set Internal Front File. Internal Front File Also render Page Components.
* @param FrontFile $obj 
*/
public function setFrontFile($obj) {}
public function getFrontFile() {}
public function showFrontFile() {}
public function showNotFrontFile() {}
public function setTableName($dbtable) {}
public function getTableName(){}
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
public function run() {}
public function render() {}
public function getReturnData() {}
}
}
