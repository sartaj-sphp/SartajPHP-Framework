<?php
namespace Sphp\tools {
class ChildProcessAppNjs extends ConsoleApp {
/** @var int WebSocket Connection ID which start application */
public $mainConnection = 0;
/**
* Advance function 
*/
/**
* Create Child Process
* @param string $exepath file path to execute as child process
* @param array $param pass command line arguments to child process
* @param string $childid Optional Give the name of child process work as id
*/
public function createProcess($exepath, $param = array(), $childid = "mid1") {}
/**
* Advance function 
* Setup proxy server for website
* @param string $param
*/
public function setupProxy($param) {}
/**
* Configure Application as Global App Type.
* *Global Application has only 1 process for all requests and sessions. 
* It will start on first request but it will not exit 
* with browser close. By default application type is multi process 
* that mean each session has 1 separate process.
*/
public function setGlobalApp() {}
/**
* Send Data to All Others WS Connections
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param int $sendtype Optional Default=0
* @param string $datatype Optional Default=text Data Type
* @param string $groupctrl Optional 
*/
public function sendOthers($rawdata = null, $sendtype = 0, $datatype = "text", $groupctrl = "") {}
/**
* Send Data to connection id
* @param int $conid Optional Default=(current request)
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param string $datatype Optional Default=text Data Type
*/
public function sendTo($conid = 0, $rawdata = null, $datatype = "text") {}
/**
* Send Data to All WS Connections
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param int $sendtype Optional Default=0 or 1,2,3
* @param string $datatype Optional Default=text Data Type
* @param string $groupctrl Optional 
* @param int $conid Optional Default=-1
*/
public function sendAll($rawdata = null, $sendtype = 0, $datatype = "text", $groupctrl = "", $conid = -1) {}
/**
* override this event handler in your application to handle it.
* Event Handler for Child Process Console output
* @param string|array $data
* @param string $type
*/
public function onconsole($data, $type) {}
/**
* override this event handler in your application to handle it.
* @param array $data
*/
public function onrequest($data) {}
/**
* override this event handler in your application to handle it.
* Application Exit Handler
*/
public function onquit() {}
/**
* override this event handler in your application to handle it.
* Application Child process Exit Handler
*/
public function oncquit() {}
/**
* override this event handler in your application to handle it.
* WebSocket Connection Handler, 
* Trigger on each new connection
* @param int $conid WS Connection ID
*/
public function onwscon($conid) {}
/**
* override this event handler in your application to handle it.
* WebSocket DisConnection Handler
* Trigger on each connection close
* @param int $conid WS Connection ID
*/
public function onwsdiscon($conid) {}
/**
* Advance Function
* Send Data to Browser in JSON format
* @param array|string $data
* @param string $type Optional Default=jsonweb
*/
public function sendData($data, $type = "jsonweb") {}
/**
* Send Command to Child Process
* @param string|array $msg
* @param string $type Optional Default=childp
*/
public function sendCommand($msg, $type = "childp") {}
/**
* Advance Function
* Send Data to Child Process
* @param string $ptype <p>
* Your custom command type. sendCommand use 'cmd' and callProcess use 'fun'
* </p>
* @param array|string $data
* @param string $type Optional Default=childp
*/
public function sendProcess($ptype, $data, $type = "childp") {}
/**
* Call function of child process and pass data
* @param string $fun funcation name of child process
* @param string|array $data
* @param string $type Optional
*/
public function callProcess($fun, $data, $type = "childp") {}
/**
* Advance function, Internal use
* Override wait event handler of ConsoleAPP
*/
public function onwait() {}
/**
* Advance function, Internal use
*/
public function run() {}
}
}
