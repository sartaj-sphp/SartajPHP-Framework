<?php
class index extends \Sphp\tools\BasicApp{
    
    public function onstart() {
        global $masterf;
        //$this->getAuthenticate("GUEST,ADMIN,MEMBER");
        //$this->setTableName("tbl1"); 
        $this->setMasterFile($masterf);
    }
    
    public function page_new() {
        if(file_exists(PROJ_PATH . "/fronts/index.front")){ 
            $dynData = new FrontFile(PROJ_PATH . "/fronts/index.front");
        }else{
            $dynData = new FrontFile("{$this->mypath}/fronts/index.front");
        }
        $this->setFrontFile($dynData);
    }
    public function page_event_captcha($param) {
        $dynData = new FrontFile("{$this->mypath}/fronts/contacts.front");
    }
    public function page_event_refresh_captcha($param) {
        $dynData = new FrontFile("{$this->mypath}/fronts/contacts.front");
    }
    public function page_event_info($param) {
        $dynData = new FrontFile("fronts/{$this->page->evtp}.front");
        $this->setFrontFile($dynData);
    }
    public function page_event_page($param) { 
        $dynData = new FrontFile($this->mypath . "/fronts/{$this->page->evtp}.front");
        $this->setFrontFile($dynData);
    }
    
    public function page_event_subquote($evtp){
        global $mailUser,$cmpemail,$cmpname;
        $sd = new FrontFile("{$this->mypath}/fronts/contacts.front", false,false, $this);
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
                $sd2 = new FrontFile("{$this->mypath}/fronts/quote-submit.front");
                $this->setFrontFile($sd2);
            }else{
                $this->setFrontFile($sd);                
            }
        }        
    }
    
}
