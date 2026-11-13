<?php
namespace Sphp\Lib{
/**
* PostgresSqlPdo PDO class
*
* This class should be responsible for all PostgreSQL Database activities using PDO
* 
* @author     Sartaj Singh
* @copyright  2007
* @version    4.0.0
*
* Provides a PDO-based wrapper for PostgreSQL: connection management,
* query execution, transaction control, SQL string builders (insert,
* update, search) and row fetching helpers.
*/
class PostgresSqlPdo extends \Sphp\Kit\DbEngine {
public static $dlink;
public static $isConnect = false;
public $allQueryOk = true;
public $sphpApi = null;
/**
* Class Constructor
* This returns the PostgresSQLPdo class object
* @return PostgresSQLPdo
*/
/**
* Connect to the PostgreSQL server using the given host, user and password.
* @param string $dbHost1 Host (optionally with port, e.g. "host:5432")
* @param string $dbUser1 Database user
* @param string $dbPass1 Database password
* @return bool true on success, false on failure
*/
public function connectServer($dbHost1, $dbUser1, $dbPass1) {}
/**
* Open a connection to the database, using settings defaults when arguments are empty.
* @param string $db1 Database name (defaults to settings db)
* @param string $dbHost1 Host (defaults to settings host)
* @param string $dbUser1 User (defaults to settings user)
* @param string $dbPass1 Password (defaults to settings password)
* @return void
*/
public function connect($db1 = "", $dbHost1 = "", $dbUser1 = "", $dbPass1 = "") {}
/**
* Select (switch to) the given database.
* @param string $db1 Database name
* @return bool true on success, false on failure
*/
public function selectDb($db1) {}
/**
* Clean a string for safe inclusion in a SQL query using PDO quoting.
* @param string $string Input string
* @return string Cleaned string
*/
public function cleanQuery($string) {}
/**
* Clear a string by escaping single and double quotes.
* @param string $string Input string
* @return string Cleared string
*/
public function clearQuery($string) {}
/**
* Execute a SQL query and return the result.
* @param string $sql SQL query
* @return \PDOStatement|false Result on success, false on failure
*/
public function executeQuery($sql) {}
/**
* Execute a SQL query, connecting first if needed and disconnecting afterwards.
* @param string $sql SQL query
* @return \PDOStatement|false Result on success, false on failure
*/
public function executeQueryQuick($sql) {}
/**
* Commit the transaction if all queries succeeded, otherwise roll back.
* @return void
*/
public function commitRollback() {}
/**
* Commit the current transaction.
* @return void
*/
public function commit() {}
/**
* Roll back the current transaction.
* @return void
*/
public function rollback() {}
/**
* Disable auto commit and begin a transaction.
* @return void
*/
public function disableAutoCommit() {}
/**
* Enable auto commit, committing any open transaction first.
* @return void
*/
public function enableAutoCommit() {}
/**
* Get the static PDO database link.
* @return \PDO|null PDO instance or null
*/
public function getDatabaseLink() {}
/**
* Execute multiple SQL statements separated by semicolons.
* @param string $sql SQL string containing multiple statements
* @return bool true on success
*/
public function multiQuery($sql) {}
/**
* Prepare a SQL statement.
* @param string $sql SQL query
* @return \PDOStatement|false Prepared statement on success, false on failure
*/
public function prepare($sql) {}
/**
* Disconnect from the database and release the link.
* @return void
*/
public function disconnect() {}
/**
* Destructor, disconnects from the database.
* @return void
*/
/**
* Build an UPDATE SQL string from an array of field/value pairs.
* @param array $frm Field/value pairs
* @param string $txttbl Table name
* @param string $where WHERE clause
* @return string UPDATE SQL string
*/
public function updateSql($frm, $txttbl, $where) {}
/**
* Build and execute an INSERT SQL string for the given table and data.
* @param string $table Table name
* @param array $ar Field/value pairs
* @return \PDOStatement|false Result of the executed query
*/
public function runSql($table, $ar) {}        
/**
* Build an INSERT SQL string from an array of field/value pairs.
* @param array $frm Field/value pairs
* @param string $txttbl Table name
* @return string INSERT SQL string
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
* Build a SELECT SQL string from an array of field/value pairs.
* @param array $frm Field/value pairs
* @param string $tbllist Table list
* @param string $where Additional WHERE clause
* @param string $OP Logical operator (AND/OR)
* @return string SELECT SQL string
*/
public function searchSql($frm, $tbllist, $where, $OP) {}
/**
* Create the database configured in settings if not already connected.
* @return void
*/
public function createDatabase() {}
/**
* Create a table using the given SQL.
* @param string $sql CREATE TABLE SQL
* @return void
*/
public function createTable($sql) {}
/**
* Drop a table by name.
* @param string $tableName Table name
* @return void
*/
public function dropTable($tableName) {}
/**
* 
* @param string $sql
* @return bool|\PDOStatement
*/
public function isRecordExist($sql) {}
/**
* Fetch the next row from a result as an associative array.
* @param \PDOStatement $result Result set
* @return array|false Associative row on success, false on failure
*/
public function rowFetchAssoc($result) {}
/**
* Fetch the next row from a result as an array (both numeric and associative).
* @param \PDOStatement $result Result set
* @return array|false Row on success, false on failure
*/
public function rowFetchArray($result) {}
/**
* Get the last inserted ID.
* @return string Last inserted ID
*/
public function lastInsertId() {}        
}
}