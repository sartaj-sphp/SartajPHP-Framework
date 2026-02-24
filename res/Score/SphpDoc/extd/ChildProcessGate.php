<?php
namespace Sphp\tools{
/**
* Experimental:- Create a Child process Gate with PHP
*/
class ChildProcessGate extends ConsoleGate{
public function createProcess($cmd, $cwd = null, array $env = null, array $options = array()) {}
public function ondata($data) {}
public function onerror($data) {}
public function onend($data) {}
public function onquit() {}
public function oncquit() {}
public function sendData($data) {}
public function sendCommand($msg) {}
public function callProcess($fun,$data) {}
public function onwaitin($str1) {}
public function onwait() {}
}
}
