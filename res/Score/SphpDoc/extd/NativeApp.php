<?php
namespace Sphp\tools {
class NativeApp extends ConsoleApp {
/** @var int WebSocket Connection ID which start application */
public $mainConnection = null;
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
* Send Message to browser
* @param type $msg
* @param string $type 'i' mean info other mean error
*/
public function sendMsg($msg,$type='i'){}
/**
* Advance function 
* Setup proxy server for website
* @param string $param
*/
public function setupProxy($param) {}
/**
* Configure Application as Global App Type.
* Global Application has only 1 process for all requests and sessions. 
* It will start on first request but it will not exit 
* with browser close. By default application type is multi process 
* that mean each session or Web Socket has 1 separate process. 
*/
public function setGlobalApp() {}
/**
* Set Manager WS Connection for Global Application. Every
* Global Application has one main WS connection which started global App.
* But this WS connection lost if browser close or reload. So if you need a
* manager to control or watch global app processing then this method reassign
* any connection id as a main connection. Only Work with Global app and
* Web Socket connection.
*/
public function setGlobalAppManager() {}
/**
* Send Data to main connections related to All processes of 
* current app or match with $groupctrl.
* In case of global app(Single Process App) Only one main 
* connection and if it is disconnected then data will not send.
* If you want to send data to all connections of global app then use sendOthers
* or sendAll.
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param string $datatype Optional Default=text Data Type
* @param string $groupctrl Optional Default=this app, controller of app to send data
*/
public function sendAllProcess($rawdata = null, $datatype = "text",$groupctrl="") {}
/**
* Easy Send Data for custom use sendToWS
* Send Data to All WS Connections of Server also included current connection.
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param string $datatype Optional Default=text Data Type
*/
public function sendAllWS($rawdata = null, $datatype = "text") {}
/**
* Send Data to All WS Connections related to app process, current controller or $groupctrl.
* It works similar to sendOthers but also send data to current connection.
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param string $datatype Optional Default=text Data Type
* @param string $groupctrl Optional Default=this app, controller of app to send data
*/
public function sendAll($rawdata = null, $datatype = "text", $groupctrl = "") {}
/**
* Easy Send Data for custom use sendOthersRaw
* Send Data to All Others WS Connections and leave current connection id
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param string $datatype Optional Default=text Data Type
* @param string $groupctrl Optional Default=this app, controller of app to send data
*/
public function sendOthers($rawdata = null, $datatype = "text", $groupctrl = "") {}
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
* of process not all connections) of $groupctrl app or this app), 
* 1(All connections of global app), 2(All WS connections)
* @param string $datatype Optional Default=text Data Type
* @param string $groupctrl Optional Default=this, controller of app to send data
*/
public function sendOthersRaw($rawdata = null, $sendtype = 0, $datatype = "text", $groupctrl = "") {}
/**
* Advance 
* Send Data to WS Connections.
* sendtype:-
* 0 = send data to all processes of this app or other app controller as $groupctrl.
* for single process app(global app), data send only to main connection
* 1 = send data to all connections of WS with global app this or other app controller as $groupctrl.
* 2 = send data to all WS connections of Server
* 3 = send data to connection id $conid only
* @param string $rawdata Optional Default=(send JSServer), JSON String
* @param int $sendtype Optional Default=0 or 1,2,3 
* @param string $datatype Optional Default=text Data Type
* @param string $groupctrl Optional controller of app to send data
* @param int $conid Optional Default=-1=all, this id will leave to send data if $sendtype=0,1 or 2
*/
public function sendToWS($rawdata = null, $sendtype = 0, $datatype = "text", $groupctrl = "", $conid = -1) {}
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
* Connection object include conid, REQUEST_ADD and REQUEST_PORT key
* Trigger on each new connection
* @param array $conobj WS Connection Object
*/
public function onwscon($conobj) {}
/**
* override this event handler in your application to handle it.
* WebSocket DisConnection Handler
* Connection object include conid, REQUEST_ADD and REQUEST_PORT key
* Trigger on each connection close
* @param array $conobj WS Connection Object
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
* @param string $fun function name of child process
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
