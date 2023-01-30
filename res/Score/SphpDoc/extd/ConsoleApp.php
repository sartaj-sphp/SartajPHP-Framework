<?php
namespace Sphp\tools {
/**
* Description of ConsoleApp
*
* @author Sartaj Singh
*/
class ConsoleApp {
/** @var \Sphp\kit\Page $page */
public $page = "";
/** @var string $apppath application folder path */
public $apppath = "";
/** @var string $phppath res folder path */
public $phppath = "";
/** @var string $respath res browser url */
public $respath = "";
/** @var \Sphp\kit\JSServer $JSServer */
public $JSServer = null;
/** @var \Sphp\core\Request $Client */
public $Client = null;
/** @var \MySQL $dbEngine */
public $dbEngine = null;
/** @var \Sphp\core\DebugProfiler $debug */
public $debug = null;
/** @var \Sphp\core\SphpApi $sphp_api */
public $sphp_api = null;
/** @var string $sphp_api */
public $scriptname = "";
/** @var array $argv */
public $argv = array();
/** @var boolean $isRunning */
protected $isRunning = false;
/** @var array $wait_interval default value 1000000 */
public $wait_interval = 1000000;
/**
* Register TempFile with app
* @param \Sphp\tools\TempFile $tempobj
*/
public function registerTemp($tempobj) {}
/**
* Advance Function
* @ignore
*/
public function triggerAppEvent() {}
/**
* Advance Function
* @ignore
*/
public function setup($tempobj) {}
/**
* Advance Function
* @ignore
*/
public function process($tempobj) {}
/**
* Advance Function
* @ignore
*/
public function processEvent() {}
/**
* Advance Function
* @ignore
*/
public function render() {}
public function __construct() {}
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
* Stop exit Automatically after end of processing. It turn on wait event time loop.
* For exit manually then you need to call ExitMe
*/
public function setDontExit() {}
/**
* Exit Manually
*/
public function ExitMe() {}
/**
* Handle Wait Event when application is running in manually exit mode
*/
public function onwait() {}
/**
* Set wait loop interval time
* @param int $microsec time in microsecond for wait loop
*/
public function setWaitInterval($microsec = 100000) {}
/**
* Advance Function
* @ignore
*/
public function run() {}
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
* Write on Console
* @param string $param
*/
public function consoleWrite($param) {}
/**
* Write on Console with end line
* @param string $param
*/
public function consoleWriteln($param) {}
/**
* Read a line from Console with message print on console
* @param string $msg message print on console
*/
public function consoleReadln($msg) {}
/**
* Write error on console
* @param string $err
*/
public function consoleError($err) {}
/**
* Read command line argument
* $v = consoleReadArgument('--dest')
* @param string $argkey key like --ctrl
* @return string
*/
public function consoleReadArgument($argkey) {}
/**
* Execute shell command
* @param string $command
* @return array return from command
*/
public function execute($command) {}
/**
* Convert argv to string
* @return string
*/
public function argvToArgs() {}
/**
* Only work on Windows, get COM object
* @return \COM
*/
public function getWScript() {}
public function runWScript($strCommand, $intWindowStyle = 3, $bWaitOnReturn = true) {}
/**
* Execute shell command in Background
* @param string $cmd
*/
public function execInBackground($cmd) {}
/**
* Exit App Forcefully, Not safe
*/
public function exitApp() {}
}
}
