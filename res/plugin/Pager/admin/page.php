<?php
global $formFields,$libpath,$genForm,$formHead,$cmpid,$showformhead;
$tblName = "pagdet";
SphpBase::page()->tblName = $tblName;
SphpBase::page()->getAuthenticatePerm("ADMIN,MEMBER");
//SphpBase::page()->Authenticate();
//SphpBase::page()->sesSecure();
SphpBase::JSServer()->getAJAX();

$masterFile = $mebmasterf;
$formHead = "Add Edit Web Pages";
function comp_genForm_on_create($e){
    $genForm = $e["element"]->getComponent();
$genForm->setField("pagesubttitle","Web Title","text","r","2","300");
$genForm->setField("pagetitle","Page Heading","text","","","70");
$genForm->setField("pagedes","Meta Description","text","","","150");
$genForm->setField("pagekey","Meta Keywords","text","","","850");
$genForm->setField("catname","Category","select");
$genForm->setField("pagestatus","Ban","select","NO,YES");
$genForm->setField("menustatus","Show Menu","select","YES,NO");
$genForm->setField("menuname","Menu Name","text","","","40");
$genForm->setField("rank","Menu Rank","num","","","4");
$genForm->setField("filepath1","FileName","file","","2","200000");
$genForm->setField("filepath2","FileName","file","","2","200000");
$genForm->setField("details","Page Code","controls/TinyEditor/TinyEditor.php");
$genForm->setField("spcmpid"," ","hidden");
$genForm->setField("catid"," ","hidden");
$genForm->setField("pagename"," ","hidden");
}

$genFormFront = new FrontFile("{$libpath}/tpl/db/GenForm.php");
if($details->issubmit){
$pagename->value = str_replace(" ", "_",  strtolower($pagetitle->value));
$pagename->value = str_replace("//", "",  $pagename->value);
$pagename->value = str_replace("-", "",  $pagename->value);
$pagename->setDataBound();
}

$catname->setOptionsFromTable('id,aname','id,aname','pagcategory',"WHERE spcmpid='$cmpid' ORDER BY aname");
$details->unsetDataBound();
$filepath1->setFileSavePath("pagres/". $pagename->value .'-1.'.$filepath1->getFileExtention());
$filepath2->setFileSavePath("pagres/". $pagename->value .'-2.'.$filepath2->getFileExtention());
$filepath1->setFileTypesAllowed("image/pjpeg,image/jpeg,image/gif,image/x-png,image/png");
$filepath2->setFileTypesAllowed("image/pjpeg,image/jpeg,image/gif,image/x-png,image/png");
$genForm->firecompcreate();


$details->parameterA['rows'] = 50;
if($details->issubmit){
file_put_contents("pagres/". $pagename->getValue().".html",$details->getValue());
}

$showallFront = new FrontFile("{$libpath}/tpl/db/Showall.php");
$showall->setFieldNames("pagename,pagestatus,catname");
$showall->setHeaderNames("Name,Ban,Category");
$showall->setWhere("WHERE spcmpid='". $cmpid ."'  ORDER BY catname");
$showall->setColWidths("");
$showall->setEdit();
$showall->setDelete();
//$showall->setCacheTime(10);
$showall->setPerPageRows(50);
//$showall->setAJAX();
//$form2->setAJAX();
$showformhead  = "List Pages";


function getProdLimit(){
global $showallFront,$showall,$page;
$showallFront->run();
$nump = count($showall->result);
 if($nump>=20){
     setErr('Membership', 'You can not add more pages.Please Upgrade you membership!');
     $blnert = true;
 }
    if(getCheckErr() && $blnert){
SphpBase::page()->isnew = false;
SphpBase::page()->isinsert = false;
SphpBase::page()->isevent = true;
SphpBase::page()->sact = 'show';
 }
else if(getCheckErr() && !$blnert){
 }

}


if(SphpBase::page()->isinsert){
if(SphpBase::dbEngine()->isRecordExist("SELECT pagename FROM pagdet WHERE spcmpid='$cmpid' AND pagename='$pagename->value'")){
     setErr('Pagename', 'You can not add more pages with same name!');
	}
//getProdLimit();
}
if(SphpBase::page()->isview){
SphpBase::page()->viewData($form2);
$details->value = file_get_contents("pagres/". $pagename->getValue().".html");
SphpBase::page()->isview = false;
$formNo = 1;
$blngetFront = true;
}
if(SphpBase::page()->isnew){
//getProdLimit();
}
if(SphpBase::page()->isdelete){
SphpBase::page()->viewData($form2,SphpBase::page()->evtp);
$pathf = "pagres/".$pagename->getValue().".html";
if(file_exists($pathf)){unlink($pathf);}
}

if(SphpBase::page()->isinsert || SphpBase::page()->isupdate){
    $spcmpid->value = $cmpid;
    $spcmpid->setDataBound();
    $catid->value = explode(",",$catname->value)[0];
    $catid->setDataBound();
    $callbackfun = function(){
        // update cache data
        //SphpBase::debug()->println('y');
        include(__DIR__ . "/../front/menuupdate.php");
    };    
    
}

//addHeaderJSFunctionCode('pageload', 'jh', 'alert("load done")',true);
include_once("{$libpath}/tpl/db/autoapp.php");

