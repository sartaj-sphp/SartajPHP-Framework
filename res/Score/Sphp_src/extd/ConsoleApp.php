<?php

namespace Sphp\tools {

    /**
     * Description of ConsoleApp
     *
     * @author Sartaj Singh
     */
    class ConsoleApp {

        private $auth = "GUEST";
        private $tblName = "";

        /** @var \Sphp\kit\Page $page */
        public $page = "";

        /** @var string $apppath application folder path */
        public $apppath = "";

        /** @var string $phppath res folder path */
        public $phppath = "";

        /** @var string $respath res browser url */
        public $respath = "";

        /** @var \Sphp\kit\JSServer $JSServer */
        public $JSServer = null;

        /** @var \Sphp\core\Request $Client */
        public $Client = null;

        /** @var \MySQL $dbEngine */
        public $dbEngine = null;

        /** @var \Sphp\core\DebugProfiler $debug */
        public $debug = null;

        /** @var \Sphp\core\SphpApi $sphp_api */
        public $sphp_api = null;

        /** @var string $sphp_api */
        public $scriptname = "";

        /** @var array $argv */
        public $argv = array();

        /** @var boolean $isRunning */
        protected $isRunning = false;

        /** @var array $wait_interval default value 1000000 */
        public $wait_interval = 1000000;
        private $frontFiles = array();
        private $ps = "";
        private $disable_stdout = true;
        private $ANSI_CODES = array(
            "off" => 0,
            "bold" => 1,
            "italic" => 3,
            "underline" => 4,
            "blink" => 5,
            "inverse" => 7,
            "hidden" => 8,
            "black" => 30,
            "red" => 31,
            "green" => 32,
            "yellow" => 33,
            "blue" => 34,
            "magenta" => 35,
            "cyan" => 36,
            "white" => 37,
            "black_bg" => 40,
            "red_bg" => 41,
            "green_bg" => 42,
            "yellow_bg" => 43,
            "blue_bg" => 44,
            "magenta_bg" => 45,
            "cyan_bg" => 46,
            "white_bg" => 47
        );
        /**
         * Set Password for Sudo command
         * @param string $pas password
         */
        public function setPassword($pas) {
            if (\SphpBase::debug()->debugmode > 0)
                $this->disable_stdout = false;
            $this->ps = $pas;
        }
        /**
         * enable stdout print
         */
        public function enableStdout() {
            $this->disable_stdout = false;
        }
        /**
         * Disbale stdout print 
         */
        public function disableStdout() {
            $this->disable_stdout = true;
        }
        /**
         * Create Command Que
         * @param array &$ar1 pass by reference to fill command
         * @param string $cmd shell command
         * @param string $msg Message to display command help
         * @param boolean $sudo true = sudo command
         * @param boolean $critical true = stop execution if error in this command
         * @param function $callbackerr callback if error in this command
         */
        public function createQue(&$ar1, $cmd, $msg = "", $sudo = false, $critical = false, $callbackerr = null) {
            $ar1[] = [$cmd, $msg, $sudo, $critical, $callbackerr];
        }
        /**
         * Call Command and wait to finish
         * @param string $cmd shell command
         * @param string &$str1 output text from command
         * @param string $msg help text with command
         * @param boolean $sudo true = run as sudo
         * @return boolean true = run succesfull
         */
        public function callSync($cmd, &$str1, $msg = "", $sudo = false) {
            $str1 = "";
            $fun = function ($msg2) use (&$str1) {
                $str1 .= $msg2;
            };
            //$funer
            if ($sudo) {
                $o = $this->callSudo($cmd, $msg, $fun);
            } else {
                $o = $this->callf($cmd, $msg, $fun);
            }
            return $o;
        }
        /**
         * Call Command and process callback without wait to end.
         * @param string $cmd shell command
         * @param string $msg help text with command
         * @param function $fun2 callback on data
         * @param function $funer2 callback on error
         * @param function $fun_ready2 callback process ready
         * @return boolean true = run successful
         */
        public function callf($cmd, $msg = "", $fun2 = null, $funer2 = null, $fun_ready2 = null) {
            $timer1 = 0;
            $statuscall = function ($msg2) {
                $this->sendMsg($msg2);
            };
            $fun = function ($msg2) use (&$msg, &$timer1) {
                //send data with 5 seconds delay
                if ($timer1 + 5 < time()) {
                    $timer1 = time();
                    $this->sendMsg($msg . ' ' . $timer1);
                }
            };
            $funer = function ($msg2) use (&$msg, &$timer1, &$funer2) {
                //send data with 5 seconds delay
                if ($funer2 != null)
                    $funer2($msg2);
                if ($timer1 + 5 < time()) {
                    $timer1 = time();
                    $this->sendMsg($msg . ' ' . $timer1);
                }
            };
            if ($fun2 != null) {
                $fun = $fun2;
            }
            if (!$this->disable_stdout) {
                if ($fun2 == null) {
                    $fun = function ($msg2) {
                        $this->sendMsg($msg2);
                    };
                }
                $funer = function ($err) use (&$funer2) {
                    $this->sendMsg("Error: " . $err, 'e');
                    if ($funer2 != null)
                        $funer2($err);
                };
            }
            $o = $this->calla($cmd, $msg, $fun, $funer, $fun_ready2, $statuscall);
            if (!$o) {
                $funer("Command Fail $msg");
            }
            return $o;
        }
        /**
         * Call Shell Command With Sudo without wait for end.
         * @param string $cmd command
         * @param string $msg command help text
         * @param function $fun2 callback on data
         * @param function $funer2 callback on error
         * @param function $fun_ready2 callback on process ready
         * @return boolean true = run successful
         */
        public function callSudo($cmd, $msg = "", $fun2 = null, $funer2 = null, $fun_ready2 = null) {
            $cmd = '/usr/bin/sudo -S -k --prompt tjm-js-sphp ' . $cmd;
            $stdin = null;
            $statuscall = function ($msg2) {
                $this->sendMsg($msg2);
            };
            $timer1 = 0;
            $fun = function ($msg2) use ($msg, &$timer1) {
                //send data with 5 seconds delay
                if ($timer1 + 5 < time()) {
                    $timer1 = time();
                    $this->sendMsg($msg . ' ' . $timer1);
                }
            };
            $funer = function ($msg2) use ($msg, &$timer1) {
                //send data with 5 seconds delay
                if ($funer2 != null)
                    $funer2($msg2);
                if ($timer1 + 5 < time()) {
                    $timer1 = time();
                    $this->sendMsg($msg . ' ' . $timer1);
                }
            };
            if ($fun2 != null) {
                $fun = $fun2;
            }

            if (!$this->disable_stdout) {
                if ($fun2 == null) {
                    $fun = function ($msg2) {
                        $this->sendMsg($msg2);
                    };
                }
                $funer = function ($err) use (&$funer2, &$fun_ready2, &$stdin) {
                    if ($err == "tjm-js-sphp") {
                        fwrite($stdin, $this->ps . "\n");
                        if ($fun_ready2 == null)
                            fclose($stdin);
                    } else {
                        if ($funer2 != null)
                            $funer2($err);
                        $this->sendMsg("Error: " . $err, 'e', 'e');
                    }
                };
            }
            $fun_ready = function (&$stdin2, &$process) use (&$fun_ready2,&$stdin) {
                $stdin = $stdin2;
                if ($fun_ready2 != null)
                    $fun_ready2($stdin2, $process);
            };
            $o = $this->calla($cmd, $msg, $fun, $funer, $fun_ready, $statuscall);
            if (!$o) {
                $funer("Command Fail $msg");
            }
            return $o;
        }

