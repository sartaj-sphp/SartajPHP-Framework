<?php
$auth = "ADMIN";
$tblName = "admin";
$page->Authenticate();
//$page->sesSecure();
$masterFile = $admmasterf;

if($page->isnew)
{
$formName ="admhome";
 }


if($page->isevent){
switch($page->sact){

}
}

switch($formName){

    case "admhome":{
$title = "";
$metakeywords = "";
$metadescription = "";
$metaclassification = "";
$dynData = new TempFile("{$apppath}/forms/admhome.php");
$dynData->run();
include_once("$masterFile");
    break;
	}

}
?>