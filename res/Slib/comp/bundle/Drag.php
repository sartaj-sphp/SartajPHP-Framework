<?php
/**
 * Description of DragAble
 *
 * @author SARTAJ
 */



class Drag extends Sphp\tools\Component{
protected function oncreate($element){
$this->setHTMLName("");
}

protected function onjsrender(){
global $jquerypath;
if($this->parameterA['axis']!=''){
$this->parameterA['axis'] = ", axis: '".$this->parameterA['axis']. "'";
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
addFileLink($jquerypath.'ui/jquery.ui.draggable.min.js');
 * 
 */
addHeaderJSFunctionCode('ready',$this->name,'
$("#'.$this->name.'").draggable({
start: function() {
'.$this->parameterA['onstart'].'
 },
 drag: function() {
'.$this->parameterA['ondrag'].'
 },
 stop: function() {
'.$this->parameterA['onstop'].'
 }
'.$this->parameterA['axis'].'
'.$this->parameterA['containment'].'
'.$this->parameterA['snap'].'
'.$this->parameterA['revert'].'
'.$this->parameterA['helper'].'
'.$this->parameterA['handle'].'
});
');
if($this->parameterA['class'] == ''){
    addHeaderCSS('dragdrop', '
.dragdrop
{
position: relative; 
cursor: auto;
}
');
$this->parameterA['class'] = 'dragdrop ui-widget-content ui-corner-all';
}

$this->parameterA['axis'] =  "";
$this->parameterA['containment'] =  "";
$this->parameterA['snap'] =  "";
$this->parameterA['revert'] =  "";
$this->parameterA['helper'] =  "";
$this->parameterA['handle'] =  "";
$this->parameterA['onstart'] =  "";
$this->parameterA['ondrag'] =  "";
$this->parameterA['onstop'] =  "";

}


}
?>