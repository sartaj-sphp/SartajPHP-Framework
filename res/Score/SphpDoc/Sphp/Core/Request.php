<?php
namespace Sphp\Core{
/**
* Request class
*
* Represents the incoming HTTP request. It exposes request metadata such as
* method, mode, protocol, URI and type, and provides access to GET, POST,
* REQUEST, COOKIE, SESSION, SERVER and FILES data. It also handles secure
* (tamper-protected) cookies, session persistence to storage/cookies, and
* HTML tag escaping for request values.
*/
class Request {
/** @var string $method Request Method */
public $method = "";
/** @var string $mode Default SERVER OR CLI or CGI */
public $mode = "SERVER"; 
/** @var string $protocol Request Protocol */
public $protocol = "";
/** @var boolean $blnsecure Request SSL */
public $blnsecure = false;
/** @var string $uri Request URI */
public $uri = "";
/** @var string $scriptPath Engine Script Path */
public $scriptPath = "";
/** @var array $argv Command Line Arguments */
public $argv = array();
/** @var string $type Request Type Default NORMAL or AJAX or SOAP */
public $type = "NORMAL"; 
/** @var boolean $isNativeClient true if Gate embed with browser  */
public $isNativeClient = false;
/**
* Constructor
*
* Loads the application settings into the request.
* @return void
*/
/**
* Get All Request Headers
* @return array()
*/
public function getClientHeaders() {}
/**
* Advance Function, Internal use
* @return void
*/
public function parseRequest() {}
/**
* True if Application run with SphpServer Mode or Browser embed mode 
* False on Web Server Mode or Console Mode
* @return boolean
*/
public function isNativeApp() {}
/**
* Check if client request is AJAX Base or Server are ready to reply as AJAX JSON.
* @return boolean 
*/
public function isAjax() {}
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
* Write/Read Cookie with tamper protection. Bad cookie return empty value.
* @param string $name key
* @param boolean $blnRaw true mean, no escaping at time of reading
* @param string|array $value null mean read key
* @param int $expire
* @param string $path
* @param string $domain
* @param boolean $secure
* @param boolean $httponly
* @param string $prefix
* @return string
*/
public function cookieSecure($name, $value = null, $blnRaw = false,$expire=-1,$path='/', $domain="", $secure=false, $httponly=true,$prefix="") {}
/**
* Advance Function, Internal use
* @return void
*/
public function restoreSessionFromStorage() {}
/**
* Advance Function, Internal use
* @return void
*/
public function saveSessionToStorage() {}
/**
* Delete Cookie
* @param string $name key
* @return void
*/
public function unsetCookie($name) {}
/**
* Delete Session Variable
* @param string $name key
* @return void
*/
public function unsetSession($name) {}
/**
* Destroy All Session Data
* @return void
*/
public function destroySession() {}
/**
* Read/Write Session key
* @param string $name key
* @param string|array $value null mean read key
* @return string|array
*/
public function session($name, $value = null) {}
/**
* Advance Function, Internal use
* @return void
*/
public function setUseServerVariables() {}
/**
* Advance Function, Internal use
* @param string $name key
* @param string|array $value null mean read key
* @return string|array
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
* @param string|array $str
* @return string|array
*/
public function escapetag($str) {}
/**
* Advance Function, Internal use
* @deprecated 4.4.8
* @return string
*/
public function getEngineRootPath() {}
/**
* Advance Function, Internal use
* @param string $val
* @return string
*/
public function getUrlSafe($val) {}
/**
* Advance Function, Internal use
* @param string $val
* @return string
*/
public function getUrlSafeRet($val) {}
}
}
