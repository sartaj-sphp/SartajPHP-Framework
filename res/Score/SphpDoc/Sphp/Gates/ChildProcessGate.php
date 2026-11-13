<?php
namespace Sphp\Gates{
/**
* Experimental:- Create a Child process Gate with PHP
*
* ChildProcessGate extends ConsoleGate to run a child process and communicate
* with it via IPC. It reads stdin asynchronously in a thread and dispatches
* events to the Gate's event handlers.
*/
class ChildProcessGate extends ConsoleGate{
/** @var \ChildProcess $childProcess child process object */
/** @var \SphpThread $sthread1 thread object for async stdin reading */
/** @var boolean $chlp flag indicating child process is active */
/**
* Constructor
* Initializes the thread, sets wait interval, and starts async stdin reading.
*/
/**
* Create a child process
* @param string $cmd command to execute
* @param string $cwd working directory
* @param array $env environment variables
* @param array $options proc_open options
*/
public function createProcess($cmd, $cwd = null, array $env = null, array $options = array()) {}
/**
* Called when data is received from child process
* @param string $data data received
*/
public function ondata($data) {}
/**
* Called when error is received from child process
* @param string $data error data
*/
public function onerror($data) {}
/**
* Called when child process ends
* @param string $data end data
*/
public function onend($data) {}
/**
* Called when quit event is received
*/
public function onquit() {}
/**
* Called when child process quit event is received
*/
public function oncquit() {}
/**
* Send data to child process
* @param string $data data to send
*/
public function sendData($data) {}
/**
* Send a command to child process
* @param string $msg command message
*/
public function sendCommand($msg) {}
/**
* Call a function in child process
* @param string $fun function name
* @param mixed $data data to pass
*/
public function callProcess($fun,$data) {}
/**
* Handle async stdin input from thread
* @param string $str1 input string
* @return int 1 to continue, 2 to stop
*/
public function onwaitin($str1) {}
/**
* Handle wait event when Gate is running in manually exit mode
* Reads child process output and dispatches events.
*/
public function onwait() {}
/**
* Destructor
*/
}
}
