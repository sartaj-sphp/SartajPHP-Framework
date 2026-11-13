<?php
//include_once(SphpBase::sphpSettings()->libPath . "/Sphp/Lib/Dir.php");

class indexfrm extends \Sphp\Tools\BasicGate{
    private $temp1 = "";
    public $eventname = "home";
    
    public function onstart() {
     $this->setTableName('pagdet');
     // enable permission system
     $this->page->getAuthenticatePerm();
     //$this->temp1 = new FrontFile($this->myPath . "/forms/imgeditor.front");
        $this->setMasterFile(SphpBase::sphpSettings()->slibPath . "/masters/default/master_empty.php");
    }

  public function page_submit(){
      global $cmpId,$masterf;
      include_once($this->myPath . "/TinyEditor/TinyEditor.php");
      $txtid = $this->client->request('txtid');
       //$tinydetails = new TinyEditor();
        //$str1 = html_entity_decode($tinydetails->convertValue(file_get_contents("pagres/a". $txtid .".html")), ENT_COMPAT, "UTF-8"); 

      //$sql = "SELECT * FROM pagdet WHERE id='". $txtid ."'";
      //$res = $this->dbEngine->isRecordExist($sql);
      //if($res){
      //$row = mysqli_fetch_assoc($res);
      $tmp1 = new FrontFile("pagres/b". $txtid .".html");
      if(!getCheckErr()){
//                $this->setFrontFile($tmp1);
          
         // $this->page->forward(getEventUrl("p",$txtid));
      }else{
          $this->page->forward(getEventUrl("e",$txtid));
      }
      //$this->jsServer->addJsonReturnBlock($tmp1->data);
     // }
  }
  
  public function page_event_p($evtp){
      global $cmpId,$masterf;
            $txtid = $evtp;
            $this->setMasterFile($masterf);
            $tmp2 = new FrontFile($this->myPath . "/forms/infradet.front");
            $tmp2->list->setWhere("WHERE spcmpId='$cmpId' AND  id='$txtid'");
            $this->setFrontFile($tmp2);
          setMsg("app1","Form Submit Successfully, Thanks!");
      
  }
  public function page_event_e($evtp){
      global $cmpId,$masterf;
            $txtid = $evtp;
            $this->setMasterFile($masterf);
            $tmp2 = new FrontFile($this->myPath . "/forms/infradet.front");
            $tmp2->list->setWhere("WHERE spcmpId='$cmpId' AND  id='$txtid'");
            $this->setFrontFile($tmp2);
            setErr("app1","Error in Page");
      
  }
  
  public function page_event_tiny_imgup($evtp){
      //$tmp1 = new FrontFile("{$this->myPath}/TinyEditor/splugins/advimage/file_browser.front");
    //SphpBase::jsServer()->addJsonTemp($tmp1,'browse_panel');
      
  }
  
}