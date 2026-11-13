<?php
/**
 * Description of Frame
 *
 * @author SARTAJ
 */


class Frame extends Sphp\Tools\Component{
private $width = '540px';
private $heigth = '380px';
protected function oncreate($element){
$this->setHTMLName("");
}

public function fu_setWidth($val){
$this->width = $val;
}
public function fu_setHeight($val){
$this->height = $val;
}

protected function onjsrender(){
if($this->parameterA['class'] == ''){
    addHeaderCss('frame', '
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