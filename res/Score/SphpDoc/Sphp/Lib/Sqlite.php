<?php
namespace Sphp\Lib{
/**
* sqlite class
*
* This class should be responsible for all sqlite Database activities 
* 
* @author     Sartaj Singh
* @copyright  2007
* @version    4.0.0
*
* Database adapter for SQLite3. Manages the connection lifecycle (connect,
* disconnect, commit), executes queries, builds UPDATE/INSERT/SELECT SQL
* strings, and inspects database tables and columns.
*/
class Sqlite extends \Sphp\Kit\DbEngine{
public static $dlink;
public static $isConnect = false;
public $allQueryOk = true;
/**
* Class Constructor
* This returns the sqlite class object
* @return sqlite
*/
/**
* Connect to the SQLite database.
* @param string $db1 database file name
* @param string $dbHost1 host (unused for sqlite)
* @param string $dbUser1 user (unused for sqlite)
* @param string $dbPass1 password (unused for sqlite)
* @return void
*/
public function connect($db1 = "", $dbHost1 = "", $dbUser1 = "", $dbPass1 = "") {}
/**
* Clean a string for safe use in a query.
* @param string $string
* @return string escaped string
*/
public function cleanQuery($string) {}
/**
* Clear a string by removing slashes and escaping quotes.
* @param string $string
* @return string cleaned string
*/
public function clearQuery($string) {}
/**
* Execute a query and return the result.
* @param string $sql
* @return \SQLite3Result|false result or false on error
*/
public function executeQuery($sql) {}
/**
* Execute a query quickly, connecting and disconnecting as needed.
* @param string $sql
* @return \SQLite3Result|false result or false on error
*/
public function executeQueryQuick($sql) {}
/**
* Commit the current transaction.
* @return void
*/
public function commit() {}
/**
* Get the database link.
* @return \SQLite3
*/
public function getDatabaseLink() {}
/**
* Prepare a statement.
* @param string $sql
* @return \SQLite3Stmt
*/
public function prepare($sql) {}
/**
* Disconnect from the database.
* @return void
*/
public function disconnect() {}
/**
* Destructor, disconnects from the database.
* @return void
*/
/**
* Build an UPDATE SQL string.
* @param array $frm field/value pairs
* @param string $txttbl table name
* @param string $where where clause
* @return string
*/
public function updateSql($frm, $txttbl, $where) {}
/**
* Build an INSERT SQL string.
* @param array $frm field/value pairs
* @param string $txttbl table name
* @return string
*/
public function insertSql($frm, $txttbl) {}
/**
* Build a SELECT SQL string.
* @param array $frm field/value pairs
* @param string $tbllist table list
* @param string $where where clause
* @param string $OP operator
* @return string
*/
public function searchSql($frm, $tbllist, $where, $OP) {}
/**
* Create a new database.
* @return void
*/
public function createDatabase() {}
/**
* Execute a statement.
* @param string $sql
* @return void
*/
public function exec($sql) {}
/**
* Check if a record exists.
* @param string $sql
* @return \SQLite3Result|false
*/
public function isRecordExist($sql) {}
/**
* Fetch a row as an associative array.
* @param \SQLite3Result $result
* @return array
*/
public function rowFetchAssoc($result) {}
/**
* Fetch a row as a numeric array.
* @param \SQLite3Result $result
* @return array
*/
public function rowFetchArray($result) {}
/**
* Get the last inserted row id.
* @return int
*/
public function lastInsertId() {}
/**
* Get a unique key for a row.
* @param string $key
* @param array $row
* @return string
*/
/**
* Fetch a query result.
* @param string $sql
* @param int $ttl
* @param string $filename
* @param string $key
* @param bool $issave
* @return array
*/
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
/**
*  Check if result has rows of data
* @param Result Object From Database $param
* @return boolean true if rows exist
*/
public function isRows($result) {}
}
}