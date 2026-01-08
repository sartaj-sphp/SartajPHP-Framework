<?php

class PermisApp extends \Sphp\tools\BasicApp {       
    public $extra = array();
    protected $insertedid = 0;
    protected $defWhere = "";
    /**
     *  @var \Sphp\tools\FrontFile
     */
    protected $genFormFront = null;

    /**
     *  @var \Sphp\tools\FrontFile
     */
    protected $showallFront = null;
        
    
    public function page_event_showallShow($param) {
        $showall = $this->showallFront->getComponent('showall');
        $showall->fu_unsetRenderTag();
        $this->JSServer->addJSONComp($showall,'showall');
        $this->JSServer->addJSONBlock('html','pagebar',$showall->getPageBar());            
    }
    
    public function page_event_showall_show($param) {
        $showall = $this->showallFront->getComponent('showall');
        $showall->fu_unsetRenderTag();
        $this->JSServer->addJSONComp($showall, 'showall');
        $this->JSServer->addJSONBlock('html', 'pagebar', $showall->getPageBar());
    }
    
    public function page_new(){
        // no any permission check, you can overwrite this behaviour in your app
        $this->setFrontFile($this->showallFront);
    }
    
    public function hasPermission($p){
        return $this->page->hasPermission($p);
    }
    
    public function page_event_addnew($param) {
        if($this->page->hasPermission("add")){
            $this->Client->session("formType", "Add");
            $this->Client->session("formButton", "Save");
            $this->setFrontFile($this->genFormFront);
        } else {
            $this->page_new();
        }
    }
    
    
    public function page_view() {
        if($this->page->hasPermission("view")){
            $this->Client->session("formType", "Edit");
            $this->Client->session("formButton", "Update");
            $this->page->viewData($this->genFormFront->getComponent('form2'));
            $this->setFrontFile($this->genFormFront);
        }else{
            $this->page_new();
        }
    }        
    
    public function page_insert() {
        global $cmpid;
        if($this->page->hasPermission("add")){
            $this->extra[]['userid'] = $this->Client->session('sid');
            $this->extra[]['parentid'] = $this->Client->session('parentid');
            $this->extra[]['spcmpid'] = $cmpid;
            $this->extra[]['submit_timestamp'] = time();
            $this->extra[]['update_timestamp'] = time();
            
            //$this->debug->println("Call Insert Event");
            if (!getCheckErr()) {
                $this->insertedid = $this->page->insertData($this->extra);            
                if (!getCheckErr()) {
                    setMsg('app1', 'Added Successfully');
                    $this->setFrontFile($this->showallFront);
                } else {
                    setErr('app1', 'Can not add Data');
                    $this->setFrontFile($this->genFormFront);
                }
            } else {
                setErr('app1', 'Can not add Data');
                $this->setFrontFile($this->genFormFront);
            } 
        } else {
            $this->page_new();
        }   
    }
    
    public function page_update() {
        if($this->page->hasPermission("view")){
            if (!getCheckErr()) {                        
                $this->page->updateData($this->extra);
                if (!getCheckErr()) {
                    setMsg('app1', 'Update Successfully');
                    $this->setFrontFile($this->showallFront);
                } else {
                    setErr('app1', 'Record can not update');
                    $this->setFrontFile($this->genFormFront);
                }
            } else {
                setErr('app1', 'Record can not update');
                $this->setFrontFile($this->genFormFront);
            }
        } else {
            $this->page_new();
        }
    }
    
    public function page_delete() {
        if($this->page->hasPermission("delete")){
            $this->page->deleteRec();
            if (!getCheckErr()) {
                setMsg("app1",'delete Successfully');
                $type = "danger";                
                $showall = $this->showallFront->getComponent('showall');
                $showall->fu_unsetRenderTag();
                $this->JSServer->addJSONComp($showall,'showall');
                $this->JSServer->addJSONBlock('html','pagebar',$showall->getPageBar());
                $this->JSServer->addJSONJSBlock('setFormStatus("'.$msg.'", "'.$type.'"); readyFormAsNew("form2");');            
            } else {
                setErr('app1', 'Record could not be deleted');
                $this->setFrontFile($this->showallFront);
            }
        } else {
            $this->page_new();
        }    
    }
    
    
    public function checkUserName($username) {  
        $check = false;
        //$result = $this->dbEngine->executeQueryQuick("SELECT * FROM member WHERE username = '$username' ");
        if($this->dbEngine->isRecordExist("SELECT * FROM member WHERE username = '$username' ")) {
            $check = true;
        }
        return $check;
    }
    
    public function checkUserEmail($email) {  
        $check = false;
//        $result = $this->dbEngine->executeQueryQuick("SELECT * FROM member WHERE email = '$email' ");
        if($this->dbEngine->isRecordExist("SELECT * FROM member WHERE email = '$email' ")) {
            $check = true;
        }
        return $check;
    }
}

