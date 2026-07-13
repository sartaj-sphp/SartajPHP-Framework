<?php

class AdminLogin extends Sphp\Tools\BasicGate {

    public $genFormFront = null;

    public function onstart() {
        $this->getAuthenticate("GUEST,ADMIN,MEMBER");
        $this->setMasterFile(readGlobal('admmasterf'));
        $this->setTableName("admin");
        $this->genFormFront = new FrontFile("login");
    }

    public function page_new() {
        global $cmpid;
        if (!$this->Client->isCookie("algdec") && $this->page->getAuthenticateType() !== 'ADMIN') {
            // open login form
            $this->send_login_form();
        } else {
            // authenticate user type ADMIN with value $cmpid
            setSession('ADMIN', $cmpid);
            getWelcome();
        }
    }

    private function send_login_form() {
        SphpBase::sphp_settings()->title = "Login System";
        SphpBase::sphp_settings()->metakeywords = "";
        SphpBase::sphp_settings()->metadescription = "";
        SphpBase::sphp_settings()->metaclassification = "";
        SphpBase::sphp_settings()->keywords = "login,page,admin";
        $this->setFrontFile($this->genFormFront);
    }

    public function page_event_logout() {
        $this->Client->unsetCookie("algdec");
        destSession();
        getWelcome();
    }

    public function page_submit() {
        global $admuser, $admpass, $cmpid;
        if ($this->genFormFront->getComponent("txtuserID")->value == $admuser && $this->genFormFront->getComponent("txtpass")->value == $admpass) {
            $number_of_days = 10;
            $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;
            if ($this->Client->isPost("chkremb")) {
                $this->Client->cookie("algdec", "dome1", false, $date_of_expiry);
            }
            // authenticate user type ADMIN with value $cmpid
            setSession('ADMIN', $cmpid);
            // forward to home page of ADMIN user type
            getWelcome();
        } else {
            setErr("app1", "Error:- Wrong user name or password");
            $this->send_login_form();
        }
    }
}
