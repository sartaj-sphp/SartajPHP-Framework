<?php
namespace Sphp\tools{
/**
* Description of SubApp
*
* @author Sartaj Singh
*/
class SubApp extends SphpApp{
/** @var \Sphp\kit\Page page */
public $page = "";
/** @var TempFile tempform */
public $tempform;
/** @var TempFile maintempform */
public $maintempform;
public $apppath = "";
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
public function setup($tempobj){}
public function process($tempobj){}
public function processEvent(){}
/**
* Set Internal Temp File. Internal Temp File Also render Page Components.
* @param TempFile $obj 
*/
public function setTempFile($obj){}
public function getTempFile() {}
public function showTempFile(){}
public function showNotTempFile(){}
public function setTableName($dbtable){}
public function getTableName(){}
public function onstart(){}
public function onready(){}
public function ontempinit($tempobj){}
public function ontempprocess($tempobj){}
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
