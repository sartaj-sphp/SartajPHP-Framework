<?php
/**
* Page class
*
* This is low level class of Page Events, It Trigger all PageEvent for Gate Class. It is set Even Flags and set 
*  Event name and parameter then Gate Class Route Events according to their type of Class and way of 
*  development of Application.
* SphpBase::page() function to get page object of Current Request in any php file and $this->page to get Page 
* Object in Gate Class.
* 
* @author     Sartaj Singh
* @copyright  2007
*/
namespace Sphp\Kit{
class Page {
public $authentication = false;
public $isnew = false;
public $issubmit = false;
public $isevent = false;
public $sact = "";
public $evtp = "";
/**
* Directory path of the current Gate
*/
public $gateDirPath = "";
/**
* File path of the current Gate
*/
public $gateFilePath = "";
/**
* Current Gate object
*/
public $currentGateObj = null;
public $tblName = "";
public $auth = "";
public $masterfilepath = "";
/** Gate use Session Security */
public $isSesSecure = false;
/**
* Advance No Use
* @depends start
*/
/**
* Get Gate Event name of current request
* @return string
*/
public function getEvent() {}
/**
* Get Gate Event parameter of current request
* @return string
*/
public function getEventParameter() {}
/**
* Get Request to Landing URL of Gate
* Return True if page_new event triggered
* @return bool
*/
public function isNewEvent(){}
/**
* Data Post on Landing URL of Gate
* Return True if page_submit event triggered
* @return bool
*/
public function isSubmitEvent(){}
/**
* Browser Request to Event URL of Gate
* Return True if page_submit event triggered
* @return bool
*/
public function isUrlEvent(){}
/** Advance 
* Overload, Event Handler For Gate Type development
*/
public function init() {}
/**
* Start page event detection from router
*/
/**
* Get profile permission of current user
*/
/**
* Set which user Permission can access this Gate. Default Permission is ALL.
* You can set session variable in login Gate 
* SphpBase::sphpRequest()->session('lstpermis','profile-view,prfile-delete');
* If user is not login with specific permission then Gate exit and
* redirect according to the getWelcome function in comp.php
*  It will exit PHP script and so no further execution on fail.
* @param string $perm Default=null mean, permission to everyone<p>
* @param string $gate optional Default is current Gate, permission like index-view where index is Gate.
* permission to allow Gate Processing. Example:- AuthenticatePerm("view")
* </p>
* @return boolean true if permission match with session variable lstpermis, never return false because no further execution.
*/
public function getAuthenticatePerm($perm=null,$gate=null) {}
/**
*  Check Permission is given to Authorized user or not given.
* @param string $perm permission to check
* @param string $gate optional Default is current Gate, permission like index-view where index is Gate.
* @return bool return true if permission found
*/
public function hasPermission($perm,$gate=null) {}
/**
* Set which user can access this Gate. Default user is GUEST.
* You can set session variable in login Gate 
* SphpBase::sphpRequest()->session('logType','ADMIN');
* If user is not login with specific type then Gate exit and
* redirect according to the getWelcome function in comp.php
*  It will exit PHP script and so no further execution on fail.
* @param string $auth <p>
* comma separated list of string. Example:- getAuthenticate("GUEST,ADMIN") or getAuthenticate("ADNIN")
* </p>
* @return boolean true if user type match with session variable logType, never return false
*/
public function getAuthenticate($auth="") {}
/** Advance
* Authorised base on server variables, in session less environment
* @param string $auth
* @depends getAuthenticate
*/
public function getAuthenticateSvar($auth="") {}
/**
* Check if user type in session logType = unauthorised
* @param string $param <p>
* comma separated list of string. Example:- checkUnAuth("GUEST,ADMIN") or checkUnAuth("ADNIN")
* </p>
* @return boolean true if user type match with session variable logType
*/
public function checkUnAuth($param) {}
/**
* Check if user type in session logType = authorised
* @param string $param <p>
* comma separated list of string. Example:- checkAuth("GUEST,ADMIN") or checkAuth("ADNIN")
* </p>
* @return boolean true if user type match with session variable logType
*/
public function checkAuth($param) {}
/**
* Read logType session variable as User Type of login user which is set in login Gate
* @return string
*/
public function getAuthenticateType() {}
/** Gate exit if URL isn't session secure
*@return Gate exit if URL isn't session secure
*/
public function getSesSecurity() {}
/**
* Forward request to url
* @param string $loc <p>
* pass url address
* </p>
*/
public function forward($loc) {}
/**
* Set default Database Engine for execute query and managing connections 
* Default is MySQL
* @param \MySQL $objdbengine
*/
public function setDbEngine($objdbengine) {}
/**
* This Function delete the record of database table with generate and execute delete query.
* DELETE FROM $tblName WHERE id='$evtp'
* $tblName = default table of Gate
* $evtp = \SphpBase::page()->getEventParameter()
* @param string $recid If empty then use event parameter as record id.<br>
*
*/
public function deleteRec($recid="") {}
/**
* When Components use Database Binding. Then This Function insert the values to database table from a
* component value. This insert a new record in table.<br>
* $extra = array()
* $extra['table']['datecreate'] = date('Y-m-d)
*  OR
* $extra[]['datecreate'] = date('Y-m-d)
* insertData($extra)
* @param array $extra extra fields to insert with query.
* @return int|bool Return Inserted Last ID
*/
public function insertData($form1,$extra = array()) {}
/**
* When Components use Database Binding. Then This Function Fill the values from database table to a
* Component value.<br>
* changeable $sql = "SELECT $fldList FROM $tbln $where"<br>
* $tbln = use default tblName of Gate or Components dtable attribute
* SphpBase::page()->viewData(,,"WHERE id='1'");<br>
* SphpBase::page()->viewData('','aname,pass,lst',"WHERE lastname='devel'");<br>
* @param type $form <p> Form Component
* Read value from database and fill all Children Components of Form object which is bind with field of table.
* </p>
* @param string $recID <p>
*  Every table should have unique,auto increment and primary filed and default it has name id. 
* id = record id in table, pass this record id to $recID or if it is empty then it uses SphpBase::page()->getEventParameter()
* </p>
* @param string $fldList <p>
* pass comma separated list of table fields or otherwise it is *
* </p>
* @param string $where WHERE Logic in SQL
*
*/
public function viewData($form , $recID = "", $fldList = "", $where = "") {}
/**
* When Components use Database Binding. Then This Function Update the values to database table from a
* Component value. This update old record in table. This will only update Children of Form Component only.
* It will not update all bound components to Database. So Form Component is required to pass.
* $extra = array()
* $extra['table']['dateupdate'] = date('Y-m-d)
*  OR
* $extra[]['dateupdate'] = date('Y-m-d)
* updateData($extra)
* @param \Sphp\Tools\Component $form1 Form Component or container uses for getAllChildren.
* @param array $extra is extra fields to insert with query.
* @param string $recID Optional if empty then use $form1->getRecID()
*  Every table should have unique,auto increment and primary filed and SartajPHP use default name "id". 
* id = record id in table, pass this record id to $recID or if it is empty then it uses 
* Form Component recID = $form1->getRecID()
* 
* @param string $where WHERE Logic in SQL You can over write WHERE id=1 login to use other 
* field to update record.
*/
public function updateData($form1,$extra = array(), $recID = '', $where = '') {}
}
class DbEngine{
/**
* Fix Bad Format in Query call clearQuery
* @param string $string
* @depends clearQuery
* @return string
*/
public function cleanQuery($string) {}
/**
* Fix Bad Format in Query
* @param string $string
* @return string
*/
public function clearQuery($string) {}
/**
* Get unique key from row data
* @param string $key
* @param array $row
* @return string
*/
/**
* Fetch query result with optional caching
* @param string $sql
* @param int $ttl
* @param string $filename
* @param string $key
* @param bool $issave
* @return array
*/
public function fetchQuery($sql = "", $ttl = 0, $filename = "", $key = "id", $issave = false) {}
/**
* Insert data to cache
* @param string $filename
* @param string $key
* @param array $data
* @param string $tbls
* @param string $sql
* @return bool
*/
public function insertCache($filename, $key, $data = array(), $tbls = "", $sql = "") {}
/**
* Clear cache file
* @param string $filename
* @return bool|null
*/
public function clearCache($filename) {}
/**
* Update data in cache
* @param string $filename
* @param string $keymap
* @param array $data
* @param string $where
* @param string $tbls
* @param string $sql
* @return bool
*/
public function updateCache($filename, $keymap, $data = array(), $where = "", $tbls = "", $sql = "") {}
/**
* Delete data from cache
* @param string $filename
* @param string $keymap
* @param string $where
* @param string $tbls
* @param string $sql
* @return bool
*/
public function deleteCache($filename, $keymap, $where = "", $tbls = "", $sql = "") {}
/**
* Update cache SQL
* @param string $filename
* @param string $key
* @param string $sql
* @param int $priority
* @return bool
*/
public function updateCacheSql($filename, $key, $sql, $priority = 1) {}
/**
* Execute update cache SQL
* @param string $filename
* @return bool
*/
public function executeUpdateCacheSql($filename) {}
/**
* Import table data as PHP Code. Override this function when you need to
* create of database adapter. Default work with MySQL
* @param string $tablenl <p>
* Comma Separated string as table names or table name
* </p>
* @param string $where <p>
* where logic for query
* </p>
* @return string
*/
public function getTableSql($tablenl, $where = "") {}
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
* List Tables in Database. execute SHOW TABLES query. Override this function when you need to
* create of database adapter. Default work with MySQL
* @return array
*/
public function getDbTables() {}
/**
* Generate a Table CREATE query. Override this function when you need to
* create of database adapter. Default work with MySQL
* @param string $table <p> table name
* </p>
* @return string
*/
public function getCreateTableSql($table) {}
/**
*  Check if result has rows of data
* @param Result Object From Database $param
* @return boolean true if rows exist
*/
public function isRows($result) {}
/**
* Create table
* @param string $sql
*/
public function createTable($sql) {}
/**
* Drop table
* @param string $tableName
*/
public function dropTable($tableName) {}
/**
* Empty table
* @param string $tableName
*/
public function emptyTable($tableName) {}
}
}
