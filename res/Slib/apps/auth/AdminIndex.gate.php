<?php
class AdminIndex extends Sphp\Tools\BasicGate {
        public $genFormFront = null;

    public function onstart() {
        $this->getAuthenticate("ADMIN");
        $this->setMasterFile(readGlobal('admmasterf'));
        $this->setTableName("admin");
            $this->genFormFront = new FrontFile("home");
	}
	
	public function page_new(){
            $this->setFrontFile($this->genFormFront);
	}
}
