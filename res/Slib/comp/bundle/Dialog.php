<?php
/**
 * Description of Dialog
 *
 * @author SARTAJ
 */

class Dialog extends \Sphp\tools\Component{
protected function oncreate($element){
$this->setHTMLName("");
$this->setHTMLID($this->name . '_dlg');
}

public function sendAJAX($content){
    SphpBase::JSServer()->addJSONHTMLBlock($this->name . "_body",$content);
}

protected function onjsrender(){
global $jquerypath;
//work pending
//addFileLink($this->myrespath . '/fq-ui.extendeddialog.css');
//addFileLink($this->myrespath . '/fq-ui.extendeddialog.js');
    SphpJsM::addjQueryUI();
   $this->setInnerHTML('<div id="'. $this->name .'_body"></div>');
   
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
addHeaderJSFunctionCode('ready',$this->HTMLID,'
$("#'.$this->HTMLID.'").dialog({
autoOpen: false,
width: "700",
height: "800",
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
 $(".ui-dialog-titlebar-close").html("X");

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
