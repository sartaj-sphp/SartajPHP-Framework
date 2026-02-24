<?php
namespace Sphp\core {
class Router {
/** @var string $url_extension extension use in URL default is .html */
public $url_extension = ".html";
/** @var string $act Gate Action */
public $act = "";
/** @var string $sact Gate Event */
public $sact = "";
/** @var string $evtp Gate Event Parameter */
public $evtp = "";
/** @var string $gate Current Request Gate */
public $gate = "";
/** @var string $uri Request URI */
public $uri = "";
/**
* Advance Function, Internal use
*/
public function route() {}
/**
* Get Current Request Gate
* @return string
*/
public function getCurrentRequest() {}
/**
* Check if any Gate registered with current request
* @return boolean
*/
public function isRegisterCurrentRequest() {}
/**
* Register Current Request with Gate
* @param string $gate_dir_path Gate file path like Gates/index.Gate
* @param string $s_namespace Optional Namespace if any
* @param string $permtitle Title Display in Permission List
* @param array $permlist Create Permissions List for Gate
*/
public function registerCurrentRequest($gate_dir_path, $s_namespace = "",$permtitle="",$permlist=null) {}
/**
* Register Current Request with different App Gate
* @param string $gate <p>
* registerCurrentGate('home')
* </p>
*/
public function registerCurrentGate($gate) {}
public function isRootURI() {}
/**
* Get Registered Gate Path details of Current Request
* @return array
*/
public function getCurrentGatePath() {}
/**
* Get Registered Gate Path details
* @param string $gate Gate
* @return array
*/
public function getGatePath($gatea2) {}
/**
* Generate URL for a Gate
* @param string $gate_param Gate like index
* @param string $extra <P> Extra query string in URL 
* $extra = 'test=1&mpid=13'
* </p>
* @param string $newbasePath <p> new domain url
* $newbasePath = 'https://domain.com/test
* </p>
* @param boolean $blnSesID Add session id default false
* @param string $ext change url file extension as Gate default empty and use html or set in comp file.
* @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
* @return string
*/
public function getGateURL($gate_param, $extra = "", $newbasePath = "", $blnSesID = false,$ext='',$noncache=false) {}
/**
* Generate URL for Current Gate
* @param string $extra <P> Extra query string in URL 
* $extra = 'test=1&mpid=13'
* </p>
* @param boolean $blnSesID Add session id default false
* @param string $ext change url file extension as Gate default empty and use html or set in comp file.
* @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
* @return string
*/
public function getThisGateURL($extra = "", $blnSesID = false,$ext='',$noncache=false) {}
/**
* Generate Secure Event URL for a Event Parameter of Gate. 
* If you try tamper the URL Event Parameter then it gives empty event parameter value. If you need 
* to pass other value also secure then you need to manually secure with function
* val2Secure function and restore back with secure2Val function. By default event parameter
* automatically convert by SartajPHP.
* @param string $eventName <p> Name of Event
* class index extends Sphp\tools\BasicGate{
* public function page_event_test($evtp){
* 
* }
* }
* $eventName = test
* $gate_param = index
* Registered Gate File = Gates/index.Gate
* </p>
* @param string $evtp Event Parameter pass to URL
* @param string $gate_param Gate like index
* @param string $extra <P> Extra query string in URL 
* $extra = 'test=1&mpid=13'
* </p>
* @param string $newbasePath <p> new domain url
* $newbasePath = 'https://domain.com/test
* </p>
* @param boolean $blnSesID Add session id default false, url expired with session (Gate can allow expired url)
* @param string $ext change url file extension as Gate default empty and use html or set in comp file.
* @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
* @return string
*/
public function getEventURLSecure($eventName, $evtp = "", $gate_param = "", $extra = "", $newbasePath = "", $blnSesID = false,$ext='',$noncache=false) {}
/**
* Generate URL for a Event of Gate
* @param string $eventName <p> Name of Event
* class index extends Sphp\tools\BasicGate{
* public function page_event_test($evtp){
* 
* }
* }
* $eventName = test
* $gate_param = index
* Registered Gate = Gates/index.Gate
* </p>
* @param string $evtp Event Parameter pass to URL
* @param string $gate_param Gate like index
* @param string $extra <P> Extra query string in URL 
* $extra = 'test=1&mpid=13'
* </p>
* @param string $newbasePath <p> new domain url
* $newbasePath = 'https://domain.com/test
* </p>
* @param boolean $blnSesID Add session id default false, url expired with session (Gate can allow expired url)
* @param string $ext change url file extension as Gate default empty and use html or set in comp file.
* @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
* @return string
*/
public function getEventURL($eventName, $evtp = "", $gate_param = "", $extra = "", $newbasePath = "", $blnSesID = false,$ext='',$noncache=false) {}
/**
* Advance Function, Internal use
* @param string $evt
* @param string $evtp
*/
public function setEventName($evt, $evtp = "") {}
}
}
