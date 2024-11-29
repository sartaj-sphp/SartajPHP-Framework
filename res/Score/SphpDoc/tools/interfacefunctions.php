<?php
namespace{
class TempFile extends Sphp\tools\TempFile { }
class Control extends Sphp\tools\Control { }
/**
* Use getAppURL rather then this
* @deprecated since version 4.8.4
*/
function getAppPath($ControllerName,$extra="",$newbasePath="",$blnSesID=false,$ext='',$noncache=false){}
/**
* Use getThisURL rather then this
* @deprecated since version 4.8.4
*/
function getThisPath($extra="",$blnSesID=false,$ext='',$noncache=false){}
/**
* Use getEventURL rather then this
* @deprecated since version 4.8.4
*/
function getEventPath($eventName,$evtp="",$ControllerName="",$extra="",$newbasePath="",$blnSesID=false,$ext='',$noncache=false){}
/**
* Generate URL for a Controller
* @param string $ControllerName controller like index
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
function getAppURL($ControllerName,$extra="",$newbasePath="",$blnSesID=false,$ext='',$noncache=false){}
/**
* Generate URL for Current Application
* @param string $extra <P> Extra query string in URL 
* $extra = 'test=1&mpid=13'
* </p>
* @param boolean $blnSesID Add session id default false, url expired with session (App can allow expired url)
* @param string $ext change url file extension as app default empty and use html or set in comp file.
* @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
* @return string
*/
function getThisURL($extra="",$blnSesID=false,$ext='',$noncache=false){}
/**
* Generate URL for a Event of Application
* @param string $eventName <p> Name of Event
* class index extends Sphp\tools\BasicApp{
* public function page_event_test($evtp){
* 
* }
* }
* $eventName = test
* $controllerName = index
* Registered Application = apps/index.app
* </p>
* @param string $evtp Event Parameter pass to URL
* @param string $ControllerName controller like index
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
function getEventURL($eventName,$evtp="",$ControllerName="",$extra="",$newbasePath="",$blnSesID=false,$ext='',$noncache=false){}
function getCurrentRequest(){}
function isRegisterCurrentRequest(){}
function registerCurrentRequest($apppath,$s_namespace="",$permtitle="",$permlist=null){}
function registerCurrentController($ctrl){}
function registerApp($ctrl,$apppath,$s_namespace="",$permtitle="",$permlist=null){}
function isRegisterApp($ctrl){}
function setSession($lType,$uid1){}
function destSession(){}
function addFileLink($fileURL,$renderonce=false,$aname="",$ext="",$ver="0",$assets=array()){}
function updateFileLink($fileURL,$renderonce=false,$aname="",$ext="",$ver="0",$assets=array()){}
function removeFileLink($fileURL,$renderonce=false,$aname="",$ext=""){}
function addFileLinkCode($name,$code,$renderonce=false){}
function issetFileLink($filename, $ext, $renderonce = false) {}
function isHeaderJSFunctionExist($funname, $rendertype = "private") {}
function isFooterJSFunctionExist($funname, $rendertype = "private") {}
function addHeaderJSFunction($funname, $startcode, $endcode, $renderonce = false) {}
function addFooterJSFunction($funname, $startcode, $endcode, $renderonce = false) {}
function addHeaderJSFunctionCode($funname, $name, $code, $renderonce = false) {}
function addFooterJSFunctionCode($funname, $name, $code, $renderonce = false) {}
function addHeaderJSCode($name, $code, $renderonce = false) {}
function addHeaderCSS($name, $code, $renderonce = false) {}
function addFooterJSCode($name, $code, $renderonce = false) {}
function getHeaderHTML($htmltag=true,$global=true,$blockJSCode = 0){}
function getFooterHTML($htmltag = true, $global = true,$blockJSCode = 0) {}
function traceError($blnDontJS = false) {}
function setErr($name, $msg) {}
function getCheckErr() {}
function unsetCheckErr() {}
function getErrMsg($name) {}
function traceMsg($blnDontJS = false) {}
function setMsg($name, $msg) {}
function getMsg($name) {}
function traceErrorInner($blnDontJS = false) {}
function setErrInner($name, $msg) {}
function getErrMsgInner($name) {}
function setFrontPlacePath($frontname, $basepath, $secname = "left", $type = "TempFile") {}
function removeFrontPlace($frontname, $secname = "left") {}
function addFrontPlace($frontname, $filepath = "", $secname = "left", $type = "TempFile") {}
function getFrontPlace($frontname, $secname = "left") {}
function runFrontPlace($frontname, $secname = "left") {}
function renderFrontPlace($frontname, $secname = "left") {}
function runFrontSection($secname = "left") {}
function addrunFrontSection($secname = "left") {}
function ListNotrenderFrontSection($secname = "left") {}
function renderFrontSection($secname = "left") {}
function encrypt($string, $key = "BA007231") {}
function decrypt($string, $key = "BA007231") {}
function endec($str, $ky = "CD098ABA") {}
function is_valid_num($val,$datatype){}
function is_valid_email($email){}
function executePHPScript($strPHPScript) {}
function executePHPCode($strPHPCode,$blnNoGlobal=true) {}
function executePHP($strPHPCode) {}
function executePHPGlobal($strPHPCode) {}
function executePHPFunc($strPHPCode) {}
function getKeyword(){}
function genAutoText($para,$paraRepeated=1,$startIndex=1){}
function stopOutput(){}
}
