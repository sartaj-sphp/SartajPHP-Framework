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
    public function page_event_refresh_captcha($param) {
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
    
    public function page_event_subquote($evtp){
        global $mailUser,$cmpemail,$cmpname;
        $sd = new TempFile("{$this->apppath}/forms/contacts.php", false,false, $this);
        include_once(SphpBase::sphp_settings()->php_path . "/classes/bundle/email/SMTPMail.php");
        if(!getCheckErr()){
            $mail = new SMTPMail();
            $mail->setFrom($cmpname, $mailUser);
            $msgn = "Dont Reply This Email! This Mailbox does not Check. <br>";
            $msgn .= "Name:- ".$sd->qname->getValue()."<br>";
            $msgn .= "Email:- ".$sd->qemail->getValue()."<br>";
            $msgn .= "Phone:- ".$sd->qphone->getValue()."<br>";
            $msgn .= "Address:- ".$sd->qadd->getValue()."<br>";
            $msgn .= "Comments:- ".$sd->qcomments->getValue()."<br>";
            if($mail->sendMail('Query',$cmpemail, $cmpname, $msgn)){
                $sd2 = new TempFile("{$this->apppath}/forms/quote-submit.php");
                $this->setTempFile($sd2);
            }else{
                $this->setTempFile($sd);                
            }
        }        
    }
    
}
