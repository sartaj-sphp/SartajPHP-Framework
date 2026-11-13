<?php
namespace{
class FrontFile extends Sphp\Tools\FrontFile { }
/**
* Generate URL for a Gate
* @param string $gateParam Gate like index
* @param string $extra <P> Extra query string in URL 
* $extra = 'test=1&mpid=13'
* </p>
* @param string $newprojectUrl <p> new domain url
* $newprojectUrl = 'https://domain.com/test
* </p>
* @param boolean $blnSesID Add session id default false, url expired with session (Gate can allow expired url)
* @param string $ext change url file extension as Gate default empty and use html or set in comp file.
* @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
* @return string The generated URL for the given gate
*/
function getGateUrl($gateParam,$extra="",$newprojectUrl="",$blnSesID=false,$ext='',$noncache=false){}
/**
* Generate URL for Current Gate
* @param string $extra <P> Extra query string in URL 
* $extra = 'test=1&mpid=13'
* </p>
* @param boolean $blnSesID Add session id default false, url expired with session (Gate can allow expired url)
* @param string $ext change url file extension as Gate default empty and use html or set in comp file.
* @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
* @return string The generated URL for the current gate
*/
function getThisGateUrl($extra="",$blnSesID=false,$ext='',$noncache=false){}
/**
* Generate Secure URL for a Event of Gate
* @param string $eventName <p> Name of Event
* class index extends Sphp\Tools\BasicGate{
* public function page_event_test($evtp){
* 
* }
* }
* $eventName = test
* $gateParam = index
* Registered Gate = Gates/index.gate.php
* </p>
* @param string $evtp Event Parameter pass to URL
* @param string $gateParam Gate like index
* @param string $extra <P> Extra query string in URL 
* $extra = 'test=1&mpid=13'
* </p>
* @param string $newprojectUrl <p> new domain url
* $newprojectUrl = 'https://domain.com/test
* </p>
* @param boolean $blnSesID Add session id default false, url expired with session (Gate can allow expired url)
* @param string $ext change url file extension as Gate default empty and use html or set in comp file.
* @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
* @return string The generated secure URL for the given gate event
*/
function getEventUrlSecure($eventName,$evtp="",$gateParam="",$extra="",$newprojectUrl="",$blnSesID=false,$ext='',$noncache=false){}
/**
* Generate URL for a Event of Gate
* @param string $eventName <p> Name of Event
* class index extends Sphp\Tools\BasicGate{
* public function page_event_test($evtp){
* 
* }
* }
* $eventName = test
* $gateParam = index
* Registered Gate = Gates/index.gate.php
* </p>
* @param string $evtp Event Parameter pass to URL
* @param string $gateParam Gate like index
* @param string $extra <P> Extra query string in URL 
* $extra = 'test=1&mpid=13'
* </p>
* @param string $newprojectUrl <p> new domain url
* $newprojectUrl = 'https://domain.com/test
* </p>
* @param boolean $blnSesID Add session id default false, url expired with session (Gate can allow expired url)
* @param string $ext change url file extension as Gate default empty and use html or set in comp file.
* @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
* @return string The generated URL for the given gate event
*/
function getEventUrl($eventName,$evtp="",$gateParam="",$extra="",$newprojectUrl="",$blnSesID=false,$ext='',$noncache=false){}
/**
* Get the current request information
* @return mixed The current request data
*/
function getCurrentRequest(){}
/**
* Check if the current request is registered
* @return boolean True if the current request is registered, false otherwise
*/
function isRegisterCurrentRequest(){}
/**
* Register the current request
* @param string $gateDirPath Path to the gate directory
* @param string $sNamespace Namespace for the gate
* @param string $permtitle Permission title
* @param mixed $permlist Permission list
* @return void
*/
function registerCurrentRequest($gateDirPath,$sNamespace="",$permtitle="",$permlist=null){}
/**
* Register the current gate
* @param string $gate Gate name
* @return void
*/
function registerCurrentGate($gate){}
/**
* Register a gate
* @param string $gate Gate name
* @param string $gateDirPath Path to the gate directory
* @param string $sNamespace Namespace for the gate
* @param string $permtitle Permission title
* @param mixed $permlist Permission list
* @return void
*/
function registerGate($gate,$gateDirPath,$sNamespace="",$permtitle="",$permlist=null){}
/**
* Check if a gate is registered
* @param string $gate Gate name
* @return boolean True if the gate is registered, false otherwise
*/
function isRegisterGate($gate){}
/**
* Set session
* @param string $lType Session type
* @param string $uid1 User ID
* @return void
*/
function setSession($lType,$uid1){}
/**
* Destroy session
* @return void
*/
function destSession(){}
/**
* Add a file link
* @param string $fileURL File URL
* @param boolean $renderonce Render only once
* @param string $aname Anchor name
* @param string $ext File extension
* @param string $ver Version
* @param array $assets Assets array
* @return void
*/
function addFileLink($fileURL,$renderonce=false,$aname="",$ext="",$ver="0",$assets=array()){}
/**
* Update a file link
* @param string $fileURL File URL
* @param boolean $renderonce Render only once
* @param string $aname Anchor name
* @param string $ext File extension
* @param string $ver Version
* @param array $assets Assets array
* @return void
*/
function updateFileLink($fileURL,$renderonce=false,$aname="",$ext="",$ver="0",$assets=array()){}
/**
* Remove a file link
* @param string $fileURL File URL
* @param boolean $renderonce Render only once
* @param string $aname Anchor name
* @param string $ext File extension
* @return void
*/
function removeFileLink($fileURL,$renderonce=false,$aname="",$ext=""){}
/**
* Add a file link with code
* @param string $name Name of the file link
* @param string $code Code to add
* @param boolean $renderonce Render only once
* @return void
*/
function addFileLinkCode($name,$code,$renderonce=false){}
/**
* Check if a file link is set
* @param string $filename File name
* @param string $ext File extension
* @param boolean $renderonce Render only once
* @return boolean True if the file link is set, false otherwise
*/
function issetFileLink($filename, $ext, $renderonce = false) {}
/**
* Check if a header JS function exists
* @param string $funname Function name
* @param string $rendertype Render type
* @return boolean True if the header JS function exists, false otherwise
*/
function isHeaderJsFunctionExist($funname, $rendertype = "private") {}
/**
* Check if a footer JS function exists
* @param string $funname Function name
* @param string $rendertype Render type
* @return boolean True if the footer JS function exists, false otherwise
*/
function isFooterJsFunctionExist($funname, $rendertype = "private") {}
/**
* Add a header JS function
* @param string $funname Function name
* @param string $startcode Start code
* @param string $endcode End code
* @param boolean $renderonce Render only once
* @return void
*/
function addHeaderJsFunction($funname, $startcode, $endcode, $renderonce = false) {}
/**
* Add a footer JS function
* @param string $funname Function name
* @param string $startcode Start code
* @param string $endcode End code
* @param boolean $renderonce Render only once
* @return void
*/
function addFooterJsFunction($funname, $startcode, $endcode, $renderonce = false) {}
/**
* Add a header JS function with code
* @param string $funname Function name
* @param string $name Name of the code
* @param string $code Code to add
* @param boolean $renderonce Render only once
* @return void
*/
function addHeaderJsFunctionCode($funname, $name, $code, $renderonce = false) {}
/**
* Add a footer JS function with code
* @param string $funname Function name
* @param string $name Name of the code
* @param string $code Code to add
* @param boolean $renderonce Render only once
* @return void
*/
function addFooterJsFunctionCode($funname, $name, $code, $renderonce = false) {}
/**
* Add header JS code
* @param string $name Name of the code
* @param string $code Code to add
* @param boolean $renderonce Render only once
* @return void
*/
function addHeaderJsCode($name, $code, $renderonce = false) {}
/**
* Add header CSS
* @param string $name Name of the CSS
* @param string $code CSS code to add
* @param boolean $renderonce Render only once
* @return void
*/
function addHeaderCss($name, $code, $renderonce = false) {}
/**
* Add footer JS code
* @param string $name Name of the code
* @param string $code Code to add
* @param boolean $renderonce Render only once
* @return void
*/
function addFooterJsCode($name, $code, $renderonce = false) {}
/**
* Get header HTML
* @param boolean $htmltag Include HTML tag
* @param boolean $global Include global content
* @param int $blockJSCode Block JS code
* @return string The header HTML
*/
function getHeaderHtml($htmltag=true,$global=true,$blockJSCode = 0){}
/**
* Get footer HTML
* @param boolean $htmltag Include HTML tag
* @param boolean $global Include global content
* @param int $blockJSCode Block JS code
* @return string The footer HTML
*/
function getFooterHtml($htmltag = true, $global = true,$blockJSCode = 0) {}
/**
* Trace error
* @param boolean $blnDontJS Don't use JS
* @return mixed The traced error
*/
function traceError($blnDontJS = false) {}
/**
* Set error
* @param string $name Error name
* @param string $msg Error message
* @return void
*/
function setErr($name, $msg) {}
/**
* Get check error
* @return mixed The check error
*/
function getCheckErr() {}
/**
* Unset check error
* @return void
*/
function unsetCheckErr() {}
/**
* Get error message
* @param string $name Error name
* @return string The error message
*/
function getErrMsg($name) {}
/**
* Trace message
* @param boolean $blnDontJS Don't use JS
* @return mixed The traced message
*/
function traceMsg($blnDontJS = false) {}
/**
* Set message
* @param string $name Message name
* @param string $msg Message
* @return void
*/
function setMsg($name, $msg) {}
/**
* Get message
* @param string $name Message name
* @return string The message
*/
function getMsg($name) {}
/**
* Trace error inner
* @param boolean $blnDontJS Don't use JS
* @return mixed The traced inner error
*/
function traceErrorInner($blnDontJS = false) {}
/**
* Set error inner
* @param string $name Error name
* @param string $msg Error message
* @return void
*/
function setErrInner($name, $msg) {}
/**
* Get error message inner
* @param string $name Error name
* @return string The inner error message
*/
function getErrMsgInner($name) {}
/**
* Set front place path
* @param string $frontname Front name
* @param string $projectUrl Project URL
* @param string $secname Section name
* @return void
*/
function setFrontPlacePath($frontname, $projectUrl, $secname = "left") {}
/**
* Remove front place
* @param string $frontname Front name
* @param string $secname Section name
* @return void
*/
function removeFrontPlace($frontname, $secname = "left") {}
/**
* Add front place
* @param string $frontname Front name
* @param string $filepath File path
* @param string $secname Section name
* @return void
*/
function addFrontPlace($frontname, $filepath = "", $secname = "left") {}
/**
* Get front place
* @param string $frontname Front name
* @param string $secname Section name
* @return mixed The front place
*/
function getFrontPlace($frontname, $secname = "left") {}
/**
* Run front place
* @param string $frontname Front name
* @param string $secname Section name
* @return void
*/
function runFrontPlace($frontname, $secname = "left") {}
/**
* Render front place
* @param string $frontname Front name
* @param string $secname Section name
* @return void
*/
function renderFrontPlace($frontname, $secname = "left") {}
/**
* Render front place manually
* @param string $frontname Front name
* @param string $secname Section name
* @return mixed The rendered front place
*/
function renderFrontPlaceManually($frontname, $secname = "left") {}
/**
* Run front section
* @param string $secname Section name
* @return void
*/
function runFrontSection($secname = "left") {}
/**
* Add and run front section
* @param string $secname Section name
* @return void
*/
function addrunFrontSection($secname = "left") {}
/**
* List not rendered front section
* @param string $secname Section name
* @return void
*/
function ListNotrenderFrontSection($secname = "left") {}
/**
* Render front section
* @param string $secname Section name
* @return void
*/
function renderFrontSection($secname = "left") {}
/**
* Get my resource path
* @param string $filepath File path
* @return string The resource path
*/
function getMyResPath($filepath){}
/**
* 
* @param string $str
* @param string $ky secure key in hexa decimal
* @return string
*/
function endec($str, $ky = "CD098ABA") {}
/**
* Check if a value is a valid number
* @param mixed $val Value to check
* @param string $datatype Data type
* @return boolean True if the value is a valid number, false otherwise
*/
function isValidNum($val,$datatype){}
/**
* Check if an email is valid
* @param string $email Email to check
* @return boolean True if the email is valid, false otherwise
*/
function isValidEmail($email){}
/**
* Get keyword
* @return string The keyword
*/
function getKeyword(){}
/**
* Generate auto text
* @param string $para Paragraph
* @param int $paraRepeated Number of times to repeat
* @param int $startIndex Start index
* @return string The generated auto text
*/
function genAutoText($para,$paraRepeated=1,$startIndex=1){}
/**
* Stop output
* @return void
*/
function stopOutput(){}
}
