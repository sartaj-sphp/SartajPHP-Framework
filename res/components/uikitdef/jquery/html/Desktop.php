<?php
/**
 * Description of Desktop
 *
 * @author SARTAJ
 */


class Desktop extends Sphp\tools\Component{

protected function oncreate($element){
$this->unsetrenderTag();
}


protected function onjsrender(){
addHeaderJSCode($this->name,"
function setContentWin(frmid){
$('#{$this->name}').html($('#'+frmid).html());
return false;
}
");
}

protected function onrender(){
$this->preTag = '<div id="'.$this->name.'">&nbsp;</div><div style="display:none;">';
$this->postTag = '</div>';
}

public function setJSContent($val){
return "setContentWin('$val');";
}

}
?>