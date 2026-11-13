<?php
namespace Sphp\Core {
/**
* SphpApi provides the core API services for the SartajPHP framework.
* It manages gate registration, caching, file links, JS/CSS code generation,
* error handling, front places, menus, reflection helpers, and various
* utility functions used throughout the framework.
*/
class SphpApi {
public $errStatus = false;
/**
* Advance function, Internal use
* @ignore
*/
/**
* Advance function, Internal use
* @ignore
*/
public function init() {}
/**
* Register FrontFile
* @param string $key name of frontfile
* @param \Sphp\Tools\FrontFile $obj FrontFile Object
*/
public function registerFrontFile($key, $obj) {}
/**
* Add Property into property bag. It is good to use, rather then global variables
* @param string $name Name for identification
* @param mixed $obj Any valid PHP Object or Data Type
*/
public function addProp($name, $obj) {}
/**
* Read proprty from property bag
* @param string $name Name for identification
* @return string|mixed
*/
public function getProp($name) {}
/**
* Add menu in menu list <p>
* SphpBase::sphpApi()->addMenu("Live Chat",getEventUrl("page","chat","index"),"fa fa-commenting","root",false,"index-chat-view");
* SphpBase::sphpApi()->addMenu("Debug", "","fa fa-home","root");
* SphpBase::sphpApi()->addMenuLink("Debug", 'javascript: debugApp();',"","Debug",true,"","f7");
* These all features are depend on renderer, customize renderer may be not support all fetaures.
* </p>
* @param string $text name of menu
* @param string $link Optional URL show in html tag
* @param string $icon Optional CSS class of icon
* @param string $parent Optional parent name for menu as sub menu, default is root
* @param boolean $ajax Optional if true then use AJAX request
* @param string $roles Optional <p>
* comma separated list for user Authentication types or permissions, if match then menu display in HTML code 
* </p>
* @param string $akey Optional keyboard shortcut <p>
* SphpBase::sphpApi()->addMenuLink("Debug", 'javascript: debugApp();',"","Debug",true,"","f7");
* f7 is keyboard shortcut. v,alt+shift = press v + alt + shift key
* </p>
* @param array $settings Optional <p>
* Extra data pass to renderer as associative array
* </p>
*/
public function addMenu($text, $link = "", $icon = "", $parent = "root", $ajax = false, $roles = "", $akey = "", $settings = null) {}
/**
* Add menu link in menu <p>
* SphpBase::sphpApi()->addMenu("Live Chat",getEventUrl("page","chat","index"),"fa fa-commenting","root",false,"index-chat-view");
* SphpBase::sphpApi()->addMenu("Debug", "","fa fa-home","root");
* SphpBase::sphpApi()->addMenuLink("Debug", 'javascript: debugApp();',"","Debug",true,"","f7");
* These all features are depend on renderer, customize renderer may be not support all fetaures.
* </p>
* @param string $text name of menulink
* @param string $link Optional URL show in html tag
* @param string $icon Optional CSS class of icon
* @param string $parent Optional parent name for menulink, default is root
* @param boolean $ajax Optional if true then use AJAX request
* @param string $roles Optional <p>
* comma separtaed list for user Authentication types or permissions, if match then menulink display in HTML code 
* </p>
* @param string $akey Optional keyboard shortcut <p>
* SphpBase::sphpApi()->addMenuLink("Debug", 'javascript: debugApp();',"","Debug",true,"","f7");
* f7 is keyboard shortcut. v,alt+shift = press v + alt + shift key
* </p>
* @param array $settings Optional <p>
* Extra data pass to renderer as associative array
* </p>
*/
public function addMenuLink($text, $link = "", $icon = "", $parent = "root", $ajax = false, $roles = "", $akey = "", $settings = null) {}
/**
* Ban Menu from list, it will not display
* @param string $text menu name
* @param string $parent Optional menu parent
*/
public function banMenu($text, $parent = "root") {}
/**
* Ban Menulink from list, it will not display
* @param string $text menu name
* @param string $parent Optional menu parent
*/
public function banMenuLink($text, $parent = "root") {}
/**
* Get All Menu List from parent menu
* @param string $parent Optional menu parent
* @return array|null
*/
public function getMenuList($parent = "root") {}
/**
* Get All Menulink List from parent menu
* @param string $parent Optional menu parent
* @return array|null
*/
public function getMenuLinkList($parent = "root") {}
/**
* Save Data in Cache
* @param string $filename give unique file name to identify 
* @param array|object $data Data to save in Cache
* @return boolean on error return false
*/
public function saveToCache($filename,$data) {}
/**
* Clear Data from Cache if exist. If $filename is * then it will clear all files from cache.
* @param string $filename unique file name as identification
* @return bool true if clear
*/
public function clearCache($filename) {}
/**
* Read Data from Cache if exist. It will not check isCacheExpired.
* @param string $filename unique file name as identification
* @return array|object on error return empty array
*/
public function getFromCache($filename) {}
/**
* Read Data from Cache if exist and not expired, also check expiry
* @param string $filename unique file name as identification
* @param int $ttl time in seconds, -1 mean never expired
* @return null|object on error or expired cache it will return null
*/
public function readFromCache($filename,$ttl) {}
/**
*  Check Cache is Expired
* @param string $filename unique file name as ID
* @param int $ttl time in seconds, -1 mean never expired
* @return bool return true when expired
*/
public function isCacheExpired($filename, $ttl) {}
/**
* Register file with App Gate Name
* @param string $gate Name of Gate assigned to Gate
* @param string $gateDirPath <p>
* Attach Gate path. 
* Path end with .php is module Gate 
* and path end with .gate.php is class Gate. 
* Filename should match with class name
* </p>
* @param string $sNamespace if class Gate is under a name space
* @param string $permtitle Title Display in Permission List
* @param array $permlist Create Permissions List for Gate
*/
public function registerGate($gate, $gateDirPath, $sNamespace = "",$permtitle="",$permlist=null) {}
/**
* Check Gate is registered
* @param string $gate
* @return boolean
*/
public function isRegisterGate($gate) {}
/**
* Get Gate Path that is registered with Gate name $gate 
* @param string $gate
* @return array
*/
public function getGatePath($gate) {}
/**
* Get List of Registered Gates 
* @return array
*/
public function getRegisteredGates() {}
/**
* Get Gate name that has matched file path with $gateFilePath
* @param string $gateFilePath
* @return string|null
*/
public function getRegisteredGate($gateFilePath) {}
/**
* Get Root folder path of a path. 
* It may be inside res folder or project folder.
* Return SphpBase::sphpSettings()->resourcePath or PROJ_PATH
* @param string $val path to check
* @return string
*/
public function getRootPath($val) {}
/**
* Convert URL to local server filepath 
* $a = SphpBase::sphpApi->resourceUrlToFilepath("../res/jslib/twitter/bootstarp4/main.css")
* @param string $fileurl
* @return array pathinfo,directory,url path,filepath
*/
public function resourceUrlToFilepath($fileurl) {}
/**
* Convert filepath to URL path for browser
* $a = SphpBase::sphpApi->filepathToRespaths("Gates/chat/index.gate.php")
* @param string $filepath
* @return array pathinfo,directory,url path,filepath
*/
public function filepathToRespaths($filepath) {}
public function getMyResPath($filepath){}
/**
*  Get Gate Class Name From PATHINFO_FILENAME of pathinfo
*  It will return class name without second extension as type and remove it.
*  basename as Index.gate.php will return "Index" as class name. gate is just 
*  naming convention for developer help to differentiate file task. 
*  @param string $filename
*/
public function getClassTypeName($filename) {}
/**
* Run Class type Gate
* @param string $path
*/
public function runGate($path) {}
/**
* Create Gate object from $path as filepath
* @param string $path
* @return \Sphp\Core\formname
*/
public function getGateObject($path) {}
/**
* 
* @param string $filepath Gate Path
* @param boolean $setEnv Default true = set Gate_gateDirPath variable
* @return type
*/
public function getRegisterGateClass($filepath, $setEnv = true) {}
/**
* Read Global Variable
* @param string $varname
* @return mixed
*/
public function getGlobal($varname) {}
/**
* Write Global Variable
* @param string $varname
* @param mixed $val value to set
*/
public function setGlobal($varname, $val) {}
/**
* Set Error Status Flag. 
* @param string $msg No Use
*/
public function raiseError($msg) {}
/**
* Print Message with end Line(br) in HTML
* @param string $str
*/
public function println($str) {}
/**
* Convert Bool to Int
* @param boolean $boolean1
* @return int
*/
public function boolToInt($boolean1) {}
/**
* Convert Bool to Yes,No
* @param boolean $boolean1
* @return string
*/
public function boolToYesNo($boolean1) {}
/**
* Convert Bool to String True,False
* @param boolean $boolean1
* @return string
*/
public function boolToString($boolean1) {}
/**
* Convert True,False to Bool
* @param string $str
* @return boolean
*/
public function stringToBool($str) {}
/**
* Search exact match of Needle in array values as case insensitive 
* @param string $needle
* @param array $haystack
* @return boolean
*/
public function inArrayi($needle, $haystack) {}
/**
* Search Needle as array match anywhere in haystack as case insensitive 
* @param string $haystack
* @param array $needle
* @return boolean
*/
public function arraySearchStr( $haystack,$needle) {}
/**
* Search Needle match anywhere in haystack and return line number
* @param string $haystack
* @param string $needle
* @return int line number
*/
public function find_line_number($haystack,$needle) {}
/**
* Change Case of Values in array
* @param array $arr
* @param string $case1 Default strtolower other value = strtoupper
* @return array
*/
public function arrayChangeValCase($arr, $case1 = "") {}
/**
* Search first match of Needle in array as case insensitive 
* @param type $needle
* @param type $haystack
* @return int|string|false return key
*/
public function arraySearchI($needle, $haystack) {}
/**
* Return IP Value of Client
* @return String <br>
* @author Sartaj Singh 
*
*/
public function getIp() {}
/**
* Return Client Details IP, Request method, url,protocol,referer,browser
* ret = SphpBase::sphpApi()->getGuestDetails();
* echo ret["ip"]; <br>
* echo ret["method"] ;<br>
* echo  ret["uri"] ;<br>
* echo ret["protocol"];<br>
* echo  ret["referer"] ;<br>
* echo  ret["agent"] ;<br>
* @author Sartaj Singh 
* @return array <br>
*
*/
public function getGuestDetails() {}
/**
* Return Client location: city country
* echo ipDetail["city"];<br>
* echo ipDetail["country"];<br>
* echo ipDetail["country_code"];<br>
* this function use http://hostip.info/ website api for conversion
* @author Sartaj Singh 
* @return array <br>
*
*/
public function getIpDetail() {}
/**
* Check if string is a number
* @param string $val
* @param string $datatype default FLOAT other value is INT
* @return boolean
*/
public function isValidNum($val, $datatype = "FLOAT") {}
public function getEngine() {}
/**
* Check valid email format
* @param string $email
* @return boolean
*/
public function isValidEmail($email) {}
/**
* Generate JS Array code for PHP Array
* @param string $jsVarName JS Array variable name in code
* @param array $phpArray
* @return string
*/
public function getJsArray($jsVarName, $phpArray, $novar=false) {}
/**
* Generate JS Associative Array code for PHP Array
* @param string $jsVarName JS Associative Array variable name in code
* @param array $phpArray
* @return string
*/
public function getJsArrayAss($jsVarName, $phpArray, $novar=false) {}
/**
* Convert HTML string into JS string
* @param string $strHTML
* @return string
*/
public function HtmlToJs($strHTML) {}
/**
* Get SartajPhp Version
* @return String
*/
public function getSartajPhp() {}
public function getSartajPhpVer() {}
public function setServLanguage($val) {}
public function getServLanguage() {}
public function isDebugMode() {}
/**
* Get string from php content
* @param string $filepath filepath or string
* @param object $caller variable pass as object or array to use inside content as $caller->myprop
* @param bool $stringpass $filepath as string
* @return string
*/
public function getDynamicContent($filepath,$caller=null,$stringpass=false) {}
/**
* Minify Php code string
* @param string $filedata
* @return string
*/
public function minifyPhp($filedata) {}
/**
* Minify Css code string
* @param string $filedata
* @return string
*/
public function minifyCss($filedata) {}
/**
* Minify HTML code string
* @param string $filedata
* @return string
*/
public function minifyHtml($filedata) {}
/**
* Minify JS code string
* @param string $filedata
* @return string
*/
public function minifyJs($filedata) {}
/**
* Safe write file
* @param string $filepath file path
* @param string|mixed $data content to write in file
* @return int| Exception
*/
public function safeWriteFile($filepath, $data) {}
/**
* Trigger Error
* SphpBase::sphpApi()->triggerError("Couldn't get any result from database", E_USER_NOTICE,debug_backtrace())
* @param type $msg Error Message
* @param type $errType Default E_USER_NOTICE
* @param array $debugArray 
*/
public function triggerError($msg, $errType, $debugArray) {}
/**
* Advance Function, Internal use
* @param boolean $renderonce Default false
* @return string
*/
public function getrenderType($renderonce = false) {}
/**
* Add CSS, JS File Link for browser 
* SphpBase::sphpApi()->addFileLink("front/default/theme-black.css",true,"","","2.7")
* SphpBase::sphpApi()->addFileLink("front/default/theme-black.js",false,"black1","js","2.7")
* @param string $fileURL URL for file
* @param boolean $renderonce Optional default false if true then file ignore in AJAX request
* @param string $filename Optional file identification key. default=filename in fileurl
* @param string $ext Optional default=file extension in fileurl
* @param string $ver Optional default=0 file version if any
* @param array $assets path for asset folders to copy with this file when distribute
* @param int $async Default=global file setting, 2=defer, 1= async and 0=default
*/
public function addFileLink($fileURL, $renderonce = false, $filename = "", $ext = "", $ver = "0",$assets=array(),$async=0) {}
/**
* Update CSS, JS File Link for browser 
* SphpBase::sphpApi()->updateFileLink("front/default/theme-black2.js",false,"black1","js","2.8")
* @param string $fileURL URL for file
* @param boolean $renderonce Optional default false if true then file ignore in AJAX request
* @param string $filename Optional file identification key. default=filename in fileurl
* @param string $ext Optional default=file extension in fileurl
* @param string $ver Optional default=0 file version if any
* @param array $assets path for asset folders to copy with this file when distribute
* @param int $async Default=global file setting, 2=defer, 1= async and 0=default
*/
public function updateFileLink($fileURL, $renderonce = false, $filename = "", $ext = "", $ver = "0",$assets=array(),$async=0) {}
/**
* Remove CSS, JS File Link for browser 
* SphpBase::sphpApi()->removeFileLink("front/default/theme-black2.js",false,"black1","js")
* @param string $fileURL URL for file
* @param boolean $renderonce Optional default false if true then file ignore in AJAX request
* @param string $filename Optional file identification key. default=filename in fileurl
* @param string $ext Optional default=file extension in fileurl
*/
public function removeFileLink($fileURL, $renderonce = false, $filename = "", $ext = "") {}
/**
* Insert HTML Tag into header section. 
* SphpBase::sphpApi()->addFileLinkCode("f1",'<meta name="viewport" content="width=device-width, initial-scale=1" />')
* @param string $name Name as id
* @param string $code HTML link tag code
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addFileLinkCode($name, $code, $renderonce = false) {}
/**
* Check if filelink is set
* if(SphpBase::sphpApi()->issetFileLink("black1","js",false)){
* // add more related files
* }
* @param string $filename
* @param string $ext
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
* @return boolean
*/
public function issetFileLink($filename, $ext, $renderonce = false) {}
public function getParentDirectory($path) {}
public function directoriesCreate($dirPath,$mod=0775,$owner=""){}
public function directoryCopy($src,$dst,$fixdst=""){}
/**
* Advance Function
* Distribute All Global JS Lib (render once=true) JS files. These
* Files will not load by AJAX.
* @param boolean $min Optional no use
* @param boolean $removeonly Optional if true then remove only links
* @param boolean $combine Optional if true then combine files
* @param string $distpath Optional Folder Path to copy files Default = cache
* @return string
*/
public function getDistGlobalJsFiles($min = false, $removeonly = false,$combine=true,$distpath="cache") {}
/**
* Advance Function
* Distribute All private files (render once=false) JS files. These
* Files can also load via AJAX
* @param boolean $min Optional no use
* @param boolean $removeonly Optional if true then remove only links
* @param boolean $combine Optional if true then combine files
* @param string $distpath Optional Folder Path to copy files Default = cache
* @return string
*/
public function getDistJsFiles($min = false, $removeonly = false,$combine=true,$distpath="cache") {}
/**
* Advance Function
* Distribute All css files
* @param boolean $min Optional no use
* @param boolean $removeonly Optional if true then remove only links no output
* @param boolean $combine Optional if true then combine files
* @param string $distpath Optional Folder Path to copy files Default = cache
* @return string
*/
public function getDistCssFiles($min = false, $removeonly = false,$combine=true,$distpath="cache") {}
/**
* Combine All js and css filelinks and create combine file in $parentfolder folder.
* It also incudes addFileLink code for browser.
* Combines multiple css files into one may brake relative path. So you also
* need to copy assets manually into relative path. If
* you want to leave css links to combine but combine few css files then use combineFiles function to 
* combine required css files.
* in Debug mode=2 it create fresh file on every request but in normal mode
* it checks file exist and create if not exist.
* @param string $parentfolder Optional Default=front parent folder to save combo files
* @param boolean $addcss Optional Default=false create css css combo file
* @param boolean $forceOverwrite Optional Default=false create fresh combo files
* 
*/
public function getCombineFileLinks($parentfolder = "front",$addcss=false,$forceOverwrite=false) {}
/**
* Combine All files path into single file as $outputfilepath
* It willn't incudes addFileLink code for browser. You need to provide browser
* code if you need to send link to browser.
* Combines multiple css files into one may brake relative path. So you also
* need to copy assets manually into relative path. If
* in Debug mode=2 it create fresh file on every request but in normal mode
* it checks file exist and create if not exist.
* @param array $arrayList List of files path
* @param string $outputfilepath Optional Default=front/combo2.css Combine file path
* @param boolean $forceOverwrite Optional Default=false create fresh combo files
* 
*/
public function combineFiles($arrayList,$outputfilepath = "front/combo2.css",$forceOverwrite=false) {}
/**
* Check JS Function Exist in Header Section
* @param string $funname Function name as id
* @param string $rendertype default=private other value is global
* @return boolean
*/
public function isHeaderJsFunctionExist($funname, $rendertype = "private") {}
/**
* Check JS Function Exist in Footer Section
* @param string $funname Function name as id
* @param string $rendertype default=private other value is global
* @return boolean
*/
public function isFooterJsFunctionExist($funname, $rendertype = "private") {}
/**
* Add JS Function header section. 
* SphpBase::sphpApi()->addHeaderJsFunction("myfun","function myfun(){var v1 = 12;","}");
* SphpBase::sphpApi()->addHeaderJsFunctionCode("myfun","code1","console.log(v1);");
* @param string $funname Function name as id
* @param string $startcode 
* @param string $endcode
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addHeaderJsFunction($funname, $startcode, $endcode, $renderonce = false) {}
/**
* Add JS Function footer section. 
* SphpBase::sphpApi()->addFooterJsFunction("myfun","function myfun(){var v1 = 12;","}");
* SphpBase::sphpApi()->addFooterJsFunctionCode("myfun","code1","console.log(v1);");
* @param string $funname Function name as id
* @param string $startcode 
* @param string $endcode
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addFooterJsFunction($funname, $startcode, $endcode, $renderonce = false) {}
/**
* Insert JS Code into JS Function in header section. 
* SphpBase::sphpApi()->addHeaderJsFunctionCode("myfun","code1","console.log(v1);");
* @param string $funname Function name as id
* @param type $name Code block name as id
* @param type $code JS code
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addHeaderJsFunctionCode($funname, $name, $code, $renderonce = false) {}
/**
* Insert JS Code into JS Function in header section. 
* SphpBase::sphpApi()->addFooterJsFunctionCode("myfun","code1","console.log(v1);");
* @param string $funname Function name as id
* @param type $name Code block name as id
* @param type $code JS code
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addFooterJsFunctionCode($funname, $name, $code, $renderonce = false) {}
/**
* Insert JS Code into header section
* SphpBase::sphpApi()->addHeaderJsCode("code1","console.log('test js code');");
* @param type $name Code block name as id
* @param type $code JS code
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addHeaderJsCode($name, $code, $renderonce = false) {}
/**
* Insert CSS Code into header section
* SphpBase::sphpApi()->addHeaderCss("code1","p{color: #FF88F6;}");
* @param type $name Code block name as id
* @param type $code JS code
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addHeaderCss($name, $code, $renderonce = false) {}
/**
* Insert JS Code into footer section
* SphpBase::sphpApi()->addFooterJsCode("code1","console.log('test js code');");
* @param type $name Code block name as id
* @param type $code JS code
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addFooterJsCode($name, $code, $renderonce = false) {}
/**
* Advance Function, Internal use
* Generate all JS code for Header section
* @param boolean $htmltag Optional default true generate HTML tags
* @param boolean $global Optional default true generate render once code also
* @param int $blockJSCode Optional default 0 block JS code section Other values 1 and 2
* @return string
*/
public function getHeaderJs($htmltag = true, $global = true, $blockJSCode = 0) {}
/**
* Remove line break characters from a String.
* @param string $strvalue
* @return string
*/
public function stripNewLineChar($strvalue) {}
/**
* Filter String as JS String
* @param string $str
* @return string
*/
public function getFilterJsString($str) {}
/**
* Advance Function, Internal use
* Generate all JS code for Footer section
* @param boolean $htmltag Optional default true generate HTML tags
* @param boolean $global Optional default true generate render once code also
* @param int $blockJSCode Optional default 0 block JS code section Other values 1 and 2
* @return string
*/
public function getFooterJs($htmltag = true, $global = true, $blockJSCode = 0) {}
/**
* Advance Function, Internal use
* Generate all HTML,CSS and JS code for Header Section
* @param boolean $htmltag Optional default true generate HTML tags
* @param boolean $global Optional default true generate render once code also
* @param int $blockJSCode Optional default 0 block JS code section Other values 1 and 2
* @return string
*/
public function getHeaderHtml($htmltag = true, $global = true, $blockJSCode = 0) {}
/**
* Advance Function, Internal use
* Generate all HTML,CSS and JS code for Footer Section
* @param boolean $htmltag Optional default true generate HTML tags
* @param boolean $global Optional default true generate render once code also
* @param int $blockJSCode Optional default 0 block JS code section Other values 1 and 2
* @return string
*/
public function getFooterHtml($htmltag = true, $global = true, $blockJSCode = 0) {}
/**
* Generate JS Code for console message.
* @param string $msg
* @param string $type Optional Default=log, it is same as JS console like info, error
* @return string
*/
public function consoleMsg($msg, $type = "log") {}
/**
* Print Error message in browser in HTML or JS code. This
* uses SphpBase::sphpApi()->setErr function for set error message.
* SphpBase::sphpApi()->getCheckErr() for check if there are any error.
* @param type $blnDontJS Optional Default false
* @return string
*/
public function traceError($blnDontJS = false) {}
/**
* 
* Set Error Message and Error Flag, display for User of your project. 
* This isn't PHP Language errors. It doesn't break your 
* program execution. It is flag base error status which then you can
* use for decision making on server side or browser side. You can also set this flag
* from PHP exception and display error message in html tag rather then broken PHP 
* output. Like validation error on TextBox Component will also set error flag on server and
* send back html error message with proper format and valid HTML.  
* After this SphpBase::sphpApi()->getCheckErr() return true.
* @param string $name id for message error
* @param string $msg 
*/
public function setErr($name, $msg) {}
/**
* SphpBase::sphpApi()->getCheckErr() for check if there are any error set by setErr.
* @return boolean
*/
public function getCheckErr() {}
/**
* Clear error flag set by setErr.
*/
public function unsetCheckErr() {}
/**
* 
* @param string $name name as id of error
* @return array
*/
public function getErrMsg($name) {}
/**
* Print Error message in browser in HTML or JS code. This
* uses SphpBase::sphpApi()->setMsg function for set message.
* @param type $blnDontJS Optional Default false
* @return string
*/
public function traceMsg($blnDontJS = false) {}
/**
* Set Message for browser, display for User. 
* @param string $name id for message
* @param string $msg 
*/
public function setMsg($name, $msg) {}
/**
* 
* @param string $name name as id of message
* @return array list of Messages under Name
*/
public function getMsg($name) {}
/**
* Print Developer Error message in browser in HTML or JS code. 
* These errors are only available in debug mode and gives some extra informations
* to devloper about logical erros or help in debugging. 
* Not php erros or exceptions whichbreak executions. 
* These are just messages which can also comes from PHP errors.
* uses SphpBase::sphpApi()->setErrInner function for set error developer message.
* @param type $blnDontJS Optional Default false
* @return string
*/
public function traceErrorInner($blnDontJS = false) {}
/**
* Set Error Inner for developer
* @param string $name id for message
* @param string $msg
*/
public function setErrInner($name, $msg) {}
/**
* Read Inner Error Message
* @param string $name id for message
* @return array
*/
public function getErrMsgInner($name) {}
/**
* Set Front Place ignore if addFrontPlace don't initialize front place. 
* It only reserve place. But not render in master without addFrontPlace.
* @param string $frontname name is id
* @param string $filepath file path full FrontFile or Php file
* @param string $secname Optional Default=left
*/
public function setFrontPlacePath($frontname, $filepath, $secname = "left") {}
/**
* Remove Front Place. 
* @param string $frontname name is id
* @param string $secname Optional Default=left
*/
public function removeFrontPlace($frontname, $secname = "left") {}
/**
* Add and initialize front place. 
* @param string $frontname name is id
* @param string $filepath File path of FrontFile or Php file, leave if you want to use from setFrontPlacePath
* @param string $secname Optional Default=left
*/
public function addFrontPlace($frontname, $filepath = "", $secname = "left") {}
/**
* Get Front Place Object or path
* @param string $frontname name is id
* @param string $secname Optional Default=left
* @return \Sphp\Tools\FrontPlace|\Sphp\Tools\FrontPlacePhp
*/
public function getFrontPlace($frontname, $secname = "left") {}
/**
* Run Front Place. 
* @param string $frontname name is id
* @param string $secname Optional Default=left
*/
public function runFrontPlace($frontname, $secname = "left") {}
/**
* Render Front Place Manually. It doesn't support PHP files. 
* $frontname=dynData is reserved of center content of master.
* It will return dynData.
* @param string $frontname name is id
* @param string $secname Optional Default=left
* @return string HTML output from FrontFile
*/
public function renderFrontPlaceManually($frontname, $secname = "left") {}
/**
* Render Front Place. $frontname=dynData is reserved of center content of master.
* It will render dynData.
* @param string $frontname name is id
* @param string $secname Optional Default=left
*/
public function renderFrontPlace($frontname, $secname = "left") {}
/**
* Run All Front Places in a section
* @param string $secname Optional Default=left
*/
public function runFrontSection($secname = "left") {}
/**
* Add and Run All Front Places in a section. 
* If any Front Place is not added but set then this will add automatically.
* @param string $secname Optional Default=left
*/
public function addrunFrontSection($secname = "left") {}
/**
* List of all front places which isn't render
* @param string $secname Optional Default=left
*/
public function listNotRenderFrontSection($secname = "left") {}
/**
* Render All Front Places in a section. 
* @param string $secname Optional Default=left
*/
public function renderFrontSection($secname = "left") {}
/**
* Encrypt/Decrypt String. Use Hexadecimal key. Output Length is not big.
* Data recover is near to impossible if you lost key.  
* @param string $str
* @param string $ky Optional secure key in hexadecimal
* @return string
*/
public function endec($str, $ky="CD098ABA") {}
public function rtClassMethod(\ReflectionClass &$refClass) {}
public function rtClassFile(\ReflectionClass &$refClass) {}
public function rtMethodSource(\ReflectionMethod &$method, &$arlines) {}
public function rtMethodParamFromString($strline, $parameters) {}
public function rtMethodParm(&$method) {}
public function rtClassConstantHelp($mainClass, \ReflectionClass &$reflector) {}
public function rtScopeDefinedHelp(&$arCls, &$arConst, &$arFun, &$arVars) {}
public function rtClassMethodInvoke(&$method, &$obj, $args = null) {}
public function rtFunctionInvoke($fun, $args = null) {}
public function rtClassMethodFromFileLine(\ReflectionClass &$reflector, $line) {}
public function rtClassMethodHelp($mainClass, \ReflectionClass &$reflector, &$arResult) {}
public function rtClassPropertyHelp($mainClass, $clsobj, \ReflectionClass &$reflector, &$arResult) {}
public function rtAutoCompleteFormat($objname, $helpdoc, $objtype, $code, $helptype) {}
public function executePhp($strPHPCode) {}
public function executePhpGlobal($strPHPCode) {}
public function executePhpFunc($strPHPCode) {}
public function consoleWrite($param) {}
public function consoleWriteln($param) {}
public function consoleReadln($msg) {}
public function consoleError($err) {}
}
}
