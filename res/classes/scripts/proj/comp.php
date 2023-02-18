<?php
$cmpid = "demo";
$cmpname = "SartajPHP Demo";


$duser = "root";
$db = "db1";
$dpass = "mypass";

$debugmode = 2;

if($basepath != ""){
	$basepath .= "proj_folder/";
}

//app mail settings
$mailServer = "mail.domain.com";
$mailUser = "info@domain.com";
$mailPass = "";
$mailPort = "26";

$masterf = "temp/default/master.php";
//$admmasterf = "temp/admin/master.php";

function getWelcome(){
$page = SphpBase::page();

switch(SphpBase::page()->getAuthenticateType()){
case "ADMIN":{
$page->forward(getAppURL("admhome",'','',true));
break;
}
case "MEMBER":{
$page->forward(getAppURL("mebhome"));
break;
}

default:{
$page->forward(getAppURL("index"));
break;
}

}

}

