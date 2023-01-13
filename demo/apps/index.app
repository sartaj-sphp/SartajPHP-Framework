<?php 
class index extends \Sphp\tools\ConsoleApp{

        public function onstart(){
                $this->consoleWriteln("Welcome ");
        }

    public function onready(){
        $ans = $this->consoleReadln("do you want to run server? y / n");
        if($ans == "y\n"){
            if(PHP_OS == "Linux"){
                echo shell_exec("chmod 755 " . __DIR__ . "/../../res/sphpserver/sphpserver-linux");
                echo shell_exec(__DIR__ . "/../../res/sphpserver/sphpserver-linux");
            }else{
                echo shell_exec(__DIR__ . "/../../res/sphpserver/sphpserver-win.exe");                
            }
        }
            $this->consoleWriteln("Bye " . PHP_OS);
    }
}
