<?php
namespace{
class TempFile extends Sphp\tools\TempFile { }
class Control extends Sphp\tools\Control { }
function getAppPath($ControllerName,$extra="",$newbasePath="",$blnSesID=false){}
function getThisPath($extra="",$blnSesID=false){}
function getEventPath($eventName,$evtp="",$ControllerName="",$extra="",$newbasePath="",$blnSesID=false){}
function getCurrentRequest(){}
function isRegisterCurrentRequest(){}
function registerCurrentRequest($apppath,$s_namespace=""){}
function registerCurrentController($ctrl){}
function registerApp($ctrl,$apppath,$s_namespace=""){}
function isRegisterApp($ctrl){}
function setSession($lType,$uid1){}
function destSession(){}
function addFileLink($fileURL,$renderonce=false,$aname="",$ext="",$ver="0"){}
function updateFileLink($fileURL,$renderonce=false,$aname="",$ext="",$ver="0"){}
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
function endec($str, $ky = "") {}
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
