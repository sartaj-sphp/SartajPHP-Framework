<?php
namespace Sphp\Gates{
/**
* Experimental:- 
* NativeAppCom work as console Gate load by child process of different languages like dot net
*
* @author Sartaj Singh
*/
class NativeComGate {
/** @var \Sphp\Kit\Page page */
public $page = "";
/** @var FrontFile frontform */
public $gateDirPath = "";
public $resourcePath = "";
public $resourceUrl = "";
/** @var \Sphp\Kit\JsServer jsServer */
public $jsServer = null;
/** @var \Sphp\Kit\Request client */
public $client = null;
/** @var \Sphp\Kit\MySQL dbEngine */
public $dbEngine = null;
/** @var \Sphp\Core\DebugProfiler debug */
public $debug = null;
public $Form = null;
public $protocolJ = null;
/**
* Set Form Object
* @param object $param
*/
public function setForm($param) {}
/**
* Process Events
*/
public function processEvent(){}
/**
* Set Table Name
* @param string $dbtable
*/
public function setTableName($dbtable){}
/**
* Get Table Name
* @return string
*/
public function getTableName(){}
public function onstart(){}
public function initalize() {}
public function onready(){}
public function page_submit(){}
public function page_new(){}
/**
* Get Event
* @return string
*/
public function getEvent(){}
/**
* Get Event Parameter
* @return string
*/
public function getEventParameter(){}
public function onrun(){}
public function onrender(){}
/**
* Run Gate
*/
public function run(){}
/**
* Render Gate
*/
public function render(){}
/**
* Set Authentication
* @param string $authenticates
*/
public function getAuthenticate($authenticates){}
/**
* Get Session Security
*/
public function getSesSecurity(){}
}
class ProtocolJ {
public $jsServer;
/**
* Create Value Type
* @param string $type
* @param string $subtype
* @param mixed $value
* @return array
*/
public function createValueType($type,$subtype,$value) {}
/**
* Create Event
* @param string $url
* @param string $evtargtype
* @param array $args
* @return array
*/
public function createEvent($url,$evtargtype,$args) {}
/**
* Create Event Args
* @param string $arg
* @param string $type
* @param string $subtype
* @param mixed $value
* @return array
*/
public function createEventArgs($arg,$type,$subtype,$value) {}
/**
* Create Object
* @param string $name
* @param string $objclass
* @param object $parentobj
* @param array $props
*/
public function createObject($name,$objclass,$parentobj=null,$props = array()) {}
/**
* Set Properties
* @param string $name
* @param array $props
*/
public function setProps($name,$props=array()) {}
/**
* Set Events
* @param string $name
* @param array $evts
*/
public function setEvts($name,$evts=array()) {}
}
}