        public function calla($cmd, $msg = "", $fun = null, $funer = null, $callback_ready = null, $statuscall = null) {
            if ($fun === null)
                $fun = function ($s1) {
                    $this->println("$s1");
                };
            if ($funer === null)
                $funer = function ($e1) {
                    $this->printer("$e1");
                };
            if ($statuscall == null)
                $statuscall = $fun;
            $statuscall("Start: " . $msg);
            $ot = $this->execShellAsync($cmd, $fun, $funer, $callback_ready);
            if (!$ot) {
                $funer("Error: $msg");
//        echo "Error Details:- " . implode("\n",$out2) . "\033[0m";
                $statuscall("Failed: $msg");
                return false;
            }
//    echo implode("\n",$out2);
            $statuscall("Completed: $msg");
            return true;
        }

        /**
         * Print Error Message on terminal
         * @param string $str1 error msg
         */
        public function printer($str1) {
            echo "\033[41m" . $str1 . "\033[0m\n";
        }
        /**
         * Print Message on terminal
         * @param string $str1 error msg
         */
        public function println($str1) {
            echo $str1 . "\n";
        }

        public function processCmdQue(&$ar1) {
            foreach ($ar1 as $index => $val) {
                $o = false;
                if ($val[2]) {
                    $o = $this->callSudo($val[0], $val[1]);
                } else {
                    $o = $this->callf($val[0], $val[1]);
                }
                if ($o) {
                    $this->sendMsg("Complete: " . $val[1]);
                } else {
                    if ($val[4] == null) {
                        $this->sendMsg("Failed: " . $val[1], 'e');
                    } else {
                        $fune = $val[4];
                        $fune($val[1]);
                    }
                    if ($val[3])
                        break;
                }
            }
        }

