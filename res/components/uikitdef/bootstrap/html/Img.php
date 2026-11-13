<?php
/**
 * Description of Img
 *
 * @author SARTAJ
 */
namespace Sphp\Comp\Html{

class Img extends \Sphp\Tools\Component{

protected function oninit() {
$this->tagName = "img";
$this->unsetEndTag();
//$this->unsetSubmit();
}


protected function onrender(){
    $sphpSettings = getSphpSettings();
$projectUrl = $sphpSettings->projectUrl;
if($this->value!=''){
$this->setAttribute('src', $this->value);
}
if($this->getAttribute('src')!='' && $this->getAttribute('width')!=''){
$size = getimagesize(str_replace($projectUrl, '',$this->getAttribute('src')));
$size0 = $size[0];
$size1 = $size[1];
$aspectratio = $size0/$size1;
$width = $this->getAttribute('width');
$height = $width / $aspectratio;
$this->setAttribute('height', strval($height));
}

}

// javascript functions used by ajax control and other control
public function getJsValue(){
return "document.getElementById('$this->name').value" ;
}

public function setJSValue($exp){
return "document.getElementById('$this->name').value = $exp;" ;
}

public function getJsSrc(){
return "document.getElementById('$this->name').src" ;
}

public function setJSSrc($exp){
return "document.getElementById('$this->name').src = $exp;" ;
}

}
}
