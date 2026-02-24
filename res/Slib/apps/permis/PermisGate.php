<?php

class PermisGate extends \Sphp\tools\BasicGate {       
    /**
     * $extra array as $extra[table][field] = value format. pass $extra value while 
     * insert,update data to database. this is extra data which is not provided by bound Components.
     * @var array
     */
    public $extra = array();
    /**
     * Set Last inserted record "id" value in database when insert operation process.
     * @var int
     */
    protected $insertedid = 0;
    /**
     * pass default WHERE login to Pagination Component to Search Records. It will only work when 
     * no other WHERE logic exists.
     * @var string
     */
    protected $defWhere = "";
    /**
     * Form Component ID to process Database bound Component for automatic INSERT,UPDATE and VIEW 
     * Database record.
     * @var string default value is form2
     */
    protected $formid = "form2";
    /**
     * This Front File provide Edit Form to use Insert and Update records
     *  @var \Sphp\tools\FrontFile
     */
    protected $genFormFront = null;

    /**
     * This Front File provide List Records with Pagination + search Form
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
            $this->genFormFront->addMetaData("pageName", "Add " . $this->genFormFront->getMetaData('pageName'));
        // set Submit Button Text
            $this->genFormFront->addMetaData("formButton", "Save");
            $this->setFrontFile($this->genFormFront);
        } else {
            $this->page_new();
        }
    }
    
    
    public function page_view() { 
        if($this->page->hasPermission("view") && $this->page->getEventParameter() != ""){
            $this->genFormFront->addMetaData("pageName", "Edit " . $this->genFormFront->getMetaData('pageName'));
        // set Submit Button Text
            $this->genFormFront->addMetaData("formButton", "Update");
            $form2 = $this->genFormFront->getComponent($this->formid);
            // fill Components data from database
            $this->page->viewData($form2);
            $this->setFrontFile($this->genFormFront);
        }else{
            $this->page_new();
        }
    }        
    
    public function page_insert() {
        global $cmpid;
        if($this->page->hasPermission("add")){
            if($this->Client->isSession('sid')) setErr('App','Need to login');
            $this->extra[]['userid'] = $this->Client->session('sid');
            $this->extra[]['parentid'] = $this->Client->session('parentid');
            $this->extra[]['spcmpid'] = $cmpid;
            $this->extra[]['submit_timestamp'] = time();
            $this->extra[]['update_timestamp'] = time();
            
            //$this->debug->println("Call Insert Event");
            if (!getCheckErr()) {
                $form2 = $this->genFormFront->getComponent($this->formid);
                $this->insertedid = $this->page->insertData($form2,$this->extra);            
                if (!getCheckErr()) {
                    setMsg('App', 'Added Successfully');
                    $this->setFrontFile($this->showallFront);
                } else {
                    setErr('App', 'Can not add Data');
                    $this->setFrontFile($this->genFormFront);
                }
            } else {
                setErr('App', 'Can not add Data');
                $this->setFrontFile($this->genFormFront);
            } 
        } else {
            $this->page_new();
        }   
    }
    
    public function page_update() {
        if($this->page->hasPermission("view")){
            if (!getCheckErr()) {                        
                $form2 = $this->genFormFront->getComponent($this->formid);
                $this->page->updateData($form2,$this->extra);
                if (!getCheckErr()) {
                    setMsg('App', 'Update Successfully');
                    $this->setFrontFile($this->showallFront);
                } else {
                    setErr('App', 'Record can not update');
                    $this->setFrontFile($this->genFormFront);
                }
            } else {
                setErr('App', 'Record can not update');
                $this->setFrontFile($this->genFormFront);
            }
        } else {
            $this->page_new();
        }
    }
    
    public function page_delete() {
        if($this->page->hasPermission("delete") && $this->page->getEventParameter() != ""){
            $this->page->deleteRec();
            if (!getCheckErr()) {
                setMsg("App",'delete Successfully');
                $type = "danger";                
                $showall = $this->showallFront->getComponent('showall');
                $showall->fu_unsetRenderTag();
                $this->JSServer->addJSONComp($showall,'showall');
                $this->JSServer->addJSONBlock('html','pagebar',$showall->getPageBar());
                $this->JSServer->addJSONJSBlock('setFormStatus("'.$msg.'", "'.$type.'"); readyFormAsNew("form2");');            
            } else {
                setErr('App', 'Record could not be deleted');
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

