<?php
namespace Sphp\kit{
/**
* Description of ajax
*
* @author SARTAJ
*/
use \PDO;
class Ajax {
public function postDataAjax($url, $outputID, $showObj = '', $flds = Array(), $MIMEType = '', $data = false) {}
public function getDataAjax($url, $outputID, $showObj = '') {}
}
class SQLiteSessionHandler implements \SessionHandlerInterface {
public function open($savePath, $sessionName): bool {}
public function close(): bool {}
public function read($id): string {}
public function write($id, $data): bool {}
public function destroy($id): bool {}
public function gc($maxlifetime): int|false {}
}
class Session {
public $name = "";
/**
* Register DB as session handler rather then Files. It
*  stops the "perma-freeze" blocking issue.
*  Call it before session_start
*/
public function useSqliteDb(){}
/**
* Register Redis Server as session handler rather then Files. It
*  stops the "perma-freeze" blocking issue and very fast and work in memory.
*  $url as Redis server URL default is tcp://127.0.0.1:6379 .
*  Call it before session_start
*/
public function useRedisServer($url="tcp://127.0.0.1:6379"){}
public function setSessionID($uid){}
public function getSessionID(){}
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
