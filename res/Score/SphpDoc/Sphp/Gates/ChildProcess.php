<?php
namespace Sphp\Gates{
/**
* Experimental:- Create a Child process with PHP
*
* This class wraps PHP's proc_open() to launch and manage a child process.
* It provides methods to write to stdin, read from stdout/stderr, check the
* running status, and close the process.
*/
class ChildProcess {
/**
* Constructor.
*
* @param string $cmd     Command line to run
* @param string $cwd     Current working directory or null to inherit
* @param array  $env     Environment variables or null to inherit
* @param array  $options Options for proc_open()
* @throws RuntimeException When proc_open() is not installed
*/
/**
* Write a message to the child process stdin.
* @param string $msg data to write
* @return void
*/
public function write($msg) {}
/**
* Read a line from the child process stdout.
* @return string
*/
public function read() {}
/**
* Read all content from the child process stderr.
* @return string
*/
public function readErr() {}
/**
* Run the child process in a loop, reading output until it finishes.
* @return void
*/
public function run() {}
/**
* Close the child process and return its exit code.
* @return int|null exit code from proc_close
*/
public function closeProcess() {}
/**
* Get the running status of the child process.
* @return bool|int true if running, 0 if not a resource
*/
public function getStatus() {}
/**
* Destructor, closes the process if still running.
*/
}
}
