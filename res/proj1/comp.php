<?php
$cmpid = "demo";
$cmpName = "Sphp Server";


$dbUser = "root";
$db = "dbproj";
$dbPass = "";

$debugMode = 1;

if($projectUrl != ""){
	$projectUrl .= "/res/proj1";
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
$page->forward(getGateUrl("admhome",'','',true));
break;
}
case "MEMBER":{
$page->forward(getGateUrl("mebhome"));
break;
}

default:{
$page->forward(getGateUrl("index"));
break;
}

}

}

