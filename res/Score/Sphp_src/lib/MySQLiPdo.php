<?php

namespace {

    /**
     * MySQLiPdo PDO class
     *
     * This class should be responsible for all mysql Database activities using PDO
     * 
     * @author     Sartaj Singh
     * @copyright  2007
     * @version    4.0.0
     */
    class MySQLiPdo extends \Sphp\kit\DbEngine {

        public static $dlink;
        public static $isConnect = false;
        public $all_query_ok = true;
        private $engine = null;
        public $sphp_api = null;
        private $settings = null;
        private $pdo = null;

        /**
         * Class Constructor
         * This returns the MySQLiPdo class object
         * @return MySQLiPdoiPdo
         */
        public function __construct($engine) {
            $this->engine = $engine;
            $this->sphp_api = $engine->getSphpAPI();
            $this->settings = $engine->getSettings();
        }

        public function connectServer($dhost1, $duser1, $dpass1) {
            try {
                $host = $dhost1;
                $port = '3306';
                
                if (strpos($dhost1, ':') !== false) {
                    list($host, $port) = explode(':', $dhost1, 2);
                }
                
                MySQLiPdo::$dlink = new \PDO("mysql:host=$host;port=$port", $duser1, $dpass1);
                MySQLiPdo::$dlink->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                MySQLiPdo::$isConnect = true;
                $this->pdo = MySQLiPdo::$dlink;
                return true;
            } catch (\PDOException $e) {
                setErrInner("MySQLiPdo", "Couldn't Connect to MySQLiPdo Server:- " . $e->getMessage());
                setErr("MySQLiPdo", "Couldn't Connect to MySQLiPdo Server");
                MySQLiPdo::$isConnect = false;
                return false;
            }
        }

        public function connect($db1 = "", $dhost1 = "", $duser1 = "", $dpass1 = "") {
            try {
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
                
                if (!MySQLiPdo::$isConnect) {
                        $cons = $this->connectServer($dhost1, $duser1, $dpass1);
                        if ($cons) {
                            $this->selectDb($db1);
                        }
                }
            } catch (\Exception $e) {
                throw new \Exception("Couldn't Open Database Please Check user, password and permissions"); 
            }
        }

        public function selectDB($db1) {
            if (MySQLiPdo::$isConnect) {
                try {
                    $this->pdo->exec("USE $db1");
                    return true;
                } catch (\PDOException $e) {
                    setErrInner("MySQLiPdo", "Couldn't Open Database " . $e->getMessage());
                    setErr("MySQLiPdo", "Couldn't Open Database");
                    return false;
                }
            }
            return false;
        }
        
        public function cleanQuery($string) {
            $string = stripslashes($string);
            // PDO quote method handles escaping properly
            $string = $this->pdo->quote($string);
            // Remove the quotes added by PDO::quote to maintain compatibility with original function
            $string = substr($string, 1, -1);
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
                $result = $this->pdo->query($sql);
                if (!$result) {
                    $this->all_query_ok = false;
                    setErrInner("MySQLiPdo", "Couldn't Execute Query :- " . $sql . " Err:- " . implode(" ", $this->pdo->errorInfo()));
                    setErr("MySQLiPdo", "Couldn't Execute Query");
                }
                return $result;
            } catch (\Throwable $e) {
                setErrInner("MySQLiPdo", "Couldn't Execute Query :- " . $sql . " Err:- " . $e->getMessage());
                setErr("MySQLiPdo", "Couldn't Execute Query");
            } catch (\Exception $e) {
                setErrInner("MySQLiPdo", "Couldn't Execute Query :- " . $sql . " Err:- " . $e->getMessage());
                setErr("MySQLiPdo", "Couldn't Execute Query");
            }        
        }

        public function executeQueryQuick($sql) {
            try {
                $blnfound = false;
                if (MySQLiPdo::$isConnect == false) {
                    $this->connect();
                    $blnfound = true;
                }
                
                $result = $this->pdo->query($sql);
                if (!$result) {
                    $this->all_query_ok = false;
                    setErrInner("MySQLiPdo", "Couldn't Execute Query :- " . $sql . " Err:- " . implode(" ", $this->pdo->errorInfo()));
                    setErr("MySQLiPdo", "Couldn't Execute Query");
                }
                
                if ($blnfound == true) {
                    $this->disconnect();
                }

                return $result;
            } catch (\Throwable $e) {
                setErrInner("MySQLiPdo", "Couldn't Execute Query :- " . $sql . " Err:- " . $e->getMessage());
                setErr("MySQLiPdo", "Couldn't Execute Query");
            } catch (\Exception $e) {
                setErrInner("MySQLiPdo", "Couldn't Execute Query :- " . $sql . " Err:- " . $e->getMessage());
                setErr("MySQLiPdo", "Couldn't Execute Query");
            }        
        }

