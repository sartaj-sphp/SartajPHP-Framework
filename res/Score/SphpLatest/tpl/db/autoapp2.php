<?php
$jsServer = SphpBase::jsServer();
$jsServer->getAjax();

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
$jsServer->addJsonFront($genFormFront,'showall_editor');
break;
}
case 'updlist':{
//$jsServer->addJsonBlock('jsp','proces','$( "#showalledt" ).dialog( "close" ); getURL("'.  getEventUrl('updlist','','','','',true).'",{});');
$jsServer->addJsonComp($showall,'showall_list');
break;
}

}
 }

if(SphpBase::page()->isview)
{
SphpBase::page()->viewData($form2);
$jsServer->addJsonFront($genFormFront,'showall_editor');
}
if(SphpBase::page()->isdelete)
{
SphpBase::page()->deleteRec();
setMsg('Gate1','Record is Deleted' );
$jsServer->addJsonBlock('html','showerrdet',traceError(true));
$jsServer->addJsonBlock('html','showmsgdet',traceMsg(true));
$jsServer->addJsonComp($showall,'showall_list');
}

if(SphpBase::page()->isupdate)
{
if(!getCheckErr()){
SphpBase::page()->updateData();
if(!getCheckErr()){
$jsServer->addJsonBlock('jsp','proces','$( "#showall_dlg" ).dialog( "close" );');
$jsServer->addJsonComp($showall,'showall_list');
setMsg('Update Record','Your Data is Updated');
$jsServer->addJsonBlock('html','showmsgdet',traceMsg(true));    
}else{
setErr('Gate1','Can not Update Data' );
$jsServer->addJsonBlock('html','frmerrdet',traceError(true));
$jsServer->addJsonBlock('html','frmmsgdet',traceMsg(true));    
}
}
else{
setErr('Gate1','Can not Update Data' );
$jsServer->addJsonBlock('html','frmerrdet',traceError(true));
$jsServer->addJsonBlock('html','frmmsgdet',traceMsg(true));
}
}

if(SphpBase::page()->isinsert)
{
if(!getCheckErr()){
SphpBase::page()->insertData();
if(!getCheckErr()){
//setMsg('Gate1','New Data Record is Inserted, want more record add fill form again' );
$jsServer->addJsonBlock('jsp','proces','$( "#showall_dlg" ).dialog( "close" );');
$jsServer->addJsonComp($showall,'showall_list');
setMsg('New Record','Your Data is added in Database');
$jsServer->addJsonBlock('html','showmsgdet',traceMsg(true));    
}else{
setErr('Gate1','Can not add Data' );
$jsServer->addJsonBlock('html','frmerrdet',traceError(true));
$jsServer->addJsonBlock('html','frmmsgdet',traceMsg(true));    
}
}
else{
setErr('Gate1','Can not add Data' );
$jsServer->addJsonBlock('html','frmerrdet',traceError(true));
$jsServer->addJsonBlock('html','frmmsgdet',traceMsg(true));
}
 }


if(SphpBase::page()->isnew)
{
SphpBase::page()->forward(getEventUrl('show', '', '', '', '', true));
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
$jsServer->addJsonFront($genFormFront,'showall_editor');
break;
    }
    case 4:{
$jsServer->addJsonFront($showallFront,'showall_list');
break;
    }
}

}

?>