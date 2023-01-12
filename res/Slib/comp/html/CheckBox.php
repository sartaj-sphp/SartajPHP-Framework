<?php
/**
 * Description of CheckBox
 *
 * @author SARTAJ
 */
namespace Sphp\comp\html{

class CheckBox extends \Sphp\tools\Control{
private $formName = '';
private $msgName = '';
    private $errmsg = '';
private $req = false;
private $label = "";

public function oninit() {
$Client = \SphpBase::$sphp_request;
$this->tagName = "input";
$this->setAttribute('type','checkbox');
if($this->issubmit){
$this->setAttribute('checked', 'checked');
}else if($Client->request('chktxt'.$this->name)=='1'){
$this->value = '0';
$this->setDataBound();
}
        if($this->getAttribute("msgname") != ""){
            $this->msgName = $this->getAttribute("msgname");
        }        

}
public function setLabel($param) {
    $this->label = $param;
}
    public function setErrMsg($msg){
        $this->errmsg .= '<strong class="alert-danger">' . $msg . '</strong>';
        setErr($this->name, $msg);
    }
    protected function genhelpPropList() {
        $this->addHelpPropFunList('setForm','Bind with Form JS Event','','$val');
        $this->addHelpPropFunList('setMsgName','Name Display in placeholder and Error','','$val');
        $this->addHelpPropFunList('setRequired','Can not submit Empty','','');
    }

     public function setForm($val) { $this->formName = $val;}
     public function setMsgName($val) { $this->msgName = $val; $this->setAttribute('placeholder', $val);}
     public function setRequired() {
if($this->issubmit){
if(strlen($this->value) < 1){
$this->setErrMsg($this->getAttribute("msgname") .' ' . "Can not submit Empty");
            }
  }
$this->req = true;
}

public function onprejsrender(){
if($this->formName !='' && $this->req){
$jscode = "if(blnSubmit==true && ".$this->getJSValue()."==false){
    blnSubmit = false ;
alert('Please Accept ".$this->msgName."');
document.getElementById('$this->name').focus();
}";
addFooterJSFunctionCode("{$this->formName}_submit", "$this->name",$jscode);
}
}

public function onrender(){
        if($this->errmsg!=""){
            $this->setPostTag($this->errmsg);
        }
 if($this->getAttribute('class')==''){
    $this->class = "form-check-input";
}
   $this->setPostTag('<input type="hidden" name="chktxt'.$this->name.'" value="1" />');
        if($this->label != ""){
            $this->setPreTag($this->getPreTag() . '<div class="form-check">');
            $this->setPostTag('<label class="form-check-label" for="'. $this->name .'">
    '. $this->label .'
  </label></div>' . $this->getPostTag());
        }
   
if($this->value != '1'){
$this->setAttribute('value', '1');
}else{
$this->setAttribute('value', '1');
$this->setAttribute('checked', 'checked');
}

}


// javascript functions
public function getJSValue(){
return "document.getElementById('$this->name').checked" ;
}

public function setJSValue($exp){
$jsOut = "document.getElementById('$this->name').checked = $exp;" ;
writeGlobal("jsOut",$jsOut);
}


}
}
