<?php
/**
* SphpPermission class for manage permissions system
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
* @return \Sphp\core\Router
*/
public static function sphp_router() {}
/**
* Get SphpAPI
* @static
* @return \Sphp\core\SphpAPI
*/
public static function sphp_api() {}
/**
* Get Request
* @static
* @return \Sphp\core\Request
*/
public static function sphp_request() {}
/**
* Get Response
* @static
* @return \Sphp\core\Response
*/
public static function sphp_response() {}
/**
* Get Session
* @static
* @return \Sphp\core\Session
*/
public static function sphp_session() {}
/**
* Get Settings
* @static
* @return \Sphp\core\Settings
*/
public static function sphp_settings() {}
/**
* Get SphpPermission
* @static
* @return \SphpPermission
*/
public static function sphp_permissions() {}
/**
* Get JSServer
* @static
* @return \Sphp\kit\JSServer
*/
public static function JSServer() {}
/**
* Get JQuery
* @static
* @return \Sphp\kit\JQuery
*/
public static function JQuery() {}
/**
* Get Page Object
* @static
* @return \Sphp\kit\Page
*/
public static function page() {}
/**
* Set Page Object
* @static
* @param \Sphp\kit\Page $p
*/
public static function set_page($p) {}
/**
* Get getAppOutput
* @static
*/
public static function getAppOutput() {}    
/**
* Get DebugProfiler
* @static
* @return \Sphp\core\DebugProfiler
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
*/
public static function set_dbEngine($d) {}
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
*/
/**
* Advance Function, No Use
* @static
* @ignore
*/
public static function init() {}
/**
* Advance Function, No Use
* @static
* @ignore
*/
public static function setReady($engine) {}
/**
* Advance Function, No Use
* @static
* @ignore
*/
public static function refreshCacheEngine() {}
/**
* Advance Function, No Use
* @static
* @ignore
*/
public static function addNewRequest() {}
}
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
*/
public static function addCodeBlock($name,$callback=null,$para=[]){}
public static function getCodeBlocks(){}
public static function getCodeBlock($name){}
}
if (!$blnPreLibCache) {
if ($blnPreLibLoad) {
include_once("{$libpath}/libsphp1.php");
} else {
include_once("{$libpath}/global/libloader.php");
}
}
include_once("{$slibpath}/comp/SphpJsM.php");
if ($debugmode > 0) {
ini_set("display_errors", 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
}
/**
* Extra autoload registered function
* @param string $name
*/
function loadSphpLibClass($name) {}
spl_autoload_register("loadSphpLibClass");
function runSartajPHPEngine(){}
