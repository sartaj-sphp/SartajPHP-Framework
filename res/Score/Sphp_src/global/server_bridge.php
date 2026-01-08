<?php
function logM($msg){
    file_put_contents("t.txt", $msg,FILE_APPEND);
}
class tdfgst{
    private $isRunning = false;
    private $stdin = null;
    private $counter = 1;
    
    public function __construct() {
        $this->stdin = fopen('php://stdin', 'r'); 
        $this->isRunning = true;
    }
    public function run() {
        while($this->isRunning){
            usleep(100000);
            $this->onwait();
        }
    }
    public function onwait() {
        $str1 = fgets($this->stdin);
        if($this->onrx($str1)==2){
            $this->isRunning = false;
        }
        
    }
    public function runApp() {
       $stmycache = SphpBase::refreshCacheEngine();
       SphpBase::addNewRequest();
       $sphp_notglobalapp = SphpBase::engine()->executeinit();
       if(!$sphp_notglobalapp[0]){
           include($sphp_notglobalapp[1]);
           SphpBase::engine()->execute(true); 
       }else{
           SphpBase::engine()->execute();
       }
        
/*        
        $a1 = ob_get_status(false); 
        if(count($a1) > 0){
            ob_flush();
        }
        ob_flush();
 */       
    }
    public function onrx($data) {
       global $argv;
        if($data !== ""){
            $line = str_replace("\r", "", $data);
            $line = str_replace("\n", "", $line);  
            $line = hex2bin($line);
            $ar1 = json_decode($line,true);
            //unset($ar1[0]);
            array_splice($ar1, 0, 1);
            $argv = $ar1;
            $this->runApp();
        }
        if($this->counter > 100){
            return 2;
        }
        $this->counter = $this->counter + 1;
    }
    
}


$argv[0] = $argv[11] . "/start.php";

//print_r($argv);
define("sphp_mannually_start_engine", true);
include_once(__DIR__ . "/start.php");
$tdfgst = new tdfgst();
$tdfgst->runApp();
$tdfgst->run();

