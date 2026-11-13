<?php
namespace Sphp\Gates{
/**
* TesterGate
*
* A console gate used for testing. It forwards the command-line arguments
* (from SphpBase::$stmycache->argv) into the current Sphp request and then
* delegates gate execution to the Sphp API.
*/
class TesterGate extends \Sphp\Gates\ConsoleGate{
/**
* Constructor.
*
* Copies each command-line argument (skipping the first two characters of
* the key) into the current Sphp request, then calls the parent
* constructor.
*
* @return void
*/
/**
* runGate
*
* Runs the given gate file by delegating to the Sphp API.
*
* @param string $gateFilePath Path to the gate file to run.
* @return void
*/
public function runGate($gateFilePath){}
}
}
