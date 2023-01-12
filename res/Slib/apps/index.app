<?php
class index extends \Sphp\tools\BasicApp{
    
    public function onstart() {
        global $masterf;
        //$this->getAuthenticate("GUEST,ADMIN,MEMBER");
        //$this->setTableName("tbl1"); 
        $this->setMasterFile($masterf);
    }
    
    public function page_new() {
        if(file_exists(PROJ_PATH . "/forms/index.php")){ 
            $dynData = new TempFile(PROJ_PATH . "/forms/index.php", false,false, $this);
        }else{
            $dynData = new TempFile("{$this->apppath}/forms/index.php", false,false, $this);
        }
        $this->setTempFile($dynData);
    }
    public function page_event_captcha($param) {
        $dynData = new TempFile("{$this->apppath}/forms/contacts.php", false,false, $this);
    }
    public function page_event_info($param) {
        $dynData = new TempFile("forms/{$this->page->evtp}.php", false,false, $this);
        $this->setTempFile($dynData);
    }
    public function page_event_page($param) { 
        $dynData = new TempFile($this->apppath . "/forms/{$this->page->evtp}.php", false,false, $this);
        $this->setTempFile($dynData);
    }
}
