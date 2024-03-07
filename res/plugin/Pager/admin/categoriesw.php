<?php
$auth = "ADMIN";
$tblName = "pagcategory";
SphpBase::page()->tblName = $tblName;
SphpBase::page()->Authenticate();
//SphpBase::page()->sesSecure();
$JSServer->getAJAX();
$masterFile = $admmasterf;
$formHead = "Page Category Form";
$formFields = '
$genForm->setField("atype","Category Type","select","Parent,Sub");
$genForm->setField("aparent","Category Parent","select");
$genForm->setField("aname","Category Name","text","r","3","200");
$genForm->setField("rank","Category Rank","num","","","4");
$genForm->setField("spcmpid"," ","hidden");
';

$genFormTemp = new TempFile("{$libpath}/tpl/db/GenForm.php");
$aparent->setOptionsFromTable('aname','','pagcategory',"WHERE spcmpid='$cmpid' ORDER BY aname");
$aparent->unsetOptionsKeyArray();
$aparent->setOptions("NONE," . $aparent->getOptions());
if($Client->request('page')!=""){
$_SESSION['pg1'] = $_REQUEST['page'];
SphpBase::page()->isnew = false;
SphpBase::page()->isevent = true;
SphpBase::page()->sact = 'show';
}else{
    $_REQUEST['page'] = $Client->session('pg1');
}

$showallTemp = new TempFile("{$libpath}/tpl/db/Showall.php");
$showall->setFieldNames("aname,atype,aparent");
$showall->setHeaderNames("Category Name,Type,Parent");
//$showall->setColWidths("");
$showall->setWhere("WHERE spcmpid='".$_SESSION['uid']."' ORDER BY aparent");
$showall->setEdit();
$showall->setDelete();
$showall->setPerPageRows(50);
$showall->setAjax();
$form2->setAjax();
$showformhead  = "List Categories";

if(SphpBase::page()->isinsert){
$spcmpid->value = $_SESSION['uid'];
$spcmpid->setDataBound();
if($rank->value==''){
$rank->value = 0;
$rank->setDataBound();
}
}

//if(!SphpBase::page()->isnew){
//}else{
//include_once("{$libpath}/tpl/db/autoapp.php");    
//}
include_once("{$libpath}/tpl/db/autoapp2.php");

?>