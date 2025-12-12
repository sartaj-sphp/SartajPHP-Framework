<?php
namespace {
/**
* PostgresSQLPdo PDO class
*
* This class should be responsible for all PostgreSQL Database activities using PDO
* 
* @author     Sartaj Singh
* @copyright  2007
* @version    4.0.0
*/
class PostgresSQLPdo extends \Sphp\kit\DbEngine {
public static $dlink;
public static $isConnect = false;
public $all_query_ok = true;
public $sphp_api = null;
/**
* Class Constructor
* This returns the PostgresSQLPdo class object
* @return PostgresSQLPdo
*/
public function connectServer($dhost1, $duser1, $dpass1) {}
public function connect($db1 = "", $dhost1 = "", $duser1 = "", $dpass1 = "") {}
public function selectDB($db1) {}
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
public function runSQL($table, $ar) {}        
public function insertSQL($frm, $txttbl) {}
/**
* Create Insert SQL for Multiple Records from array
* @param array $arr multiple rows of array [["row1"=>"1"],["row2"=>"2"]]
* @param string $txttbl Database Table Name use in insert query
* @return string
*/
public function insertSQLMulti($arr, $txttbl) {}
public function searchSQL($frm, $tbllist, $where, $OP) {}
public function createDatabase() {}
public function createTable($sql) {}
public function dropTable($tableName) {}
/**
* 
* @param string $sql
* @return bool|\PDOStatement
*/
public function isRecordExist($sql) {}
public function row_fetch_assoc($result) {}
public function row_fetch_array($result) {}
public function last_insert_id() {}        
}
}