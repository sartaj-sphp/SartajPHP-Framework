<?php
/**
 * Description of Radio
 * Placeholder Show as heading the group of radio buttons and message on validation error.
 * setOptions Take both JSON and comma separated list of Value and Label pair. 
 * set checked,disabled radio button with value.
 *<input id="radbook" funsetForm="form2" placeholder="Choose Book" funsetOptions="Book1,Book2,Book3"
 type="radio" runat="server" funsetRequired="" checked="Book2" disabled="Book3" />
 * @author SARTAJ
 */
namespace Sphp\Comp\Form{

class Radio extends \Sphp\tools\Component{
private $formName = '';
private $msgName = '';
private $req = false;
private $options = array();

    protected function genhelpPropList() {
        parent::genhelpPropList();
        $this->addHelpPropFunList('setForm','Bind with Form JS Event','','$val');
        $this->addHelpPropFunList('setMsgName','Name Display in placeholder and Error','','$val');
        $this->addHelpPropFunList('setRequired','Can not submit Empty','','');
    }

protected function oninit() {
$this->tagName = "input";
        if(!$this->element->hasAttribute("name")){
            $this->HTMLName = $this->name;
        }else{
            $this->HTMLName = $this->getAttribute("name");            
        }

$this->setAttribute('type', 'radio');
}

     public function fi_setForm($val) { $this->formName = $val;}
     public function fu_setMsgName($val) { $this->msgName = $val;}
     /**
      * {"option1":"label1", "option2": "label2"}
      * or comma separated list
      * option1,option2
      * @param string $val
      */
     public function fu_setOptions($val) { 
        $opt1 = array();
        if($val[0] == '{'){
            $opt2 = json_decode($val,true);
            foreach($opt2 as $key=>$val){
                $opt1[] = [$key,$val];
            }
            $this->options = $opt1;
        }else{
            $this->options = explode(",",$val);            
        }
         
     }
     public function fi_setRequired() {
if($this->issubmit){
if(strlen($this->value) < 1){
setErr($this->name,"Can not submit Empty");
            }
  }
$this->req = true;
}

protected function onprejsrender(){
    if($this->msgName == "") $this->msgName = $this->getAttribute("placeholder");
if($this->formName !='' && $this->req){
$jscode = "var f1 = ". $this->getJSValue() ."; var v1 = f1(); if(blnSubmit==true && v1[0]==-1){blnSubmit = false ; alert('Please Select ". $this->msgName . "'); document.getElementById('" . $this->name ."0').focus();}";
addHeaderJSFunctionCode("{$this->formName}_submit", "$this->name",$jscode);
}
}

protected function onrender(){
if($this->getAttribute('class')==''){
    $class = "form-check form-check-inline";
}else{
    $class = $this->element->getAttribute("class");    
}
$chk = false;
if($this->getAttribute('checked')!='') $chk = true;

$stro = "";
if(strlen($this->msgName) > 2) $stro = "<h2 class=\"\">{$this->msgName}</h2>";
// only when checked
$blnchkone = true;
foreach($this->options as $i=>$v){
    $v0 = "";
    $label = "";
    if(is_array($v)){
        $v0 = $v[0];
        $label = $v[1];
    }else{
        $v0 = $v;
        $label = $v;        
    }
    $checked = "";
    $disabled = "";
    if($blnchkone){
        if($this->value != "" && $v0 == $this->value){
            $checked = 'checked="checked"';
            $blnchkone = false;
        }else if($chk && $this->getAttribute("checked") == $v0){
            $checked = 'checked="checked"';        
            $blnchkone = false;
        }
    }
    if($this->getAttribute("disabled") == $v0){
        $disabled = 'disabled="disabled"';        
    }
    $stro .= '<div class="'. $class .'">
  <input class="form-check-input" type="radio" value="'. $v0 .'" name="'. $this->name .'" id="'. $this->name . $i .'"  '. $checked .' '. $disabled .'>
  <label class="form-check-label" for="'. $this->name .'">
    '. $label  .'
  </label>
</div>';
}

// wrap original tag as child of div
$parentdiv = $this->element->wrapTag('div');
// over write original tag with stro html
$parentdiv->setInnerHTML($stro);
$parentdiv->setAttribute("class","px-2 py-2");
//$parentdiv->setInnerPreTag("<div class=\"card-body\">");
//$parentdiv->setInnerPostTag("</div>");
}


// javascript functions
public function getJSValue(){
    return " function(){var v1 = []; v1[0] = -1; v1[1]='';  for(var c=0;c<". count($this->options) ."; c++){ if(document.getElementById('$this->name' + c).checked){v1[0] = c;v1[1] = \$('#$this->name' + c).val(); } } return v1;}" ;
}


}
}
