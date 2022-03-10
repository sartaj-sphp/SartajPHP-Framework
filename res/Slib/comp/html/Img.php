<?php
/**
 * Description of Img
 *
 * @author SARTAJ
 */
namespace Sphp\comp\html{

class Img extends \Sphp\tools\Control{

public function __construct($name='',$fieldName='',$tableName='') {
$this->tagName = "img";
$this->init($name,$fieldName,$tableName);
$this->unsetEndTag();
//$this->unsetSubmit();
}


public function onjsrender(){

}

public function onrender(){
    $sphp_settings = getSphpSettings();
$basepath = $sphp_settings->base_path;
if($this->value!=''){
$this->setAttribute('src', $this->value);
}
if($this->getAttribute('src')!='' && $this->getAttribute('width')!=''){
$size = getimagesize(str_replace($basepath, '',$this->getAttribute('src')));
$size0 = $size[0];
$size1 = $size[1];
$aspectratio = $size0/$size1;
$width = $this->getAttribute('width');
$height = $width / $aspectratio;
$this->setAttribute('height', strval($height));
}

}

// javascript functions used by ajax control and other control
public function getJSValue(){
return "document.getElementById('$this->name').value" ;
}

public function setJSValue($exp){
return "document.getElementById('$this->name').value = $exp;" ;
}

public function getJSSrc(){
return "document.getElementById('$this->name').src" ;
}

public function setJSSrc($exp){
return "document.getElementById('$this->name').src = $exp;" ;
}

}
}
