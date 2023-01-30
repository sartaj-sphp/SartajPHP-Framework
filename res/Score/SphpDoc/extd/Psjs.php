<?php
namespace Sphp\tools{
/**
* Description of Psjs
*
* @author Sartaj Singh
*/
class Psjs {
public $strdata = "";
public $strlen = -1;
public $file_arr = array();
public function __construct($filepath) {}
public function parseJavascript() {}
public function parseJavascriptBlock($start, $find_start, $find_end) {}
public function fixCompEventHandlers($tempobj) {}
public function processSJSEvent() {}
public function processSJSFunction($jsstate, $jsfunname, $obj_method) {}
public function sendJs($fun, $jsfun, $funtype = false) {}
public function addJSFunction($jsfun) {}
public function genSJSCode($eventname, $ajaxname) {}
}
}