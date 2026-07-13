<?php
namespace def{
    use Sphp\tools\FrontFile;
    use Sphp\tools\FrontParser;
class Index extends \Sphp\tools\BasicGate{
    
    public function onstart() {
        //$this->getAuthenticate("GUEST,ADMIN,MEMBER");
        //$this->setTableName("tbl1"); 
        $this->setMasterFile(readGlobal('masterf'));
    }
    
    public function page_new() {
        if(file_exists(PROJ_PATH . "/apps/fronts/index_home.front")){ 
            $dynData = new FrontParser(PROJ_PATH . "/apps/fronts/index_home.front");
        }else{
            //$dynData = new FrontParser($this->mypath . "/fronts/index_home.front");
            $dynData = new FrontFile("home");
        }
        $this->setFrontFile($dynData);
    }
    public function page_event_captcha($param) {
        $dynData = new FrontFile("contacts");
    }
    public function page_event_refresh_captcha($param) {
        $dynData = new FrontFile("contacts");
    }
    public function page_event_info($param) {
        $dynData = new FrontParser(PROJ_PATH . "/apps/fronts/index_{$this->page->evtp}.front");
        $this->setFrontFile($dynData);
    }
    public function page_event_page($param) { 
        $dynData = new FrontFile("{$this->page->evtp}");
        $this->setFrontFile($dynData);
    }
    
    public function page_event_subquote($evtp){
        global $mailUser,$cmpemail,$cmpname;
        $sd = new FrontFile("contacts", false,false, $this);
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
                $sd2 = new FrontFile("quote_submit");
                $this->setFrontFile($sd2);
            }else{
                $this->setFrontFile($sd);                
            }
        }        
    }
    
}
}