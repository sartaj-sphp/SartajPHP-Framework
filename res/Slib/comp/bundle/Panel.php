<?php
/**
 * Description of Add Panel
 *
 * @author SARTAJ
 */


class Panel extends Control{

public function __construct($name='',$fieldName='',$tableName='') {
}
public function oncreate($element){
$this->setHTMLName("");
}


public function onjsrender(){
if($this->parameterA['class'] == ''){
    addHeaderCSS('panel', '
.panelc
{
-moz-box-shadow: 10px 10px 5px #888888;
padding: 5px 5px 5px 15px;
background-color: #EEEEEE;
-moz-border-radius: 5px; 
-webkit-border-radius: 5px;

}

');
$this->parameterA['class'] = 'panelc';
}

}


}
?>