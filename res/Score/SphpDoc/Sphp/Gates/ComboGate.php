<?php
namespace Sphp\Gates{
/**
* Description of BasicGate
*
* @author Sartaj Singh
*/
/**
* ComboGate extends BasicGate to support server-side JS (SJS) processing.
* It handles SJS events and generates SJS code during render.
*/
class ComboGate extends BasicGate{
public $sjsobj = null;
public $blnsjsobj = false;
public $sphpApi = null;
public $cfilename = "";
public $myPath = "";
public $myUrl = "";
/**
* Constructor, initializes gate properties and starts the gate.
*/
/**
* Setup front file object, initialize SJS and component event handlers.
* @param FrontFile $frontobj
*/
public function setup($frontobj){}
/**
* Process front file object.
* @param FrontFile $frontobj
*/
public function process($frontobj){}
/**
* Process gate events.
*/
public function processEvent(){}
/**
* Call page events based on request type.
*/
protected function callPageEvents(){}
/**
* Run the gate lifecycle.
*/
public function run(){}
/**
* Render the gate and generate SJS code.
*/
public function render(){}
/**
* Set class path and filename from reflection.
*/
public function setClassPath() {}
}
}
