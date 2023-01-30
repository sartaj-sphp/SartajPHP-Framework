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
public static function __callStatic($name, $arguments) {
}
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
}
class Event{
public function setHandler($eventhandlerobj, $handler) {}
public function raiseEvent($arglst = array()) {}
}
}
