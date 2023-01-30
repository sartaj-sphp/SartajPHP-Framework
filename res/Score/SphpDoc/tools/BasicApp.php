<?php
namespace Sphp\tools {
/**
* Description of BasicApp
*
* @author Sartaj Singh
*/
class BasicApp extends SphpApp {
/** @var \Sphp\kit\Page $page */
public $page = "";
/** @var \Sphp\tools\TempFile $tempform */
public $tempform;
/** @var \Sphp\tools\TempFile $maintempform */
public $maintempform;
/** @var string $apppath application folder path */
public $apppath = "";
/** @var string $phppath res folder path */
public $phppath = "";
/** @var string $respath res browser url */
public $respath = "";
/** @var string $myrespath application browser url */
public $myrespath = "";
/** @var string $mypath application folder path */
public $mypath = "";
/** @var \Sphp\kit\JSServer $JSServer */
public $JSServer = null;
/** @var \Sphp\core\Request $Client */
public $Client = null;
/** @var \MySQL $dbEngine */
public $dbEngine = null;
/** @var \Sphp\core\DebugProfiler $debug */
public $debug = null;
public function __construct() {}
/**
* Advance function for change the behavior of app
* @param \Sphp\tools\TempFile $tempobj
*/
public function setup($tempobj) {}
/**
* Advance function for change the behavior of app
* @param \Sphp\tools\TempFile $tempobj
*/
public function process($tempobj) {}
/**
* Advance function for change the behavior of app
*/
public function processEvent() {}
/**
* Assign Default TempFile to App for render
* @param \Sphp\tools\TempFile $obj 
*/
public function setTempFile($obj) {}
/**
* Get Current TempFile assign to app for render
* @return \Sphp\tools\TempFile
*/
public function getTempFile() {}
/**
* Rendering Permission to default assigned TempFile 
*/
public function showTempFile() {}
/**
* Disable Rendering Permission to default assigned TempFile 
*/
public function showNotTempFile() {}
/**
* Set default table of Database to Sphp\Page object and this application.
* This information is important for controls and other database users objects.
* @param string $dbtable
*/
public function setTableName($dbtable) {}
/**
* get default database table assigned to application
* @return string
*/
public function getTableName() {}
/**
* get controller event name trigger by browser
* @return string
*/
public function getEvent() {}
/**
* get controller event parameter post by browser
* @return string
*/
public function getEventParameter() {}
/**
* override this event handler in your application to handle it.
* trigger when application start
*/
public function onstart() {}
/**
* override this event handler in your application to handle it.
* trigger when application finish process of default TempFile
*/
public function onready() {}
/**
* override this event handler in your application to handle it.
* trigger when application initialize TempFile Object
*/
public function ontempinit($tempobj) {}
/**
* override this event handler in your application to handle it.
* trigger when application start process on TempFile Object
*/
public function ontempprocess($tempobj) {}
/** Inbuilt Event
* override this event handler in your application to handle it.
* trigger when browser get (url=index-delete.html)
* where index is controller of application and application path is in reg.php file 
*/
public function page_delete() {}
/** Inbuilt Event
* override this event handler in your application to handle it.
* trigger when browser get (url=index-view-19.html)
* where index is controller of application and application path is in reg.php file 
* view = event name 
* 19 = recid of database table or any other value.
*/
public function page_view() {}
/** Inbuilt Event
* override this event handler in your application to handle it.
* trigger when browser post form (url=index.html)
* where index is controller of application and application path is in reg.php file 
*/
public function page_submit() {}
/** Inbuilt Event
* override this event handler in your application to handle it.
* trigger when browser post form (url=index.html) as new form
* where index is controller of application and application path is in reg.php file 
*/
public function page_insert() {}
/** Inbuilt Event
* override this event handler in your application to handle it.
* trigger when browser post form (url=index.html) as filled form
* from database with view_data function
* where index is controller of application and application path is in reg.php file 
*/
public function page_update() {}
/** Inbuilt Event
* override this event handler in your application to handle it.
* trigger when browser get (url=index.html) first time
* where index is controller of application and application path is in reg.php file 
*/
public function page_new() {}
/** Inbuilt Event
* override this event handler in your application to handle it.
* trigger when application run after ready event and before trigger any event handler
*/
public function onrun() {}
/** Inbuilt Event
* override this event handler in your application to handle it.
* trigger when application render after run TempFile but before start master
* file process. You can't manage TempFile output here but you can replace TempFile
* output in SphpBase::$dynData or change master file or add front place for master filepath
*/
public function onrender() {}
/**
* Advance function for change the behavior of app
*/
public function run() {}
/**
* Advance function for change the behavior of app
*/
public function render() {}
/**
* set path of master design file name
* @param string $masterFile
*/
public function setMasterFile($masterFile) {}
/**
* Set which user can access this application. Default user is GUEST.
* You can set session variable in login app 
* SphpBase::sphp_request()->session('logType','ADMIN');
* If user is not login with specific type then application exit and
* redirect according to the getWelcome function in comp.php
* @param string $authenticates <p>
* comma separated list of string. Example:- getAuthenticate("GUEST,ADMIN") or getAuthenticate("ADNIN")
* </p>
*/
public function getAuthenticate($authenticates) {}
/**
* Check if user has session secure url. This application can't work with cross session.
* Every app has unique url and expired with end of session. 
*/
public function getSesSecurity() {}
}
}
