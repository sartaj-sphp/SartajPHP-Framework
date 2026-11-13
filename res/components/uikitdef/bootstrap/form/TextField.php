<?php

/**
 * Description of textfield
 *
 * @author SARTAJ
 */

namespace Sphp\Comp\Form{

class TextField extends \Sphp\Tools\Component{

    public $maxLen = '';
    public $minLen = '';
    private $formName = '';
    private $msgName = '';
    private $errmsg = '';
    private $password = false;
    private $readOnly = false;
    private $numeric = false;
    private $email = false;
    private $req = false;
    private $match = "";

    protected function genhelpPropList() {
        parent::genhelpPropList();
        $this->addHelpPropFunList('setForm','Bind with Form JS Submit Event','','$val');
        $this->addHelpPropFunList('setMsgName','Name Display in placeholder and Error','','$val');
        $this->addHelpPropFunList('setNumeric','Only Accept Numeric Value','','');
        $this->addHelpPropFunList('setRequired','Can not submit Empty','','');
        $this->addHelpPropFunList('setEmail','Only Accept Email','','');
        $this->addHelpPropFunList('setMaxLen','Maximum Accept Length','','$val');
        $this->addHelpPropFunList('setMinLen','Minimum Accept Length','','$val');
        $this->addHelpPropFunList('setPassword','Mask as Pasword Char','','');
        $this->addHelpPropFunList('setReadOnly','Set as Read Only','','');
    }
    protected function oninit() {
        $this->tagName = "input";
        if(!$this->element->hasAttribute("name")){
            $this->htmlName = $this->name;
        }else{
            $this->htmlName = $this->getAttribute("name");            
        }
        if($this->getAttribute("type") == ""){
            $this->setAttribute('type', 'text');
        }
        if($this->getAttribute("msgname") != ""){
            $this->msgName = $this->getAttribute("msgname");
        } 
        
//        $this->unsetEndTag();
    }

    public function fi_setForm($val) {
        $this->formName = $val;
    }

    // upper or lower
    public function fi_setCase($val) {
        if($val == "upper"){
            $this->value = strtoupper($this->value);
        }else{
            $this->value = strtolower($this->value);            
        }
    }
    
    public function fu_setMsgName($val) {
        $this->msgName = $val;
        $this->setAttribute('placeholder', $val);
    }
    public function setErrMsg($msg){
        $this->errmsg .= '<strong class="text-danger">' . $msg . '! </strong>';
        if(\SphpBase::sphpRequest()->isAjax()){
            \SphpBase::jsServer()->addJsonJsBlock('$("#'. $this->name .'").after("<strong class=\"text-danger\">' . $msg . '! </strong>");');
        }
        setErr($this->name, $msg); 
    }
    public function fi_setNumeric() {
        if ($this->blnSubmit) {
            if (!isValidNum($this->value, $this->dataType)) {
                if ($this->dataType == "INT") {
                    $msg = "Please Fill a Whole Number";
                } else {
                    $msg = "Please Fill a Number";
                }
                $this->setErrMsg( $this->getAttribute("msgname") .' ' . $msg);
            }
        }
        $this->numeric = true;
    }

    public function fi_setMatch($compid) { 
        if ($this->blnSubmit) {
            if ($this->value != $this->frontobj->getComponent($compid)->value) {
                $this->setErrMsg( $this->getAttribute("msgname") .' ' . "Value is not Match"); 
            }
        }
        $this->match = $compid;
    }
    
    public function fi_setRequired() { 
        if ($this->blnSubmit) {
            if (strlen($this->value) < 1) {
                $this->setErrMsg( $this->getAttribute("msgname") .' ' . "Can not submit Empty"); 
            }
        }
        $this->req = true;
    }

    public function fi_setEmail() {
        if ($this->blnSubmit) {
            if (strlen($this->value) > 0 && !isValidEmail($this->value)) {
                $this->setErrMsg( $this->getAttribute("msgname") .' ' . "Please Fill correct Email Address");
            }
        }
        $this->email = true;
    }

