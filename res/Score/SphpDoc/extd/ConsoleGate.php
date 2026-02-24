<?php
namespace Sphp\tools {
/**
* Description of ConsoleGate
*
* @author Sartaj Singh
*/
class ConsoleGate {
/** @var \Sphp\kit\Page $page */
public $page = "";
/** @var string $gate_dir_path Gate folder path */
public $gate_dir_path = "";
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
* Set Password for Sudo command
* @param string $pas password
*/
public function setPassword($pas) {}
/**
* enable stdout print
*/
public function enableStdout() {}
/**
* Disbale stdout print 
*/
public function disableStdout() {}
/**
* Create Command Que
* @param array &$ar1 pass by reference to fill command
* @param string $cmd shell command
* @param string $msg Message to display command help
* @param boolean $sudo true = sudo command
* @param boolean $critical true = stop execution if error in this command
* @param function $callbackerr callback if error in this command
*/
public function createQue(&$ar1, $cmd, $msg = "", $sudo = false, $critical = false, $callbackerr = null) {}
/**
* Call Command and wait to finish
* @param string $cmd shell command
* @param string &$str1 output text from command
* @param string $msg help text with command
* @param boolean $sudo true = run as sudo
* @return boolean true = run succesfull
*/
public function callSync($cmd, &$str1, $msg = "", $sudo = false) {}
/**
* Call Command and process callback without wait to end.
* @param string $cmd shell command
* @param string $msg help text with command
* @param function $fun2 callback on data
* @param function $funer2 callback on error
* @param function $fun_ready2 callback process ready
* @return boolean true = run successful
*/
public function callf($cmd, $msg = "", $fun2 = null, $funer2 = null, $fun_ready2 = null) {}
/**
* Call Shell Command With Sudo without wait for end.
* @param string $cmd command
* @param string $msg command help text
* @param function $fun2 callback on data
* @param function $funer2 callback on error
* @param function $fun_ready2 callback on process ready
* @return boolean true = run successful
*/
public function callSudo($cmd, $msg = "", $fun2 = null, $funer2 = null, $fun_ready2 = null) {}
public function calla($cmd, $msg = "", $fun = null, $funer = null, $callback_ready = null, $statuscall = null) {}
/**
* Print Error Message on terminal
* @param string $str1 error msg
*/
public function printer($str1) {}
/**
* Print Message on terminal
* @param string $str1 error msg
*/
public function println($str1) {}
public function processCmdQue(&$ar1) {}
public function processIAQue(&$ar1, $cmd, $msg1 = '', $sudo = false, $fune = null) {}
/**
* print error on console or send to browser
* @param string $msg
* @param string $type 'i' mean info other mean error
*/
public function sendMsg($msg, $type = 'i') {}
public function execShellAsync($cmd, $callback, $funer, $callback_ready = null, $cwd = "", $env = null, $options = null) {}
/**
* Remove Extra Spaces from text
* @param string $v1 data
* @return string
*/
public function removeExtraSpaces($v1) {}
/**
* get Gate event name trigger by browser
* @return string
*/
public function getEvent() {}
/**
* get Gate event parameter post by browser
* @return string
*/
public function getEventParameter() {}
/**
* override this event handler in your Gate to handle it.
* trigger when Gate start
*/
public function onstart() {}
/**
* override this event handler in your Gate to handle it.
* trigger when Gate finish process of default FrontFile
*/
public function onready() {}
/**
* override this event handler in your Gate to handle it.
* trigger when Gate initialize FrontFile Object
*/
public function onfrontinit($frontobj) {}
/**
* override this event handler in your Gate to handle it.
* trigger when Gate start process on FrontFile Object
*/
public function onfrontprocess($frontobj) {}
/** Inbuilt Event
* override this event handler in your Gate to handle it.
* trigger when browser get (url=index-delete.html)
* where index is Gate of Gate and Gate path is in reg.php file 
*/
public function page_delete() {}
/** Inbuilt Event
* override this event handler in your Gate to handle it.
* trigger when browser get (url=index-view-19.html)
* where index is Gate of Gate and Gate path is in reg.php file 
* view = event name 
* 19 = recid of database table or any other value.
*/
public function page_view() {}
/** Inbuilt Event
* override this event handler in your Gate to handle it.
* trigger when browser post form (url=index.html)
* where index is Gate of Gate and Gate path is in reg.php file 
*/
public function page_submit() {}
/** Inbuilt Event
* override this event handler in your Gate to handle it.
* trigger when browser post form (url=index.html) as new form
* where index is Gate of Gate and Gate path is in reg.php file 
*/
public function page_insert() {}
/** Inbuilt Event
* override this event handler in your Gate to handle it.
* trigger when browser post form (url=index.html) as filled form
* from database with view_data function
* where index is Gate of Gate and Gate path is in reg.php file 
*/
public function page_update() {}
/** Inbuilt Event
* override this event handler in your Gate to handle it.
* trigger when browser get (url=index.html) first time
* where index is Gate of Gate and Gate path is in reg.php file 
*/
public function page_new() {}
/** Inbuilt Event
* override this event handler in your Gate to handle it.
* trigger when Gate run after ready event and before trigger any event handler
*/
public function onrun() {}
/** Inbuilt Event
* override this event handler in your Gate to handle it.
* trigger when Gate render after run FrontFile but before start master
* file process. You can't manage FrontFile output here but you can replace FrontFile
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
* Handle Wait Event when Gate is running in manually exit mode
*/
public function onwait() {}
/**
* Set wait loop interval time
* @param int $microsec time in microsecond for wait loop
*/
public function setWaitInterval($microsec = 100000) {}
/**
* Set which user can access this Gate. Default user is GUEST.
* You can set session variable in login Gate 
* SphpBase::sphp_request()->session('logType','ADMIN');
* If user is not login with specific type then Gate exit and
* redirect according to the getWelcome function in comp.php
* @param string $authenticates <p>
* comma separated list of string. Example:- getAuthenticate("GUEST,ADMIN") or getAuthenticate("ADNIN")
* </p>
*/
public function getAuthenticate($authenticates) {}
/**
* Set default table of Database to Sphp\Page object and this Gate.
* This information is important for Components and other database users objects.
* @param string $dbtable
*/
public function setTableName($dbtable) {}
/**
* get default database table assigned to Gate
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
* Execute shell command and print output directly
* @param string $command 
* @return array return from command exit code
*/
public function execute($command) {}
/**
* Execute Shell command With output
* @param type $cmd Command
* @param string &$out Reference var to fill output text
* @return boolean true if execute succesfully 
*/
public function execShell($cmd, &$out) {}
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
* Exit Gate Forcefully, Not safe
*/
public function exitApp() {}
/**
* Advance Function
* @ignore
*/
/**
* Register FrontFile with Gate
* @param \Sphp\tools\FrontFile $frontobj
*/
/**
* Advance Function
* @ignore
*/
/**
* Advance Function
* @ignore
*/
/**
* Advance Function
* @ignore
*/
/**
* Advance Function
* @ignore
*/
protected function _processEvent() {}
/**
* Advance Function
* @ignore
*/
protected function _render() {}
}
}
