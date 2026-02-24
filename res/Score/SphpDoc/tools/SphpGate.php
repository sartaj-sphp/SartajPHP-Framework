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
protected function _fixCompEventHandlers($frontobj) {}
public function setServerSentEvent($eventurl) {}
public function createWebWorker($jsfunname,$jsfileurl) {}
protected function _genSJSCode($eventname, $ajaxname) {}
}
}
