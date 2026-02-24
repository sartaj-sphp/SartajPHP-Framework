<?php
include_once(SphpBase::sphp_settings()->lib_path . "/lib/DIR.php");

class indexplg extends \Sphp\tools\BasicGate{
    private $temp1 = "";
    public $eventname = "home";
    
    public function onstart() {
     $this->setTableName('pagdet');
     // enable permission system
     $this->page->getAuthenticatePerm();
     //$this->temp1 = new FrontFile($this->mypath . "/forms/imgeditor.front");
        $this->setMasterFile(SphpBase::sphp_settings()->slib_path . "/masters/default/master_empty.php");
    }

  public function page_event_imgedt($evtp){
      SphpJsM::addBootStrap();
     $tmp1 = new FrontFile($this->mypath . "/forms/imgeditor.front");
      if($this->Client->request("insert") == 0){
          $tmp1->div1->fu_unsetRender();
      }
    //$tmp1->run();
    //$this->JSServer->addJSONReturnBlock($tmp1->data);
      $this->setFrontFile($tmp1);
  }
  
  
  public function page_event_tiny_imgup($evtp){
      $tmp1 = new FrontFile("{$this->mypath}/TinyEditor/splugins/advimage/file_browser.front");
    SphpBase::JSServer()->addJSONTemp($tmp1,'browse_panel');
      
  }
  
  public function page_event_tinyfile1del($evtp){
        $file =  decrypt($_REQUEST['pfn']); 
        $pt = pathinfo($file);
        if(file_exists($file)){unlink($file);}
        if(file_exists('cache/'.$pt['basename'])){unlink('cache/'.$pt['basename']);}
        SphpBase::JSServer()->addJSONTemp(new FrontFile("{$this->mypath}/TinyEditor/splugins/advimage/file_browser.front"),'browse_panel');
        SphpBase::JSServer()->addJSONBlock('html','picselected','Pic Deleted!'.$file);

  }
  
}