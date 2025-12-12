<?php
namespace {
/**
* MySQLO class for old mysql extension of php like php5.4 and old
*
* This class should be responsible for all mysql Database activities 
* 
* @author     Sartaj Singh
* @copyright  2003
* @version    2.0.0
*/
class MySQLO extends \Sphp\kit\DbEngine {
public static $dlink;
public static $isConnect = false;
public $all_query_ok = true;
public $sphp_api = null;
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
public function executeQueryJFX($sql) {}
public function executeQueryQuickJFX($sql) {}
public function disconnect() {}
public function updateSQL($frm, $txttbl, $where) {}
public function runSQL($table, $ar) {}        
public function insertSQL($frm, $txttbl) {}
public function insertSQLMulti($arr, $txttbl) {}
public function searchSQL($frm, $tbllist, $where, $OP) {}
public function createDatabase() {}
public function createTable($sql) {}
public function dropTable($tableName) {}
public function isRecordExist($sql) {}
public function row_fetch_assoc($result) {}
public function row_fetch_array($result) {}
public function last_insert_id() {}
/**
*  Check if result has rows of data
* @param Result Object From Database $param
* @return boolean true if rows exist
*/
public function is_rows($result) {}
}
}
