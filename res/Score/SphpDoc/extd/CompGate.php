<?php
namespace Sphp\tools {
/**
* Description of CompApp
*
* @author Sartaj Singh
*/
class CompGate extends Gate {
/** @var \Sphp\tools\Front $parentFrontObj **/
public $parentFrontObj = null;
/** @var \Sphp\tools\Component $parentComponent **/
public $parentComponent = null;
/** @var \Sphp\tools\BasicGate $parentgate **/
public $parentgate = null;
public $nameprefix = "";
/**
* 
* @param string $filepath front file path
* @param boolean $noprefix false mean add prefix as parent-component name to all Components
* @return \Sphp\tools\FrontFile
*/
public function createFrontFile($filepath,$noprefix=false) {}
/**
*  Ban Page_new Event handler
*/
public function page_new(){}
protected function call_page_events() {}
/**
* Set Internal Front File. Internal Front File Also render Page Components.
* @param FrontFile $obj 
*/
public function getReturnData() {}
}
}
