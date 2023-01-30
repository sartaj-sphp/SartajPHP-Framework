<?php
if (!$blnPreLibCache) {
if ($blnPreLibLoad) {
include_once("{$libpath}/libsphp1.php");
} else {
include_once("{$libpath}/global/libloader.php");
}
}
include_once("{$slibpath}/comp/SphpJsM.php");
/**
* SphpPermission class for manage permissions system
*/
class SphpPermission {
/**
* Set Permissions List as Associate Array
* @param array $arrP <p>
* $arrp = array("perm1" => true,"perm2" => true);
* perm1 can be like index-view or allview or any word you want to use as
* permission identification. This permissions can be manage content in temp file or
* enable disable application features or menus.
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
* Authorise user if permission is available otherwise application will be exit 
* and redirected by according to getWelcome function in comp.php file in project folder 
* @param string $perm <p>
* string or comma separated string list
* </p>
* @return boolean
*/
public function getAuthenticate($perm = "") {}
}
class SphpBase {
/** @static \Sphp\Engine $engine */
private static $engine = null;
/** @static \Sphp\core\Router $sphp_router */
private static $sphp_router = null;
/** @static \Sphp\core\SphpApi $sphp_api */
private static $sphp_api = null;
/** @static \Sphp\core\Request $sphp_request */
private static $sphp_request = null;
/** @static \Sphp\core\Response $sphp_response */
private static $sphp_response = null;
/** @static \Sphp\kit\Session $sphp_session */
private static $sphp_session = null;
/** @static \Sphp\Settings $sphp_settings */
private static $sphp_settings = null;
/** @static \SphpPermission $sphp_permissions */
private static $sphp_permissions = null;
/** @static \Sphp\kit\JSServer $JSServer */
private static $JSServer = null;
/** @static \Sphp\kit\JQuery $JQuery */
private static $JQuery = null;
/** @static \Sphp\kit\Page $page */
private static $page = null;
/** @static \Sphp\core\DebugProfiler $debug */
private static $debug = null;
/** @static \MySQL $dbEngine */
private static $dbEngine = null;
/** @static \SphpJsM $sphpJsM */
private static $sphpJsM = null;
/** @static \Sphp\tools\TempFile $dynData */
public static $dynData = null;
/** @static \stmycache $stmycache */
public static $stmycache = null;
/** @static array $cacheFileList */
public static $cacheFileList = null;
public static function engine() {}
public static function sphp_router() {}
public static function sphp_api() {}
public static function sphp_request() {}
public static function sphp_response() {}
public static function sphp_session() {}
public static function sphp_settings() {}
public static function sphp_permissions() {}
public static function JSServer() {}
public static function JQuery() {}
public static function page() {}
public static function set_page($p) {}
public static function debug() {}
public static function dbEngine() {}
public static function set_dbEngine($d) {}
public static function sphpJsM() {}
public static function _startme() {}
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
if ($debugmode > 0) {
error_reporting(E_ALL);
ini_set("display_errors", 1);
}
SphpBase::_startme();
SphpBase::init();
$jq = new \Sphp\kit\jq();
$engine = new Sphp\Engine();
SphpBase::setReady($engine);
$engine->start();
try {
if (!defined("sphp_mannually_start_engine")) {
$sphp_notglobalapp = $engine->executeinit();
if (!$sphp_notglobalapp[0]) {
include_once($sphp_notglobalapp[1]);
$engine->execute(true);
} else {
$engine->execute();
}
}
} catch (\Throwable $e) {
throw new Exception($e->getMessage() . ' File:- ' . $e->getFile() . ' Line:- ' . $e->getLine());
} catch (\Exception $e) {
throw new Exception($e->getMessage() . ' File:- ' . $e->getFile() . ' Line:- ' . $e->getLine());
}
