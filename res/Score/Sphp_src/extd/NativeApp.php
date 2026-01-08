<?php

namespace Sphp\tools {

    class NativeApp extends ConsoleApp {

        private $child_process = null;
        private $chlp = false;
        private $stdin = null;
        private $singleProcess = false;
        /** @var int WebSocket Connection ID which start application */
        public $mainConnection = null;
        public $JQuery = null;
        /**
         * Create Child Process
         * @param string $exepath file path to execute as child process
         * @param array $param pass command line arguments to child process
         * @param string $childid Optional Give the name of child process work as id
         */
        public function createProcess($exepath, $param = array(), $childid = "mid1") {
            $this->chlp = true;
            $data = array();
            $data["childid"] = $childid;
            $data["exepath"] = $exepath;
            $data["param"] = $param;
            $this->callProcess("createprocess", $data, "server");
        }
            // type 1 = info and e = error
        /**
         * Send Message to browser
         * @param type $msg
         * @param string $type 'i' mean info other mean error
         */
        public function sendMsg($msg,$type='i'){
            if($type == 'i'){
                $this->JSServer->addJSONReturnBlock($msg);
            }else{
                $this->JSServer->addJSONReturnBlock('<span class="text-danger">'. $msg . '</span>');
            }
            $this->sendTo();
        }

