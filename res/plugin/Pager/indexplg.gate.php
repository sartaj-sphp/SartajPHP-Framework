<?php
include_once(SphpBase::sphpSettings()->libPath . "/Sphp/Lib/Dir.php");

class indexplg extends \Sphp\Tools\BasicGate{
    private $temp1 = "";
    public $eventname = "home";
    
    public function onstart() {
     $this->setTableName('pagdet');
     // enable permission system
     $this->page->getAuthenticatePerm();
     //$this->temp1 = new FrontFile($this->myPath . "/forms/imgeditor.front");
        $this->setMasterFile(SphpBase::sphpSettings()->slibPath . "/masters/default/master_empty.php");
    }

  public function page_event_imgedt($evtp){
      SphpJsM::addBootStrap();
     $tmp1 = new FrontFile($this->myPath . "/forms/imgeditor.front");
      if($this->client->request("insert") == 0){
          $tmp1->div1->fu_unsetRender();
      }
    //$tmp1->run();
    //$this->jsServer->addJsonReturnBlock($tmp1->data);
      $this->setFrontFile($tmp1);
  }
  
  
  public function page_event_tiny_imgup($evtp){
      $tmp1 = new FrontFile("{$this->myPath}/TinyEditor/splugins/advimage/file_browser.front");
    SphpBase::jsServer()->addJsonTemp($tmp1,'browse_panel');
      
  }
  
  public function page_event_tinyfile1del($evtp){
        $file =  decrypt($_REQUEST['pfn']); 
        $pt = pathinfo($file);
        if(file_exists($file)){unlink($file);}
        if(file_exists('cache/'.$pt['basename'])){unlink('cache/'.$pt['basename']);}
        SphpBase::jsServer()->addJsonTemp(new FrontFile("{$this->myPath}/TinyEditor/splugins/advimage/file_browser.front"),'browse_panel');
        SphpBase::jsServer()->addJsonBlock('html','picselected','Pic Deleted!'.$file);

  }
  
}