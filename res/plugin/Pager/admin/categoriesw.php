<?php
global $formFields,$libPath,$genForm,$formHead,$cmpId,$showformhead;
$tblName = "pagcategory";
SphpBase::page()->tblName = $tblName;
SphpBase::page()->getAuthenticatePerm("ADMIN,MEMBER");
//SphpBase::page()->getSesSecurity();
//SphpBase::jsServer()->getAjax();
$masterFile = $mebmasterf;
$formHead = "Page Category Form";
function comp_genForm_on_create($e){
    $genForm = $e["element"]->getComponent();
$genForm->setField("atype","Category Type","select","Parent,Sub");
$genForm->setField("aparent","Category Parent","select");
$genForm->setField("aname","Category Name","text","r","3","200");
$genForm->setField("rank","Category Rank","num","","","4");
$genForm->setField("spcmpId"," ","hidden");
}

$genFormFront = new FrontFile("{$libPath}/tpl/db/GenForm.php");
$aparent->setOptionsFromTable('aname','','pagcategory',"WHERE spcmpId='$cmpId' ORDER BY aname");
$aparent->unsetOptionsKeyArray();
$aparent->setOptions("NONE," . $aparent->getOptions());
if(SphpBase::sphpRequest()->request('page')!=""){
SphpBase::sphpRequest()->session('pg1', SphpBase::sphpRequest()->request('page'));
SphpBase::page()->isnew = false;
SphpBase::page()->isevent = true;
SphpBase::page()->sact = 'show';
}else{
SphpBase::sphpRequest()->request('page',SphpBase::sphpRequest()->session('pg1'));
}

$showallFront = new FrontFile("{$libPath}/tpl/db/Showall.php");
$showall->setFieldNames("aname,atype,aparent");
$showall->setHeaderNames("Category Name,Type,Parent");
$showall->setColWidths("");
$showall->setWhere("WHERE spcmpId='". $cmpId ."' ORDER BY aparent");
$showall->setEdit();
$showall->setDelete();
$showall->setPerPageRows(50);
//$showall->setAjax();
//$form2->setAjax();
$showformhead  = "List Categories";

if(SphpBase::page()->isinsert || SphpBase::page()->isupdate){
$spcmpId->value = $cmpId;
$spcmpId->setDataBound();
if($rank->value==''){
$rank->value = 0;
$rank->setDataBound();
}
}

//if(!SphpBase::page()->isnew){
//}else{
//include_once("{$libPath}/tpl/db/autoapp.php");    
//}
include_once("{$libPath}/tpl/db/autoapp.php");

