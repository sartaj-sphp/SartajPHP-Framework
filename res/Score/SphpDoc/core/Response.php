<?php
namespace Sphp\core{
class Response {
public function __construct() {}
/**
* Advance Function, Internal use
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
*/
public function addSecurityHeaders($policy = array(),$policyExtra="",$reportURL="") {}
/**
* Advance Function, Internal use
*/
public function setContent($data){}
/**
* Advance Function, Internal use
*/
public function getContent(){}
/**
* Set Status Code of Server
* @param int $code
*/
public function setStatusCode($code){}
/**
* Read Status Code of Server
* @return int
*/
public function getStatusCode(){}
/**
* Add HTTP Header and send to browser
* SphpBase::sphp_response()->addHttpHeader("Cache-control", "public, max-age=864000, must-revalidate");
* @param string $key
* @param string $val
* @param int $statuscode
*/
public function addHttpHeader($key,$val,$statuscode=0) {}
/**
* Remove HTTP Header from Response
* SphpBase::sphp_response()->removeHttpHeader("Cache-control")
* @param string $key
*/
public function removeHttpHeader($key) {}
/**
* Get All Response Headers
* @return array
*/
public function getHeader() {}
/**
* Advance Function, Internal use
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
*/
public function setCookie($name,$value="",$expire=-1,$path='/',$domain="",$secure=false,$httponly=false) {}
/**
* Advance Function, Internal use
*/
public function send($sendheader=true) {}
}
}
