<?php
$auth = "GUEST,ADMIN,MEMBER";
$tblName = "admin";
$masterFile = $admmasterf;
$page->Authenticate();

$dynData = new TempFile("{$apppath}/forms/admlogin.php");

if($page->isevent){
switch($page->sact){

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

if($page->issubmit){
 if($dynData->getComponent("txtuserID")->value == $admuser && $dynData->getComponent("txtpass")->value == $admpass){
        $number_of_days = 10 ;
        $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
        if(isset($_REQUEST["chkremb"])) {
            setcookie( "algdec", "dome1", $date_of_expiry );
        }
setSession('ADMIN', $cmpid);
\SphpBase::$sphp_request->session("edtmode",autocompkey);
getWelcome();
}else{
  $msg = "Error:- Wrong user name or password";  
$formName = "admlogin";
}
}


if($page->isnew){
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
$dynData->run();
include_once("$masterFile");
    break;
	}

}
