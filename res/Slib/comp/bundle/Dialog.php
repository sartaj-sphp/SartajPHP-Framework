<?php
/**
 * Description of DragAble
 *
 * @author SARTAJ
 */
include_once("$libpath/tools/Control.php");
include_once("$comppath/jquery.php");

class Dialog extends Control{
public function oncreate($element){
$this->setHTMLName("");
}

public function onjsrender(){
global $jquerypath;


    if($this->getAttribute('parameter')!=''){
$this->parameterA['parameter'] = ", ".$this->parameterA['parameter'];
}
    if($this->getAttribute('opener')==''){
$this->parameterA['opener'] = "#opener";
}

    if($this->getAttribute('modal')!=''){
$this->parameterA['modal'] = ", modal: ".$this->parameterA['modal'];
}
    if($this->getAttribute('buttons')!=''){
$ft = explode(',', $this->parameterA['buttons']);
$tu = '';
foreach($ft as $key=>$val){
if($tu!=''){
$tu .= ",";    
}
    switch(strtolower($val)){
     case 'ok':{
$tu .= "Ok: function() { $(this).dialog('close'); ".$this->getAttribute('onok')." }";
         break;
     }
     case 'cancel':{
$tu .= "Cancel: function() { $(this).dialog('close'); ".$this->getAttribute('oncancel')." }";
         break;
     }
     default:{
$tu .= "'$val': function() {".$this->parameterA['on'.strtolower($val)]." }";
         break;
     }
 }
}
$this->parameterA['buttons'] = ", buttons: {
$tu
        }
";
//$this->parameterA['type'] = ", modal: true '".$this->parameterA['axis']. "'";
}
/*
addFileLink($jquerypath.'themes/base/jquery.ui.all.css');
addFileLink($jquerypath.'themes/base/jquery.ui.dialog.css');
addFileLink($jquerypath.'ui/jquery.ui.core.min.js');
addFileLink("{$jquerypath}/ui/jquery.ui.widget.min.js");
addFileLink("{$jquerypath}/ui/jquery.ui.mouse.min.js");
addFileLink($jquerypath.'ui/jquery.ui.draggable.min.js');
addFileLink("{$jquerypath}/ui/jquery.ui.position.min.js");
addFileLink($jquerypath.'ui/jquery.ui.resizable.min.js');
addFileLink($jquerypath.'ui/jquery.ui.button.min.js');
addFileLink($jquerypath.'ui/jquery.ui.dialog.min.js');
addFileLink($jquerypath.'ui/jquery.ui.effect.min.js');
addFileLink($jquerypath.'ui/jquery.ui.effect-blind.min.js');
addFileLink($jquerypath.'ui/jquery.ui.effect-explode.min.js');
 * 
 */
if($this->HTMLID==''){
    $this->HTMLID = $this->name;
}
addHeaderJSFunctionCode('ready',$this->HTMLID,'
$("#'.$this->HTMLID.'").dialog({
autoOpen: false,
width: "auto",
height: "auto",
show: {
        effect: "blind",
        duration: 1000
},
hide: {
        effect: "explode",
        duration: 1000
},
title: "'.$this->getAttribute('title').'"
'.$this->getAttribute('modal').'
'.$this->getAttribute('buttons').'
'.$this->getAttribute('parameter').'
    });
$( "'.$this->getAttribute('opener').'" ).click(function() {
			$( "#'.$this->HTMLID.'" ).dialog( "open" );
			return false;
		});

');
if($this->getAttribute('class') == ''){
    addHeaderCSS('dragdrop', '
.dragdrop
{
position: relative; 
cursor: auto;
}
');
$this->parameterA['class'] = 'dragdrop';
}

}


}
?>