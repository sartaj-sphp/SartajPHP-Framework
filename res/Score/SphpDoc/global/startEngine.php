<?php
/**
* SphpPermission class for manage permissions system
*
* Manages the application permission system. Holds an associative array of
* permission identifiers and provides helpers to set, check and authorise
* permissions. Used by the Gate system to control access to content,
* features and menus.
*/
class SphpPermission {
/**
* Set Permissions List as Associate Array
* @param array $arrP <p>
* $arrp = array("perm1" => true,"perm2" => true);
* perm1 can be like index-view or allview or any word you want to use as
* permission identification. This permissions can be manage content in front file or
* enable disable Gate features or menus.
* </p>
* @return void
*/
public function setPermissions($arrP) {}
/**
* Check is permission ID exists
* @param string $permission
* @return boolean
*/
public function hasPermission($permission) {}
/**
* Check Single or multi permissions
* @param string $permissions <p>
* single or coma separated permissions list as string
* </p>
* @return boolean
*/
public function isPermission($permissions) {}
/**
* Authorise user if permission is available otherwise Gate will be exit 
* and redirected by according to getWelcome function in comp.php file in project folder 
* @param string $perm <p>
* string or comma separated string list
* </p>
* @return boolean
*/
public function getAuthenticate($perm = "") {}
}
/**
* SphpBase class
*
* Static base class that holds references to all core Sphp engine objects
* (engine, router, api, request, response, session, settings, permissions,
* js server, jquery, page, debug profiler, db engine, js manager, dynamic
* data and cache). Provides static accessor and setup methods used by the
* engine bootstrap and by application code.
*/
class SphpBase {
public static $dynData = null;
public static $stmycache = null;
/**
* Get Engine
* @static
* @return \Sphp\Engine
*/
public static function engine() {}
/**
* Get Router
* @static
* @return \Sphp\Core\Router
*/
public static function sphpRouter() {}
/**
* Get SphpAPI
* @static
* @return \Sphp\Core\SphpAPI
*/
public static function sphpApi() {}
/**
* Get Request
* @static
* @return \Sphp\Core\Request
*/
public static function sphpRequest() {}
/**
* Get Response
* @static
* @return \Sphp\Core\Response
*/
public static function sphpResponse() {}
/**
* Get Session
* @static
* @return \Sphp\Core\Session
*/
public static function sphpSession() {}
/**
* Get Settings
* @static
* @return \Sphp\Settings
*/
public static function sphpSettings() {}
/**
* Get SphpPermission
* @static
* @return \SphpPermission
*/
public static function sphpPermissions() {}
/**
* Get jsServer
* @static
* @return \Sphp\Kit\JsServer
*/
public static function jsServer() {}
/**
* Get Page Object
* @static
* @return \Sphp\Kit\Page
*/
public static function page() {}
/**
* Set Page Object
* @static
* @param \Sphp\Kit\Page $p
* @return void
*/
public static function setPage($p) {}
/**
* Get getAppOutput
* @static
* @return void
*/
public static function getAppOutput() {}    
/**
* Get DebugProfiler
* @static
* @return \Sphp\Core\DebugProfiler
*/
public static function debug() {}    
/**
* Get DB Engine
* @static
* @return \MySQL
*/
public static function dbEngine() {}
/**
* set DB Engine
* @static
* @param \MySQL $d
* @return void
*/
public static function setDbEngine($d) {}
/**
* Get JS Manager
* @static
* @return \SphpJsM
*/
public static function sphpJsM() {}
/**
* Advance Function, No Use
* @static
* @ignore
* @return void
*/
/**
* Advance Function, No Use
* @static
* @ignore
* @return void
*/
public static function init() {}
/**
* Advance Function, No Use
* @static
* @ignore
* @param \Sphp\Engine $engine
* @return void
*/
public static function setReady($engine) {}
/**
* Advance Function, No Use
* @static
* @ignore
* @return \stmycache
*/
public static function refreshCacheEngine() {}
/**
* Advance Function, No Use
* @static
* @ignore
* @return void
*/
public static function addNewRequest() {}
}
/**
* SphpCodeBlock class
*
* Registry for front-file code blocks. Code blocks are registered with a
* name, a callback and optional html/css parameters, and can be retrieved
* for rendering inside front files. Loading the blocks also links the
* sphpcodeblocks.css asset once.
*/
class SphpCodeBlock{
/**
* Add Code Block for FrontFile. use runcb="true" and sphp-cb-blockName on tag
* @param string $name Name of code block
* @param function $callback function($element,$args,$lstOther_CB) 
* $element=NodeTag object, $args=list of arguments, $lstOther_CB=List of other Code Blocks
* Gately on this element 
* @param array $para add css,html for simple code block
* Values can pass as associative array:-
*  class = CSS class Attribute
*  pclass = parent tag css classes
*  pretag = pre tag html
*  posttag = post tag html
*  innerpretag = tag start inner html
*  innerposttag = tag end inner html
*  documentation = Help details about code block, also display in VS Code and other editors.
* @return void
*/
public static function addCodeBlock($name,$callback=null,$para=[]){}
/**
* Generate default code block parameter array
* @param function $callback
* @param string $css
* @param string $pclass
* @param string $pretag
* @param string $posttag
* @param string $innerpretag
* @param string $innerposttag
* @param string $documentation
* @return array
*/
/**
* Get all registered code blocks
* @return array
*/
public static function getCodeBlocks(){}
/**
* Get a single registered code block by name
* @param string $name
* @return array
*/
public static function getCodeBlock($name){}
}
if (!$blnPreLibCache) {
if ($blnPreLibLoad) {
include_once(__DIR__ . "/../libsphp1.php");
} else {
include_once(__DIR__ . "/libloader.php");
}
}
include_once("{$slibPath}/comp/SphpJsM.php");
if ($debugMode > 0) {
ini_set("display_errors", 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
}
/**
* Extra autoload registered function
* @param string $name
* @return void
*/
function loadSphpLibClass($name) {}
spl_autoload_register("loadSphpLibClass");
/**
* 
* @param array $server REQUEST_METHOD,REQUEST_URI,SERVER_SOFTWARE
* @param array $get data of GET
* @param array $post Data of POST
* @param array $file Data of POST
* @param array $cookies key,value pair
* @param array $session key,value pair
* @return array [code,content,headers,cookies,session]
*/
function pushToSartajPHPEngine($server,$get,$post,$file,$cookies,$session){}
/**
* Run the Sphp engine in the current process
* @return string gate file path when engine is not global, otherwise empty string
*/
function runSartajPHPEngine(){}