        public function commitRollback() {
            if ($this->all_query_ok) {
                $this->pdo->commit();
            } else {
                $this->pdo->rollBack();
            }
        }

        public function commit() {
            $this->pdo->commit();
        }

        public function rollback() {
            $this->pdo->rollBack();
        }

        public function disableAutoCommit() {
            $this->pdo->setAttribute(\PDO::ATTR_AUTOCOMMIT, false);
            $this->pdo->beginTransaction();
        }

        public function enableAutoCommit() {
            if ($this->pdo->inTransaction()) {
                $this->pdo->commit();
            }
            $this->pdo->setAttribute(\PDO::ATTR_AUTOCOMMIT, true);
        }

        public function getDatabaseLink() {
            return MySQLiPdo::$dlink;
        }

        public function multiQuery($sql) {
            // For PDO, we need to execute multiple statements separately
            // This is a basic implementation - may need enhancement for complex multi-queries
            $statements = explode(';', $sql);
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement)) {
                    $this->pdo->exec($statement);
                }
            }
            return true;
        }

        public function prepare($sql) {
            return $this->pdo->prepare($sql);
        }

        public function executeQueryJFX($sql) {
            return $this->pdo->query($sql);
        }

        public function executeQueryQuickJFX($sql) {
            $blnfound = false;
            if (MySQLiPdo::$isConnect == false) {
                $this->connect();
                $blnfound = true;
            }
            $result = $this->pdo->query($sql);
            if ($blnfound == true) {
                $this->disconnect();
            }
            return $result;
        }

        public function disconnect() {
            if (MySQLiPdo::$isConnect == true) {
                MySQLiPdo::$dlink = null;
                $this->pdo = null;
                MySQLiPdo::$isConnect = false;
            }
        }

        public function __destruct() {
            $this->disconnect();
        }

        public function updateSQL($frm, $txttbl, $where) {
            $blnfound = false;
            if (MySQLiPdo::$isConnect == false) {
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
            if (MySQLiPdo::$isConnect == false) {
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
                    if ($fields == "") $fields2 .= $key1 . ", ";
                    $values2 .= "'" . $val2 . "', ";
                }
                if ($fields2 != "") $fields = substr($fields2, 0, strlen($fields2) - 2);
                if ($values != "") $values .= ", ";
                $values .= "(" . substr($values2, 0, strlen($values2) - 2) . ") ";
            }
            $sql .= "(" . $fields . ") VALUES " . $values . "";

            return $sql;
        }
        
        public function searchSQL($frm, $tbllist, $where, $OP) {
            $blnfound = false;
            if (MySQLiPdo::$isConnect == false) {
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
            $dpass = $this->settings->getDpass();
            
            if (!MySQLiPdo::$isConnect) {
                try {
                    $frontPdo = new \PDO("mysql:host=$dhost", $duser, $dpass);
                    $frontPdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                    
                    $query = "CREATE DATABASE " . $db;
                    if ($frontPdo->exec($query)) {
                        echo "$db Database created " . $query;
                    }
                } catch (\PDOException $e) {
                    echo "Error in creating database: " . $e->getMessage();
                }
            }
        }

        public function createTable($sql) {
            try {
                $this->pdo->exec($sql);
            } catch (\PDOException $e) {
                setErrInner("MySQLiPdo", $e->getMessage());
            }
        }

        public function dropTable($tableName) {
            try {
                $this->pdo->exec("DROP TABLE " . $tableName);
            } catch (\PDOException $e) {
                setErrInner("MySQLiPdo", $e->getMessage());
            }
        }

        /**
         * 
         * @param string $sql
         * @return bool|\PDOStatement
         */
        public function isRecordExist($sql) {
            $res = $this->executeQueryQuick($sql);
            if ($res && $res->rowCount() > 0) {
                return $res;
            } else {
                return false;
            }
        }

        public function row_fetch_assoc($result) {
            if ($result instanceof \PDOStatement) {
                return $result->fetch(\PDO::FETCH_ASSOC);
            }
            return false;
        }

        public function row_fetch_array($result) {
            if ($result instanceof \PDOStatement) {
                return $result->fetch(\PDO::FETCH_BOTH);
            }
            return false;
        }
        
        public function last_insert_id() {
            return $this->pdo->lastInsertId();
        }        

    }

}