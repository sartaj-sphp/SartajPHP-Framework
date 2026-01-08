<?php

namespace {
    /**
     * MySQLO class for old mysql extension of php like php5.4 and old
     *
     * This class should be responsible for all mysql Database activities 
     * 
     * @author     Sartaj Singh
     * @copyright  2003
     * @version    2.0.0
     */

    class MySQLO extends \Sphp\kit\DbEngine {

        public static $dlink;
        public static $isConnect = false;
        public $all_query_ok = true;
        private $engine = null;
        public $sphp_api = null;
        private $settings = null;

        public function __construct($engine) {
            $this->engine = $engine;
            $this->sphp_api = $engine->getSphpAPI();
            $this->settings = $engine->getSettings();
        }

        public function connect($db1 = "", $dhost1 = "", $duser1 = "", $dpass1 = "") {
            try {
                $db = $this->settings->getDb();
                $dhost = $this->settings->getDhost();
                $duser = $this->settings->getDuser();
                $dpass = $this->settings->getDpass();
                
                if ($dhost1 == "") $dhost1 = $dhost;
                if ($duser1 == "") $duser1 = $duser;
                if ($dpass1 == "") $dpass1 = $dpass;
                
                if (!MySQLO::$isConnect) {
                    if ($db1 != "") {
                        MySQLO::$dlink = mysql_connect($dhost1, $duser1, $dpass1);
                    } else {
                        MySQLO::$dlink = mysql_connect($dhost, $duser, $dpass);
                    }
                    
                    if (!MySQLO::$dlink) {
                        setErrInner("MySQL", "Couldn't Connect to MySQL Server:- " . mysql_error());
                        setErr("MySQL", "Couldn't Connect to MySQL Server");
                        MySQLO::$isConnect = false;
                        throw new \Exception("Couldn't Connect to MySQL Server:- " . mysql_error());
                        return;
                    }
                    
                    if ($db1 == "") {
                        if (!mysql_select_db($db, MySQLO::$dlink)) {
                            setErrInner("MySQL", "Couldn't Open Database " . mysql_error());
                            setErr("MySQL", "Couldn't Open Database");
                            MySQLO::$isConnect = false;
                            throw new \Exception("Couldn't Open Database:- " . mysql_error());
                            return;
                        }
                    } else {
                        if (!mysql_select_db($db1, MySQLO::$dlink)) {
                            setErrInner("MySQL", "Couldn't Open Database " . mysql_error());
                            setErr("MySQL", "Couldn't Open Database");
                            MySQLO::$isConnect = false;
                            throw new \Exception("Couldn't Open Database:- " . mysql_error());
                            return;
                        }
                    }
                    MySQLO::$isConnect = true;
                }
            } catch(\Exception $e) {
                throw new \Exception("Couldn't Open Database Please Check user, password and permissions"); 
            }
        }

        public function cleanQuery($string) {
            $string = stripslashes($string);
            $string = mysql_real_escape_string($string, MySQLO::$dlink);
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
            try {
                $result = mysql_query($sql, MySQLO::$dlink); 
                if (!$result) { 
                    $this->all_query_ok = false;
                    setErrInner("MySQL", "Couldn't Execute Query :- " . $sql . " Err:- " . mysql_error(MySQLO::$dlink));
                    setErr("MySQL", "Couldn't Execute Query");
                }
                return $result;
            } catch(\Exception $e) {
                setErrInner("MySQL", "Couldn't Execute Query :- " . $sql . " Err:- " . $e->getMessage());
                setErr("MySQL", "Couldn't Execute Query");
            }        
        }

        public function executeQueryQuick($sql) {
            try {
                $blnfound = false;
                if (MySQLO::$isConnect == false) {
                    $this->connect();
                    $blnfound = true;
                }
                $result = mysql_query($sql, MySQLO::$dlink);
                if (!$result) {
                    $this->all_query_ok = false;
                    setErrInner("MySQL", "Couldn't Execute Query :- " . $sql . " Err:- " . mysql_error(MySQLO::$dlink));
                    setErr("MySQL", "Couldn't Execute Query");
                }
                if ($blnfound == true) {
                    $this->disconnect();
                }
                return $result;
            } catch(\Exception $e) {
                setErrInner("MySQL", "Couldn't Execute Query :- " . $sql . " Err:- " . $e->getMessage());
                setErr("MySQL", "Couldn't Execute Query");
            }        
        }

        public function commitRollback() {
            // Note: mysql_* doesn't support transactions directly
            // This would need to be implemented with SQL queries
            if ($this->all_query_ok) {
                mysql_query("COMMIT", MySQLO::$dlink);
            } else {
                mysql_query("ROLLBACK", MySQLO::$dlink);
            }
        }