        /**
         * Advance function 
         * Setup proxy server for website
         * @param string $param
         */
        public function setupProxy($param) {
            $data = array();
            $data["host"] = $param;
            $this->callProcess("setproxy", $data, "server");
        }
        /**
         * Configure Application as Global App Type.
         * Global Application has only 1 process for all requests and sessions. 
         * It will start on first request but it will not exit 
         * with browser close. By default application type is multi process 
         * that mean each session or Web Socket has 1 separate process. 
         */
        public function setGlobalApp() {
            $this->singleProcess = true;
            $data = array();
            $this->callProcess("setglobal", $data, "server");
        }
        /**
         * Set Manager WS Connection for Global Application. Every
         * Global Application has one main WS connection which started global App.
         * But this WS connection lost if browser close or reload. So if you need a
         * manager to control or watch global app processing then this method reassign
         * any connection id as a main connection. Only Work with Global app and
         * Web Socket connection.
         */
        public function setGlobalAppManager() {
            if($this->singleProcess){
                $bd = \SphpBase::sphp_request()->request("bdata");
                if ($bd !== "" && isset($bd["wcon"])) {
                    $conid = $bd["wcon"]["conid"];
                    $this->mainConnection = $bd["wcon"];
                    $data = array();
                    $data["conid"] = intval($conid);
                    $this->callProcess("setglobalm", $data, "server");
                }
            }
        }
        /**
         * Send Data to main connections related to All processes of 
         * current app or match with $groupctrl.
         * In case of global app(Single Process App) Only one main 
         * connection and if it is disconnected then data will not send.
         * If you want to send data to all connections of global app then use sendOthers
         * or sendAll.
         * @param string $rawdata Optional Default=(send JSServer), JSON String
         * @param string $datatype Optional Default=text Data Type
         * @param string $groupctrl Optional Default=this app, Appgate of app to send data
         */
        public function sendAllProcess($rawdata = null, $datatype = "text",$groupctrl="") {
            $this->sendToWS($rawdata, 0, $datatype, $groupctrl, -1);
        }
        /**
         * Easy Send Data for custom use sendToWS
         * Send Data to All WS Connections of Server also included current connection.
         * @param string $rawdata Optional Default=(send JSServer), JSON String
         * @param string $datatype Optional Default=text Data Type
         */
        public function sendAllWS($rawdata = null, $datatype = "text") {
            $this->sendToWS($rawdata, 2, $datatype, "", -1);
        }
        /**
         * Send Data to All WS Connections related to app process, current Appgate or $groupctrl.
         * It works similar to sendOthers but also send data to current connection.
         * @param string $rawdata Optional Default=(send JSServer), JSON String
         * @param string $datatype Optional Default=text Data Type
         * @param string $groupctrl Optional Default=this app, Appgate of app to send data
         */
        public function sendAll($rawdata = null, $datatype = "text", $groupctrl = "") {
            $sendtype = 0;
            if($this->singleProcess) $sendtype = 1;
            $this->sendToWS($rawdata, $sendtype, $datatype, $groupctrl, -1);
        }
        /**
         * Easy Send Data for custom use sendOthersRaw
         * Send Data to All Others WS Connections and leave current connection id
         * @param string $rawdata Optional Default=(send JSServer), JSON String
         * @param string $datatype Optional Default=text Data Type
         * @param string $groupctrl Optional Default=this app, Appgate of app to send data
         */
        public function sendOthers($rawdata = null, $datatype = "text", $groupctrl = "") {
            $conid = 0;
            $bd = \SphpBase::sphp_request()->request("bdata");
            if ($bd !== "" && isset($bd["wcon"])) {
                $conid = $bd["wcon"]["conid"];
            }
            $sendtype = 0;
            if($this->singleProcess) $sendtype = 1;
            $this->sendToWS($rawdata, $sendtype, $datatype, $groupctrl, $conid);
        }
        /**
         * Send Data to connection id or current connection id
         * @param int $conid Optional Default=(current request)
         * @param string $rawdata Optional Default=(send JSServer), JSON String
         * @param string $datatype Optional Default=text Data Type
         */
        public function sendTo($conid = 0, $rawdata = null, $datatype = "text") {
            if ($conid == 0) {
                $bd = \SphpBase::sphp_request()->request("bdata");
                if ($bd !== "" && isset($bd["wcon"])) {
                    $conid = $bd["wcon"]["conid"];
                }
            }
            $this->sendToWS($rawdata, 3, $datatype, "", $conid);
        }
        /**
         * Advance for easy way use SendOthers
         * Send Data to All Others WS Connections and leave current connection id
         * @param string $rawdata Optional Default=(send JSServer), JSON String
         * @param int $sendtype Optional Default=0(All Processes(Only Main Connection 
         * of process not all connections) of $groupctrl app or this app), 
         * 1(All connections of global app), 2(All WS connections)
         * @param string $datatype Optional Default=text Data Type
         * @param string $groupctrl Optional Default=this, Appgate of app to send data
         */
        public function sendOthersRaw($rawdata = null, $sendtype = 0, $datatype = "text", $groupctrl = "") {
            $conid = 0;
            $bd = \SphpBase::sphp_request()->request("bdata");
            if ($bd !== "" && isset($bd["wcon"])) {
                $conid = $bd["wcon"]["conid"];
            }
            $this->sendToWS($rawdata, $sendtype, $datatype, $groupctrl, $conid);
        }
        /**
         * Advance 
         * Send Data to WS Connections.
         * sendtype:-
         * 0 = send data to all processes of this app or other app Appgate as $groupctrl.
         * for single process app(global app), data send only to main connection
         * 1 = send data to all connections of WS with global app this or other app Appgate as $groupctrl.
         * 2 = send data to all WS connections of Server
         * 3 = send data to connection id $conid only
         * @param string $rawdata Optional Default=(send JSServer), JSON String
         * @param int $sendtype Optional Default=0 or 1,2,3 
         * @param string $datatype Optional Default=text Data Type
         * @param string $groupctrl Optional Appgate of app to send data
         * @param int $conid Optional Default=-1=all, this id will leave to send data if $sendtype=0,1 or 2
         */
        public function sendToWS($rawdata = null, $sendtype = 0, $datatype = "text", $groupctrl = "", $conid = -1) {
            $data = array();
            if ($groupctrl == "") {
                $groupctrl = \SphpBase::sphp_router()->getCurrentRequest();
            }
            $data["groupctrl"] = $groupctrl;
            $data["conid"] = intval($conid);
            $data["sendtype"] = intval($sendtype);
            $data["datatype"] = $datatype;
            if ($rawdata == null) {
                $rawdata = $this->JSServer->getResponse();
                \SphpBase::sphp_api()->init();
                $this->JSServer->init();
            }
            $data["rawdata"] = $rawdata;
            $this->callProcess("sendall", $data, "server");
        }
        /**
         * override this event handler in your application to handle it.
         * Event Handler for Child Process Console output
         * @param string|array $data
         * @param string $type
         */
        public function onconsole($data, $type) {
            
        }
        /**
         * override this event handler in your application to handle it.
         * @param array $data
         */
        public function onrequest($data) {
            
        }
        /**
         * override this event handler in your application to handle it.
         * Application Exit Handler
         */
        public function onquit() {
            
        }
        /**
         * override this event handler in your application to handle it.
         * Application Child process Exit Handler
         */
        public function oncquit() {
            
        }
        /**
         * override this event handler in your application to handle it.
         * WebSocket Connection Handler, 
         * Connection object include conid, REQUEST_ADD and REQUEST_PORT key
         * Trigger on each new connection
         * @param array $conobj WS Connection Object
         */
        public function onwscon($conobj) {
            
        }
        /**
         * override this event handler in your application to handle it.
         * WebSocket DisConnection Handler
         * Connection object include conid, REQUEST_ADD and REQUEST_PORT key
         * Trigger on each connection close
         * @param array $conobj WS Connection Object
         */
        public function onwsdiscon($conobj) {
            
        }
        /**
         * Advance Function
         * Send Data to Browser in JSON format
         * @param array|string $data
         * @param string $type Optional Default=jsonweb
         */
        public function sendData($data, $type = "jsonweb") {
            $msgm = array();
            $msgm["response"]["type"] = $type;
            $msgm["response"]["ipc"] = $data;
            echo json_encode($msgm);
        }
        /**
         * Send Command to Child Process
         * @param string|array $msg
         * @param string $type Optional Default=childp
         */
        public function sendCommand($msg, $type = "childp") {
            $this->JSServer->setBlockType($type);
            $this->JSServer->addJSONIpcBlock("cmd", $msg);
            $this->JSServer->flush();
        }
        /**
         * Advance Function
         * Send Data to Child Process
         * @param string $ptype <p>
         * Your custom command type. sendCommand use 'cmd' and callProcess use 'fun'
         * </p>
         * @param array|string $data
         * @param string $type Optional Default=childp
         */
        public function sendProcess($ptype, $data, $type = "childp") {
            $this->JSServer->setBlockType($type);
            $this->JSServer->addJSONIpcBlock($ptype, $data);
            $this->JSServer->flush();
        }
        /**
         * Call function of child process and pass data
         * @param string $fun function name of child process
         * @param string|array $data
         * @param string $type Optional
         */
        public function callProcess($fun, $data, $type = "childp") {
            $msg1 = array();
            $msg1["aname"] = $fun;
            $msg1["data"] = $data;
            $this->sendProcess("fun", $msg1, $type);
        }
        private function onwaitin($line) {
            if ($line != "") {
                $line = str_replace("\r", "", $line);
                $line = str_replace("\n", "", $line);
                //file_put_contents("test.txt", "rx: " . $line,FILE_APPEND);
                $ara1 = json_decode($line, true);
                if (is_array($ara1)) {
                    if ($ara1["type"] == "c") {
                        $line2 = hex2bin($ara1["cpdata"]);
                        $ar1 = json_decode($line2, true);
                        //file_put_contents("test.txt", "rx: " . $line2,FILE_APPEND);
                        // only event call work
                        if (isset($ar1["evt"]) && $ar1["evt"] !== "") {
                            $this->page->sact = $ar1["evt"];
                            $this->page->evtp = $ar1["evtp"];
                            $this->page->isevent = true;
                            if (isset($ar1["bdata"]["wconn"])) {
                                $this->onwscon($ar1["bdata"]["wcon"]);
                            }
                            // command for nodejs server or child process
                            if (isset($ar1["type"]) && $ar1["type"] != "") {
                                if ($this->page->sact !== "cquit") {
                                    $this->page->sact = $ar1["type"] . "_" . $this->page->sact;
                                    $fun = "page_event_{$this->page->sact}";
                                    if (method_exists($this, $fun)) {
                                        $this->{$fun}($this->page->evtp, $ar1["bdata"]);
                                    }
                                } else {
                                    $this->oncquit();
                                }
                            } else if($this->page->sact == "wsdiscon") {
                                // web socket connection bind with global app as a secondary 
                                // trigger discon when close
                                    $this->onwsdiscon($ar1["bdata"]["wcon"]);                                
                            } else {
                                // request from browser via websocket
                                // but application behave like same on http request, but only user event trigger functions
                                if (isset($ar1["bdata"]) && count($ar1["bdata"]) > 0) {
                                    \SphpBase::sphp_request()->request("bdata", false, $ar1["bdata"]);
                                }else{
                                    \SphpBase::sphp_request()->request("bdata", false, array());                                    
                                }
                                $fun = "page_event_{$this->page->sact}";
                                if (method_exists($this, $fun)) {
                                    $this->{$fun}($this->page->evtp);
                                }
                            }

                            if ($this->page->evtp == "quit") {
                                if (isset($ar1["bdata"]["wcon"])) {
                                    $this->onwsdiscon($ar1["bdata"]["wcon"]);
                                }
                                $this->onconsole($line2, $ara1["type"]);
                                if ($this->singleProcess) {
                                    return 1;
                                } else {
                                    return 2;
                                }
                            } else {
                                $this->onconsole($line2, $ara1["type"]);
                            }
                        } else {
                            // only new connecton count for global app
                            // otherwise only event system work
                            if (isset($ar1["bdata"]["wconn"])) {
                                $this->onwscon($ar1["bdata"]["wcon"]);
                            }
                            $this->onconsole($line2, $ara1["type"]);
                        }
                    } else {
                        $this->onconsole($line, $ara1["type"]);
                    }
                } else {
                    $this->onconsole($line, 'l');
                }
            }
            return 1;
        }
        /**
         * Advance function, Internal use
         * Override wait event handler of ConsoleAPP
         */
        public function onwait() {
            $str1 = fgets($this->stdin);
            if ($this->onwaitin($str1) == 2) {
                //echo "find exit ";
                //sleep(5);
                $this->ExitMe();
            }
        }
        /**
         * Exit Manually
         */
        public function ExitMe() {
            $this->isRunning = false;
            $this->onquit();
        }

