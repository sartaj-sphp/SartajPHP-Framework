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
public $sphp_api = null;
/**
* Class Constructor
* This returns the MySQL class object
* @return MySQL
*/
/**
*  Connect to Database Server
* @param string $dhost1
* @param string $duser1
* @param string $dpass1
* @return bool
*/
public function connectServer($dhost1, $duser1, $dpass1) {}
/**
*  Connect Server and Database
*  If already connected then it will no effect and use existed connection 
*  If leave all parameters then it will be use comp.php file settings
* @param string $db1
* @param string $dhost1
* @param string $duser1
* @param string $dpass1
* @throws \Exception
*/
public function connect($db1 = "", $dhost1 = "", $duser1 = "", $dpass1 = "") {}
/**
* Manually Connect to Database or change Database
* @param string $db1
* @return bool
*/
public function selectDB($db1) {}
/**
*  Clean any string value before to insert into database.
*  No need if you use Page class methods or Component to inset or update 
*  Data into Database. Use Database engine method to escape string.
*  It may be required when you read directly POST or GET variables
* @param string $string
* @return string
*/
public function cleanQuery($string) {}
/**
*  Strip Slashes and escape quote in string.  
*  No need if you use cleanQuery,Page class methods or Component to inset or update 
*  Data into Database.
*  It may be required when you read directly POST or GET variables
* @param string $string
* @return string
*/
public function clearQuery($string) {}
/**
*  Execute SQL but it will not check connection 
*  It will be give error if Database is not connected 
* @param string $sql
* @return object|bool
*/
public function executeQuery($sql) {}
/**
*  Execute SQL but it will be connect to database if not connected 
* @param string $sql
* @return object|bool
*/
public function executeQueryQuick($sql) {}
/**
* If all queries are executed successfully then it will commit otherwise rollback
*/
public function commitRollback() {}
/**
* Manually Commit
*/
public function commit() {}
/**
* Manually Rollback
*/
public function rollback() {}
/**
* Start Multiple Transactions and manually commit or rollback
*/
public function disableAutoCommit() {}
/**
* Auto commit after each SQL execution
*/
public function enableAutoCommit() {}
/**
* Get Database Connection Object
* @return object
*/
public function getDatabaseLink() {}
/**
* Multi SQL statements separate by semi colon
* @param string $sql
* @return bool
*/
public function multiQuery($sql) {}
/**
*  Prepare SQL Statement for execute later
* @param string $sql
* @return object|bool
*/
public function prepare($sql) {}
/**
* Disconnect connection from Database if connected otherwise ignored
*/
public function disconnect() {}
/**
*  Generate UPDATE SQL from associative array 
*  It will be also clean all values of array and connect to database if not connected 
* @param array $frm Fields -Value Pair
* @param string $txttbl Table Name
* @param type $where WHERE logic
* @return string Generated SQL
*/
public function updateSQL($frm, $txttbl, $where) {}
/**
* Run SQL will be generate INSERT SQL from Array and execute it
* @param string $table Table Name
* @param array $ar Associative Array of Fields-Value Pairs
* @return object|bool
*/
public function runSQL($table,$ar) {}        
/**
*  Generate INSERT SQL from associative array 
*  It will be also clean all values of array and connect to database if not connected 
* @param array $frm Fields -Value Pair
* @param string $txttbl Table Name
* @return string Generated SQL
*/
public function insertSQL($frm, $txttbl) {}
/**
* Create Insert SQL for Multiple Records from array
* @param array $arr multiple rows of array [["row1"=>"1"],["row2"=>"2"]]
* @param string $txttbl Database Table Name use in insert query
* @return string SQL for execution
*/
public function insertSQLMulti($arr, $txttbl) {}
/**
*  Generate SELECT SQL from Associative Array
*  It will be also clean all values of array and connect to database if not connected 
* @param array $frm Associative Array of Field-Value Pairs to use with WHERE
* @param string $tbllist Table list separate by comma or single table
* @param string $where extra WHERE Logic
* @param string $OP operator use in WHERE like filed=value $OP like AND
* @return string
*/
public function searchSQL($frm, $tbllist, $where, $OP) {}
/**
* Create Database according the settings in comp.php
*/
public function createDatabase() {}
/**
*  Execute any type SQL directly
* @param string $sql
*/
public function exec($sql) {}
/**
*  Check if Record Exist
* @param string $sql
* @return bool|Array
*/
public function isRecordExist($sql) {}
/**
*  Get DB Row as Associative Array
* @param object $result
* @return array
*/
public function row_fetch_assoc($result) {}
/**
*  Get DB Row as Array
* @param object $result
* @return array
*/
public function row_fetch_array($result) {}
/**
* Get  DB Last Inserted id filed value as unique primary key
* @param object $result
* @return array
*/
public function last_insert_id() {}        
}
}