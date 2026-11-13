<?php
namespace Sphp\Core{
/**
* Response class
*
* Represents the HTTP response sent back to the browser. It manages the
* response method, status code, body content, HTTP headers and cookies.
* It can also generate and apply browser security policies (CSP, HSTS,
* frame options, etc.) and serialize the response either as plain HTML
* or as a HEX-encoded JSON payload depending on the configured
* response method.
*/
class Response {
/**
* Constructor
*
* Initializes the response by calling the internal init method.
* @return void
*/
/**
* Advance Function, Internal use
* @return void
*/
public function init(){}
/**
* Generate Security Policy for Browser
* @param string $extrahost host list
* @param string $extrawshost Web Socket host list
* @return array
*/
public function getSecurityPolicy($extrahost="",$extrawshost="") {}
/**
* Add Security Policy into Browser
* @param array $policy
* @param string $policyExtra
* @param string $reportURL error reporting url
* @return void
*/
public function addSecurityHeaders($policy = array(),$policyExtra="",$reportURL="") {}
/**
* Advance Function, Internal use
* @param mixed $data
* @return void
*/
public function setContent($data){}
/**
* Advance Function, Internal use
* @return mixed
*/
public function getContent(){}
/**
* Set Status Code of Server
* @param int $code
* @return void
*/
public function setStatusCode($code){}
/**
* Read Status Code of Server
* @return int
*/
public function getStatusCode(){}
/**
* Add HTTP Header and send to browser
* SphpBase::sphpResponse()->addHttpHeader("Cache-control", "public, max-age=864000, must-revalidate");
* @param string $key
* @param string $val
* @param int $statuscode
* @return void
*/
public function addHttpHeader($key,$val,$statuscode=0) {}
/**
* Remove HTTP Header from Response
* SphpBase::sphpResponse()->removeHttpHeader("Cache-control")
* @param string $key
* @return void
*/
public function removeHttpHeader($key) {}
/**
* Get All Response Headers
* @return array
*/
public function getHeader() {}
/**
* Get All Response Cookies
* @return array
*/
public function getCookie() {}
/**
* Advance Function, Internal use
* @return void
*/
public function sendHeaders() {}
/**
* Write Cookie
* @param string $name key
* @param string $value
* @param int $expire -1 mean calculate expire time
* @param string $path
* @param string $domain
* @param boolean $secure
* @param boolean $httponly
* @return void
*/
public function setCookie($name,$value="",$expire=-1,$path='/',$domain="",$secure=false,$httponly=false) {}
/**
* Save Response Data into Cache File
* @param string $data
* @return void
*/
/**
* Sanitize HTML Output Buffer
* @param string $buffer
* @return string
*/
/**
* Advance Function, Internal use
* @param boolean $sendheader
* @return void
*/
public function send($sendheader=true) {}
}
}
