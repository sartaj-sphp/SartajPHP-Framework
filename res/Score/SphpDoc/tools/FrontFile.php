<?php
namespace Sphp\tools {
/**
* Description of FrontPlace
*  Parent Class for create PHP Class as Front Place Object. 
*  Front Place is generate dynamic content in Master File and it can enable, disable by Master File.
*  For Example you can generate a slider with PHP file rather then FrontFile.
*/
abstract class FrontPlace{
abstract protected function _run();
abstract protected function render();
}
/**
* Description of FrontFile
*
* @author Sartaj Singh
*/
class FrontFile {}
/**
* Child Front File Share Components and meta data with parent as reference not a copy. So changes in child
*  effect in parent also.
*/
class FrontFileChild extends FrontFile {
/**
* Advance Function
* Add component object in FrontFile
* @param string $key component name or id in HTML code
* @param \Sphp\tools\Component $obj
*/
public function _setComponent($key, $obj) {}
}
class FrontFileComp extends FrontFile {
}
}
