<?php
namespace Sphp\core{
class DebugProfiler {
/** @var array All Messages as associative array */
public $msg = array();
/** @var int $debugmode 0=no,1=only error,2=all 
* @deprecated 4.4.8
* @ignore
*/
public $debugmode = 0;
public $cur_front_file = "";
/**
* Clear all messages
*/
public function clearMe() {}
/**
* Add Message
* @param string $msgb Message
* @param string $errnob PHP Error Number like E_USER_ERROR
* @param string $errfileb Error in filepath
* @param string $errlineb Error Line Number
* @param string $typeb default info 
*/
public function setMsg($msgb, $errnob = "", $errfileb = "", $errlineb = "", $typeb = "info") {}
/**
* Add Info Message
* @param string $msgc Message
* @param string $errnoc PHP Error Number like E_USER_ERROR
* @param string $errfilec Error in filepath
* @param string $errlinec Error Line Number
* @param string $typec default infoi 
*/
public function setMsgi($msgc, $errnoc = "", $errfilec = "", $errlinec = "", $typec = "infoi") {}
/**
* Print Line
* @param string $msg
*/
public function println($msg) {}
/**
* Print Object or Array
* @param array|object $arr
*/
public function print_r($arr) {}
/**
* Get All Messages
* @return array
*/
public function getMsg() {}
protected function traceBack($errnom, $errstr, $errfile, $errline,$debug_arry) {}
/**
* Advance Function, Internal Use
*/
public function callerFun() {}
/**
* Advance Function, Internal Use
*/
public function SphpErrorHandler($errnom, $errstr, $errfile, $errline) {}
public function write_log($log_data) {}
/**
* Advance Function, Internal Use
*/
public function Sphp_exception_handler($exception) {}
/**
* Advance Function, Internal Use
*/
public function Sphp_handle_fatal() {}
/**
* Print All as HTML
*/
public function printAll() {}
/**
* Write message on JS Console
* @param string $msg
* @param string $type default=log, info,error
* @return type
*/
protected function consoleMsg($msg,$type="log"){}
/**
* Advance Function, Internal Use
*/
protected function renderHexMode() {}
/**
* Advance Function, Internal Use
*/
public function render() {}
}
class DebugProfiler2 extends DebugProfiler {
public function setMsg($msgb, $errnob = "", $errfileb = "", $errlineb = "", $typeb = "info") {}
public function setMsgi($msgc, $errnoc = "", $errfilec = "", $errlinec = "", $typec = "infoi") {}
public function println($msg) {}
public function print_r($arr) {}
}
}
