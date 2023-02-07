<?php

class index extends \Sphp\tools\BasicApp{
    private $home_front1 = null;
     
    public function onstart() {
        global $masterf;  
        // if not authorise then application call getWelcome() function in comp.php
        //$this->getAuthenticate("GUEST,ADMIN");
        $this->home_front1 = new \Sphp\tools\TempFile($this->apppath . "/forms/index_front1.front");
        // use global variable in comp.php file
        $this->setMasterFile($masterf);        
    }
    
    public function page_new() {
        $this->setTempFile($this->home_front1);
    }
    
}
