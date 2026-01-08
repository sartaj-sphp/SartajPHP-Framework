<?php
namespace Sphp\tools{
/**
* Description of SphpApp
*
* @author Sartaj Singh
*/
class SphpApp {
public function _registerFront($frontobj) {}
protected function _triggerAppEvent() {}
public function startQuickResponse() {}
public function createFrontFile($filepath,$prefix="") {}
protected function _fixCompEventHandlers($frontobj) {}
public function setServerSentEvent($eventurl) {}
public function createWebWorker($jsfunname,$jsfileurl) {}
protected function _genSJSCode($eventname, $ajaxname) {}
}
}