        public function processIAQue(&$ar1, $cmd, $msg1 = '', $sudo = false, $fune = null) {
            $o = false;
            $stdin = null;
            $process = null;
            $counter = 0;
            $blnerror = false;
            $fun2 = function ($msg) use (&$stdin, &$counter, &$ar1, &$blnerror, &$process) {
                $this->sendMsg($msg);
                if ($stdin !== null) {
                    if (count($ar1) > $counter) {
                        $val = $ar1[$counter];
                        $counter += 1;
                        $this->sendMsg("Complete: " . $val[1]);
                        fwrite($stdin, $val[0] . "\n");
                        if ($val[3] && $blnerror)
                            $counter = count($ar1);
                    } else if (is_resource($process)) {
                        //fclose($stdin);
                        proc_terminate($process);
                        $counter = count($ar1);
                    }
                }
            };
            $fun_ready = function (&$stdin2, &$process2) use (&$stdin, &$process) {
                $stdin = $stdin2;
                $process = $process2;
            };
            $funer = function ($msg) use (&$blnerror) {
                $blnerror = true;
            };
            if ($sudo) {
                $o = $this->callSudo($cmd, $msg1, $fun2, $funer, $fun_ready);
            } else {
                $o = $this->callf($cmd, $msg1, $fun2, $funer, $fun_ready);
            }
            if ($o) {
                $this->sendMsg("Complete: " . $msg1);
            } else {
                if ($fune == null) {
                    $this->sendMsg("Failed: " . $msg1, 'e');
                } else {
                    $fune($msg1);
                }
            }
        }

        /**
         * print error on console or send to browser
         * @param string $msg
         * @param string $type 'i' mean info other mean error
         */
        public function sendMsg($msg, $type = 'i') {
            if ($type == 'i') {
                $this->consoleWriteln($msg);
            } else {
                $this->consoleError($msg);
            }
        }
        
        private function stream_read_line(&$stream1,&$pendingstr){
            $b1 = fstat($stream1);
            if($b1["size"] > 0){
             $s1 = stream_get_contents($stream1);             
            $sa1 = explode("\n",$pendingstr . $s1);
            if(count($sa1)>1){
                $pendingstr = $sa1[count($sa1)-1];
                unset($sa1[count($sa1)-1]);
                return $sa1;
            }else if(count($sa1)==1){
                $pendingstr = '';
                return $sa1;
            }}else{
                return array();
            }
        }
        
