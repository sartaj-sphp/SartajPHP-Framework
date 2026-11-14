<?php

class BindNode extends \Sphp\Gates\NativeGate{
    private $stdin;
    private $counter = 0;

    public function onstart(){
        $pythonpath = "node";
        $genimg = __DIR__ . "/integration/nodejs/index.js";
        $this->createProcess($pythonpath,[$genimg]);
    }

    public function page_event_genimg($evtp){
		// this will call nodejs function page_event_genimg of index app
    $this->childCom->callProcess("index-genimg",["hello"]);
	$this->jsServer->addJsonReturnBlock("call genimg now");
        $this->sendTo();
    }
    // finish image gen
    public function page_event_c_reply($evtp,$data){
        $this->jsServer->addJsonReturnBlock("Image Generated: $evtp");
        //$this->jsServer->addJsonHtmlBlock("txtstatus","100");
        //$this->jsServer->callJsFunction("out1",$evtp);
        $this->sendTo();
    }


    public function page_event_quitme($evtp){
        $this->childCom->sendCommand("index-quitme");
        $this->jsServer->addJsonReturnBlock("Quite now");
        $this->sendTo();
    }

	/**
	* override this event handler in your Gate to handle it.
	* WebSocket Connection Handler, 
	* @param \Sphp\Tools\WsCon $conobj WS client Object
	*/
    public function onwscon($conobj) {
        $this->jsServer->addJsonReturnBlock("app: new Connection " . $conobj->getConnectionId());
        $this->sendAllProcess();
    }
	/**
	* override this event handler in your Gate to handle it.
	* WebSocket Connection Handler, 
	* @param \Sphp\Tools\WsCon $conobj WS client Object
	*/
    public function onwsdiscon($conobj) {
        $this->jsServer->addJsonReturnBlock("app: DisConnection " . $conobj->getConnectionId());
        $this->sendOthers();
    }
    public function onconsole($data,$type) {
        if($type == ""){
            $this->jsServer->addJsonReturnBlock("Unknown Data: " . $data);
            $this->sendTo();    
        }
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
    
}

    public function onquit(){
        //$this->childCom->sendCommand("quit");
        $this->jsServer->addJsonReturnBlock("quit");
        $this->jsServer->flush();
    }
    // call on quit of child process
    // only child process is use with life of app. so quit with child process
    public function oncquit(){
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
