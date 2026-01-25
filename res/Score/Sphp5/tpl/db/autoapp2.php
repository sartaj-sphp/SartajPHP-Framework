<?php
$JSServer = SphpBase::JSServer();
$JSServer->getAJAX();

if(SphpBase::page()->isevent)
{
switch(SphpBase::page()->sact){
case 'show':{
$formNo = 2;
$blngetFront = true;
break;
}
case 'showall_show':{
$formNo = 2;
$blngetFront = true;
break;
}
case 'showall_view':{
SphpBase::page()->isevent = false;
SphpBase::page()->isview = true;
break;
}
case 'showall_delete':{
SphpBase::page()->isevent = false;
SphpBase::page()->isdelete = true;
break;
}
case 'showall_newa':{
$JSServer->addJSONFront($genFormFront,'showall_editor');
break;
}
case 'updlist':{
//$JSServer->addJSONBlock('jsp','proces','$( "#showalledt" ).dialog( "close" ); getURL("'.  getEventURL('updlist','','','','',true).'",{});');
$JSServer->addJSONComp($showall,'showall_list');
break;
}

}
 }

if(SphpBase::page()->isview)
{
SphpBase::page()->viewData($form2);
$JSServer->addJSONFront($genFormFront,'showall_editor');
}
if(SphpBase::page()->isdelete)
{
SphpBase::page()->deleteRec();
setMsg('app1','Record is Deleted' );
$JSServer->addJSONBlock('html','showerrdet',traceError(true));
$JSServer->addJSONBlock('html','showmsgdet',traceMsg(true));
$JSServer->addJSONComp($showall,'showall_list');
}

if(SphpBase::page()->isupdate)
{
if(!getCheckErr()){
SphpBase::page()->updateData();
if(!getCheckErr()){
$JSServer->addJSONBlock('jsp','proces','$( "#showall_dlg" ).dialog( "close" );');
$JSServer->addJSONComp($showall,'showall_list');
setMsg('Update Record','Your Data is Updated');
$JSServer->addJSONBlock('html','showmsgdet',traceMsg(true));    
}else{
setErr('app1','Can not Update Data' );
$JSServer->addJSONBlock('html','frmerrdet',traceError(true));
$JSServer->addJSONBlock('html','frmmsgdet',traceMsg(true));    
}
}
else{
setErr('app1','Can not Update Data' );
$JSServer->addJSONBlock('html','frmerrdet',traceError(true));
$JSServer->addJSONBlock('html','frmmsgdet',traceMsg(true));
}
}

if(SphpBase::page()->isinsert)
{
if(!getCheckErr()){
SphpBase::page()->insertData();
if(!getCheckErr()){
//setMsg('app1','New Data Record is Inserted, want more record add fill form again' );
$JSServer->addJSONBlock('jsp','proces','$( "#showall_dlg" ).dialog( "close" );');
$JSServer->addJSONComp($showall,'showall_list');
setMsg('New Record','Your Data is added in Database');
$JSServer->addJSONBlock('html','showmsgdet',traceMsg(true));    
}else{
setErr('app1','Can not add Data' );
$JSServer->addJSONBlock('html','frmerrdet',traceError(true));
$JSServer->addJSONBlock('html','frmmsgdet',traceMsg(true));    
}
}
else{
setErr('app1','Can not add Data' );
$JSServer->addJSONBlock('html','frmerrdet',traceError(true));
$JSServer->addJSONBlock('html','frmmsgdet',traceMsg(true));
}
 }


if(SphpBase::page()->isnew)
{
SphpBase::page()->forward(getEventURL('show', '', '', '', '', true));
    }

if ($blngetFront){
switch($formNo){
    case 1:{
$genFormFront->run();
$dynData = $genFormFront;
SphpBase::$dynData = $dynData;
include_once("$masterFile");
break;
    }
    case 2:{
$showallFront->run();
$dynData = $showallFront;
SphpBase::$dynData = $dynData;
include_once("$masterFile");
break;
    }
    case 3:{
$JSServer->addJSONFront($genFormFront,'showall_editor');
break;
    }
    case 4:{
$JSServer->addJSONFront($showallFront,'showall_list');
break;
    }
}

}

?>