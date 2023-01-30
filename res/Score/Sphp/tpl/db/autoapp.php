<?php
if(SphpBase::page()->isevent)
{
switch(SphpBase::page()->sact){
case 'show':{
$formNo = 2;
$blngetFront = true;
break;
}

}
 }

if(SphpBase::page()->isview)
{
SphpBase::page()->viewData($form2);
$blngetFront = true;
$formNo = 1;
}
if(SphpBase::page()->isdelete)
{
SphpBase::page()->deleteRec();
$blngetFront = true;
$formNo = 2;
}

if(SphpBase::page()->isupdate)
{
if(!getCheckErr()){
SphpBase::page()->updateData();
$blngetFront = true;
$formNo = 2;
}
else{
$blngetFront = true;
$formNo = 1;
setErr('app1','Can not Update Data' );
}
}

if(SphpBase::page()->isinsert)
{
if(!getCheckErr()){
SphpBase::page()->insertData();
$blngetFront = true;
$formNo = 2;
setMsg('app1','New Data Record is Inserted, want more record add fill form again' );
}
else{
$blngetFront = true;
$formNo = 1;
setErr('app1','Can not Insert Data' );
}
 }


if(SphpBase::page()->isnew)
{
$formNo = 1;
$blngetFront = true;
 }

if ($blngetFront){
switch($formNo){
    case 1:{
$genFormTemp->run();
$dynData = $genFormTemp;
SphpBase::$dynData = $dynData;
include_once("$masterFile");
break;
    }
    case 2:{
$showallTemp->run();
$dynData = $showallTemp;
SphpBase::$dynData = $dynData;
include_once("$masterFile");
break;
    }
}

}

?>