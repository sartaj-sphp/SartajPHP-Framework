<?php
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
setErr('app1','Can not Update Data' );
}
}

if($page->isinsert)
{
if(!getCheckErr()){
$page->insertData();
$blngetFront = true;
$formNo = 1;
setMsg('app1','New Data Record is Inserted, want more record add fill form again' );
}
else{
$blngetFront = true;
$formNo = 1;
setErr('app1','Can not Insert Data' );
}
 }


if($page->isnew)
{
$formNo = 1;
$blngetFront = true;
 }

if ($blngetFront){
switch($formNo){
    case 1:{
$genFormTemp->run();
$dynData = $genFormTemp;
include_once("$masterFile");
break;
    }
    case 2:{
$showallTemp->run();
$dynData = $showallTemp;
include_once("$masterFile");
break;
    }
}

}

?>