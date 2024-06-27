<?php
namespace {
/**
* sqlite class
*
* This class should be responsible for all sqlite Database activities 
* 
* @author     Sartaj Singh
* @copyright  2007
* @version    4.0.0
*/
class Sqlite extends \Sphp\kit\DbEngine{
public static $dlink;
public static $isConnect = false;
public $all_query_ok = true;
/**
* Class Constructor
* This returns the sqlite class object
* @return sqlite
*/
public function connect($db1 = "", $dhost1 = "", $duser1 = "", $dpass1 = "") {}
public function cleanQuery($string) {}
public function clearQuery($string) {}
public function executeQuery($sql) {}
public function executeQueryQuick($sql) {}
public function commit() {}
public function getDatabaseLink() {}
public function prepare($sql) {}
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
public function fetchQuery($sql = "", $ttl = 0, $filename = "", $key = "id", $issave = false) {}
/**
* List Tables in Database. execute SHOW TABLES query. Override this function when you need to
* create of database adapter.
* @return array
*/
public function getDbTables() {}
/**
* List Fields in a Table. Override this function when you need to
* create of database adapter. Default work with MySQL
* @param string $tablename <p>
* pass table name in database
* </p>
* @return array
*/
public function getTableColumns($tablename) {}
}
}