<?php
/**
 * Description of DropAble
 *
 * @author SARTAJ
 */



class Drop extends Control{
public function oncreate($element){
$this->setHTMLName("");
}

public function onjsrender(){
global $jquerypath;
if($this->parameterA['accept']!=''){
$this->parameterA['accept'] = ", accept: '".$this->parameterA['accept']. "'";
}
if($this->parameterA['containment']!=''){
$this->parameterA['containment'] = ", containment: '".$this->parameterA['containment']. "'";
}
if($this->parameterA['snap']!=''){
$this->parameterA['snap'] = ", snap: true";
}
if($this->parameterA['revert']!=''){
$this->parameterA['revert'] = ", revert: true";
}
if($this->parameterA['helper']!=''){
$this->parameterA['helper'] = ", helper: '".$this->parameterA['helper']. "'";
}
if($this->parameterA['handle']!=''){
$this->parameterA['handle'] = ", handle: '".$this->parameterA['handle']. "'";
}
/*
addFileLink($jquerypath.'themes/base/jquery.ui.all.css');
addFileLink($jquerypath.'ui/jquery.ui.core.min.js');
addFileLink($jquerypath.'ui/jquery.ui.droppable.min.js');
 * 
 */
addHeaderJSFunctionCode('ready',$this->name,'
$("#'.$this->name.'").droppable({
 drop: function() {
'.$this->parameterA['ondrop'].'
 },
activeClass: \'drop-hover\',
hoverClass: \'drop-active\', 
'.$this->parameterA['accept'].'
'.$this->parameterA['containment'].'
'.$this->parameterA['snap'].'
'.$this->parameterA['revert'].'
'.$this->parameterA['helper'].'
'.$this->parameterA['handle'].'
});
');
if($this->parameterA['class'] == ''){
    addHeaderCSS('drop', '
.drop-hover { 
background: #999999; 
}
.drop-active { 
background: #DDDDDD; 
}

');
    addHeaderCSS('dragdrop', '
.dragdrop
{
position: relative; 
cursor: auto;
}
');
$this->parameterA['class'] = 'dragdrop ui-widget-content ui-corner-all';
}

$this->parameterA['accept'] =  "";
$this->parameterA['containment'] =  "";
$this->parameterA['snap'] =  "";
$this->parameterA['revert'] =  "";
$this->parameterA['helper'] =  "";
$this->parameterA['handle'] =  "";
$this->parameterA['ondrop'] =  "";

}


}
?>