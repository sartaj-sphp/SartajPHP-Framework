<?php
namespace Sphp\Lib{
/**
* MySQLiPdo PDO class
*
* This class should be responsible for all mysql Database activities using PDO
* 
* @author     Sartaj Singh
* @copyright  2007
* @version    4.0.0
*/
class MySqliPdo extends \Sphp\Kit\DbEngine {
public static $dlink;
public static $isConnect = false;
public $allQueryOk = true;
public $sphpApi = null;
/**
* Class Constructor
* This returns the MySQLiPdo class object
* @return MySQLiPdoiPdo
*/
/**
* Connect to the MySQL server using the given host, user and password.
* Parses an optional port from the host string and stores the PDO link
* in the static $dlink property.
* @param string $dbHost1 Host (optionally with :port)
* @param string $dbUser1 Database user
* @param string $dbPass1 Database password
* @return bool True on success, false on failure
*/
public function connectServer($dbHost1, $dbUser1, $dbPass1) {}
/**
* Open a database connection, using the given values or the engine
* settings when a parameter is empty. Connects to the server first if
* not already connected, then selects the database.
* @param string $db1 Database name (empty to use settings)
* @param string $dbHost1 Host (empty to use settings)
* @param string $dbUser1 User (empty to use settings)
* @param string $dbPass1 Password (empty to use settings)
* @return void
* @throws \Exception When the database cannot be opened
*/
public function connect($db1 = "", $dbHost1 = "", $dbUser1 = "", $dbPass1 = "") {}
/**
* Select (USE) the given database on the current connection.
* @param string $db1 Database name
* @return bool True on success, false on failure or when not connected
*/
public function selectDb($db1) {}
/**
* Clean a string for safe inclusion in a query by stripping slashes
* and using PDO quote escaping (without the surrounding quotes).
* @param string $string The string to clean
* @return string The cleaned string
*/
public function cleanQuery($string) {}
/**
* Clear a string by stripping slashes and escaping single and double
* quotes with backslashes.
* @param string $string The string to clear
* @return string The cleared string
*/
public function clearQuery($string) {}
/**
* Execute Query After connect and return result object
* @param string $sql
* @return \PDOStatement | false
*/
public function executeQuery($sql) {}
/**
* Execute Query and Auto connect if not connected and return result object
* @param string $sql
* @return \PDOStatement | false
*/
public function executeQueryQuick($sql) {}
/**
* Commit the current transaction when all queries succeeded,
* otherwise roll it back.
* @return void
*/
public function commitRollback() {}
/**
* Decrement the transaction depth and commit the transaction when the
* depth reaches zero.
* @return void
*/
public function commit() {}
/**
* Decrement the transaction depth and roll back the transaction when
* the depth reaches zero.
* @return void
*/
public function rollback() {}
/**
* Disable auto commit by starting a transaction when not already in
* one and incrementing the transaction depth.
* @return void
*/
public function disableAutoCommit() {}
/**
* Enable auto commit by committing any open transaction, setting the
* PDO auto commit attribute and resetting the transaction depth.
* @return void
*/
public function enableAutoCommit() {}
/**
* Get the static PDO database link.
* @return \PDO|null The PDO link or null
*/
public function getDatabaseLink() {}
/**
* Execute a (possibly multi-statement) SQL string via PDO exec.
* @param string $sql The SQL to execute
* @return bool True on success
*/
public function multiQuery($sql) {}
/**
* Prepare a SQL statement and return the PDOStatement.
* @param string $sql The SQL to prepare
* @return \PDOStatement|false The prepared statement
*/
public function prepare($sql) {}
/**
* Disconnect from the database by clearing the static link and the
* local PDO reference.
* @return void
*/
public function disconnect() {}
/**
* Destructor. Disconnects from the database when the object is destroyed.
* @return void
*/
/**
* Build an UPDATE SQL string from an array of field/value pairs.
* @param array $frm Array of field => value pairs
* @param string $txttbl Table name
* @param string $where WHERE clause
* @return string The generated UPDATE SQL
*/
public function updateSql($frm, $txttbl, $where) {}
/**
* Build and execute an UPDATE SQL string from an array of
* field/value pairs.
* @param string $table Table name
* @param array $ar Array of field => value pairs
* @param string $where WHERE clause
* @return \PDOStatement|false The result of executing the query
*/
public function runUpdateSql($table, $ar,$where) {}        
/**
* Build and execute an INSERT SQL string from an array of
* field/value pairs.
* @param string $table Table name
* @param array $ar Array of field => value pairs
* @return \PDOStatement|false The result of executing the query
*/
public function runSql($table, $ar) {}        
/**
* Build an INSERT SQL string from an array of field/value pairs.
* @param array $frm Array of field => value pairs
* @param string $txttbl Table name
* @return string The generated INSERT SQL
*/
public function insertSql($frm, $txttbl) {}
/**
* Create Insert SQL for Multiple Records from array
* @param array $arr multiple rows of array [["row1"=>"1"],["row2"=>"2"]]
* @param string $txttbl Database Table Name use in insert query
* @return string
*/
public function insertSqlMulti($arr, $txttbl) {}
/**
* Build a SELECT SQL string from an array of field/value pairs with
* the given operator and WHERE clause.
* @param array $frm Array of field => value pairs
* @param string $tbllist Table name
* @param string $where WHERE clause
* @param string $OP Operator (e.g. AND / OR)
* @return string The generated SELECT SQL
*/
public function searchSql($frm, $tbllist, $where, $OP) {}
/**
* Create the database from the engine settings when not already
* connected.
* @return void
*/
public function createDatabase() {}
/**
* Execute a SQL statement via PDO exec, swallowing PDO exceptions.
* @param string $sql The SQL to execute
* @return void
*/
public function exec($sql) {}
/**
* 
* @param string $sql
* @return bool|\PDOStatement
*/
public function isRecordExist($sql) {}
/**
* Fetch the next row from a result as an associative array.
* @param \PDOStatement $result The result statement
* @return array|false The row as associative array, or false
*/
public function rowFetchAssoc($result) {}
/**
* Fetch the next row from a result as both associative and numeric
* array.
* @param \PDOStatement $result The result statement
* @return array|false The row as both arrays, or false
*/
public function rowFetchArray($result) {}
/**
* Get the last inserted ID from the current connection.
* @return string|false The last insert ID, or false
*/
public function lastInsertId() {}        
/**
* Check whether a result contains any rows.
* @param \PDOStatement $result The result statement
* @return bool True when at least one row exists
*/
public function isRows($result) {}
}
}
