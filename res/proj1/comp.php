<?php
$cmpid = "demo";
$cmpname = "Sphp Server";


$duser = "root";
$db = "dbproj";
$dpass = "";

$debugmode = true;

if($basepath != ""){
	$basepath .= "demo/";
}

//app mail settings
$mailServer = "mail.domain.com";
$mailUser = "info@domain.com";
$mailPass = "";
$mailPort = "26";

//$masterf = "temp/education/master.php";
//$admmasterf = "temp/html/master.php";

function getWelcome(){
global $logType;
global $fileName;
global $page;
global $basepath;

switch($logType){
case "ADMIN":{
$page->forward(getAppPath("admhome",'','',true));
break;
}
case "MEMBER":{
$page->forward(getAppPath("mebhome"));
break;
}

default:{
$page->forward(getAppPath("home"));
break;
}

}

}