        public function commit() {
            mysql_query("COMMIT", MySQLO::$dlink);
        }

        public function rollback() {
            mysql_query("ROLLBACK", MySQLO::$dlink);
        }

        public function disableAutoCommit() {
            mysql_query("SET autocommit=0", MySQLO::$dlink);
        }

        public function enableAutoCommit() {
            mysql_query("SET autocommit=1", MySQLO::$dlink);
        }

        public function getDatabaseLink() {
            return MySQLO::$dlink;
        }

        public function multiQuery($sql) {
            // mysql_* doesn't support multi_query directly
            // Would need to split queries and execute sequentially
            return $this->executeQuery($sql);
        }

        public function executeQueryJFX($sql) {
            return mysql_query($sql, MySQLO::$dlink);
        }

        public function executeQueryQuickJFX($sql) {
            $blnfound = false;
            if (MySQLO::$isConnect == false) {
                $this->connect();
                $blnfound = true;
            }
            $result = mysql_query($sql, MySQLO::$dlink);
            if ($blnfound == true) {
                $this->disconnect();
            }
            return $result;
        }

        public function disconnect() {
            if (MySQLO::$isConnect == true) {
                mysql_close(MySQLO::$dlink);
                MySQLO::$isConnect = false;
            }
        }

        public function __destruct() {
            $this->disconnect();
        }

        public function updateSQL($frm, $txttbl, $where) {
            $blnfound = false;
            if (MySQLO::$isConnect == false) {
                $this->connect();
                $blnfound = true;
            }
            $fields = "";
            $values = "";
            $sql = "UPDATE " . $txttbl . " SET ";
            foreach ($frm as $key1 => $val2) {
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

        public function runSQL($table, $ar) {
            $sql1 = $this->insertSQL($ar, $table);
            return $this->executeQueryQuick($sql1);
        }        
        
        public function insertSQL($frm, $txttbl) {
            $blnfound = false;
            if (MySQLO::$isConnect == false) {
                $this->connect();
                $blnfound = true;
            }
            $fields = "";
            $values = "";
            $sql = "INSERT INTO " . $txttbl . " ";
            foreach ($frm as $key1 => $val2) {
                if ($val2 != "") {
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
                $values .= "(" . substr($values2, 0, strlen($values2) - 2) . ") ";
            }
            $sql .= "(" . $fields . ") VALUES " . $values . "";
            return $sql;
        }
        
        public function searchSQL($frm, $tbllist, $where, $OP) {
            $blnfound = false;
            if (MySQLO::$isConnect == false) {
                $this->connect();
                $blnfound = true;
            }
            $sql = "SELECT * FROM " . $tbllist . " WHERE ";
            foreach ($frm as $key1 => $val2) {
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
            $db = $this->settings->getDb();
            $dhost = $this->settings->getDhost();
            $duser = $this->settings->getDuser();
            $dpass = $this->settings->getDpass;
            
            if (!MySQLO::$isConnect) {
                MySQLO::$dlink = mysql_connect($dhost, $duser, $dpass);
                if (!MySQLO::$dlink) {
                    die("Couldn't Connect to MySQL Server");
                } else {
                    $query = "CREATE DATABASE " . $db;
                    if (mysql_query($query, MySQLO::$dlink))
                        echo "$db Database created " . $query;
                    else
                        echo "Error in creating database: " . mysql_error(MySQLO::$dlink);
                }
            }
        }

        public function createTable($sql) {
            if (!mysql_query($sql, MySQLO::$dlink)) {
                setErrInner("MySQL", mysql_error(MySQLO::$dlink));
            }
        }

        public function dropTable($tableName) {
            if (!mysql_query("DROP TABLE " . $tableName, MySQLO::$dlink)) {
                setErrInner("MySQL", mysql_error(MySQLO::$dlink));
            }
        }

        public function isRecordExist($sql) {
            $res = $this->executeQueryQuick($sql);
            if (mysql_num_rows($res) > 0) {
                return $res;
            } else {
                return false;
            }
        }

        public function row_fetch_assoc($result) {
            return mysql_fetch_assoc($result);
        }

        public function row_fetch_array($result) {
            return mysql_fetch_array($result);
        }
        
        public function last_insert_id() {
            return mysql_insert_id(MySQLO::$dlink);
        }
        
                /**
         *  Check if result has rows of data
         * @param Result Object From Database $param
         * @return boolean true if rows exist
         */
        public function is_rows($result) {
            if(mysql_num_rows($result) > 0){
                return true;
            }else{
                return false;
            }
        }

    }
}
