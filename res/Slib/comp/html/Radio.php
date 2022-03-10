<?php
/**
 * Description of Radio
 *
 * @author SARTAJ
 */
namespace Sphp\comp\html{

class Radio extends \Sphp\tools\Control{
private $formName = '';
private $msgName = '';
private $req = false;
private $vals = array();
private $valf = '';

    protected function genhelpPropList() {
        parent::genhelpPropList();
        $this->addHelpPropFunList('setForm','Bind with Form JS Event','','$val');
        $this->addHelpPropFunList('setMsgName','Name Display in placeholder and Error','','$val');
        $this->addHelpPropFunList('setRequired','Can not submit Empty','','');
    }

public function oninit() {
$this->tagName = "input";
$this->setAttribute('type', 'radio');
}

public function oncreate($element){
$this->vals[] = $element->getAttribute('value');
if($valf==''){
$valf = $element->getAttribute('value');
}
}
     public function setForm($val) { $this->formName = $val;}
     public function setMsgName($val) { $this->msgName = $val;}
     public function setRequired() {
if($this->issubmit){
if(strlen($this->value) < 1){
setErr($this->name,"Can not submit Empty");
            }
  }
$this->req = true;
}

public function onprejsrender(){
if($this->formName !='' && $this->req){
$jscode = "if(blnSubmit==true && ". $this->getJSValue()."==false){blnSubmit = false ; alert('Please Select ". $this->msgName . "'); document.getElementById('" . $this->name ."').focus();}";
addFooterJSFunctionCode("{$this->formName}_submit", "$this->name",$jscode);
}
}

public function onrender(){
if($this->getAttribute('class')==''){
    $this->class = "form-control";
}
$vt = current($this->vals);
if($vt == $this->value){
$this->setAttribute('checked', 'checked');
}else{
$this->setAttribute('checked', '');
}
$this->setAttribute('value', $vt);
next($this->vals);
}


// javascript functions
public function getJSValue(){
return "document.getElementById('$this->name').checked" ;
}

public function setJSValue($exp){
$jsOut = "document.getElementById('$this->name').checked = $exp;" ;
}

}
}
