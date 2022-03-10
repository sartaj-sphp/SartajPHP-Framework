<?php
$auth = "ADMIN";
$tblName = "admin";
$page->Authenticate();
$page->sesSecure();
$formHead = "Admin Form";
$formFields = '
$genForm->setField("userID","User ID","text","r","4","20");
$genForm->setField("pass","Password","pass","r","4","20");
$genForm->setField("dispName","Display Name","text","r","4","50");
$genForm->setField("atype","Type","select","ADMIN,SUB ADMIN,LOWER ADMIN");
';
$genFormTemp = new TempFile("$libpath/tpl/db/GenForm.php");
//$genForm->setTable("usert");

$showallTemp = new TempFile("$libpath/tpl/db/Showall.php");
$showall->setFieldNames("userID,pass,atype,dispName");
$showall->setColWidths("20%,20%,20%,");
$showall->setEdit();
$showall->setDelete();

if($page->isevent)
{
switch($page->sact){
case 'show':{
$formNo = 2;
$blngetFront = true;
break;
}

}
 }

if($page->isview)
{
$page->viewData($form2);
$blngetFront = true;
$formNo = 1;
}
if($page->isdelete)
{
$page->deleteRec();
$blngetFront = true;
$formNo = 2;
}
if($page->issubmit)
{

}

if($page->isupdate)
{
if(!getCheckErr()){
$page->updateData();
$blngetFront = true;
$formNo = 2;
}
else{
$blngetFront = true;
$formNo = 1;
}
}

if($page->isinsert)
{
if(!getCheckErr()){
if(!$mysql->isRecordExist("SELECT userID FROM admin WHERE userID='".$userID->getValue()."'")){
$page->insertData();
$blngetFront = true;
$formNo = 2;
}else{
$blngetFront = true;
$formNo = 1;
setErr('app', 'Error Detail:-'."User ID already Exist");
}

}
else{
$blngetFront = true;
$formNo = 1;
setErr('app','Error Detail:-'.traceError(true) );
}
 }


if($page->isnew)
{
$formNo = 1;
$blngetFront = true;
 }

if ($blngetFront == true ){
switch($formNo){
    case 1:{
$genFormTemp->run();
$dynData = $genFormTemp;
include_once("temp/admmaster.php");
break;
    }
    case 2:{
$showallTemp->run();
$dynData = $showallTemp;
include_once("temp/admmaster.php");
break;
    }
}

}

?>