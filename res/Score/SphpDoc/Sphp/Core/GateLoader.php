<?php
namespace Sphp\Core {
/**
* SphpPreRunP class
*
* Pre-run placeholder class. Its onstart event handler is executed when
* the prerun.php file is loaded, so any library included here will be
* available in the whole project.
*/
class SphpPreRunP {
/**
* Start Event Handler for prerun.php file. include any library here will be available
* in whole project 
* @return void
*/
public function onstart() {}
}
/**
* Description of GateLoader
*
* Loads and starts the requested Gate (application module). It initializes
* the session according to settings, includes the prerun.php file,
* resolves the gate file path through the router, and dispatches the
* gate based on its file type (psp, app, gate.php or global gate).
*
* @author Sartaj Singh
*/
class GateLoader {
/**
* Advance Function, Internal use
* @return array
* @ignore
*/
/**
* Advance Function, Internal use
* @return array
* @ignore
*/
}
/**
* \Sphp\Core\Exception
*
* Custom exception class for the Sphp framework. It captures the line
* number and file path where the error was triggered and can combine
* the messages of previous exceptions in the chain.
*/
class Exception extends \Exception {
/**
* Constructor
*
* Creates the exception and captures the line number and file path.
* @param string $message
* @param int $code
* @param \Exception|null $previous
* @param int $lineno
* @param string $filen
* @return void
*/
/**
* Combine Messages of Previous Exceptions
* @param \Exception $pr1
* @return string
*/
/**
* Get Line Number of Error
* @return int
*/
public function getLineNumber() {}
/**
* Get File Path where Error trigger
* @return string
*/
public function getFilePath() {}
/**
* Set Line Number of Error
* @param int $line
* @return void
*/
public function setLineNumber($line) {}
/**
* Set File Path where Error trigger
* @param string $file
* @return void
*/
public function setFilePath($file) {}
}
/**
* Experimental Class as Store Front Place as Object
*
* Stores a front place as an object. It registers the front place with
* the API and provides run() and render() methods to execute and display
* the front place in the master file.
*/
class FrontPlaceHolder {
/**
* Create Front Place Object
* @param string $frontname Unique Name of Front Place
* @param string $filepath File Path of Front Place
* @param string $secname Section Name of master file where to display Front PLace
* @param string $type <p> Type of file using in File Path.
* $type = FrontFile(*.place.front) or PHP(Class File *.place.php)
* </p>
* @return void
*/
/**
* Run Front Place before processing master file getHeaderHtml() code
* @return void
*/
public function run() {}
/**
* Call Render in master file where to display html code
* @return void
*/
public function render() {}
}
/**
* SphpVersion class
*
* This class is parent class of all Components. You can Develop SartajPHP Gate with version control
* of this class or simple use SphpBase::page() to implement page object in any php module.
* 
* @author     Sartaj Singh
* @copyright  2007
*/
class SphpVersion {
/**
* Set Version
* @param float $val
* @return void
*/
public function setVersion($val) {}
/**
* Set Minimum Sphp Version
* @param float $val
* @return void
*/
public function setMinVersionSphp($val) {}
/**
* Set Maximum Sphp Version
* @param float $val
* @return void
*/
public function setMaxVersionSphp($val) {}
/**
* Set Minimum PHP Version
* @param float $val
* @return void
*/
public function setMinVersionPhp($val) {}
/**
* Set Maximum PHP Version
* @param float $val
* @return void
*/
public function setMaxVersionPhp($val) {}
/**
* Get Version
* @return float
*/
public function getVersion() {}
/**
* Get Minimum Sphp Version
* @return float
*/
public function getMinVersionSphp() {}
/**
* Get Maximum Sphp Version
* @return float
*/
public function getMaxVersionSphp() {}
/**
* Get Minimum PHP Version
* @return float
*/
public function getMinVersionPhp() {}
/**
* Get Maximum PHP Version
* @return float
*/
public function getMaxVersionPhp() {}
}
}
