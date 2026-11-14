<?php

class BindPython extends Sphp\Gates\NativeGate{
    private $stdin;
    private $counter = 0;

    public function onstart(){
        //$pythonpath = __DIR__ . "/env/python.exe";
        $pythonpath = "python";
        $genimg = __DIR__ . "/main.py";
        $this->createProcess($pythonpath,["-u", $genimg]);
    }

    public function page_event_startme($evtp){
        $this->jsServer->addJsonJsBlock("$('#python1').prop('disabled',true)");
        $this->sendTo();
    }
    public function page_event_genimg($evtp){        
    $this->childCom->callProcess("genimg",array("nop"=>"hj"));
    }
    // finish image gen
    public function page_event_c_reply($evtp,$data){
        $this->jsServer->addJsonReturnBlock("Image Generated: $evtp");
        //$this->jsServer->addJsonHtmlBlock("txtstatus","100");
        //$this->jsServer->callJsFunction("out1",$evtp);
        $this->sendTo();
    }


    public function page_event_quitme($evtp){
        $this->childCom->sendCommand("quit");
        $this->jsServer->addJsonReturnBlock("Quite now");
        $this->sendTo();
    }

    public function page_event_genimg2($evtp){
        $this->enableStdout();
        $pythonpath = __DIR__ . "/env/python.exe";
        $genimg = __DIR__ . "/test.py";
        //$this->createProcess($pythonpath . " " . $genimg);
        $this->calla($pythonpath . " " . $genimg,"Gen Img",function($d1){
            $this->jsServer->addJsonReturnBlock("gi: " . $d1);
            $this->sendTo();
    
        },function($d2){
            $this->jsServer->addJsonReturnBlock("gi: " . $d2);
            $this->sendTo();
    
        });
            //$this->callf("whoami","User");
        

    }

    public function onwscon($conobj) {
        $this->jsServer->addJsonReturnBlock("app: new Connection " . $conobj->getConnectionId());
        $this->sendAllProcess();
    }
    public function onwsdiscon($conobj) {
        $this->jsServer->addJsonReturnBlock("app: DisConnection " . $conobj->getConnectionId());
        $this->sendOthers();
    }
    public function onconsole($data,$type) {
        if($type == ""){
            $this->jsServer->addJsonReturnBlock("Unknown Data: " . $data);
            $this->sendTo();    
        }
        /*
        else{
        $data2 = json_decode($data,true);
        //child process
        if($data2["type"] == "c"){
            $this->jsServer->addJsonReturnBlock("cp: " . json_encode($data2["bdata"]));
            $this->sendTo();
        }else{
            $this->jsServer->addJsonReturnBlock("console: " . $data);
            $this->sendTo();
        }
    }
    */
}

    public function onquit(){
        //$this->childCom->sendCommand("quit");
        $this->jsServer->addJsonReturnBlock("quit");
        $this->jsServer->flush();
    }
    // call on quit of child process
    // only child process is use with life of app. so quit with child process
    public function oncquit(){
            //$this->childprocess = null;
            $this->jsServer->addJsonJsBlock("$('#btnstart').prop('disabled',false)");
            $this->jsServer->addJsonReturnBlock("cquit");
            $this->jsServer->flush();
            $this->exitMe();
    }
    public function page_event_setm($evtp){
        $this->setGlobalGate();
        $this->jsServer->addJsonReturnBlock("Change Manager: ". $this->mainConnection);
        $this->sendTo();
    }
    
}
