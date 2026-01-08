<?php
global $formFields,$libpath,$genForm,$formHead,$cmpid,$showformhead;
$tblName = "pagcategory";
SphpBase::page()->tblName = $tblName;
SphpBase::page()->getAuthenticatePerm("ADMIN,MEMBER");
//SphpBase::page()->sesSecure();
//SphpBase::JSServer()->getAJAX();
$masterFile = $mebmasterf;
$formHead = "Page Category Form";
function comp_genForm_on_create($e){
    $genForm = $e["element"]->getComponent();
$genForm->setField("atype","Category Type","select","Parent,Sub");
$genForm->setField("aparent","Category Parent","select");
$genForm->setField("aname","Category Name","text","r","3","200");
$genForm->setField("rank","Category Rank","num","","","4");
$genForm->setField("spcmpid"," ","hidden");
}

$genFormFront = new FrontFile("{$libpath}/tpl/db/GenForm.php");
$aparent->setOptionsFromTable('aname','','pagcategory',"WHERE spcmpid='$cmpid' ORDER BY aname");
$aparent->unsetOptionsKeyArray();
$aparent->setOptions("NONE," . $aparent->getOptions());
if(SphpBase::sphp_request()->request('page')!=""){
SphpBase::sphp_request()->session('pg1', SphpBase::sphp_request()->request('page'));
SphpBase::page()->isnew = false;
SphpBase::page()->isevent = true;
SphpBase::page()->sact = 'show';
}else{
SphpBase::sphp_request()->request('page',SphpBase::sphp_request()->session('pg1'));
}

$showallFront = new FrontFile("{$libpath}/tpl/db/Showall.php");
$showall->setFieldNames("aname,atype,aparent");
$showall->setHeaderNames("Category Name,Type,Parent");
$showall->setColWidths("");
$showall->setWhere("WHERE spcmpid='". $cmpid ."' ORDER BY aparent");
$showall->setEdit();
$showall->setDelete();
$showall->setPerPageRows(50);
//$showall->setAjax();
//$form2->setAjax();
$showformhead  = "List Categories";

if(SphpBase::page()->isinsert || SphpBase::page()->isupdate){
$spcmpid->value = $cmpid;
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
include_once("{$libpath}/tpl/db/autoapp.php");