        public function execShellAsync($cmd, $callback, $funer, $callback_ready = null, $cwd = "", $env = null, $options = null) {
            $status = 1;
            try {
                $env2 = null;
                if ($cwd == "") {
                    $cwd = realpath('./');
                }
                $descriptorspec = array(
                    0 => array("pipe", "r"), // stdin is a pipe that the child will read from
                    1 => array("pipe", "w"), // stdout is a pipe that the child will write to
                    2 => array("pipe", "w")    // stderr is a pipe that the child will write to
                );
                if (null !== $env) {
                    $env2 = array();
                    foreach ($env as $key => $value) {
                        $env2[(binary) $key] = (binary) $value;
                    }
                }

                if (!function_exists('proc_open')) {
                    throw new \RuntimeException('The ConsoleApp class relies on proc_open(), which is not available on your PHP installation.');
                }

                $process = proc_open($cmd, $descriptorspec, $pipes, $cwd, $env2, $options);
                //$process = proc_open($cmd, $descriptorspec, $pipes, $cwd);
                if (is_resource($process)) {
                    stream_set_blocking($pipes[2], 0); // all these, not working on windows
                    stream_set_blocking($pipes[1], 0);
                    stream_set_blocking($pipes[0], 0);
                    
                    if ($callback_ready !== null) {
                        $callback_ready($pipes[0], $process);
                    }
                    $s1 = "";
                    $e1 = "";
                    while (1) {
                        //usleep(1000000);
                        $sa1 = $this->stream_read_line($pipes[1],$s1);
                        foreach($sa1 as $val ) {
                            $callback($val);
                            }
                            
                        $ea1 = $this->stream_read_line($pipes[2],$e1);
                        foreach($ea1 as $val ) {
                            $funer($val);
                            }

                        $st1 = proc_get_status($process);
                        if (!$st1['running']) {
                            // read remainder if any
                            $sa1 = $this->stream_read_line($pipes[1],$s1);
                            foreach($sa1 as $val ) {
                                $callback($val);
                                }
                                if(strlen($s1)>0)  $callback($s1);

                            $ea1 = $this->stream_read_line($pipes[2],$e1);
                            foreach($ea1 as $val ) {
                                $funer($val);
                                }
                                if(strlen($e1)>0) $funer($e1);
                            //exit code return by last command
                            // multi commands run with ||,&& or ; can return last command exit code
                            if ($st1["exitcode"] == 0) {
                                $status = 0;
                            } else {
                                $status = 1;
                            }
                            break;
                        }
                    }

                    fclose($pipes[0]);
                    fclose($pipes[1]);
                    fclose($pipes[2]);
                    proc_close($process);
                }
            } catch (\Exception $e) {
                $status = 1;
                $funer("Error: Exception " . $e->getMessage());
            }
            if ($status === 0) {
                return true;
            } else {
                return false;
            }
        }
        /**
         * Remove Extra Spaces from text
         * @param string $v1 data
         * @return string
         */
        public function removeExtraSpaces($v1) {
            $str1 = "";
            $prev = "";
            $len = strlen($v1);
            for ($c = 0; $c < $len; $c++) {
                $char1 = $v1[$c];
                if ($char1 != " ") {
                    $str1 .= $char1;
                    $next = $c + 1;
                    if ($next < $len && $v1[$next] == " ")
                        $str1 .= ' ';
                }
            }
            return $str1;
        }

        private function call_page_events() {
            extract(getGlobals(), EXTR_REFS);
            if ($this->page->isevent) {
                $fun = "page_event_{$this->page->sact}";
                if (method_exists($this, $fun)) {
                    $this->{$fun}($this->page->evtp);
                }
            } else if ($this->page->isnew) {
                $this->page_new();
            } else if ($this->page->isdelete) {
                $this->page_delete();
            } else if ($this->page->isview) {
                $this->page_view();
            } else if ($this->page->issubmit) {
                $this->page_submit();
                if ($this->page->isinsert) {
                    $this->page_insert();
                } else if ($this->page->isupdate) {
                    $this->page_update();
                }
            }
        }

        /**
         * get Appgate event name trigger by browser
         * @return string
         */
        public function getEvent() {
            return $this->page->sact;
        }

        /**
         * get Appgate event parameter post by browser
         * @return string
         */
        public function getEventParameter() {
            return $this->page->evtp;
        }

        /**
         * override this event handler in your application to handle it.
         * trigger when application start
         */
        public function onstart() {
            
        }

        /**
         * override this event handler in your application to handle it.
         * trigger when application finish process of default FrontFile
         */
        public function onready() {
            
        }

        /**
         * override this event handler in your application to handle it.
         * trigger when application initialize FrontFile Object
         */
        public function onfrontinit($frontobj) {
            
        }

        /**
         * override this event handler in your application to handle it.
         * trigger when application start process on FrontFile Object
         */
        public function onfrontprocess($frontobj) {
            
        }

