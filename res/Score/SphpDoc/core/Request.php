<?php
namespace Sphp\core{
class Request {
/** @var string $method Request Method */
public $method = "";
/** @var string $mode Default SERVER OR CLI or CGI */
public $mode = "SERVER";     /** @var string $protocol Request Protocol */
public $protocol = "";
/** @var boolean $blnsecure Request SSL */
public $blnsecure = false;
/** @var string $uri Request URI */
public $uri = "";
/** @var string $scriptpath Engine Script Path */
public $scriptpath = "";
/** @var array $argv Command Line Arguments */
public $argv = array();
/** @var string $type Request Type Default NORMAL or AJAX or SOAP */
public $type = "NORMAL";     /** @var boolean $isNativeClient true if application embed with browser  */
public $isNativeClient = false;
/**
* Get All Request Headers
* @return array()
*/
public function getClientHeaders() {}
/**
* Advance Function, Internal use
*/
public function parseRequest() {}
/**
* True if Application run with SphpServer Mode or Browser embed mode 
* False on Web Server Mode or Console Mode
* @return boolean
*/
public function isNativeApp() {}
/**
* Read Browser Get Method Data
* @param string $name key
* @param boolean $blnRaw true mean, no escaping
* @return string|array
*/
public function get($name, $blnRaw = false) {}
/**
* Read Browser Post Method Data
* @param string $name key
* @param boolean $blnRaw true mean, no escaping
* @return string|array
*/
public function post($name, $blnRaw = false) {}
/**
* Check if Request has key
* @param string $name key
* @return boolean
*/
public function isRequest($name) {}
/**
* Check if Cookie has key
* @param string $name key
* @return boolean
*/
public function isCookie($name) {}
/**
* Check if Session has key
* @param string $name key
* @return boolean
*/
public function isSession($name) {}
/**
* Check if Server has key
* @param string $name key
* @return boolean
*/
public function isServer($name) {}
/**
* Check if Post has key
* @param string $name key
* @return boolean
*/
public function isPost($name) {}
/**
* Check if Get has key
* @param string $name key
* @return boolean
*/
public function isGet($name) {}
/**
* Check if File has key
* @param string $name key
* @return boolean
*/
public function isFile($name) {}
/**
* Read/Write Request key
* @param string $name key
* @param boolean $blnRaw true mean, no escaping at time of reading
* @param string|array $value null mean read key
* @return string
*/
public function request($name, $blnRaw = false,$value=null) {}
/**
* Read Raw Request Data
* @return string
*/
public function requestStream() {}
/**
* Write/Read Cookie
* @param string $name key
* @param boolean $blnRaw true mean, no escaping at time of reading
* @param string|array $value null mean read key
* @param int $expire
* @param string $path
* @param string $domain
* @param boolean $secure
* @param boolean $httponly
* @return string
*/
public function cookie($name, $value = null, $blnRaw = false,$expire=-1,$path='/', $domain="", $secure=false, $httponly=true) {}
/**
* Advance Function, Internal use
*/
public function restoreSessionFromStorage() {}
/**
* Advance Function, Internal use
*/
public function saveSessionToStorage() {}
/**
* Delete Cookie
* @param string $name key
*/
public function unsetCookie($name) {}
/**
* Delete Session Variable
* @param string $name key
*/
public function unsetSession($name) {}
/**
* Read/Write Session key
* @param string $name key
* @param string|array $value null mean read key
* @return string|array
*/
public function session($name, $value = null) {}
/**
* Advance Function, Internal use
*/
public function setUseServerVariables() {}
/**
* Advance Function, Internal use
*/
public function svar($name, $value = null) {}
/**
* Read $_SERVER key
* @param string $name key
* @return string
*/
public function server($name) {}
/**
* Read $_FILES key
* @param string $name key
* @return string
*/
public function files($name) {}
/**
* Advance Function, Internal use
*/
public function escapetag($str) {}
/**
* Advance Function, Internal use
* @deprecated 4.4.8
*/
public function getEngineRootPath() {}
/**
* Advance Function, Internal use
*/
public function getURLSafe($val) {}
/**
* Advance Function, Internal use
*/
public function getURLSafeRet($val) {}
}
}
