<?php
namespace Sphp\core{
class SphpPreRunP{
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
public function load(){}
/**
* Advance Function, Internal use
* @return array
* @ignore
*/
public function startApp() {}
}
/**
* \Sphp\core\Exception
*/
class Exception extends \Exception{
protected $line = 0;
protected $file = "";
/**
* Set Line Number of Error
* @param int $line
*/
public function setLine($line) {}
/**
* Set File Path where Error trigger
* @param string $filepath
*/
public function setFile($filepath) {}
}
class FrontPlace{
/**
* Create Front Place Object
* @param string $frontname Unique Name of Front Place
* @param string $filepath File Path of Front Place
* @param string $secname Section Name of master file where to display Front PLace
* @param string $type <p> Type of file using in File Path.
* $type = TempFile(*.front) or PHP
* </p>
*/
/**
* Run Front Place before processing master file getHeaderHTML() code
*/
public function run(){}
/**
* Call Render in master file where to display html code
*/
public function render(){}
}
/**
* SphpVersion class
*
* This class is parent class of all Controls. You can Develop SartajPHP Application with version control
* of this class or simple use SphpBase::page() to implement page object in any php module.
* 
* @author     Sartaj Singh
* @copyright  2007
*/
class SphpVersion{
public function setVersion($val){}
public function setMinVersionSphp($val){}
public function setMaxVersionSphp($val){}
public function setMinVersionPHP($val){}
public function setMaxVersionPHP($val){}
public function getVersion(){}
public function getMinVersionSphp(){}
public function getMaxVersionSphp(){}
public function getMinVersionPHP(){}
public function getMaxVersionPHP(){}
}
}
