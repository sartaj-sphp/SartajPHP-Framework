<?php

class bind_node extends \Sphp\tools\NativeApp{
    private $stdin;
    private $counter = 0;

    public function onstart(){
        $pythonpath = "node";
        $genimg = __DIR__ . "/integration/nodejs/index.js";
        $this->createProcess($pythonpath,[$genimg]);
    }

    public function page_event_genimg($evtp){
		// this will call nodejs function page_event_genimg of index app
    $this->callProcess("index-genimg",["hello"]);
	$this->JSServer->addJSONReturnBlock("call genimg now");
        $this->sendTo();
    }
    // finish image gen
    public function page_event_c_reply($evtp,$data){
        $this->JSServer->addJSONReturnBlock("Image Generated: $evtp");
        //$this->JSServer->addJSONHTMLBlock("txtstatus","100");
        //$this->JSServer->callJsFunction("out1",$evtp);
        $this->sendTo();
    }


    public function page_event_quitme($evtp){
        $this->sendCommand("quit");
        $this->JSServer->addJSONReturnBlock("Quite now");
        $this->sendTo();
    }


    public function onwscon($conobj) {
        $this->JSServer->addJSONReturnBlock("app: new Connection " . $conobj["conid"]);
        $this->sendAllProcess();
    }
    public function onwsdiscon($conobj) {
        $this->JSServer->addJSONReturnBlock("app: DisConnection " . $conobj["conid"]);
        $this->sendOthers();
    }
    public function onconsole($data,$type) {
        if($type == ""){
            $this->JSServer->addJSONReturnBlock("Unknown Data: " . $data);
            $this->sendTo();    
        }
        else{
        $data2 = json_decode($data,true);
        //child process
        if($data2["type"] == "c"){
            $this->JSServer->addJSONReturnBlock("cp: " . json_encode($data2["bdata"]));
            $this->sendTo();
        }else{
            $this->JSServer->addJSONReturnBlock("console: " . $data);
            $this->sendTo();
        }
    }
    
}

    public function onquit(){
        //$this->sendCommand("quit");
        $this->JSServer->addJSONReturnBlock("quit");
        $this->JSServer->flush();
    }
    // call on quit of child process
    // only child process is use with life of app. so quit with child process
    public function oncquit(){
            //$this->childprocess = null;
            $this->JSServer->addJSONJSBlock("$('#btnstart').prop('disabled',false)");
            $this->JSServer->addJSONReturnBlock("cquit");
            $this->JSServer->flush();
            $this->exitMe();
    }
    public function page_event_setm($evtp){
        $this->setGlobalAppManager();
        $this->JSServer->addJSONReturnBlock("Change Manager: ". $this->mainConnection["conid"]);
        $this->sendTo();
    }
    
}
