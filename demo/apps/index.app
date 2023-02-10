<?php

class index extends \Sphp\tools\ConsoleApp{

        public function onstart(){
                $this->consoleWriteln("Welcome ");
        }

    public function onready(){
        $this->consoleWriteln("SartajPHP working:- ");
        $this->consoleWriteln("Choose Command");
        $this->consoleWriteln("Create Project 1");
        $this->consoleWriteln("Run Sphp Server with sphpdesk 2");
        $ans = $this->consoleReadln("type command number and press enter? 1 / 2");
        if($ans == "1\n"){
            $proj = realpath(PROJ_PATH . "/../../../../");
            if(file_exists($proj . "/start.php")){
                echo "Project is already exist in $proj\n";
            }else{
                $this->create_project();
            }
        }
        else if($ans == "2\n"){
            $this->run_server();
        }
            $this->consoleWriteln("Bye " . PHP_OS);
    }
    private function create_project(){
        $proj = realpath(PROJ_PATH . "/../../../../");
        echo shell_exec('php -f ' . SphpBase::sphp_settings()->php_path . "/classes/scripts/proj_create.php -- " . $proj);   
        $str = <<<'A'
<?php

$sharedpath = "vendor/sartajphp/sartajphp";
$respath = "vendor/sartajphp/sartajphp/res";
$slibversion = "Slib";
$libversion = "Sphp";

// not editable start
// <editor-fold defaultstate="collapsed" desc="This is generated code, any changes can effect the application">
if(!defined("start_path")){
    define("start_path", __DIR__);
}
if(!isset($argvm) && isset($argv)){
global $argvm;
$argvm = array();
    $total = count($argv);
    for ($c = 0; $c < $total; $c++) {
        $next = $c + 1;
        if ($next >= $total) {
            $next = $total - 1;
        }
        if (strpos($argv[$c], "--") !== FALSE) {
            if (strpos($argv[$next], "--") !== FALSE) {
                $value = "";
                $argvm[$argv[$c]] = $value;
            } else {
                $value = $argv[$next];
                $argvm[$argv[$c]] = $value;
                $c++;
            }
        }
    }

}
if(isset($argv) && isset($argvm["--sharedpath"])){
    chdir(start_path);
    $sharedpath = $argvm["--sharedpath"];
    $respath = "~rs/res";
}
//$respath = "~up/res/";
$phppath = $sharedpath . "/res";
include_once("{$phppath}/Score/{$libversion}/global/start.php");
startSartajPHPEngine();

// </editor-fold>
// not editable end
A;     
file_put_contents($proj ."/start.php",$str);
        echo "Project is created in " . $proj . "\n";
    }
    private function run_server(){
        try {
            if(PHP_OS == "Linux"){
                echo shell_exec("npx sphpdesk");
            }else{
                echo shell_exec("sphpdesk");
            }
        echo "Sphp Server is running \n";
        }catch(Exception $e){
            echo "Install Sphpdesk with 'npm install -g sphpdesk' \n";
        }
        
    }
}