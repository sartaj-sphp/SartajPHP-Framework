<?php

/**
 * page class
 *
 * This class is parent class of all page application. You can Develop SartajPHP Application with extend
 * of this class or simple use SphpBase::page() function to implement page object in any php module.
 * 
 * @author     Sartaj Singh
 * @copyright  2007
 * @version    4.4.4
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
    public $isSesSecure = false;
    /**
     * Advance No Use
     * @depends start
     */
    public function __construct() {
        $this->start();
    }
    /** Advance 
     * Overload, Event Handler For App Type development
     */
    public function page_init() {
        
    }
    /** Advance 
     * Overload, Event Handler For App Type development
     */
    public function page_load() {
        
    }
    /** Advance 
     * Appgate Event handler like (url=index-page-contacts.html)
     * this function gives $event = page and $evtp = contacts
     * @param string $event
     * @param string $evtp
     */
    public function page_event($event, $evtp) {
        
    }
    /** Advance 
     * Custom action designer. Default value delete or view or evt. 
     * like for events value = evt
     * @param string $act
     * @param string $event
     * @param string $evtp
     */
    public function page_action($act, $event, $evtp) {
        
    }
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
    public function page_unload() {
        
    }
    /**
     * Get Appgate Event name of current request
     * @return string
     */
    public function getEvent() {
        return $this->sact;
    }
    /**
     * Get Appgate Event parameter of current request
     * @return string
     */
    public function getEventParameter() {
        return $this->evtp;
    }
    /** Advance 
     * Overload, Event Handler For App Type development
     */
    public function readyPage() {
        $this->start();
    }
    /** Advance 
     * Overload, Event Handler For App Type development
     */
    public function init() {
        $this->authentication = false;
        $this->issubmit = false;
        $this->isview = false;
        $this->isnew = false;
        $this->isdelete = false;
        $this->isinsert = false;
        $this->isupdate = false;
        $this->isaction = false;
        $this->isevent = false;
        $this->act = "";
        $this->sact = "";
        $this->evtp = "";
        $this->txtid = "";
        $this->apppath = "";
        $this->appobj = null;
        $this->appfilepath = "";
        $this->tblName = "";
        $this->auth = "";
        $this->masterfilepath = "";
        $this->isSesSecure = false;
        $this->start();
    }

    private function start() {
        $ctrl = null;
        $ctrl = \SphpBase::engine()->getRouter();
        if (\SphpBase::sphp_request()->request('txtid') !== "") {
            $this->txtid = urldecode(\SphpBase::sphp_request()->request('txtid'));
        }
        $this->act = $ctrl->act;
        $this->sact = $ctrl->sact;
        $this->evtp = urldecode($ctrl->evtp);
// check user authorization
//          if($this->Authenticate() == true){
        $this->page_load();
        if ($this->act == "evt") {
            $this->page_event($this->sact, $this->evtp);
            $this->isevent = true;
        } elseif ($this->act == "delete") {
            $this->page_delete();
            $this->isdelete = true;
        } elseif ($this->act == "view") {
            $this->page_view();
            $this->isview = true;
        } elseif ($this->act != "") {
            $this->page_action($this->act, $this->sact, $this->evtp);
            $this->isaction = true;
        } elseif (count($_POST) > 0) {
            $this->page_submit();
            $this->issubmit = true;
            if ($this->txtid != '') {
                $this->page_update();
                $this->isupdate = true;
            } else {
                $this->page_insert();
                $this->isinsert = true;
            }
        } else {
            $this->page_new();
            $this->isnew = true;
        }

//          } // Authentication failed
        //        else{exit();}
    }

    /** Advance 
     * Overload, Event Handler For App Type development
     */
    public function __destruct() {
        $this->page_unload();
    }
    private function getProfilePermission() {
        $a1 = array();
        // if admin then give all permissions
        if(($this->getAuthenticateType() == "ADMIN") 
                && intval(\SphpBase::sphp_request()->session("uid")) === 0) { 
            // you can set permissions for an app with regsisterApp call
            foreach(\SphpBase::sphp_api()->getRegisteredApps() as $key => $armain) { 
                if($armain[3] !== null){
                foreach($armain[3] as $key2 => $permission) {
                    if(is_array($permission)){
                        $a1[$key . "-" . $permission[0]] = true;
                    }else{
                        $a1[$key . "-" . $permission] = true;                        
                    }
                }
                }
            }
        }else if($this->getAuthenticateType() == "MEMBER" && intval(\SphpBase::sphp_request()->session("uid")) > 0){
            $permission_list = \SphpBase::sphp_request()->session('lstpermis');
            $permission_list_Ary = explode(",", $permission_list);
            foreach($permission_list_Ary as $key => $value) {
                $a1[$value] = true;
            } 
        } 
        // add user type as permission also
        $a1[$this->getAuthenticateType()] = true;
        // set permissions for framework to enable permissions system
        \SphpBase::sphp_permissions()->setPermissions($a1);
    } 
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
    public function getAuthenticatePerm($perm=null,$ctrl=null) {
        $this->getProfilePermission();
        $blnF = true;
        if($ctrl === null) $ctrl = \getCurrentRequest();
        if($perm != null){
            $blnF =  \SphpBase::sphp_permissions()->hasPermission($ctrl .'-' . $perm);
            if ($blnF == false) {
                \getWelcome(); 
                \SphpBase::engine()->exitMe();
            }
        }
        $this->authentication = $blnF;
        return $blnF;
    }

    /**
     *  Check Permission is given to authorised user or not given.
     * @param string $perm permission to check
     * @param string $ctrl optional Default is current App, permission like index-view where index is Appgate.
     * @return bool return true if permission found
     */
    public function hasPermission($perm,$ctrl=null) {
        if($ctrl === null) $ctrl = \getCurrentRequest();
        if(\SphpBase::sphp_permissions()->hasPermission($ctrl .'-' . $perm)){
            return true;
        }else{
            return false;
        }
    }
    
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
    public function Authenticate($auth="") {
        // Check Athorization
        if($auth == ""){
        $auth = \SphpBase::sphp_api()->getGlobal("auth");
        }
        $this->auth =  $auth;
        $authA = explode(',', $auth);
        $blnF = false;
        $autht = $this->getAuthenticateType();
        foreach ($authA as $valA) {
            if ($autht == $valA) {
                $blnF = true;
                break;
            }
        }
        if ($blnF == false) {
            getWelcome(); 
            \SphpBase::engine()->exitMe();
        }
        $this->authentication = $blnF;
        return $blnF;
    }
    /** Advance
     * Authorise base on server variables, in session less environment
     * @param string $auth
     * @depends Authenticate
     */
    public function AuthenticateSVAR($auth="") {
        \SphpBase::sphp_request()->setUseServerVariables();
        $this->Authenticate($auth);
    }
    /**
     * Check if user type in session logType = unauthorised
     * @param string $param <p>
     * comma separated list of string. Example:- checkUnAuth("GUEST,ADMIN") or checkUnAuth("ADNIN")
     * </p>
     * @return boolean true if user type match with session variable logType
     */
    public function checkUnAuth($param) {
        $authA = explode(',', $param);
        $blnF = false;
        $logt = \SphpBase::sphp_request()->session('logType');
        foreach ($authA as $valA) {
            if ($logt == $valA) {
                $blnF = true;
                break;
            }
        }
        return $blnF;
    }
    /**
     * Check if user type in session logType = authorised
     * @param string $param <p>
     * comma separated list of string. Example:- checkAuth("GUEST,ADMIN") or checkAuth("ADNIN")
     * </p>
     * @return boolean true if user type match with session variable logType
     */
    public function checkAuth($param) {
        $authA = explode(',', $param);
        $blnF = false;
        $logt = \SphpBase::sphp_request()->session('logType');
        foreach ($authA as $valA) {
            if ($logt == $valA) {
                $blnF = true;
                break;
            }
        }
        return $blnF;
    }
    /**
     * Read logType session variable as User Type of login user which is set in login app
     * @return string
     */
    public function getAuthenticateType() {
        $at1 = \SphpBase::sphp_request()->session('logType');
        if($at1 != ""){
            return $at1;
        }else{
            return "GUEST";
        }
    }
    /** Application exit if URL isn't session secure
     *@return Application exit if URL isn't session secure
     */
    public function sesSecure() {
        $this->isSesSecure = true;
        if (\SphpBase::sphp_request()->request('sesID') != \SphpBase::sphp_request()->session('sesID')) {
            getWelcome();
            exit();
        }
    }
    /**
     * Forward request to url
     * @param string $loc <p>
     * pass url address
     * </p>
     */
    public function forward($loc) {
        if(\SphpBase::sphp_request()->type == "AJAX"){
            \SphpBase::JSServer()->addJSONJSBlock('window.location = "'. $loc .'";');
        }else{
            $stry = "<!doctype html><html><head><META http-equiv=\"refresh\" content=\"0;URL=". $loc ."\" /></head></html>";
            echo $stry;
        }
    }
    /**
     * Set default Database Engine for execute query and managing connections 
     * Default is MySQL
     * @param \MySQL $objdbengine
     */
    public function setDBEngine($objdbengine) {
        \SphpBase::engine()->setDbEngine($objdbengine);
    }

    /**
     * This Function delete the record of database table with generate and execute delete query.
     * DELETE FROM $tblName WHERE id='$evtp'
     * $tblName = default table of application
     * $evtp = getEventParameter()
     * @param string $recid If empty then use event parameter as record id.<br>
     *
     */
    public function deleteRec($recid="") {
        if (!\SphpBase::sphp_api()->getCheckErr()) {
            \SphpBase::dbEngine()->connect();
            if($recid == "") $recid = $this->evtp;
            $sql = "DELETE FROM ". $this->tblName ." WHERE id='". $recid ."'";
            \SphpBase::dbEngine()->executeQuery($sql);
            \SphpBase::dbEngine()->disconnect();
        }
    }

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
    public function insertData($extra = array()) {
        $Components = null;
        $Components = \SphpBase::sphp_api()->getComponentsDB();
        $tables = array();
        $numid = 0;
        
        if (!\SphpBase::sphp_api()->getCheckErr()) {
            $blnfound = false;
            foreach ($Components as $key => $Components2) {
                foreach ($Components2 as $key => $val) { 
                    if ($val->dataBound && !$val->blnDontSubmit && !$val->blnDontInsert) {
                        if ($val->getDataType() == 'BOOLEAN') {
                            $value = intval(\SphpBase::sphp_api()->stringToBool($val->value));
                        } else {
                            $value = $val->value;
                        }
                        if ($val->dtable == '') {
                            $tables[$this->tblName][$val->dfield] = $value;
                        } else {
                            $tables[$val->dtable][$val->dfield] = $value;
                        }
                        if ($blnfound == false) {
                            $blnfound = true;
                        }
                    }
                }
            }
            foreach ($extra as $key => $val) {
                if (is_numeric($key)) {
                    $tbl = $this->tblName;
                } else {
                    $tbl = $key;
                }
                foreach ($val as $key2 => $val2) {
                    $tables[$tbl][$key2] = $val2;
                }
                if ($blnfound == false) {
                    $blnfound = true;
                }
            }


            if ($blnfound == true) {
                \SphpBase::dbEngine()->connect();
                foreach ($tables as $tbln => $frm1) {
                    $sql = \SphpBase::dbEngine()->insertSQL($frm1, $tbln); 
                    \SphpBase::dbEngine()->executeQuery($sql);
                    $numid = \SphpBase::dbEngine()->last_insert_id();
//print $sql;
                }
                \SphpBase::dbEngine()->disconnect();
                return $numid;
            }
        } // if not error
        else {
            $this->isinsert = false;
            $this->isnew = true;
        }
    }

    /**
     * When Components use Database Binding. Then This Function Fill the values from database table to a
     * Component value.<br>
     * changeable $sql = "SELECT $fldList FROM $tbln $where"<br>
     * $tbln = use default tblName of application or Components dtable attribute
     * SphpBase::page()->viewData(,,"WHERE id='1'");<br>
     * SphpBase::page()->viewData('','aname,pass,lst',"WHERE lastname='devel'");<br>
     * @param type $form <p> Form Component
     * Read value from database and fill all Components of FrontFile object which is bind with field of table.
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
    public function viewData($form , $recID = "", $fldList = "", $where = "") {
        $errStatus = \SphpBase::sphp_api()->getCheckErr();
        $blnfound = false;
        $tables = array();
        foreach ($form->frontobj->compList as $key => $val) {
            if ($val->dfield != '' && !$val->blnDontFill) {
                if ($val->dtable == '') {
                    $tables[$this->tblName][$val->dfield][] = $val;
                } else {
                    $tables[$val->dtable][$val->dfield][] = $val;
                }
                if ($blnfound == false) {
                    $blnfound = true;
                }
            }
        }

        if ($blnfound == true) {
            \SphpBase::dbEngine()->connect();
            if ($recID == "") {
                $recID = $this->evtp;
            }
            \SphpBase::sphp_request()->request($form->recID,false, $recID);
            if ($fldList == "") {
                $fldList = '*';
            }
            $blnRecID = false;
            if ($where == "") {
                $where = "WHERE id='". $recID ."'";
            } else {
                $blnRecID = true;
            }
            foreach ($tables as $tbln => $frm1) {
                $sql = "SELECT ". $fldList ." FROM ". $tbln ." ". $where;
                $result = \SphpBase::dbEngine()->executeQuery($sql);
                $row = \SphpBase::dbEngine()->row_fetch_assoc($result);
                if ($blnRecID && $recID == '') {
                    $recID = $row['id'];
                    \SphpBase::sphp_request()->request($form->recID,false, $recID);
                }
                foreach ($frm1 as $fld1 => $compa) {
                    foreach ($compa as $ind => $comp1) {
                        if ($comp1->getDataType() == 'BOOLEAN') {
                            $value = \SphpBase::sphp_api()->boolToString($row[$fld1]);
                        } else {
                            $value = $row[$fld1];
                        }
                        $comp1->value = $value;
                    }
                }

//print $sql;
            }
            \SphpBase::dbEngine()->disconnect();
        }
    }

    /**
     * When Components use Database Binding. Then This Function Update the values to database<br> table from a
     * Component value. This update old record in table.<br>
     * $extra = array()
     * $extra['table']['dateupdate'] = date('Y-m-d)
     *  OR
     * $extra[]['dateupdate'] = date('Y-m-d)
     * updateData($extra)
     * @param array $extra extra fields to insert with query.
     * @param string $recID <p>
     *  Every table should have unique,auto increment and primary filed and default it has name id. 
     * id = record id in table, pass this record id to $recID or if it is empty then it uses SphpBase::page()->getEventParameter()
     * </p>
     * @param string $where WHERE Logic in SQL
     */
    public function updateData($extra = array(), $recID = '', $where = '') {
        $Components = null;
        $errStatus = \SphpBase::sphp_api()->getCheckErr();
        $Components = \SphpBase::sphp_api()->getComponentsDB();
        $tables = array();
        
        if (!$errStatus) {
            $blnfound = false;
            foreach ($Components as $key => $Components2) {
                foreach ($Components2 as $key => $val) {
                    if ($val->dataBound && !$val->blnDontSubmit && !$val->blnDontUpdate) {
                        if ($val->getDataType() == 'BOOLEAN') {
                            $value = intval(\SphpBase::sphp_api()->stringToBool($val->value));
                        } else {
                            $value = $val->value;
                        }
                        if ($val->dtable == '') {
                            $tables[$this->tblName][$val->dfield] = $value;
                        } else {
                            $tables[$val->dtable][$val->dfield] = $value;
                        }
                        if ($blnfound == false) {
                            $blnfound = true;
                        }
                    }
                }
            }
            foreach ($extra as $key => $val) {
                if (is_numeric($key)) {
                    $tbl = $this->tblName;
                } else {
                    $tbl = $key;
                }
                foreach ($val as $key2 => $val2) {
                    $tables[$tbl][$key2] = $val2;
                }
                if ($blnfound == false) {
                    $blnfound = true;
                }
            }


            if ($blnfound == true) {
                \SphpBase::dbEngine()->connect();
                if ($recID == '') {
                    $recID = $this->txtid;
                }
                if ($where == '') {
                    $where = "WHERE id=". $recID;
                }
                foreach ($tables as $tbln => $frm1) {
                    $sql = \SphpBase::dbEngine()->updateSQL($frm1, $tbln, $where);
                    \SphpBase::dbEngine()->executeQuery($sql);
                }
                \SphpBase::dbEngine()->disconnect();
            }
        } // if not error
        else {
            $this->isupdate = false;
            $this->isnew = true;
        }
    }

}

    class DbEngine{
        /**
         * Fix Bad Format in Query call clearQuery
         * @param string $string
         * @depends clearQuery
         * @return string
         */
        public function cleanQuery($string) {
            return $this->clearQuery($string);
        }
        /**
         * Fix Bad Format in Query
         * @param string $string
         * @return string
         */
        public function clearQuery($string) {
            $string = stripslashes($string);
            $search = array("'", "\"");
            $replace = array("\\'", "\\\"");

            $string = str_replace($search, $replace, $string);
            return $string;
        }
        /**
         * Serialize to a filepath
         * @param array|object $data
         * @param string $filename filepath 
         * @return boolean on error return false
         */
        public function saveToCache($data, $filename) {
            //write to file
            if (!file_put_contents($filename, serialize($data))) {
                setErrInner("Save Cache", "Could not write " . $filename);
                return false;
            }
            //close file pointer
            return true;
        }
        /**
         * Unserialize from file if exist.
         * @param string $filename filepath
         * @return array|object on error return empty array
         */
        public function getFromCache($filename) {
            if(file_exists($filename)){
                if (!$x = file_get_contents($filename)) {
                    setErrInner("Get From Cache", "Could not Read " . $filename);
                    return array();
                } else {
                    $data = unserialize($x);
                    return $data;
                }
            }else{
                return array();                
            }
        }
        public function isCacheExpired($filename, $ttl) {
            if (!file_exists($filename . ".exp")) {
                file_put_contents($filename . ".exp", "");
                return true;
            }
            if ($ttl != -1) {
                $rt = time() - filemtime($filename . ".exp");
                if ($rt >= $ttl) {
                    file_put_contents($filename . ".exp", "");
                    return true;
                }
            }
            return false;
        }

        private function getUniqueKey($key, $row) {
            $keyarr = explode(",", $key);
            $strret = "";
            foreach ($keyarr as $key => $val) {
                if (isset($row[$val])) {
                    $strret .= $row[$val];
                }
            }
            return md5($strret);
        }

        public function fetchQuery($sql = "", $ttl = 0, $filename = "", $key = "id", $issave = false) {
            if (!$sql) {
                return array();
            }
            $data = array("news"=>array());
            if ($ttl == 0) {
                $result = $this->executeQueryQuick($sql);
                if ($result) {
                    while ($row = $this->row_fetch_assoc($result)) {
                        $data["news"][$this->getUniqueKey($key, $row)] = $row;
                    }
                } else {
                    $this->sphp_api->triggerError("Could not get any result from database", E_USER_NOTICE, debug_backtrace());
                }
                return $data;
            } else {
                if ($filename == "") {
                    $filename = "cache/" . md5($sql);
                }
                if ($this->isCacheExpired($filename, $ttl)) {
                    if ($issave) {
                        $this->executeUpdateCacheSQL($filename);
                    }
                    $result = $this->executeQueryQuick($sql);
                    while ($row = $this->row_fetch_assoc($result)) {
                        $data["news"][$this->getUniqueKey($key, $row)] = $row;
                    }
                    if (!$this->saveToCache($data, $filename)) {
                        setErrInner("Cache Writer", "Could not Write " . $filename);
                    }

                    return $data;
                } else {
                    return $this->getFromCache($filename);
                }
            }
        }

        public function insertCache($filename, $key, $data = array(), $tbls = "", $sql = "") {
            $data2 = $this->getFromCache($filename);
            $keym = md5($key);
            $data2["new"][$keym] = $data;
            $this->saveToCache($data2, $filename);
            if ($sql != "") {
                $this->updateCacheSQL($filename, $keym, $sql, 1);
            } else if ($tbls != "") {
                $this->updateCacheSQL($filename, $keym, $this->insertSQL($data, $tbls), 1);
            }
            return true;
        }

        public function clearCache($filename) {
            if (!file_put_contents($filename, "")) {
                setErrInner("Clear Cache", "Could not write " . $filename);
                return false;
            }
        }

        public function updateCache($filename, $keymap, $data = array(), $where = "", $tbls = "", $sql = "") {
            $data2 = $this->getFromCache($filename);
            $keym = md5($keymap);
            $datarow = $data2["news"][$keym];
            foreach ($data as $key2 => $val) {
                $datarow[$key2] = $val;
            }
            $data2["news"][$keym] = $datarow;
            $this->saveToCache($data2, $filename);
            if ($sql != "") {
                $this->updateCacheSQL($filename, $keym, $sql, 2);
            } else if ($tbls != "") {
                $this->updateCacheSQL($filename, $keym, $this->updateSQL($data, $tbls, $where), 2);
            }
            return true;
        }

        public function deleteCache($filename, $keymap, $where = "", $tbls = "", $sql = "") {
            $data2 = $this->getFromCache($filename);
            $keym = md5($keymap);
            unset($data2["news"][$keym]);
            $this->saveToCache($data2, $filename);
            if ($tbls != "") {
                if ($sql != "") {
                    $this->updateCacheSQL($filename, $keym, $sql, 3);
                } else {
                    $this->updateCacheSQL($filename, $keym, "DELETE FROM " . $tbls . " " . $where, 3);
                }
            }
            return true;
        }

        public function updateCacheSQL($filename, $key, $sql, $priority = 1) {
            $data2 = $this->getFromCache($filename . ".sql");
            $data2[$priority][$key] = $sql;
            $this->saveToCache($data2, $filename . ".sql");
            return true;
        }

        public function executeUpdateCacheSQL($filename) {
            $data2 = $this->getFromCache($filename . ".sql");
            $this->connect();
            $C = 1;
            while (isset($data2[$C])) {
                $prio = $data2[$C];
                foreach ($prio as $key2 => $sql) {
                    $this->executeQuery($sql);
                }
                $C += 1;
            }
            $this->disconnect();
            $this->saveToCache(array(), $filename . ".sql");
            return true;
        }
        
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
        public function getTableSQL($tablenl, $where = "") {
            $sqldata = "";
            $rt = $this->executeQuery("SELECT * FROM " . $tablenl . " " . $where);
            while ($row = $this->row_fetch_assoc($rt)) {
                $sqldata .= "$" . "sql = \"" . $this->insertSQL($row, $tablenl) . "\"; " . "SphpBase::dbEngine()->executeQuery(" . "$" . "sql);";
            }
            return $sqldata;
        }
        /**
         * List Fields in a Table. Override this function when you need to
         * create of database adapter. Default work with MySQL
         * @param string $tablename <p>
         * pass table name in database
         * </p>
         * @return array
         */
        public function getTableColumns($tablename) {
            $result = $this->executeQuery("SHOW COLUMNS FROM $tablename");
            $arr = array();
            while ($row = $this->row_fetch_assoc($result)) {
                $arr[$row['Field']] = $row;
            }
            return $arr;
        }
        /**
         * List Tables in Database. execute SHOW TABLES query. Override this function when you need to
         * create of database adapter. Default work with MySQL
         * @return array
         */
        public function getDbTables() {
            $result = $this->executeQuery("SHOW TABLES");
            $arr = array();
            while ($row = $this->row_fetch_array($result)) {
                $arr[] = $row[0];
            }
            return $arr;
        }
        /**
         * Generate a Table CREATE query. Override this function when you need to
         * create of database adapter. Default work with MySQL
         * @param string $table <p> table name
         * </p>
         * @return string
         */
        public function getCreateTableSQL($table) {
            $result = $this->executeQuery("SHOW CREATE TABLE " . $table);
            if($result !== false){
                $row = $this->row_fetch_array($result);
                $row[1] = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $row[1]);
                return str_replace("`", "",$row[1]);
            }
            return "";
        }
        /**
         *  Check if result has rows of data
         * @param Result Object From Database $param
         * @return boolean true if rows exist
         */
        public function is_rows($result) {
            if(mysqli_num_rows($result) > 0){
                return true;
            }else{
                return false;
            }
        }

    }
}
