<?php
SphpBase::page()->tblName = "admin";
SphpBase::page()->Authenticate("ADMIN");
//SphpBase::page()->sesSecure();
$masterFile = $admmasterf;
$apppath = SphpBase::page()->apppath;

if(SphpBase::page()->isnew)
{
$formName ="admhome";
 }


if(SphpBase::page()->isevent){
switch(SphpBase::page()->sact){

}
}

switch($formName){

    case "admhome":{
$title = "";
$metakeywords = "";
$metadescription = "";
$metaclassification = "";
SphpBase::$dynData = new TempFile("{$apppath}/forms/admhome.php");
SphpBase::$dynData->run();
include_once("$masterFile");
    break;
	}

}
