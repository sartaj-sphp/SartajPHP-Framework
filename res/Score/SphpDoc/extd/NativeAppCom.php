<?php
namespace Sphp\tools{
/**
* Experimental:- 
* NativeAppCom work as console app load by child process of different languages like dot net
*
* @author Sartaj Singh
*/
class NativeAppCom {
/** @var \Sphp\kit\Page page */
public $page = "";
/** @var TempFile tempform */
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
public $Form = null;
public $protocolJ = null;
public function setForm($param) {}
public function processEvent(){}
public function setTableName($dbtable){}
public function getTableName(){}
public function onstart(){}
public function initalize() {}
public function onready(){}
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
}
class ProtocolJ {
public $JSServer;
public function createValueType($type,$subtype,$value) {}
public function createEvent($url,$evtargtype,$args) {}
public function createEventArgs($arg,$type,$subtype,$value) {}
public function createObject($name,$objclass,$parentobj=null,$props = array()) {}
public function setProps($name,$props=array()) {}
public function setEvts($name,$evts=array()) {}
}
}
