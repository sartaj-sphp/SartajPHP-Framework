<?php

class PermisApp extends \Sphp\tools\BasicApp {       
    public $extra = array();
    /**
     *
     * @var type TempFile
     */
    protected $genFormTemp = null;

    /**
     *
     * @var type TempFile
     */
    protected $showallTemp = null;
        
    
    public function page_event_showallShow($param) {
        $showall = $this->showallTemp->getComponent('showall');
        $showall->unsetRenderTag();
        $this->JSServer->addJSONComp($showall,'showall');
        $this->JSServer->addJSONBlock('html','pagebar',$showall->getPageBar());            
    }
    
    public function page_event_showall_show($param) {
        $showall = $this->showallTemp->getComponent('showall');
        $showall->unsetRenderTag();
        $this->JSServer->addJSONComp($showall, 'showall');
        $this->JSServer->addJSONBlock('html', 'pagebar', $showall->getPageBar());
    }
    
    public function page_new(){
        // no any permission check, you can overwrite this behaviour in your app
        $this->setTempFile($this->showallTemp);
    }

    public function page_event_addnew($param) {
        if($this->page->hasPermission("add")){
            $this->Client->session("formType", "Add");
            $this->Client->session("formButton", "Save");
            $this->setTempFile($this->genFormTemp);
        } else {
            $this->page_new();
        }
    }
    
    
    public function page_view() {
        if($this->page->hasPermission("view")){
            $this->Client->session("formType", "Edit");
            $this->Client->session("formButton", "Update");
            $this->page->viewData($this->genFormTemp->getComponent('form2'));
            $this->setTempFile($this->genFormTemp);
        }else{
            $this->page_new();
        }
    }        
    
    public function page_insert() {
        global $cmpid;
        if($this->page->hasPermission("add")){
            $this->extra[]['userid'] = $_SESSION['sid'];
            $this->extra[]['parentid'] = $_SESSION['parentid'];
            $this->extra[]['spcmpid'] = $cmpid;
            
            $this->extra[]['submit_timestamp'] = time();
            //$this->debug->println("Call Insert Event");
            if (!getCheckErr()) {
                $this->insertedid = $this->page->insertData($this->extra);            
                if (!getCheckErr()) {
                    setMsg('app1', 'Added Successfully');
                    $this->setTempFile($this->showallTemp);
                } else {
                    setErr('app1', 'Can not add Data');
                    $this->setTempFile($this->genFormTemp);
                }
            } else {
                setErr('app1', 'Can not add Data');
                $this->setTempFile($this->genFormTemp);
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
                    $this->setTempFile($this->showallTemp);
                } else {
                    setErr('app1', 'Record can not update');
                    $this->setTempFile($this->genFormTemp);
                }
            } else {
                setErr('app1', 'Record can not update');
                $this->setTempFile($this->genFormTemp);
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
                $showall = $this->showallTemp->getComponent('showall');
                $showall->unsetRenderTag();
                $this->JSServer->addJSONComp($showall,'showall');
                $this->JSServer->addJSONBlock('html','pagebar',$showall->getPageBar());
                $this->JSServer->addJSONJSBlock('setFormStatus("'.$msg.'", "'.$type.'"); readyFormAsNew("form2");');            
            } else {
                setErr('app1', 'Record could not be deleted');
                $this->setTempFile($this->showallTemp);
            }
        } else {
            $this->page_new();
        }    
    }
    
    
    public function checkUserName($username) {  
        $check = false;
        $result = $this->dbEngine->executeQueryQuick("SELECT * FROM member WHERE username = '$username' ");
        if(mysqli_num_rows($result) > 0) {
            $check = true;
        }
        return $check;
    }
    
    public function checkUserEmail($email) {  
        $check = false;
        $result = $this->dbEngine->executeQueryQuick("SELECT * FROM member WHERE email = '$email' ");
        if(mysqli_num_rows($result) > 0) {
            $check = true;
        }
        return $check;
    }
}

