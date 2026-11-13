<?php
namespace Sphp\Gates {
/**
* Description of ConsoleGate
*
* @author Sartaj Singh
*
* ConsoleGate is a base class for building command-line (CLI) and console
* based Gates. It provides helpers to run shell commands synchronously or
* asynchronously, process command queues, manage sudo authentication,
* ANSI colored output, and standard Gate event handlers (onstart, onready,
* onrun, onrender, onwait, page_new, page_submit, etc.).
*/
class ConsoleGate {
/** @var \Sphp\Kit\Page $page */
public $page = "";
/** @var string $gateDirPath Gate folder path */
public $gateDirPath = "";
/** @var string $resourcePath res folder path */
public $resourcePath = "";
/** @var string $resourceUrl res browser url */
public $resourceUrl = "";
/** @var \Sphp\Kit\JsServer $jsServer */
public $jsServer = null;
/** @var \Sphp\Core\Request $client */
public $client = null;
/** @var \MySQL $dbEngine */
public $dbEngine = null;
/** @var \Sphp\Core\DebugProfiler $debug */
public $debug = null;
/** @var \Sphp\Core\SphpApi $sphpApi */
public $sphpApi = null;
/** @var string $scriptname */
public $scriptname = "";
/** @var array $argv */
public $argv = array();
/** @var boolean $isRunning */
protected $isRunning = false;
/** @var array $waitInterval default value 1000000 */
public $waitInterval = 1000000;
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
* @param function $funReady2 callback process ready
* @return boolean true = run successful
*/
public function callf($cmd, $msg = "", $fun2 = null, $funer2 = null, $funReady2 = null) {}
/**
* Call Shell Command With Sudo without wait for end.
* @param string $cmd command
* @param string $msg command help text
* @param function $fun2 callback on data
* @param function $funer2 callback on error
* @param function $funReady2 callback on process ready
* @return boolean true = run successful
*/
public function callSudo($cmd, $msg = "", $fun2 = null, $funer2 = null, $funReady2 = null) {}
/**
*  Execute Command Asynchronously
* @param string $cmd command
* @param string $msg command help text display with command result
* @param function $fun stdout
* @param function $funer stderror
* @param function $callbackReady callback on process ready
* @param function $statuscall execute after end of execution with result
* @return bool
*/
public function calla($cmd, $msg = "", $fun = null, $funer = null, $callbackReady = null, $statuscall = null) {}
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
/**
* Process a queue of commands, running each one (with sudo if flagged)
* and reporting completion or failure.
* @param array &$ar1 command queue
*/
public function processCmdQue(&$ar1) {}
/**
* Process an interactive command queue, feeding queued commands into
* the stdin of a running interactive process.
* @param array &$ar1 interactive command queue
* @param string $cmd shell command to start
* @param string $msg1 help text
* @param boolean $sudo true = run as sudo
* @param function $fune callback on failure
*/
public function processIaQue(&$ar1, $cmd, $msg1 = '', $sudo = false, $fune = null) {}
/**
* print error on console or send to browser
* @param string $msg
* @param string $type 'i' mean info other mean error
*/
public function sendMsg($msg, $type = 'i') {}
/**
* Read complete lines from a stream, buffering partial lines in
* $pendingstr until a newline is received.
* @param resource &$stream1 stream to read from
* @param string &$pendingstr buffer for partial line
* @return array lines read
*/
/**
* Execute a shell command asynchronously, streaming stdout and stderr
* to callbacks.
* @param string $cmd command
* @param function $callback stdout callback
* @param function $funer stderr callback
* @param function $callbackReady callback on process ready
* @param string $cwd working directory
* @param array $env environment variables
* @param array $options proc_open options
* @return boolean true if command exited with code 0
*/
public function execShellAsync($cmd, $callback, $funer, $callbackReady = null, $cwd = "", $env = null, $options = null) {}
/**
* Remove Extra Spaces from text
* @param string $v1 data
* @return string
*/
public function removeExtraSpaces($v1) {}
/**
* Internal: dispatch page events (event, new, submit) based on the
* current page state.
*/
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
* trigger when browser post data to Landing URL (url=index.html)
* where index is Gate of Gate and Gate path is in reg.php file 
*/
public function page_submit() {}
/** Inbuilt Event
* override this event handler in your Gate to handle it.
* trigger when browser get Request to Landing URL(url=index.html) 
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
* SphpBase::sphpRequest()->session('logType','ADMIN');
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
public function getWscript() {}
/**
* Run a command via Windows WScript shell.
* @param string $strCommand command to run
* @param int $intWindowStyle window style
* @param boolean $bWaitOnReturn wait for return
* @return mixed result from WScript Run
*/
public function runWscript($strCommand, $intWindowStyle = 3, $bWaitOnReturn = true) {}
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
* Constructor: initialize Gate references and trigger onstart.
*/
/**
* Advance Function
* @ignore
*/
/**
* Register FrontFile with Gate
* @param \Sphp\Gates\FrontFile $frontobj
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
