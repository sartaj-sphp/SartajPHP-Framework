<?php 
class index extends \Sphp\tools\ConsoleApp{

        public function onstart(){
                $this->consoleWriteln("Welcome ");
        }

    public function onready(){
        $ans = $this->consoleReadln("do you want to run server? y / n");
        if($ans == "y\n"){
            echo shell_exec("chmod 755 " . __DIR__ . "/../../res/sphpserver/sphpserver-linux");
            echo shell_exec(__DIR__ . "/../../res/sphpserver/sphpserver-linux");
            $this->consoleWriteln("Bye2");
        }else{
            $this->consoleWriteln("Bye $ans");
        }
    }
}

