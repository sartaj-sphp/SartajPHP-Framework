<?php
$cmpId = "demo";
$cmpName = "SartajPHP Demo";


$dbUser = "root";
$db = "db1";
$dbPass = "mypass";

$debugMode = 2;
$admUser = 'admin';
$admPass = '1234';

if($projectUrl != ""){
	$projectUrl .= "/demo";
}

//app mail settings
$mailServer = "mail.domain.com";
$mailUser = "info@domain.com";
$mailPass = "";
$mailPort = "26";

$masterf = "masters/default/master.mast.php";
$mebmasterf = $masterf;

function getWelcome(){
$page = SphpBase::page();

switch(SphpBase::page()->getAuthenticateType()){
case "ADMIN":{
$page->forward(getAppPath("admhome",'','',true));
break;
}
case "MEMBER":{
$page->forward(getAppPath("mebhome"));
break;
}

default:{
$page->forward(getAppPath("index"));
break;
}

}

}

