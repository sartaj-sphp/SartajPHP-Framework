<?php
/**
 * Description of Frame
 *
 * @author SARTAJ
 */


class Frame extends Control{
private $width = '540px';
private $heigth = '380px';
public function oncreate($element){
$this->setHTMLName("");
}

public function setWidth($val){
$this->width = $val;
}
public function setHeight($val){
$this->height = $val;
}

public function onjsrender(){
if($this->parameterA['class'] == ''){
    addHeaderCSS('frame', '
.frame
{
border:1px solid #DDDDDD;
float:left;
height:'.$this->height.';
overflow:auto;
position:relative;
width:'.$this->width.';
}
');
$this->parameterA['class'] = 'frame';
}

}


}
?>