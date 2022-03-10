<?php
$JSServer->getAJAX();

if($page->isevent)
{
switch($page->sact){
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
$page->isevent = false;
$page->isview = true;
break;
}
case 'showall_delete':{
$page->isevent = false;
$page->isdelete = true;
break;
}
case 'showall_newa':{
$JSServer->addJSONTemp($genFormTemp,'showall_editor');
break;
}
case 'updlist':{
//$JSServer->addJSONBlock('jsp','proces','$( "#showalledt" ).dialog( "close" ); getURL("'.  getEventPath('updlist','','','','',true).'",{});');
$JSServer->addJSONComp($showall,'showall_list');
break;
}

}
 }

if($page->isview)
{
$page->viewData($form2);
$JSServer->addJSONTemp($genFormTemp,'showall_editor');
}
if($page->isdelete)
{
$page->deleteRec();
setMsg('app1','Record is Deleted' );
$JSServer->addJSONBlock('html','showerrdet',traceError(true));
$JSServer->addJSONBlock('html','showmsgdet',traceMsg(true));
$JSServer->addJSONComp($showall,'showall_list');
}

if($page->isupdate)
{
if(!getCheckErr()){
$page->updateData();
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

if($page->isinsert)
{
if(!getCheckErr()){
$page->insertData();
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


if($page->isnew)
{
$page->forward(getEventPath('show', '', '', '', '', true));
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
    case 3:{
$JSServer->addJSONTemp($genFormTemp,'showall_editor');
break;
    }
    case 4:{
$JSServer->addJSONTemp($showallTemp,'showall_list');
break;
    }
}

}

?>