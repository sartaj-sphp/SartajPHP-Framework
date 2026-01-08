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
        private $engine = null;
        public $sphp_api = null;
        private $settings = null;

        /**
         * Class Constructor
         * This returns the MySQL class object
         * @return MySQL
         */
        public function __construct($engine) {
            $this->engine = $engine;
            $this->sphp_api = $engine->getSphpAPI();
            $this->settings = $engine->getSettings();
        }

        public function connectServer($dhost1, $duser1, $dpass1) {
                MySQL::$dlink = mysqli_connect("$dhost1", "$duser1", "$dpass1");
                if (!MySQL::$dlink) {
                    setErrInner("MySQL", "Couldn't Connect to MySQL Server:- " . mysqli_connect_error());
                    setErr("MySQL", "Couldn't Connect to MySQL Server");
                    MySQL::$isConnect = false;
                    return false;
                }
                MySQL::$isConnect = true;
                return true;
        }
        public function connect($db1 = "", $dhost1 = "", $duser1 = "", $dpass1 = "") {
            try{
            $db = $this->settings->getDb();
            $dhost = $this->settings->getDhost();
            $duser = $this->settings->getDuser();
            $dpass = $this->settings->getDpass();
            if ($db1 == "") {
                $db1 = $db;
            }
            if ($dhost1 == "") {
                $dhost1 = $dhost;
            }
            if ($duser1 == "") {
                $duser1 = $duser;
            }
            if ($dpass1 == "") {
                $dpass1 = $dpass;
            }
            
            if (!MySQL::$isConnect) {
                    $cons = $this->connectServer("$dhost1", "$duser1", "$dpass1");
                    
                    if ($cons) {
                        $this->selectDb($db1);
                    }
            }
            }catch(\Exception $e){
                throw new \Exception("Couldn't Open Database Please Check user, password and permissions"); 
            }
        }

        public function selectDB($db1) {
            if (MySQL::$isConnect) {                    
                    if (!mysqli_select_db(MySQL::$dlink, $db1)) {
                        setErrInner("MySQL", "Couldn't Open Database " . mysqli_error(MySQL::$dlink));
                        setErr("MySQL", "Couldn't Open Database");
                        return false;                    
                    }
                    return true;
            }
            return false;
        }
        
        public function cleanQuery($string) {
            $string = stripslashes($string);
            $strphpver = phpversion();
            if ($strphpver >= 4) {
                $string = mysqli_real_escape_string(MySQL::$dlink, $string);
            } else {
                $string = mysql_escape_string($string);
            }
            // $badWords = "(delete)|(update)|(union)|(insert)|(drop)|(http)|(--)";
            // $string = eregi_replace($badWords, "", $string);

            return $string;
        }

        public function clearQuery($string) {
            $string = stripslashes($string);
            $search = array("'", "\"");
            $replace = array("\\'", "\\\"");

            $string = str_replace($search, $replace, $string);
            return $string;
        }

        public function executeQuery($sql) {
            try{
            $result = mysqli_query(MySQL::$dlink, "$sql"); 
            if (!$result) { 
                $this->all_query_ok = false;
                setErrInner("MySQL", "Couldn't Execute Query :- " . $sql . " Err:- " . mysqli_error(MySQL::$dlink));
                setErr("MySQL", "Couldn't Execute Query");
                //throw new \Exception("Couldn't Execute Query");
            }
            return $result;
            }catch(\Throwable $e){
                setErrInner("MySQL", "Couldn't Execute Query :- " . $sql . " Err:- " . $e->getMessage());
                setErr("MySQL", "Couldn't Execute Query");
                //$e2 = new \Sphp\core\Exception("Couldn't Execute Query",1,$e);
                //throw $e2;
            }catch(\Exception $e){
                setErrInner("MySQL", "Couldn't Execute Query :- " . $sql . " Err:- " . $e->getMessage());
                setErr("MySQL", "Couldn't Execute Query");
                //$e2 = new \Sphp\core\Exception("Couldn't Execute Query",1,$e);
                //throw $e2;
            }        
        }

        public function executeQueryQuick($sql) {
            try{
            $blnfound = false;
            if (MySQL::$isConnect == false) {
                $this->connect();
                $blnfound = true;
            }
            $result = mysqli_query(MySQL::$dlink, $sql);
            if (!$result) {
                $this->all_query_ok = false;
                setErrInner("MySQL", "Couldn't Execute Query :- " . $sql . " Err:- " . mysqli_error(MySQL::$dlink));
                setErr("MySQL", "Couldn't Execute Query");
            }
            if ($blnfound == true) {
                $this->disconnect();
            }

            return $result;
            }catch(\Throwable $e){
                setErrInner("MySQL", "Couldn't Execute Query :- " . $sql . " Err:- " . $e->getMessage());
                setErr("MySQL", "Couldn't Execute Query");
                //$e2 = new \Sphp\core\Exception("Couldn't Execute Query",1,$e);
                //throw $e2;
            }catch(\Exception $e){
                setErrInner("MySQL", "Couldn't Execute Query :- " . $sql . " Err:- " . $e->getMessage());
                setErr("MySQL", "Couldn't Execute Query");
                //$e2 = new \Sphp\core\Exception("Couldn't Execute Query",1,$e);
                //throw $e2;
            }        

        }

        public function commitRollback() {
            if ($this->all_query_ok) {
                mysqli_commit(MySQL::$dlink);
            } else {
                mysqli_rollback(MySQL::$dlink);
            }
        }

        public function commit() {
            mysqli_commit(MySQL::$dlink);
        }

        public function rollback() {
            mysqli_rollback(MySQL::$dlink);
        }

        public function disableAutoCommit() {
            mysqli_autocommit(MySQL::$dlink, false);
        }

        public function enableAutoCommit() {
            mysqli_autocommit(MySQL::$dlink, true);
        }

        public function getDatabaseLink() {
            return MySQL::$dlink;
        }

        public function multiQuery($sql) {
            return mysqli_multi_query(MySQL::$dlink, $sql);
        }

        public function prepare($sql) {
            return mysqli_prepare(MySQL::$dlink, $sql);
        }

        public function executeQueryJFX($sql) {
            $result = mysqli_query(MySQL::$dlink, $sql);
            return $result;
        }

        public function executeQueryQuickJFX($sql) {
            $blnfound = false;
            if (MySQL::$isConnect == false) {
                $this->connect();
                $blnfound = true;
            }
            $result = mysqli_query(MySQL::$dlink, $sql);
            if ($blnfound == true) {
                $this->disconnect();
            }
            return $result;
        }

        public function disconnect() {
            if (MySQL::$isConnect == true) {
                mysqli_close(MySQL::$dlink);
                MySQL::$isConnect = false;
            }
        }

        public function __destruct() {
            $this->disconnect();
        }

        public function updateSQL($frm, $txttbl, $where) {
            $blnfound = false;
            if (MySQL::$isConnect == false) {
                $this->connect();
                $blnfound = true;
            }
            $fields = "";
            $values = "";
            $sql = "UPDATE " . $txttbl . " SET ";
            foreach ($frm as $key1 => $val2) {
//$fields = substr($key1,3,strlen($key1)-3) . "=";
                $fields = $key1 . "=";
                $values = "'" . $this->cleanQuery($val2) . "', ";
                $sql .= $fields . $values;
            }
            $sql = substr($sql, 0, strlen($sql) - 2);
            $sql .= " " . $where;
            if ($blnfound == true) {
                $this->disconnect();
            }
            return $sql;
        }

        public function runSQL($table,$ar) {
            $sql1 = $this->insertSQL($ar,$table);
            return $this->executeQueryQuick($sql1);
        }        
        
        public function insertSQL($frm, $txttbl) {
            $blnfound = false;
            if (MySQL::$isConnect == false) {
                $this->connect();
                $blnfound = true;
            }
            $fields = "";
            $values = "";
            $sql = "INSERT INTO " . $txttbl . " ";
            foreach ($frm as $key1 => $val2) {
                if ($val2 != "") {
//$fields .= substr($key1,3,strlen($key1)-3) . ", ";
                    $fields .= $key1 . ", ";
                    $values .= "'" . $this->cleanQuery($val2) . "', ";
                }
            }
            $fields = substr($fields, 0, strlen($fields) - 2);
            $values = substr($values, 0, strlen($values) - 2);
            $sql .= "(" . $fields . ") VALUES(" . $values . ")";
            if ($blnfound == true) {
                $this->disconnect();
            }

            return $sql;
        }
        /**
         * Create Insert SQL for Multiple Records from array
         * @param array $arr multiple rows of array [["row1"=>"1"],["row2"=>"2"]]
         * @param string $txttbl Database Table Name use in insert query
         * @return string
         */
        public function insertSQLMulti($arr, $txttbl) {
            $fields = "";
            $values = "";
            $sql = "INSERT INTO " . $txttbl . " ";
            foreach ($arr as $key => $frm) {
                $fields2 = "";
                $values2 = "";
                foreach ($frm as $key1 => $val2) {
                        if($fields == "") $fields2 .= $key1 . ", ";
                        $values2 .= "'" . $val2 . "', ";
                }
                if($fields2 != "") $fields = substr($fields2, 0, strlen($fields2) - 2);
                if($values != "") $values .= ", ";
                $values .= "(" .  substr($values2, 0, strlen($values2) - 2) . ") ";
            }
            $sql .= "(" . $fields . ") VALUES " . $values . "";

            return $sql;
        }
        
        public function searchSQL($frm, $tbllist, $where, $OP) {
            $blnfound = false;
            if (MySQL::$isConnect == false) {
                $this->connect();
                $blnfound = true;
            }
            $sql = "SELECT * FROM " . $tbllist . " WHERE ";
            foreach ($frm as $key1 => $val2) {
//$fields = substr($key1,3,strlen($key1)-3) . "=";
                $fields = $key1 . "=";
                $values = "'" . $this->cleanQuery($val2) . "' " . $OP . " ";
                $sql .= $fields . $values;
            }
            $sql = substr($sql, 0, strlen($sql) - (strlen($OP) + 1));
            $sql .= $where;
            if ($blnfound == true) {
                $this->disconnect();
            }
            return $sql;
        }

        public function createDatabase() {
// creates a new database
            $db = $this->settings->getDb();
            $dhost = $this->settings->getDhost();
            $duser = $this->settings->getDuser();
            $dpass = $this->settings->getDpass;
            if (!MySQL::$isConnect) {
                MySQL::$dlink = mysqli_connect($dhost, $duser, $dpass);
                if (!MySQL::$dlink) {
                    die("Couldn't Connect to MySQL Server");
                } else {
                    $query = "CREATE DATABASE " . $db;
                    if (mysqli_query(MySQL::$dlink, $query))
                        echo "$db Database created " . $query;
                    else
                        echo "Error in creating database: " . mysqli_error(MySQL::$dlink);
                    //end of creates a new database
                }
            }
        }

        public function createTable($sql) {
            if (!mysqli_query(MySQL::$dlink, $sql)) {
                setErrInner("MySQL", mysqli_error(MySQL::$dlink));
            }
        }

        public function dropTable($tableName) {
            if (!mysqli_query(MySQL::$dlink, "DROP TABLE " . $tableName)) {
                setErrInner("MySQL", mysqli_error(MySQL::$dlink));
            }
        }
        /**
         * 
         * @param string $sql
         * @return bool|Array
         */
        public function isRecordExist($sql) {
            $res = $this->executeQueryQuick($sql);
            if (mysqli_num_rows($res) > 0) {
                return $res;
            } else {
                return false;
            }
        }

        public function row_fetch_assoc($result) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        }

        public function row_fetch_array($result) {
            $row = mysqli_fetch_array($result);
            return $row;
        }
        
        public function last_insert_id() {
            return mysqli_insert_id(MySQL::$dlink);
        }        
 

    }

}