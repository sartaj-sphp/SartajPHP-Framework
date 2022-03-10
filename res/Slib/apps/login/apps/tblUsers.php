<?php
$auth = "ADMIN";
$tblName = "usert";
$page->Authenticate();
$page->sesSecure();
$formHead = "Users Form";
$formFields = '
$genForm->setField("userID","User ID","text","r","4","20");
$genForm->setField("pass","Password","pass","r","4","20");
$genForm->setField("email","Email","email","r","4","100");
$genForm->setField("mobile","Mobile","num","r","10","12");
$genForm->setField("phone","Phone","num","r","10","12");
$genForm->setField("validation","Validation","select","True,False");
$genForm->setField("dispName","Display Name","text","r","4","50");
$genForm->setField("atype","Type","select","MEMBER,DEVELOPER");
$genForm->setField("status","Status","select","DONE,BAN");
$genForm->setField("sacheme","Sacheme","select","FREE,PAID");
$genForm->setField("address","Address","text","","4","200");
$genForm->setField("city","City","text","","4","50");
$genForm->setField("country","Country","text","","4","50");
$genForm->setField("expDate","Exp. Date","date");
';
$genFormTemp = new TempFile("$libpath/tpl/db/GenForm.php");
//$genForm->setTable("usert");
$validation->setDataType("BOOLEAN");

$showallTemp = new TempFile("$libpath/tpl/db/Showall.php");
$showall->setFieldNames("userID,pass,sacheme,logDate,createDate,logIP");
$showall->setColWidths("");
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
if(!$mysql->isRecordExist("SELECT userID FROM usert WHERE userID='".$userID->getValue()."'")){
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
