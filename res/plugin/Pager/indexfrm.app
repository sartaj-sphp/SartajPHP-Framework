<?php
//include_once(SphpBase::sphp_settings()->lib_path . "/lib/DIR.php");

class indexfrm extends \Sphp\tools\BasicApp{
    private $temp1 = "";
    public $eventname = "home";
    
    public function onstart() {
     $this->setTableName('pagdet');
     // enable permission system
     $this->page->getAuthenticatePerm();
     //$this->temp1 = new FrontFile($this->mypath . "/forms/imgeditor.front");
        $this->setMasterFile(SphpBase::sphp_settings()->slib_path . "/masters/default/master_empty.php");
    }

  public function page_submit(){
      global $cmpid,$masterf;
      include_once($this->mypath . "/TinyEditor/TinyEditor.php");
      $txtid = $this->Client->request('txtid');
       //$tinydetails = new TinyEditor();
        //$str1 = html_entity_decode($tinydetails->convertValue(file_get_contents("pagres/a". $txtid .".html")), ENT_COMPAT, "UTF-8"); 

      //$sql = "SELECT * FROM pagdet WHERE id='". $txtid ."'";
      //$res = $this->dbEngine->isRecordExist($sql);
      //if($res){
      //$row = mysqli_fetch_assoc($res);
      $tmp1 = new FrontFile("pagres/b". $txtid .".html");
      if(!getCheckErr()){
//                $this->setFrontFile($tmp1);
          
         // $this->page->forward(getEventURL("p",$txtid));
      }else{
          $this->page->forward(getEventURL("e",$txtid));
      }
      //$this->JSServer->addJSONReturnBlock($tmp1->data);
     // }
  }
  
  public function page_event_p($evtp){
      global $cmpid,$masterf;
            $txtid = $evtp;
            $this->setMasterFile($masterf);
            $tmp2 = new FrontFile($this->mypath . "/forms/infradet.front");
            $tmp2->list->setWhere("WHERE spcmpid='$cmpid' AND  id='$txtid'");
            $this->setFrontFile($tmp2);
          setMsg("app1","Form Submit Successfully, Thanks!");
      
  }
  public function page_event_e($evtp){
      global $cmpid,$masterf;
            $txtid = $evtp;
            $this->setMasterFile($masterf);
            $tmp2 = new FrontFile($this->mypath . "/forms/infradet.front");
            $tmp2->list->setWhere("WHERE spcmpid='$cmpid' AND  id='$txtid'");
            $this->setFrontFile($tmp2);
            setErr("app1","Error in Page");
      
  }
  
  public function page_event_tiny_imgup($evtp){
      //$tmp1 = new FrontFile("{$this->mypath}/TinyEditor/splugins/advimage/file_browser.front");
    //SphpBase::JSServer()->addJSONTemp($tmp1,'browse_panel');
      
  }
  
}