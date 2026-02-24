<?php
namespace Sphp\tools {
class NativeGate extends ConsoleGate {
/** @var int WebSocket Connection ID which start Gate */
public $mainConnection = null;
public $JQuery = null;
protected $childCom = null;
/**
* Create Child Process
* @param string $exepath file path to execute as child process
* @param array $param pass command line arguments to child process
* @param string $childid Optional Give the name of child process work as id
*/
public function createProcess($exepath, $param = array(), $childid = "mid1") {}
/**
* Send Message to browser
* @param type $msg
* @param string $type 'i' mean info other mean error
*/
public function sendMsg($msg,$type='i'){}
/**
* Advance function 
* Setup proxy server for website
* @param string $param
* @deprecated since version 5.0.0
*/
public function setupProxy($param) {}
/**
* Configure Gate as Global Gate Type.
* Global Gate has only 1 process for all requests and sessions. 
* It will start on first request but it will not exit 
* with browser close. By default Gate type is multi process 
* that mean each session or Web Socket has 1 separate process. 
*/
public function setGlobalGate() {}
/**
* Set Manager WS Connection for Global Gate. Every
* Global Gate has one main WS connection which started global Gate.
* But this WS connection lost if browser close or reload. So if you need a
* manager to control or watch global Gate processing then this method reassign
* any connection id as a main connection. Only Work with Global Gate and
* Web Socket connection.
*/
public function setGlobalGateManager() {}
/**
* Send Data to main connections related to All processes of 
* current Gate or match with $gate.
* In case of global Gate(Single Process Gate) Only one main 
* connection and if it is disconnected then data will not send.
* If you want to send data to all connections of global Gate then use sendOthers
* or sendAll.
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param string $datatype Optional Default=text Data Type
* @param string $gate Optional Default=this Gate, Gate of Gate to send data
*/
public function sendAllProcess($rawdata = null, $datatype = "text",$gate="") {}
/**
* Easy Send Data for custom use sendToWS
* Send Data to All WS Connections of Server also included current connection.
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param string $datatype Optional Default=text Data Type
*/
public function sendAllWS($rawdata = null, $datatype = "text") {}
/**
* Send Data to All WS Connections related to Gate process, current Gate or 
* $gate of other Native Gate.
* It works similar to sendOthers but also send data to current connection.
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param string $datatype Optional Default=text Data Type
* @param string $gate Optional Default=this Gate, Gate of Gate to send data
*/
public function sendAll($rawdata = null, $datatype = "text", $gate = "") {}
/**
* Easy Send Data for custom use sendOthersRaw
* Send Data to All Others WS Connections and leave current connection id
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param string $datatype Optional Default=text Data Type
* @param string $gate Optional Default=this Gate, Gate of Gate to send data
*/
public function sendOthers($rawdata = null, $datatype = "text", $gate = "") {}
/**
* Send Data to connection id or current connection id
* @param int $conid Optional Default=(current request)
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param string $datatype Optional Default=text Data Type
*/
public function sendTo($conid = 0, $rawdata = null, $datatype = "text") {}
/**
* Advance for easy way use SendOthers
* Send Data to All Others WS Connections and leave current connection id
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param int $sendtype Optional Default=0(All Processes(Only Main Connection 
* of process not all connections) of $gate Gate or this Gate), 
* 1(All connections of global Gate), 2(All WS connections)
* @param string $datatype Optional Default=text Data Type
* @param string $gate Optional Default=this, Gate of Gate to send data
*/
public function sendOthersRaw($rawdata = null, $sendtype = 0, $datatype = "text", $gate = "") {}
/**
* Advance 
* Send Data to WS Connections.
* sendtype:-
* 0 = send data to all processes of this Gate or other Gate Gate as $gate.
* for single process Gate(global Gate), data send only to main connection
* 1 = send data to all connections of WS with global Gate this or other Gate Gate as $gate.
* 2 = send data to all WS connections of Server
* 3 = send data to connection id $conid only
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param int $sendtype Optional Default=0 or 1,2,3 
* @param string $datatype Optional Default=text Data Type
* @param string $gate Optional Gate of Gate to send data
* @param int $conid Optional Default=-1=all, this id will leave to send data if $sendtype=0,1 or 2
*/
public function sendToWS($rawdata = null, $sendtype = 0, $datatype = "text", $gate = "", $conid = -1) {}
/**
* override this event handler in your Gate to handle it.
* Event Handler for Child Process Console output
* @param string|array $data
* @param string $type
*/
public function onconsole($data, $type) {}
/**
* SphpServer Event Trigger when Child Process is ready.
* @param string $evtp
* @param array $bdata Child Process id
*/
public function page_event_s_onprocesscreate($evtp,$bdata){}
/**
* override this event handler in your Gate to handle it.
* Gate Exit Handler
*/
public function onquit() {}
/**
* override this event handler in your Gate to handle it.
* Gate Child process Exit Handler
*/
public function oncquit() {}
/**
* override this event handler in your Gate to handle it.
* WebSocket Connection Handler, 
* Trigger on each new connection
* @param \Sphp\tools\WsCon $conobj WS Client Object
*/
public function onwscon($conobj) {}
/**
* override this event handler in your Gate to handle it.
* WebSocket DisConnection Handler
* Trigger on each connection close
* @param \Sphp\tools\WsCon $conobj WS Client Object
*/
public function onwsdiscon($conobj) {}
/**
* Advance Function
* Send Data to Browser in JSON format
* @param array|string $data
* @param string $type Optional Default=jsonweb
*/
public function sendData($data, $type = "jsonweb") {}
/**
* Advance function, Internal use
* Override wait event handler of ConsoleGate
*/
public function onwait() {}
/**
* Exit Manually
*/
public function ExitMe() {}
/**
* Advance function 
*/
/**
* Advance function, Internal use
*/
}
/**
* WS Connection Object hold the WS Connection.
*/
class WsCon{
/**
* Send Data to WS Client
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param string $datatype Optional Default=text Data Type
*/
public function send($rawdata = null, $datatype = "text"){}
/**
* Get Connection ID of WS Client
* @return int
*/
public function getConnectionId(){}
/**
* Get IP Address of WS Client
* @return string
*/
public function getAddress(){}
/**
* Get Port Address of WS Client
* @return string
*/
public function getPort(){}
}
/**
* Child Process Communication Protocol Object
*/
class CpCom{        
public $status = false;
/**
* Call function of child process and pass data
* @param string $fun function name of child process
* @param string|array $data
*/
public function callProcess($fun, $data) {}
/**
* Send Command to Child Process
* @param string $cmd Command Name of Child Process
*/
public function sendCommand($cmd) {}
/**
* Advance Function
* Send Data to Child Process
* @param string $ptype <p>
* Your custom command type. sendCommand use 'cmd' and callProcess use 'fun'
* </p>
* @param array|string $data
* @param string $type Optional Default=childp
*/
}
}