    public function fi_setMaxLen($val) {
        $this->maxLen = $val;
        if ($this->blnSubmit) {
            if (strlen($this->getValue()) > $val) {
                $this->setErrMsg( $this->getAttribute("msgname") .' ' . "Maximum Characters should not be exceed then $val");
            }
        }
    }

    public function getMaxLen() {
        return $this->maxLen;
    }

    public function fi_setMinLen($val) {
        $this->minLen = $val;
        if ($this->blnSubmit) {
            if ($this->getValue() != '' && strlen($this->getValue()) < $val) {
                $this->setErrMsg( $this->getAttribute("msgname") .' ' . "Minimum Characters should be $val");
            }
        }
    }

    public function getMinLen() {
        return $this->minLen;
    }

    public function fu_setPassword() {
        $this->password = true;
    }

    public function unsetPassword() {
        $this->password = false;
    }

    public function getPassword() {
        return $this->password;
    }

    public function fu_setReadOnly() {
        $this->readOnly = true;
    }

    public function unsetReadOnly() {
        $this->readOnly = false;
    }

    public function getReadOnly() {
        return $this->readOnly;
    }

    protected function onjsrender() {
        if ($this->formName != '') {
            if ($this->msgName == "") {
                $this->fu_setMsgName($this->getAttribute('placeholder'));
            }
            if ($this->minLen != '') {
                addHeaderJsFunctionCode("{$this->formName}_submit", "{$this->name}min", "
ctlMins['$this->name']= Array('$this->msgName','TextField','$this->minLen');");
            }
            if ($this->numeric) {
                addHeaderJsFunctionCode("{$this->formName}_submit", "{$this->name}num", "
ctlNums['$this->name']= Array('$this->msgName','TextField');");
            }
            if ($this->email) {
                addHeaderJsFunctionCode("{$this->formName}_submit", "{$this->name}email", "
ctlEmail['$this->name']= Array('$this->msgName','TextField');");
            }
            if ($this->req) {
                addHeaderJsFunctionCode("{$this->formName}_submit", "{$this->name}req", "
ctlReq['$this->name']= Array('$this->msgName','TextField');");
            }
            if ($this->match != "") {
                addHeaderJsFunctionCode("{$this->formName}_submit", "{$this->name}match", '
 if($("#'. $this->name .'").val() != $("#'. $this->match .'").val()){
   displayValidationError(document.getElementById("'. $this->name .'"),"Value isn\'t match with " + $("#'. $this->match .'").attr("placeholder"));
   blnSubmit = false ;
}');
            }

        }
    }

    protected function onrender() {
        if($this->errmsg!=""){
            $this->setPostTag($this->errmsg);
        }
        $this->setAttributeDefault("class","form-control");
        if ($this->maxLen != '') {
            $this->setAttribute('maxlength', $this->maxLen);
        }
        if ($this->password == true) {
            $this->setAttribute('type', 'password');
        } else if ($this->getAttribute('type') == 'password') {
            $this->password = true;
        }

        if ($this->readOnly == true) {
            $this->setAttribute('readonly', 'readonly');
        }
        if ($this->password == true) {
            $this->value = "";
        }
        if ($this->value != "") {
            $this->setAttribute('value', htmlentities($this->value, ENT_COMPAT, "UTF-8"));
        }
        if($this->getVisible()){
        switch($this->styler){
            case 1:{
                $this->setPreTag($this->getPreTag() . '<div class="form-floating mb-3">');
                $this->setPostTag('<label for="'. $this->htmlId .'" class="form-label">'. $this->msgName .'</label></div>' . $this->getPostTag());
                break;
            }case 2:{
                $this->setPreTag($this->getPreTag() .'<div class="mb-3">
                <label for="'. $this->htmlId .'" class="form-label">'. $this->msgName .'</label>');
                $this->setPostTag('<div id="'. $this->htmlId .'Help" class="form-text">'. $this->helptext .'</div></div>'. $this->getPostTag());
                break;
            }
        }
        }
    }

// javascript functions used by ajax control and other control
    public function getJsValue() {
        return "document.getElementById('$this->name').value";
    }

    public function setJSValue($exp) {
        return "document.getElementById('$this->name').value = $exp;";
    }

}

}
