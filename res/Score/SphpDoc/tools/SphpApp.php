<?php
namespace Sphp\tools{
/**
* Description of SphpApp
*
* @author Sartaj Singh
*/
class SphpApp {
public function registerTemp($tempobj) {}
public function triggerAppEvent() {}
public function startQuickResponse() {}
public function createTempFile($filepath,$prefix="") {}
public function fixCompEventHandlers($tempobj) {}
public function setServerSentEvent($eventurl) {}
public function createWebWorker($jsfunname,$jsfileurl) {}
public function genSJSCode($eventname, $ajaxname) {}
}
}
