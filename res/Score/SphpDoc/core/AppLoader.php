<?php
namespace Sphp\core {
class SphpPreRunP {
/**
* Start Event Handler for prerun.php file. include any library here will be available
* in whole project 
*/
public function onstart() {}
}
/**
* Description of AppLoader
*
* @author Sartaj Singh
*/
class AppLoader {
/**
* Advance Function, Internal use
* @return array
* @ignore
*/
public function _load() {}
/**
* Advance Function, Internal use
* @return array
* @ignore
*/
public function _startApp() {}
}
/**
* \Sphp\core\Exception
*/
class Exception extends \Exception {
/**
* Get Line Number of Error
*/
public function getLineNumber() {}
/**
* Get File Path where Error trigger
*/
public function getFilePath() {}
/**
* Set Line Number of Error
*/
public function setLineNumber($line) {}
/**
* Set File Path where Error trigger
*/
public function setFilePath($file) {}
}
class FrontPlace {
/**
* Create Front Place Object
* @param string $frontname Unique Name of Front Place
* @param string $filepath File Path of Front Place
* @param string $secname Section Name of master file where to display Front PLace
* @param string $type <p> Type of file using in File Path.
* $type = FrontFile(*.front) or PHP
* </p>
*/
/**
* Run Front Place before processing master file getHeaderHTML() code
*/
public function run() {}
/**
* Call Render in master file where to display html code
*/
public function render() {}
}
/**
* SphpVersion class
*
* This class is parent class of all Components. You can Develop SartajPHP Application with version control
* of this class or simple use SphpBase::page() to implement page object in any php module.
* 
* @author     Sartaj Singh
* @copyright  2007
*/
class SphpVersion {
public function setVersion($val) {}
public function setMinVersionSphp($val) {}
public function setMaxVersionSphp($val) {}
public function setMinVersionPHP($val) {}
public function setMaxVersionPHP($val) {}
public function getVersion() {}
public function getMinVersionSphp() {}
public function getMaxVersionSphp() {}
public function getMinVersionPHP() {}
public function getMaxVersionPHP() {}
}
}
