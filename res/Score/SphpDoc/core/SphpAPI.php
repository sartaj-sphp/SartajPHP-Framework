<?php
namespace Sphp\core {
final class SphpAPI {
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
* @param \Sphp\tools\FrontFile $obj FrontFile Object
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
* SphpBase::sphp_api()->addMenu("Live Chat",getEventURL("page","chat","index"),"fa fa-commenting","root",false,"index-chat-view");
* SphpBase::sphp_api()->addMenu("Debug", "","fa fa-home","root");
* SphpBase::sphp_api()->addMenuLink("Debug", 'javascript: debugApp();',"","Debug",true,"","f7");
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
* SphpBase::sphp_api()->addMenuLink("Debug", 'javascript: debugApp();',"","Debug",true,"","f7");
* f7 is keyboard shortcut. v,alt+shift = press v + alt + shift key
* </p>
* @param array $settings Optional <p>
* Extra data pass to renderer as associative array
* </p>
*/
public function addMenu($text, $link = "", $icon = "", $parent = "root", $ajax = false, $roles = "", $akey = "", $settings = null) {}
/**
* Add menu link in menu <p>
* SphpBase::sphp_api()->addMenu("Live Chat",getEventURL("page","chat","index"),"fa fa-commenting","root",false,"index-chat-view");
* SphpBase::sphp_api()->addMenu("Debug", "","fa fa-home","root");
* SphpBase::sphp_api()->addMenuLink("Debug", 'javascript: debugApp();',"","Debug",true,"","f7");
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
* SphpBase::sphp_api()->addMenuLink("Debug", 'javascript: debugApp();',"","Debug",true,"","f7");
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
* Register Application with an Appgate
* @param string $ctrl Name of Appgate assigned to application
* @param string $apppath <p>
* Attach application path. 
* Path end with .php is module application 
* and path end with .app is class application. 
* Filename should match with class name
* </p>
* @param string $s_namespace if class application is under a name space
* @param string $permtitle Title Display in Permission List
* @param array $permlist Create Permissions List for application
*/
public function registerApp($ctrl, $apppath, $s_namespace = "",$permtitle="",$permlist=null) {}
/**
* Check application is registered
* @param string $ctrl
* @return boolean
*/
public function isRegisterApp($ctrl) {}
/**
* Get Application Details that is registered with Appgate name $ctrl 
* @param string $ctrl
* @return array
*/
public function getAppPath($ctrl) {}
/**
* Get List of Registered Applications 
* @return array
*/
public function getRegisteredApps() {}
/**
* Get Appgate name that has matched apppath with $appfilepath
* @param string $appfilepath
* @return string|null
*/
public function getAppCtrl($appfilepath) {}
/**
* Get Root folder path of a path. 
* It may be inside res folder or project folder.
* Return SphpBase::sphp_settings()->php_path or PROJ_PATH
* @param string $val path to check
* @return string
*/
public function getRootPath($val) {}
/**
* Convert URL to local server filepath 
* $a = SphpBase::sphp_api->respathToFilepath("../res/jslib/twitter/bootstarp4/main.css")
* @param string $fileurl
* @return array pathinfo,directory,url path,filepath
*/
public function respathToFilepath($fileurl) {}
/**
* Convert filepath to URL path for browser
* $a = SphpBase::sphp_api->filepathToRespaths("apps/chat/index.app")
* @param string $filepath
* @return array pathinfo,directory,url path,filepath
*/
public function filepathToRespaths($filepath) {}
public function getMyResPath($filepath){}
/**
* Run Class type Application
* @param string $path
*/
public function runApp($path) {}
/**
* Create Application object from $path as filepath
* @param string $path
* @return \Sphp\core\formname
*/
public function getAppObject($path) {}
/**
* 
* @param string $filepath App Path
* @param boolean $setEnv Default true = set apppath variable
* @return type
*/
public function getRegisterAppClass($filepath, $setEnv = true) {}
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
public function in_arrayi($needle, $haystack) {}
/**
* Search Needle as array match anywhere in haystack as case insensitive 
* @param string $haystack
* @param array $needle
* @return boolean
*/
public function array_search_str( $haystack,$needle) {}
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
public function array_change_val_case($arr, $case1 = "") {}
/**
* Search first match of Needle in array as case insensitive 
* @param type $needle
* @param type $haystack
* @return int|string|false return key
*/
public function array_search_i($needle, $haystack) {}
/**
* Return IP Value of Client
* @return String <br>
* @author Sartaj Singh 
*
*/
public function getIP() {}
/**
* Return Client Details IP, Request method, url,protocol,referer,browser
* ret = SphpBase::sphp_api()->getGuestDetails();
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
public function getIPDetail() {}
/**
* Check if string is a number
* @param string $val
* @param string $datatype default FLOAT other value is INT
* @return boolean
*/
public function is_valid_num($val, $datatype = "FLOAT") {}
public function getEngine() {}
/**
* Check valid email format
* @param string $email
* @return boolean
*/
public function is_valid_email($email) {}
/**
* Generate JS Array code for PHP Array
* @param string $jsVarName JS Array variable name in code
* @param array $phpArray
* @return string
*/
public function getJSArray($jsVarName, $phpArray, $novar=false) {}
/**
* Generate JS Associative Array code for PHP Array
* @param string $jsVarName JS Associative Array variable name in code
* @param array $phpArray
* @return string
*/
public function getJSArrayAss($jsVarName, $phpArray, $novar=false) {}
/**
* Convert HTML string into JS string
* @param string $strHTML
* @return string
*/
public function HTMLToJS($strHTML) {}
/**
* Get SartajPHP Version
* @return String
*/
public function getSartajPHP() {}
public function getSartajPHPVer() {}
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
* Minify PHP code string
* @param string $filedata
* @return string
*/
public function minifyPHP($filedata) {}
/**
* Minify CSS code string
* @param string $filedata
* @return string
*/
public function minifyCSS($filedata) {}
/**
* Minify HTML code string
* @param string $filedata
* @return string
*/
public function minifyHTML($filedata) {}
/**
* Minify JS code string
* @param string $filedata
* @return string
*/
public function minifyJS($filedata) {}
/**
* Safe write file
* @param string $filepath file path
* @param string|mixed $data content to write in file
* @return int| Exception
*/
public function safeWriteFile($filepath, $data) {}
/**
* Trigger Error
* SphpBase::sphp_api()->triggerError("Couldn't get any result from database", E_USER_NOTICE,debug_backtrace())
* @param type $msg Error Message
* @param type $errType Default E_USER_NOTICE
* @param array $debug_array 
*/
public function triggerError($msg, $errType, $debug_array) {}
/**
* Advance Function, Internal use
* @param boolean $renderonce Default false
* @return string
*/
public function getrenderType($renderonce = false) {}
/**
* Add CSS, JS File Link for browser 
* SphpBase::sphp_api()->addFileLink("front/default/theme-black.css",true,"","","2.7")
* SphpBase::sphp_api()->addFileLink("front/default/theme-black.js",false,"black1","js","2.7")
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
* SphpBase::sphp_api()->updateFileLink("front/default/theme-black2.js",false,"black1","js","2.8")
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
* SphpBase::sphp_api()->removeFileLink("front/default/theme-black2.js",false,"black1","js")
* @param string $fileURL URL for file
* @param boolean $renderonce Optional default false if true then file ignore in AJAX request
* @param string $filename Optional file identification key. default=filename in fileurl
* @param string $ext Optional default=file extension in fileurl
*/
public function removeFileLink($fileURL, $renderonce = false, $filename = "", $ext = "") {}
/**
* Insert HTML Tag into header section. 
* SphpBase::sphp_api()->addFileLinkCode("f1",'<meta name="viewport" content="width=device-width, initial-scale=1" />')
* @param string $name Name as id
* @param string $code HTML link tag code
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addFileLinkCode($name, $code, $renderonce = false) {}
/**
* Check if filelink is set
* if(SphpBase::sphp_api()->issetFileLink("black1","js",false)){
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
public function getDistGlobalJSFiles($min = false, $removeonly = false,$combine=true,$distpath="cache") {}
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
public function getDistJSFiles($min = false, $removeonly = false,$combine=true,$distpath="cache") {}
/**
* Advance Function
* Distribute All css files
* @param boolean $min Optional no use
* @param boolean $removeonly Optional if true then remove only links no output
* @param boolean $combine Optional if true then combine files
* @param string $distpath Optional Folder Path to copy files Default = cache
* @return string
*/
public function getDistCSSFiles($min = false, $removeonly = false,$combine=true,$distpath="cache") {}
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
* @param boolean $force_overwrite Optional Default=false create fresh combo files
* 
*/
public function getCombineFileLinks($parentfolder = "front",$addcss=false,$force_overwrite=false) {}
/**
* Combine All files path into single file as $outputfilepath
* It willn't incudes addFileLink code for browser. You need to provide browser
* code if you need to send link to browser.
* Combines multiple css files into one may brake relative path. So you also
* need to copy assets manually into relative path. If
* in Debug mode=2 it create fresh file on every request but in normal mode
* it checks file exist and create if not exist.
* @param array $array_list List of files path
* @param string $outputfilepath Optional Default=front/combo2.css Combine file path
* @param boolean $force_overwrite Optional Default=false create fresh combo files
* 
*/
public function combineFiles($array_list,$outputfilepath = "front/combo2.css",$force_overwrite=false) {}
/**
* Check JS Function Exist in Header Section
* @param string $funname Function name as id
* @param string $rendertype default=private other value is global
* @return boolean
*/
public function isHeaderJSFunctionExist($funname, $rendertype = "private") {}
/**
* Check JS Function Exist in Footer Section
* @param string $funname Function name as id
* @param string $rendertype default=private other value is global
* @return boolean
*/
public function isFooterJSFunctionExist($funname, $rendertype = "private") {}
/**
* Add JS Function header section. 
* SphpBase::sphp_api()->addHeaderJSFunction("myfun","function myfun(){var v1 = 12;","}");
* SphpBase::sphp_api()->addHeaderJSFunctionCode("myfun","code1","console.log(v1);");
* @param string $funname Function name as id
* @param string $startcode 
* @param string $endcode
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addHeaderJSFunction($funname, $startcode, $endcode, $renderonce = false) {}
/**
* Add JS Function footer section. 
* SphpBase::sphp_api()->addFooterJSFunction("myfun","function myfun(){var v1 = 12;","}");
* SphpBase::sphp_api()->addFooterJSFunctionCode("myfun","code1","console.log(v1);");
* @param string $funname Function name as id
* @param string $startcode 
* @param string $endcode
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addFooterJSFunction($funname, $startcode, $endcode, $renderonce = false) {}
/**
* Insert JS Code into JS Function in header section. 
* SphpBase::sphp_api()->addHeaderJSFunctionCode("myfun","code1","console.log(v1);");
* @param string $funname Function name as id
* @param type $name Code block name as id
* @param type $code JS code
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addHeaderJSFunctionCode($funname, $name, $code, $renderonce = false) {}
/**
* Insert JS Code into JS Function in header section. 
* SphpBase::sphp_api()->addFooterJSFunctionCode("myfun","code1","console.log(v1);");
* @param string $funname Function name as id
* @param type $name Code block name as id
* @param type $code JS code
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addFooterJSFunctionCode($funname, $name, $code, $renderonce = false) {}
/**
* Insert JS Code into header section
* SphpBase::sphp_api()->addHeaderJSCode("code1","console.log('test js code');");
* @param type $name Code block name as id
* @param type $code JS code
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addHeaderJSCode($name, $code, $renderonce = false) {}
/**
* Insert CSS Code into header section
* SphpBase::sphp_api()->addHeaderCSS("code1","p{color: #FF88F6;}");
* @param type $name Code block name as id
* @param type $code JS code
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addHeaderCSS($name, $code, $renderonce = false) {}
/**
* Insert JS Code into footer section
* SphpBase::sphp_api()->addFooterJSCode("code1","console.log('test js code');");
* @param type $name Code block name as id
* @param type $code JS code
* @param boolean $renderonce Optional default false, true mean ignore in AJAX request
*/
public function addFooterJSCode($name, $code, $renderonce = false) {}
/**
* Advance Function, Internal use
* Generate all JS code for Header section
* @param boolean $htmltag Optional default true generate HTML tags
* @param boolean $global Optional default true generate render once code also
* @param int $blockJSCode Optional default 0 block JS code section Other values 1 and 2
* @return string
*/
public function getHeaderJS($htmltag = true, $global = true, $blockJSCode = 0) {}
/**
* Filter String as JS String
* @param string $str
* @return string
*/
public function getFilterJSString($str) {}
/**
* Advance Function, Internal use
* Generate all JS code for Footer section
* @param boolean $htmltag Optional default true generate HTML tags
* @param boolean $global Optional default true generate render once code also
* @param int $blockJSCode Optional default 0 block JS code section Other values 1 and 2
* @return string
*/
public function getFooterJS($htmltag = true, $global = true, $blockJSCode = 0) {}
/**
* Advance Function, Internal use
* Generate all HTML,CSS and JS code for Header Section
* @param boolean $htmltag Optional default true generate HTML tags
* @param boolean $global Optional default true generate render once code also
* @param int $blockJSCode Optional default 0 block JS code section Other values 1 and 2
* @return string
*/
public function getHeaderHTML($htmltag = true, $global = true, $blockJSCode = 0) {}
/**
* Advance Function, Internal use
* Generate all HTML,CSS and JS code for Footer Section
* @param boolean $htmltag Optional default true generate HTML tags
* @param boolean $global Optional default true generate render once code also
* @param int $blockJSCode Optional default 0 block JS code section Other values 1 and 2
* @return string
*/
public function getFooterHTML($htmltag = true, $global = true, $blockJSCode = 0) {}
/**
* Generate JS Code for console message.
* @param string $msg
* @param string $type Optional Default=log, it is same as JS console like info, error
* @return string
*/
public function consoleMsg($msg, $type = "log") {}
/**
* Print Error message in browser in HTML or JS code. This
* uses SphpBase::sphp_api()->setErr function for set error message.
* SphpBase::sphp_api()->getCheckErr() for check if there are any error.
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
* After this SphpBase::sphp_api()->getCheckErr() return true.
* @param string $name id for message error
* @param string $msg 
*/
public function setErr($name, $msg) {}
/**
* SphpBase::sphp_api()->getCheckErr() for check if there are any error set by setErr.
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
* uses SphpBase::sphp_api()->setMsg function for set message.
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
* uses SphpBase::sphp_api()->setErrInner function for set error developer message.
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
* @return \Sphp\tools\FrontFile|string
*/
public function getFrontPlace($frontname, $secname = "left") {}
/**
* Run Front Place. Only Run FrontFile not PHP. 
* PHP file include only on render time.
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
public function executePHP($strPHPCode) {}
public function executePHPGlobal($strPHPCode) {}
public function executePHPFunc($strPHPCode) {}
public function consoleWrite($param) {}
public function consoleWriteln($param) {}
public function consoleReadln($msg) {}
public function consoleError($err) {}
}
}
