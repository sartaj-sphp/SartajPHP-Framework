<?php
namespace Sphp\tools{
/**
* Description of SubApp
*
* @author Sartaj Singh
*/
class SubGate extends SphpGate{
/** @var \Sphp\kit\Page page */
public $page = "";
/** @var FrontFile frontform */
public $frontform;
/** @var FrontFile mainfrontform */
public $mainfrontform;
public $gate_dir_path = "";
public $phppath = "";
public $respath = "";
/** @var \Sphp\kit\JSServer JSServer */
public $JSServer = null;
/** @var \Sphp\kit\Request Client */
public $Client = null;
/** @var \Sphp\kit\MySQL dbEngine */
public $dbEngine = null;
/** @var \Sphp\core\DebugProfiler debug */
public $debug = null;
public $cfilename = "";
public $cfilepath = "";
public $mypath = "";
public $myrespath = "";
public function setup($frontobj){}
public function process($frontobj){}
public function processEvent(){}
/**
* Set Internal Front File. Internal Front File Also render Page Components.
* @param FrontFile $obj 
*/
public function setFrontFile($obj){}
public function getFrontFile() {}
public function showFrontFile(){}
public function showNotFrontFile(){}
public function setTableName($dbtable){}
public function getTableName(){}
public function onstart(){}
public function onready(){}
public function onfrontinit($frontobj){}
public function onfrontprocess($frontobj){}
public function page_delete(){}
public function page_view(){}
public function page_submit(){}
public function page_insert(){}
public function page_update(){}
public function page_new(){}
public function getEvent(){}
public function getEventParameter(){}
public function onrun(){}
public function onrender(){}
public function run(){}
public function render(){}
public function getAuthenticate($authenticates){}
public function getSesSecurity(){}
public function setClassPath() {}
}
}
