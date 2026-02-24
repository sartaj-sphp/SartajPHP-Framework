<?php

class index extends \Sphp\tools\BasicApp{
    private $home_front1 = null;
     
    public function onstart() {
        global $masterf;  
        // if not authorise then application call getWelcome() function in comp.php
        //$this->getAuthenticate("GUEST,ADMIN");

        //set default DB table to deal with
        //$this->setTableName("tbl1");

        $this->home_front1 = new \Sphp\tools\FrontFile($this->mypath . "/fronts/index_front1.front");
        // use global variable in comp.php file
        $this->setMasterFile($masterf);        
    }
    
    //index.html land here
    public function page_new() {
        // send temp file to browser
        $this->setFrontFile($this->home_front1);
    }

    public function page_event_page($evtp) {
        // send temp file to browser
        $this->setFrontFile(new FrontFile(SphpBase::sphp_settings()->slib_path . '/apps/fronts/contacts.php'));
    }

    public function page_event_captcha($evtp) {
        // pass captcha event to component
        $temp1 = new FrontFile(SphpBase::sphp_settings()->slib_path . '/apps/fronts/contacts.php');
    }
    //form submit here
    public function page_submit() {
        // set dummy error to test getCheckErr, you can watch this error in browser console in debugmode=2
        //setErr("app1","I am dummy error");

        if(! getCheckErr()){
            //submit data to mysql database, you need to set db user pass in comp.php file
            // $this->dbEngine->executeQueryQuick("INSERT INTO tbl1 () values()");
            // or $this->page->insertData() will insert data automatically with use of control 
            // dfield and dtable attributes or it can use default table of application.
            // check app Framework folder ./res/Slib/apps/helper/AutoApp.php file 
            //set inner html of spn2 control
            $this->home_front1->spn2->setInnerHTML("Form Submut value = " . $this->home_front1->txtname->value);
        }else{
            $this->home_front1->spn2->setInnerHTML("Form Submut with error ");
        }
        // send temp file to browser
        $this->setFrontFile($this->home_front1);
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

