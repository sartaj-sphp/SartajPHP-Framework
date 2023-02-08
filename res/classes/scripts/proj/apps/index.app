<?php

class index extends \Sphp\tools\BasicApp{
    private $home_front1 = null;
     
    public function onstart() {
        global $masterf;  
        // if not authorise then application call getWelcome() function in comp.php
        //$this->getAuthenticate("GUEST,ADMIN");
        $this->home_front1 = new \Sphp\tools\TempFile($this->mypath . "/forms/index_front1.front");
        // use global variable in comp.php file
        $this->setMasterFile($masterf);        
    }
    
    //index.html land here
    public function page_new() {
        // send temp file to browser
        $this->setTempFile($this->home_front1);
    }

    //form submit here
    public function page_submit() {
        // send temp file to browser
        $this->setTempFile($this->home_front1);
    }

    //form submit via ajax here
    public function page_event_formsub($evtp) {
        //$this->JSServer->addJSONHTMLBlock("spn1","You post to server  " . $this->home_front1->getComponent('txtname')->value);
        $this->JSServer->addJSONHTMLBlock("spn1","You post to server  " . $this->home_front1->txtaddress->value);
        $this->JSServer->addJSONJSBlock("$('#txtaddress').css('background-color','#FF0000');");
    }

    //txtname component submit via ajax here
    public function page_event_txtname_keyup($evtp) {
        $this->JSServer->addJSONHTMLBlock("spn2","Server is reading:-  " . $this->home_front1->txtname->value);
    }
    
}
