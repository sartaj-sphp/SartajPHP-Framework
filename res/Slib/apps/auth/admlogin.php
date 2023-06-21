<?php

// global app type
SphpBase::page()->tblName = "admin";
$masterFile = $admmasterf;
SphpBase::page()->Authenticate("GUEST,ADMIN,MEMBER");
global $msg;
$msg = "";
SphpBase::$dynData = new TempFile(SphpBase::page()->apppath . "/forms/admlogin.php");
$formName = "";

if (SphpBase::page()->isevent) {
    switch (SphpBase::page()->sact) {

        case "logout" : {
                SphpBase::sphp_request()->unsetCookie("algdec");
                destSession();
                getWelcome();
                break;
            }
    }
}

if (SphpBase::page()->issubmit) {
    if (SphpBase::$dynData->getComponent("txtuserID")->value == $admuser && SphpBase::$dynData->getComponent("txtpass")->value == $admpass) {
        $number_of_days = 10;
        $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;
        if (SphpBase::sphp_request()->isPost("chkremb")) {
            SphpBase::sphp_request()->cookie("algdec", "dome1",false, $date_of_expiry);
        }
        // authenticate user type ADMIN with value $cmpid
        setSession('ADMIN', $cmpid);
        // forward to home page of ADMIN user type
        getWelcome();
    } else {
        $msg = "Error:- Wrong user name or password";
        $formName = "admlogin";
    }
}


if (SphpBase::page()->isnew) {
    if (! SphpBase::sphp_request()->isCookie("algdec") && SphpBase::page()->getAuthenticateType() !== 'ADMIN') {
        // open login form
        $formName = "admlogin";
    }else{
        // authenticate user type ADMIN with value $cmpid
        setSession('ADMIN', $cmpid);
        getWelcome();
    }
}
switch ($formName) {

    case "admlogin": {
            SphpBase::sphp_settings()->title = "Login System";
            SphpBase::sphp_settings()->metakeywords = "";
            SphpBase::sphp_settings()->metadescription = "";
            SphpBase::sphp_settings()->metaclassification = "";
            SphpBase::sphp_settings()->keywords = "login,page,admin";
            SphpBase::$dynData->run();
            include_once("$masterFile");
            break;
        }
}
