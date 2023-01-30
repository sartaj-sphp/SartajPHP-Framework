<?php
namespace Sphp\kit{
/**
* Description of ajax
*
* @author SARTAJ
*/
class Ajax {
public function postDataAjax($url, $outputID, $showObj = '', $flds = Array(), $MIMEType = '', $data = false) {}
public function getDataAjax($url, $outputID, $showObj = '') {}
}
class Session {
public function setSessionName($name="SphpID") {}
public function setSessionSavePath($path="") {}
public function closeSession() {}
public function sessionStart(){}
public function setSession($lType,$uid1){}
public function destSession(){}
}
/**
* Description of jq
*
* @author Sartaj Singh
*/
class jq {
public $jsstate = "of";
public function __construct() {}
public function __invoke($param1) {}
public function __call($name, $arguments) {}
public static function __callStatic($name, $arguments) {}
public function __get($varName) {}
public function __set($varName, $value) {}
public function __toString() {}
}
/**
* Description of Eventer
*
* @author Sartaj Singh
*/
class Eventer{
public $obj="";
public $evt="";
public $event="";
public $ui="";
public function __construct() {}
}
class Event{
public function __construct($targetobj) {}
public function setHandler($eventhandlerobj, $handler) {}
public function raiseEvent($arglst = array()) {}
}
}
