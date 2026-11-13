<?php
namespace Sphp\Core{
/**
* DebugProfiler
* Collects debug messages, handles PHP errors, exceptions and fatal errors,
* and renders them in HTML, JS console, or CLI output depending on the
* response method and request mode.
*/
class DebugProfiler {
/** @var array All Messages as associative array */
public $msg = array();
/** @var int $debugMode 0=no,1=only error,2=all 
* @deprecated 4.4.8
* @ignore
*/
public $debugMode = 0;
public $curFrontFile = "";
/**
* Constructor
* Sets debugMode from settings.
*/
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
/**
* Get Function Args
* @param array $caller
* @return string
*/
/**
* Get Function Args Recursive
* @param mixed $funs
* @param int $c
* @return string
*/
/**
* Get Function Args Recursive 2
* @param mixed $funs
* @param int $c
* @return string
*/
/**
* Get Error Type
* @param int $errno1
* @return string
*/
/**
* Trace Back
* @param int $errnom
* @param string $errstr
* @param string $errfile
* @param int $errline
* @param array $debugArry
*/
protected function traceBack($errnom, $errstr, $errfile, $errline,$debugArry) {}
/**
* Advance Function, Internal Use
*/
public function callerFun() {}
/**
* Advance Function, Internal Use
*/
public function SphpErrorHandler($errnom, $errstr, $errfile, $errline) {}
/**
* Write Log
* @param string $logData
*/
public function writeLog($logData) {}
/**
* Translate Class Name
* @param array $debugobj
* @return string
*/
/**
* Advance Function, Internal Use
*/
public function sphpExceptionHandler($exception) {}
/**
* Advance Function, Internal Use
*/
public function sphpHandleFatal() {}
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
/**
* DebugProfiler2
* Extends DebugProfiler to save memory when debug mode is off.
* Only log file is available.
*/
class DebugProfiler2 extends DebugProfiler {
public function setMsg($msgb, $errnob = "", $errfileb = "", $errlineb = "", $typeb = "info") {}
public function setMsgi($msgc, $errnoc = "", $errfilec = "", $errlinec = "", $typec = "infoi") {}
public function println($msg) {}
public function print_r($arr) {}
}
}
