<?php
namespace Sphp\tools{
/**
 * Experimental:- Create a Child process App with PHP
 */
        class ChildProcessApp extends ConsoleApp{
        private $child_process = null;
        private $sthread1 = null;
        private $chlp = false;

        public function __construct() {
            $this->sthread1 = new SphpThread();
            parent::__construct();
            $this->wait_interval = 100000;
            $this->setDontExit(); 
            if(\SphpBase::sphp_request()->isRequest("bdata")){
                \SphpBase::sphp_request()->request("bdata",false,json_decode(\SphpBase::sphp_request()->request("bdata"),true));
            }else{
                \SphpBase::sphp_request()->request("bdata",false, json_decode("{}",true));
            }
            $this->sthread1->startT("ghjk", function($str){
                try{
                return $this->onwaitin($str);
                }catch(Exception $e){
                    return 1;
                }
            });
        }
        
        public function createProcess($cmd, $cwd = null, array $env = null, array $options = array()) {
            $this->chlp = true;
            $this->child_process = new ChildProcess($cmd, $cwd,$env,$options);
        }
        public function ondata($data) {}
        public function onerror($data) {}
        public function onend($data) {}
        public function onquit() {}
        public function oncquit() {}
        public function sendData($data) {
            $this->child_process->write(bin2hex($data) ."\n");
        }
        public function sendCommand($msg) {
            $msg2 = array();
            $msgm = array();
            $msg2["cmd"] = $msg;
            $msgm["response"]["ipc"] = $msg2;
            $this->sendData(json_encode($msgm));
        }
        public function callProcess($fun,$data) {
            $msg1 = array();
            $msg2 = array();
            $msgm = array();
            $msg1["aname"] = $fun;
            $msg1["data"] = $data;
            $msg2["fun"] = $msg1;
            $msgm["response"]["ipc"] = $msg2;
            $this->sendData(json_encode($msgm));
        }
        public function onwaitin($str1) {
            $line = $this->sthread1->readStdinAsync();
            if($line != ""){ 
                $line = str_replace("\r", "", $line);
                $line = str_replace("\n", "", $line);  
                $line2 = hex2bin($line);   
                //file_put_contents("test.txt", "rx: " . $line2,FILE_APPEND);
                $ar1 = json_decode($line2,true);
                if(is_array($ar1)){
                \SphpBase::sphp_request()->request("bdata",false, json_decode(hex2bin(trim($ar1["bdata"])),true));
                $this->page->sact = $ar1["evt"];
                if($this->page->sact !== ""){
                    $this->page->evtp = $ar1["evtp"];
                    $this->page->isevent = true;
                    $this->processEvent();
                    if($this->page->evtp == "quit"){
                        $this->onquit();
                        return 2;
                    }
                }
                }
            }
            return 1;
        }
        public function onwait() {
            if($this->chlp){
            if($this->child_process->getStatus()) {
                $dt1 =  $this->child_process->read();
                if(strlen($dt1) > 2){
                   $ar2 = json_decode($dt1,true);
                \SphpBase::sphp_request()->request("data",false, $ar2[2]);
                $this->page->sact = "c_" . $ar2[0];
                if($this->page->sact !== ""){
                    $this->page->evtp = $ar2[1];
                    $this->page->isevent = true;
                    $this->processEvent();
                    if($this->page->evtp == "quit"){
                        $this->oncquit();
                        $this->child_process->closeProcess();
                    }
                }

                    //$this->ondata($dt1);
                }
            }else{
                $this->chlp = false;
                $this->onend("");
                $errmsg = $this->child_process->readErr();
                if(strlen($errmsg)>2){
                    $this->onerror($errmsg);
                }
                $this->child_process->closeProcess();
                
            }
            }
            if($this->sthread1->isRunning() !== 1){
                $this->ExitMe();
            }

        }
        
        public function __destruct() {
            //$this->sendCommand("quit");
        }
     
    }

    
}
