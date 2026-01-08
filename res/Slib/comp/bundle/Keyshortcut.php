<?php
/**
 * Description of Keyshortcut
 *
 * @author SARTAJ
 */


class Keyshortcut extends Sphp\tools\Component{

protected function oncreate($element){
$this->unsetrenderTag();
}


protected function onjsrender(){
if($this->parameterA['keys']!=''){
$this->parameterA['keys'] = strtoupper($this->parameterA['keys']);
$ky = split(',',$this->parameterA['keys']);
$kyf = split(',',$this->parameterA['keyfun']);
foreach($ky as $key=>$val){
$str .= "if(String.fromCharCode(e.which) == '$val') { $kyf[$key] return false; } ";
}

addHeaderJSCode($this->name,"
var isCtrl = false; $(document).keyup(function (e) { if(e.which == 17) isCtrl=false; }).keydown(function (e) {if(e.which == 17) isCtrl=true; 
if(isCtrl == true){$str}
}); 
");
}
}



}
?>