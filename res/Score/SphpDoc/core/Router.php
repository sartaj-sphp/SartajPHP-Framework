<?php
namespace Sphp\core {
class Router {
/** @var string $url_extension extension use in URL default is .html */
public $url_extension = ".html";
/** @var string $act Appgate Action */
public $act = "";
/** @var string $sact Appgate Event */
public $sact = "";
/** @var string $evtp Appgate Event Parameter */
public $evtp = "";
/** @var string $ctrl Current Request Appgate */
public $ctrl = "";
/** @var string $uri Request URI */
public $uri = "";
/**
* Advance Function, Internal use
*/
public function route() {}
/**
* Get Current Request Appgate
* @return string
*/
public function getCurrentRequest() {}
/**
* Check if any application registered with current request
* @return boolean
*/
public function isRegisterCurrentRequest() {}
/**
* Register Current Request with Application
* @param string $apppath Application file path like apps/index.app
* @param string $s_namespace Optional Namespace if any
* @param string $permtitle Title Display in Permission List
* @param array $permlist Create Permissions List for application
*/
public function registerCurrentRequest($apppath, $s_namespace = "",$permtitle="",$permlist=null) {}
/**
* Register Current Request with different Appgate
* @param string $ctrl <p>
* registerCurrentAppgate('home')
* </p>
*/
public function registerCurrentAppgate($ctrl) {}
public function isRootURI() {}
/**
* Get Registered Application FilePath details of Current Request
* @return array
*/
public function getCurrentAppPath() {}
/**
* Get Registered Application FilePath details
* @param string $ctrl Appgate
* @return array
*/
public function getAppPath($ctrla2) {}
/**
* Generate URL for a Appgate
* @param string $AppgateName Appgate like index
* @param string $extra <P> Extra query string in URL 
* $extra = 'test=1&mpid=13'
* </p>
* @param string $newbasePath <p> new domain url
* $newbasePath = 'https://domain.com/test
* </p>
* @param boolean $blnSesID Add session id default false
* @param string $ext change url file extension as app default empty and use html or set in comp file.
* @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
* @return string
*/
public function getAppURL($AppgateName, $extra = "", $newbasePath = "", $blnSesID = false,$ext='',$noncache=false) {}
/**
* Generate URL for Current Application
* @param string $extra <P> Extra query string in URL 
* $extra = 'test=1&mpid=13'
* </p>
* @param boolean $blnSesID Add session id default false
* @param string $ext change url file extension as app default empty and use html or set in comp file.
* @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
* @return string
*/
public function getthisURL($extra = "", $blnSesID = false,$ext='',$noncache=false) {}
/**
* Generate Secure Event URL for a Event of Application
* @param string $eventName <p> Name of Event
* class index extends Sphp\tools\BasicApp{
* public function page_event_test($evtp){
* 
* }
* }
* $eventName = test
* $AppgateName = index
* Registered Application = apps/index.app
* </p>
* @param string $evtp Event Parameter pass to URL
* @param string $AppgateName Appgate like index
* @param string $extra <P> Extra query string in URL 
* $extra = 'test=1&mpid=13'
* </p>
* @param string $newbasePath <p> new domain url
* $newbasePath = 'https://domain.com/test
* </p>
* @param boolean $blnSesID Add session id default false, url expired with session (App can allow expired url)
* @param string $ext change url file extension as app default empty and use html or set in comp file.
* @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
* @return string
*/
public function getEventURLSecure($eventName, $evtp = "", $AppgateName = "", $extra = "", $newbasePath = "", $blnSesID = false,$ext='',$noncache=false) {}
/**
* Generate URL for a Event of Application
* @param string $eventName <p> Name of Event
* class index extends Sphp\tools\BasicApp{
* public function page_event_test($evtp){
* 
* }
* }
* $eventName = test
* $AppgateName = index
* Registered Application = apps/index.app
* </p>
* @param string $evtp Event Parameter pass to URL
* @param string $AppgateName Appgate like index
* @param string $extra <P> Extra query string in URL 
* $extra = 'test=1&mpid=13'
* </p>
* @param string $newbasePath <p> new domain url
* $newbasePath = 'https://domain.com/test
* </p>
* @param boolean $blnSesID Add session id default false, url expired with session (App can allow expired url)
* @param string $ext change url file extension as app default empty and use html or set in comp file.
* @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
* @return string
*/
public function getEventURL($eventName, $evtp = "", $AppgateName = "", $extra = "", $newbasePath = "", $blnSesID = false,$ext='',$noncache=false) {}
/**
* Advance Function, Internal use
* @param string $evt
* @param string $evtp
*/
public function setEventName($evt, $evtp = "") {}
}
}
