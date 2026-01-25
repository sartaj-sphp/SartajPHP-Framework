<?php
/**
* page class
*
* This class is parent class of all page application. You can Develop SartajPHP Application with extend
* of this class or simple use SphpBase::page() function to implement page object in any php module.
* 
* @author     Sartaj Singh
* @copyright  2007
*/
namespace Sphp\kit{
class Page {
public $authentication = false;
public $issubmit = false;
public $isview = false;
public $isnew = false;
public $isdelete = false;
public $isinsert = false;
public $isupdate = false;
public $isaction = false;
public $isevent = false;
public $act = "";
public $sact = "";
public $evtp = "";
public $txtid = "";
public $apppath = "";
public $appfilepath = "";
public $appobj = null;
public $tblName = "";
public $auth = "";
public $masterfilepath = "";
/** App use Session Security */
public $isSesSecure = false;
/**
* Advance No Use
* @depends start
*/
/** Advance 
* Overload, Event Handler For App Type development
*/
public function page_init() {}
/** Advance 
* Overload, Event Handler For App Type development
*/
public function page_load() {}
/** Advance 
* Appgate Event handler like (url=index-page-contacts.html)
* this function gives $event = page and $evtp = contacts
* @param string $event
* @param string $evtp
*/
public function page_event($event, $evtp) {}
/** Advance 
* Custom action designer. Default value delete or view or evt. 
* like for events value = evt
* @param string $act
* @param string $event
* @param string $evtp
*/
public function page_action($act, $event, $evtp) {}
/** Special Event
* Delete Event Handler, occur when browser get (url=index-delete.html)
* where index is Appgate of application and application path is in reg.php file 
*/
public function page_delete() {}
/** Special Event
* View Event Handler, occur when browser get (url=index-view-19.html)
* where index is Appgate of application and application path is in reg.php file 
* view = event name 
* 19 = recid of database table or any other value.
*/
public function page_view() {}
/** Special Event
* Submit Event Handler, occur when browser post form (url=index.html)
* where index is Appgate of application and application path is in reg.php file 
*/
public function page_submit() {}
/** Special Event
* Insert Event Handler, occur when browser post form (url=index.html) as new form
* where index is Appgate of application and application path is in reg.php file 
*/
public function page_insert() {}
/** Special Event
* Update Event Handler, occur when browser post form (url=index.html) as filled form
* from database with view_data function
* where index is Appgate of application and application path is in reg.php file 
*/
public function page_update() {}
/** Special Event
* New Event Handler, occur when browser get (url=index.html) first time
* where index is Appgate of application and application path is in reg.php file 
*/
public function page_new() {}
/** Advance 
* Overload, Event Handler For App Type development
*/
public function page_unload() {}
/**
* Get Appgate Event name of current request
* @return string
*/
public function getEvent() {}
/**
* Get Appgate Event parameter of current request
* @return string
*/
public function getEventParameter() {}
/** Advance 
* Overload, Event Handler For App Type development
*/
public function readyPage() {}
/** Advance 
* Overload, Event Handler For App Type development
*/
public function init() {}
/** Advance 
* Overload, Event Handler For App Type development
*/
/**
* Set which user Permission can access this application. Default Permission is ALL.
* You can set session variable in login app 
* SphpBase::sphp_request()->session('lstpermis','profile-view,prfile-delete');
* If user is not login with specific permission then application exit and
* redirect according to the getWelcome function in comp.php
* @param string $perm Default=null mean, permission to everyone<p>
* @param string $ctrl optional Default is current App, permission like index-view where index is Appgate.
* permission to allow app. Example:- AuthenticatePerm("view")
* </p>
* @return boolean true if permission match with session variable lstpermis, never return false
*/
public function getAuthenticatePerm($perm=null,$ctrl=null) {}
/**
*  Check Permission is given to authorised user or not given.
* @param string $perm permission to check
* @param string $ctrl optional Default is current App, permission like index-view where index is Appgate.
* @return bool return true if permission found
*/
public function hasPermission($perm,$ctrl=null) {}
/**
* Set which user can access this application. Default user is GUEST.
* You can set session variable in login app 
* SphpBase::sphp_request()->session('logType','ADMIN');
* If user is not login with specific type then application exit and
* redirect according to the getWelcome function in comp.php
* @param string $auth <p>
* comma separated list of string. Example:- Authenticate("GUEST,ADMIN") or Authenticate("ADNIN")
* </p>
* @return boolean true if user type match with session variable logType, never return false
*/
public function Authenticate($auth="") {}
/** Advance
* Authorise base on server variables, in session less environment
* @param string $auth
* @depends Authenticate
*/
public function AuthenticateSVAR($auth="") {}
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
* Read logType session variable as User Type of login user which is set in login app
* @return string
*/
public function getAuthenticateType() {}
/** Application exit if URL isn't session secure
*@return Application exit if URL isn't session secure
*/
public function sesSecure() {}
/**
* Forward request to url
* @param string $loc <p>
* pass url address
* </p>
*/
public function forward($loc) {}
/**
* Return True if page_insert event triggered
* @return bool
*/
public function isInsertMode(){}
/**
* Return True if page_update event triggered
* @return bool
*/
public function isUpdateMode(){}
/**
* Return True if page_view event triggered
* @return bool
*/
public function isViewMode(){}
/**
* Return True if page_delete event triggered
* @return bool
*/
public function isDeleteMode(){}
/**
* Return True if page_submit event triggered
* @return bool
*/
public function isSubmitMode(){}
/**
* Return True if page_new event triggered
* @return bool
*/
public function isNewMode(){}
/**
* User Event is a type of PageEvent as a custom Event build from url which 
* doesn't match with any inbuilt Event.
* Return True if page_event_* User event triggered
* @return bool
*/
public function isUserEventMode(){}
/**
* Set default Database Engine for execute query and managing connections 
* Default is MySQL
* @param \MySQL $objdbengine
*/
public function setDBEngine($objdbengine) {}
/**
* This Function delete the record of database table with generate and execute delete query.
* DELETE FROM $tblName WHERE id='$evtp'
* $tblName = default table of application
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
*/
public function insertData($form1,$extra = array()) {}
/**
* When Components use Database Binding. Then This Function Fill the values from database table to a
* Component value.<br>
* changeable $sql = "SELECT $fldList FROM $tbln $where"<br>
* $tbln = use default tblName of application or Components dtable attribute
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
* @param \Sphp\tools\Component $form1 Form Component or container uses for getAllChildren.
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
public function fetchQuery($sql = "", $ttl = 0, $filename = "", $key = "id", $issave = false) {}
public function insertCache($filename, $key, $data = array(), $tbls = "", $sql = "") {}
public function clearCache($filename) {}
public function updateCache($filename, $keymap, $data = array(), $where = "", $tbls = "", $sql = "") {}
public function deleteCache($filename, $keymap, $where = "", $tbls = "", $sql = "") {}
public function updateCacheSQL($filename, $key, $sql, $priority = 1) {}
public function executeUpdateCacheSQL($filename) {}
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
public function getTableSQL($tablenl, $where = "") {}
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
public function getCreateTableSQL($table) {}
/**
*  Check if result has rows of data
* @param Result Object From Database $param
* @return boolean true if rows exist
*/
public function is_rows($result) {}
}
}
