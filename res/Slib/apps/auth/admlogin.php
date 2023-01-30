<?php
SphpBase::page()->tblName = "admin";
$masterFile = $admmasterf;
SphpBase::page()->Authenticate("GUEST,ADMIN,MEMBER");

SphpBase::$dynData = new TempFile("{$apppath}/forms/admlogin.php");

if(SphpBase::page()->isevent){
switch(SphpBase::page()->sact){

case "logout" :{
    $number_of_days = -1 ;
    $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
    setcookie( "algdec", "dome1", $date_of_expiry );
    destSession();
    getWelcome();

break;
}

}
}

if(SphpBase::page()->issubmit){
 if(SphpBase::$dynData->getComponent("txtuserID")->value == $admuser && SphpBase::$dynData->getComponent("txtpass")->value == $admpass){
        $number_of_days = 10 ;
        $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
        if(isset($_REQUEST["chkremb"])) {
            setcookie( "algdec", "dome1", $date_of_expiry );
        }
setSession('ADMIN', $cmpid);
\SphpBase::sphp_request()->session("edtmode",autocompkey); 
getWelcome();
}else{
  $msg = "Error:- Wrong user name or password";  
$formName = "admlogin";
}
}


if(SphpBase::page()->isnew){
    if(!isset($_COOKIE["algdec"])) {
        $formName = "admlogin";
    }else{
        setSession('ADMIN', $cmpid);
        getWelcome();    
    }
 }
switch($formName){

    case "admlogin":{
$title = "Login System";
$metakeywords = "";
$metadescription = "";
$metaclassification = "";
SphpBase::$dynData->run();
include_once("$masterFile");
    break;
	}

}
