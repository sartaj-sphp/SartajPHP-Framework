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
protected function traceBack($errnom, $errstr, $errfile, $errline) {
if (!(error_reporting() & $errnom) || $this->maxErrorCounter > 0) {
return;
}
$this->maxErrorCounter += 1;
$errnoa = $this->getErrorType($errnom);        
$arglist = "";
$objname = "";
$callerline = 0;
$filepath = "";
$filept = "";
$debug_arry = debug_backtrace();
$this->setMsg($errstr , $errnom, $errfile, $errline, "error");
$errstr = "";
$arc = array("traceBack","SphpErrorHandler");
foreach ($debug_arry as $key => $caller) { 
$ar = array();
if(!isset($caller["file"])){
$caller["file"] = "";
}
if(!isset($caller["line"])){
$caller["line"] = 0;
}
if(!isset($caller["class"])){
$caller["class"] = "";
}
if(!isset($caller["object"])){
$caller["object"] = "";
}
if(!isset($caller["type"])){
$caller["type"] = "";
}
if(! in_array($caller["function"], $arc)){ 
$ar['file'] = $caller["file"];
$ar['line'] = $caller["line"];
$ar['function'] = $caller["function"];
$ar['class'] = $caller["class"];
$ar['type'] = $caller["type"];
$ar["arglist"] = $this->getFunctionArgs($caller);
if($ar["line"]==0){
$errstr = ":Error Msg: (" . $ar["arglist"] . ')ENDMsg ' ;                
}else{
$errstr = " Call". $this->maxErrorCounter ."[" . $ar["class"] . $ar["type"] . $ar["function"] . "(". $ar["arglist"] .")]";
}
$this->setMsg($errstr , $errnoa, $ar['file'], $ar["line"], "error");
}
}
}
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
protected function consoleMsg($msg,$type="log"){
$msg = str_replace("\r", ' ',$msg);
$msg = str_replace("\n", ' ',$msg);
return 'console.'. $type .'("' . str_replace('"', '\"',$msg) . '");';
}
/**
* Advance Function, Internal Use
*/
protected function renderHexMode() { 
$C = 0;
$str1 = '';
try{
foreach ($this->msg as $key=>$value) { 
if($C > 90){
break ;
}
if($value[4]=="info"){
$str1 .= $this->consoleMsg($value[0],"log");
}else if($value[4]=="infoi"){
$C += 1;
$str1 .= $this->consoleMsg($value[0],"info");
}else{
$C += 1;
$str1 .= $this->consoleMsg("$value[2] - $value[0]" . " $value[1] - $value[3]","error");
}
}
if(function_exists("getCheckErr") && getCheckErr()){
$str1 .= traceError(false).' '.traceErrorInner(false);
$this->write_log($str1);
}
}  catch (Exception $e){
echo 'Debugger Failed: ',  $e->getMessage(), "\n";
$this->write_log('Debugger Failed: ',  $e->getMessage(), "\n");
}
addFooterJSCode("debugger1",'/* start debug */' . $str1 . '/* end debug */');
}
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
