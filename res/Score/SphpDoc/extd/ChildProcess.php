<?php
namespace Sphp\tools{
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
public function __construct($cmd, $cwd = null, array $env = null, array $options = array()) {}
public function write($msg) {}
public function read() {}
public function readErr() {}
public function run() {}
public function closeProcess() {}
public function getStatus() {}
public function __destruct() {}
}
}
