<?php
namespace {
/**
* MySQL class
*
* This class should be responsible for all mysql Database activities 
* 
* @author     Sartaj Singh
* @copyright  2007
* @version    4.0.0
*/
class MySQL extends \Sphp\kit\DbEngine {
public static $dlink;
public static $isConnect = false;
public $all_query_ok = true;
/**
* Class Constructor
* This returns the MySQL class object
* @return MySQL
*/
public function connect($db1 = "", $dhost1 = "", $duser1 = "", $dpass1 = "") {}
public function cleanQuery($string) {}
public function clearQuery($string) {}
public function executeQuery($sql) {}
public function executeQueryQuick($sql) {}
public function commitRollback() {}
public function commit() {}
public function rollback() {}
public function disableAutoCommit() {}
public function enableAutoCommit() {}
public function getDatabaseLink() {}
public function multiQuery($sql) {}
public function prepare($sql) {}
public function executeQueryJFX($sql) {}
public function executeQueryQuickJFX($sql) {}
public function disconnect() {}
public function updateSQL($frm, $txttbl, $where) {}
public function insertSQL($frm, $txttbl) {}
public function searchSQL($frm, $tbllist, $where, $OP) {}
public function createDatabase() {}
public function createTable($sql) {}
public function dropTable($tableName) {}
public function isRecordExist($sql) {}
public function row_fetch_assoc($result) {}
public function row_fetch_array($result) {}
public function last_insert_id() {}
public function isCacheExpired($filename, $ttl) {}
public function fetchQuery($sql = "", $ttl = 0, $filename = "", $key = "id", $issave = false) {}
public function insertCache($filename, $key, $data = array(), $tbls = "", $sql = "") {}
public function clearCache($filename) {}
public function updateCache($filename, $keymap, $data = array(), $where = "", $tbls = "", $sql = "") {}
public function deleteCache($filename, $keymap, $where = "", $tbls = "", $sql = "") {}
public function updateCacheSQL($filename, $key, $sql, $priority = 1) {}
public function executeUpdateCacheSQL($filename) {}
}
}