        /** Inbuilt Event
         * override this event handler in your application to handle it.
         * trigger when browser get (url=index-delete.html)
         * where index is Appgate of application and application path is in reg.php file 
         */
        public function page_delete() {
            
        }

        /** Inbuilt Event
         * override this event handler in your application to handle it.
         * trigger when browser get (url=index-view-19.html)
         * where index is Appgate of application and application path is in reg.php file 
         * view = event name 
         * 19 = recid of database table or any other value.
         */
        public function page_view() {
            
        }

        /** Inbuilt Event
         * override this event handler in your application to handle it.
         * trigger when browser post form (url=index.html)
         * where index is Appgate of application and application path is in reg.php file 
         */
        public function page_submit() {
            
        }

        /** Inbuilt Event
         * override this event handler in your application to handle it.
         * trigger when browser post form (url=index.html) as new form
         * where index is Appgate of application and application path is in reg.php file 
         */
        public function page_insert() {
            
        }

        /** Inbuilt Event
         * override this event handler in your application to handle it.
         * trigger when browser post form (url=index.html) as filled form
         * from database with view_data function
         * where index is Appgate of application and application path is in reg.php file 
         */
        public function page_update() {
            
        }

        /** Inbuilt Event
         * override this event handler in your application to handle it.
         * trigger when browser get (url=index.html) first time
         * where index is Appgate of application and application path is in reg.php file 
         */
        public function page_new() {
            
        }

        /** Inbuilt Event
         * override this event handler in your application to handle it.
         * trigger when application run after ready event and before trigger any event handler
         */
        public function onrun() {
            
        }

        /** Inbuilt Event
         * override this event handler in your application to handle it.
         * trigger when application render after run FrontFile but before start master
         * file process. You can't manage FrontFile output here but you can replace FrontFile
         * output in SphpBase::$dynData or change master file or add front place for master filepath
         */
        public function onrender() {
            
        }

        /**
         * Stop exit Automatically after end of processing. It turn on wait event time loop.
         * For exit manually then you need to call ExitMe
         */
        public function setDontExit() {
            $this->isRunning = true;
        }

        /**
         * Exit Manually
         */
        public function ExitMe() {
            $this->isRunning = false;
        }

        /**
         * Handle Wait Event when application is running in manually exit mode
         */
        public function onwait() {
            
        }

        /**
         * Set wait loop interval time
         * @param int $microsec time in microsecond for wait loop
         */
        public function setWaitInterval($microsec = 100000) {
            $this->wait_interval = $microsec;
        }

        /**
         * Set which user can access this application. Default user is GUEST.
         * You can set session variable in login app 
         * SphpBase::sphp_request()->session('logType','ADMIN');
         * If user is not login with specific type then application exit and
         * redirect according to the getWelcome function in comp.php
         * @param string $authenticates <p>
         * comma separated list of string. Example:- getAuthenticate("GUEST,ADMIN") or getAuthenticate("ADNIN")
         * </p>
         */
        public function getAuthenticate($authenticates) {
            $this->auth = $authenticates;
            $this->page->Authenticate($authenticates);
        }

        /**
         * Set default table of Database to Sphp\Page object and this application.
         * This information is important for Components and other database users objects.
         * @param string $dbtable
         */
        public function setTableName($dbtable) {
            \SphpBase::page()->tblName = $dbtable;
            $this->tblName = $dbtable;
        }

        /**
         * get default database table assigned to application
         * @return string
         */
        public function getTableName() {
            return $this->tblName;
        }

        /**
         * Write on Console
         * @param string $param
         */
        public function consoleWrite($param) {
            $this->sphp_api->consoleWrite($param);
        }

        /**
         * Write on Console with end line
         * @param string $param
         */
        public function consoleWriteln($param) {
            $this->sphp_api->consoleWriteln($param);
        }

        /**
         * Read a line from Console with message print on console
         * @param string $msg message print on console
         */
        public function consoleReadln($msg) {
            return $this->sphp_api->consoleReadln($msg);
        }

        /**
         * Write error on console
         * @param string $err
         */
        public function consoleError($err) {
            $this->sphp_api->consoleError($err);
        }

