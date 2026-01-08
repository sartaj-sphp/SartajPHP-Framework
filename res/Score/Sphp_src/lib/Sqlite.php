<?php
namespace {

    /**
     * sqlite class
     *
     * This class should be responsible for all sqlite Database activities 
     * 
     * @author     Sartaj Singh
     * @copyright  2007
     * @version    4.0.0
     */
    class Sqlite extends \Sphp\kit\DbEngine{

        public static $dlink;
        public static $isConnect = false;
        public $all_query_ok = true;
        private $engine = null;
        private $sphp_api = null;
        private $settings = null;

        /**
         * Class Constructor
         * This returns the sqlite class object
         * @return sqlite
         */
        public function __construct($engine) {
            $this->engine = $engine;
            $this->sphp_api = $engine->getSphpAPI();
            $this->settings = $engine->getSettings();
        }

        public function connect($db1 = "", $dhost1 = "", $duser1 = "", $dpass1 = "") {
            $db = $this->settings->getDb();
            $dhost = $this->settings->getDhost();
            $duser = $this->settings->getDuser();
            $dpass = $this->settings->getDpass();
            if ($dhost1 == "") {
                $dhost1 = $dhost;
            }
            if ($duser1 == "") {
                $duser1 = $duser;
            }
            if ($dpass1 == "") {
                $dpass1 = $dpass;
            }
            if (!Sqlite::$isConnect) {
                if ($db1 != "") {
                    Sqlite::$dlink = new \SQLite3($db1,SQLITE3_OPEN_READWRITE);                    
                } else {
                    Sqlite::$dlink = new \SQLite3($db,SQLITE3_OPEN_READWRITE);                    
                }
                if (!Sqlite::$dlink) {
                    setErr("Sqlite", "Couldn't Connect to Sqlite Server");
                    Sqlite::$isConnect = false;
                    return;
                }
                Sqlite::$dlink->enableExceptions(true);
                Sqlite::$isConnect = true;
            }
        }

        public function cleanQuery($string) {
            return \SQLite3::escapeString($string);
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
                $result = Sqlite::$dlink->query("$sql");
                return $result;
            } catch (\Exception $e){
                $this->all_query_ok = false;
                setErrInner("Sqlite", "Couldn't Execute Query :- " . $sql );
                setErr("Sqlite", "Couldn't Execute Query:- " . $e->getMessage());
                return false;
            }
        }

        public function executeQueryQuick($sql) {
            $blnfound = false;
            if (Sqlite::$isConnect == false) {
                $this->connect();
                $blnfound = true;
            }
            try{
                $result = Sqlite::$dlink->query("$sql");
                return $result;
            } catch (\Exception $e){
                $this->all_query_ok = false;
                setErrInner("Sqlite", "Couldn't Execute Query " . $sql );
                setErr("Sqlite", "Couldn't Execute Query:- " . $e->getMessage());
            }            
            if ($blnfound == true) {
                $this->disconnect();
            }

            return false;
        }

        /*public function commitRollback() {
            if ($this->all_query_ok) {
                mysqli_commit(Sqlite::$dlink);
            } else {
                mysqli_rollback(Sqlite::$dlink);
            }
        }
        */
        public function commit() {
            Sqlite::$dlink->exec('COMMIT');            
        }
        /*
        public function rollback() {
            mysqli_rollback(Sqlite::$dlink);
        }

        public function disableAutoCommit() {
            mysqli_autocommit(Sqlite::$dlink, false);
        }

        public function enableAutoCommit() {
            mysqli_autocommit(Sqlite::$dlink, true);
        }
        */
        
        public function getDatabaseLink() {
            return Sqlite::$dlink;
        }

        /*public function multiQuery($sql) {
            return mysqli_multi_query(Sqlite::$dlink, $sql);
        }*/

        public function prepare($sql) {
            return Sqlite::$dlink->prepare($sql);
        }

        public function disconnect() {
            if (Sqlite::$isConnect == true) {
                Sqlite::$dlink->close();
                Sqlite::$isConnect = false;
            }
        }

        public function __destruct() {
            $this->disconnect();
        }

        public function updateSQL($frm, $txttbl, $where) {
            $blnfound = false;
            if (Sqlite::$isConnect == false) {
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

        public function insertSQL($frm, $txttbl) {
            $blnfound = false;
            if (Sqlite::$isConnect == false) {
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

        public function searchSQL($frm, $tbllist, $where, $OP) {
            $blnfound = false;
            if (Sqlite::$isConnect == false) {
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
            // creates a new database
            $db = $this->settings->getDb();
            if (!Sqlite::$isConnect) {
                $db = new \SQLite3($db, SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);                
                if ($db)
                    echo "$db Database created ";
                else
                    echo "Error in creating database: ";
            }
        }
               

        public function createTable($sql) {
            if (!Sqlite::$dlink->query($sql)) {
                setErrInner("Sqlite", 'Not created table');
            }
        }

        public function dropTable($tableName) {
            if (!Sqlite::$dlink->query( "DROP TABLE " . $tableName )) {
                setErrInner("Sqlite", "Cant drop the table $tableName");
            }
        }
        
        
        public function isRecordExist($sql) {
            $result = $this->executeQueryQuick($sql);
            $row = $result->fetchArray(SQLITE3_ASSOC);
            if($row  === false){
                return false;
            }else{
                $result->reset();
                return $result;
            }
        }

        public function row_fetch_assoc($result) {
            $row = $result->fetchArray(SQLITE3_ASSOC);
            return $row;
        }

        public function row_fetch_array($result) {
            $row = $result->fetchArray(SQLITE3_NUM);
            return $row;
        }
        
        public function last_insert_id() {
            return Sqlite::$dlink->lastInsertRowID();
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
            $result = $this->executeQueryQuick($sql);
            $data = array("news"=>array());
            if ($result) {
                while ($row =  $result->fetchArray(1)) {
                    $data["news"][$this->getUniqueKey($key, $row)] = $row;
                }
            } else {
                $this->sphp_api->triggerError("Could not get any result from database", E_USER_NOTICE, debug_backtrace());
            }
            //$this->disconnect();
            return $data;

        }
        
        /**
         * List Tables in Database. execute SHOW TABLES query. Override this function when you need to
         * create of database adapter.
         * @return array
         */
        public function getDbTables() {
            $result = $this->executeQuery("SELECT name FROM sqlite_master WHERE type='table'");
            $arr = array();
            while ($row = $this->row_fetch_array($result)) {
                $arr[] = $row[0];
            }
            return $arr;
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
            $result = $this->executeQuery("PRAGMA table_info($tablename)");
            $arr = array();
            while ($row = $this->row_fetch_assoc($result)) {
                // compatible with mysql
                $row["Field"] = $row["name"];
                $row["Type"] = $row["type"];
                $row["Null"] = ($row["notnull"] == 0)? 'NO': 'YES';
                $row["Key"] = ($row["pk"] == 1)? 'PRI': '';
                $row["Default"] = $row["dflt_value"];
                $row["Extra"] = '';
                $arr[$row['name']] = $row;
            }
            return $arr;
        }

        /**
         *  Check if result has rows of data
         * @param Result Object From Database $param
         * @return boolean true if rows exist
         */
        public function is_rows($result) {
            $row = $result->fetchArray(SQLITE3_ASSOC);
            if($row  === false){
                return false;
            }else{
                $result->reset();
                return true;
            }
        }
        
    }

}