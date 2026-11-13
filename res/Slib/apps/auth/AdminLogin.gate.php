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
        global $cmpId;
        if (!$this->client->isCookie("algdec") && $this->page->getAuthenticateType() !== 'ADMIN') {
            // open login form
            $this->send_login_form();
        } else {
            // authenticate user type ADMIN with value $cmpId
            setSession('ADMIN', $cmpId);
            getWelcome();
        }
    }

    private function send_login_form() {
        SphpBase::sphpSettings()->title = "Login System";
        SphpBase::sphpSettings()->metaKeywords = "";
        SphpBase::sphpSettings()->metaDescription = "";
        SphpBase::sphpSettings()->metaClassification = "";
        SphpBase::sphpSettings()->keywords = "login,page,admin";
        $this->setFrontFile($this->genFormFront);
    }

    public function page_event_logout() {
        $this->client->unsetCookie("algdec");
        destSession();
        getWelcome();
    }

    public function page_submit() {
        global $adminUser, $adminPass, $cmpId;
        if ($this->genFormFront->getComponent("txtuserID")->value == $adminUser && $this->genFormFront->getComponent("txtpass")->value == $adminPass) {
            $number_of_days = 10;
            $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;
            if ($this->client->isPost("chkremb")) {
                $this->client->cookie("algdec", "dome1", false, $date_of_expiry);
            }
            // authenticate user type ADMIN with value $cmpId
            setSession('ADMIN', $cmpId);
            // forward to home page of ADMIN user type
            getWelcome();
        } else {
            setErr("app1", "Error:- Wrong user name or password");
            $this->send_login_form();
        }
    }
}