        /**
         * Read command line argument
         * $v = consoleReadArgument('--dest')
         * @param string $argkey key like --ctrl
         * @return string
         */
        public function consoleReadArgument($argkey) {
            if (isset($this->argv[$argkey])) {
                return $this->argv[$argkey];
            }
        }

        /**
         * Execute shell command and print output directly
         * @param string $command 
         * @return array return from command exit code
         */
        public function execute($command) {
            $output = array();
            $return_var = "";
            exec($command, $output, $return_var);
            foreach ($output as $key => $value) {
                $this->display("$value \n");
            }
//        return array($output,$return_var);
            return array($return_var);
        }

        /**
         * Execute Shell command With output
         * @param type $cmd Command
         * @param string &$out Reference var to fill output text
         * @return boolean true if execute succesfully 
         */
        public function execShell($cmd, &$out) {
            try {
                exec($cmd, $out, $status);
                if ($status === 0) {
                    return true;
                } else {
                    return false;
                }
            } catch (\Exception $e) {
                $out[] = "Error: " . $e->getMessage();
                return false;
            }
        }

        /**
         * Convert argv to string
         * @return string
         */
        public function argvToArgs() {
            $strout = "";
            foreach ($this->argv as $key => $value) {
                $strout .= " $value";
            }
            return $strout;
        }

        /**
         * Only work on Windows, get COM object
         * @return \COM
         */
        public function getWScript() {
            return new \COM("WScript.Shell");
        }

        public function runWScript($strCommand, $intWindowStyle = 3, $bWaitOnReturn = true) {
            return $WshShell->Run($strCommand, $intWindowStyle, $bWaitOnReturn);
        }

        /**
         * Execute shell command in Background
         * @param string $cmd
         */
        public function execInBackground($cmd) {
            if (substr(php_uname(), 0, 7) == "Windows") {
                pclose(popen("start /B " . $cmd, "r"));
            } else {
                exec($cmd . " > /dev/null &");
            }
        }

        /**
         * Exit App Forcefully, Not safe
         */
        public function exitApp() {
            exit(0);
        }

        // internal functions
        
        
        public function __construct() {
            \SphpBase::page()->appobj = $this;
            $this->sphp_api = \SphpBase::sphp_api();
            $this->page = \SphpBase::page();
            $this->JSServer = \SphpBase::JSServer();
            $this->Client = \SphpBase::sphp_request();
            $this->apppath = \SphpBase::page()->apppath;
            $this->phppath = \SphpBase::sphp_settings()->php_path;
            $this->respath = \SphpBase::sphp_settings()->res_path;
            $this->dbEngine = \SphpBase::dbEngine();
            $this->debug = \SphpBase::debug();
            $this->scriptname = "/";
            $this->argv = $this->Client->argv;            
            $this->onstart();
        }

        
        /**
         * Advance Function
         * @ignore
         */
        public function _run() {
            if ($this->isRunning) {
                $this->sphp_api->getEngine()->stopOutput();
            }
            $this->onready();
            $this->onrun();
            $this->_processEvent();
            $this->_render();
            while ($this->isRunning) {
                usleep($this->wait_interval);
                $this->onwait();
            }
            //echo "{quit}";
        }

        /**
         * Register FrontFile with app
         * @param \Sphp\tools\FrontFile $frontobj
         */
        public function _registerFront($frontobj) {
            array_push($this->frontFiles, $frontobj);
        }

        /**
         * Advance Function
         * @ignore
         */
        public function _triggerAppEvent() {
            foreach ($this->frontFiles as $key => $tobj) {
                $tobj->_onAppEvent();
            }
        }        
        
        /**
         * Advance Function
         * @ignore
         */
        public function _setup($frontobj) {
            $this->onfrontinit($frontobj);
        }

        /**
         * Advance Function
         * @ignore
         */
        public function _process($frontobj) {
            $this->onfrontprocess($frontobj);
        }

        /**
         * Advance Function
         * @ignore
         */
        protected function _processEvent() {
            $this->_triggerAppEvent();
            $this->call_page_events();
        }

        /**
         * Advance Function
         * @ignore
         */
        protected function _render() {
            $this->onrender();
        }

        
    }

}
