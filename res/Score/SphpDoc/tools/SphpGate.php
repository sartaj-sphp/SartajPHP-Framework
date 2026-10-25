<?php
namespace Sphp\tools{
/**
* Description of SphpGate
*
* @author Sartaj Singh
*/
class SphpGate {
protected function _triggerGateEvent() {}
public function startQuickResponse() {}
public function createFrontFile($filepath,$prefix="") {}
/** This features is disabled use SetEventHandler method.
* 
* @param \Sphp\tools\FrontParser $frontobj
*/
protected function _fixCompEventHandlers($frontobj) {}
/**
* Register as Gate Class Method as handler of Component Event. 
* if Event is registered and Trigger by Component then It will trigger method as fixed name 
* as comp_event_{$comp_name}_$event . 
* @param \Sphp\tools\Component $component Component Object
* @param string $event Event Name
*/
protected function setEventHandler($component,$event){}
public function setServerSentEvent($eventurl) {}
public function createWebWorker($jsfunname,$jsfileurl) {}
protected function _genSJSCode($eventname, $ajaxname) {}
}
}
