<?php
$cmpid = "demo";
$cmpname = "Sphp Server";


$duser = "root";
$db = "dbproj";
$dpass = "";

$debugmode = 1;

if($basepath != ""){
	$basepath .= "/res/proj1";
}

//app mail settings
$mailServer = "mail.domain.com";
$mailUser = "info@domain.com";
$mailPass = "";
$mailPort = "26";

//$masterf = "masters/education/master.php";
//$admmasterf = "masters/html/master.php";

function getWelcome(){
$page = SphpBase::page();

switch(SphpBase::page()->getAuthenticateType()){
case "ADMIN":{
$page->forward(getGateURL("mebhome",'','',true));
break;
}
case "MEMBER":{
$page->forward(getGateURL("mebhome"));
break;
}

default:{
$page->forward(getGateURL("index"));
break;
}

}

}