        public function __destruct() {
            //$this->sendCommand("quit");
        }
        
        //internal functions
        
        /**
         * Advance function 
         */
        public function __construct() {
            \SphpBase::page()->appobj = $this;
            $this->page = \SphpBase::page();
            $this->JSServer = \SphpBase::JSServer();
            $this->JQuery = \SphpBase::JQuery();
            $this->Client = \SphpBase::sphp_request();
            $this->Client->type = "AJAX";
            $this->apppath = \SphpBase::page()->apppath;
            $this->phppath = \SphpBase::sphp_settings()->php_path;
            $this->respath = \SphpBase::sphp_settings()->res_path;
            $this->dbEngine = \SphpBase::dbEngine();
            $this->debug = \SphpBase::debug();
            $this->sphp_api = \SphpBase::sphp_api();
            $this->scriptname = "/";
            $this->argv = $this->Client->argv;
            $this->wait_interval = 100;
            $this->setDontExit();
            $this->stdin = fopen('php://stdin', 'r');
            $blnwscon = false;
            if (\SphpBase::sphp_request()->isRequest("bdata")) {
                $bd = \SphpBase::sphp_request()->request("bdata");
                //\SphpBase::sphp_request()->request("bdata", false,json_decode(\SphpBase::sphp_request()->request("bdata"),true));
                if (isset($bd["wconn"])) {
                    $this->mainConnection = \SphpBase::sphp_request()->request("bdata")["wcon"];
                    $blnwscon = true;
                    //$this->onwscon($this->mainConnection); 
                }
            } else {
                \SphpBase::sphp_request()->request("bdata", false, json_decode("{}", true));
            }
            if (\SphpBase::sphp_request()->cookie("typeappobj") == "s") {
                $this->singleProcess = true;
            }
            $this->onstart();
            if ($blnwscon) {
                $this->onwscon($this->mainConnection);
            }
        }
        
        /**
         * Advance function, Internal use
         */
        public function _run() {
            if ($this->isRunning) {
                //$this->sphp_api->getEngine()->stopOutput();
            }
            $this->onready();
            $this->onrun();
            $this->_processEvent();
            $this->_render();
            while ($this->isRunning) {
                usleep($this->wait_interval);
                $this->onwait();
            }
        }

    }

}
