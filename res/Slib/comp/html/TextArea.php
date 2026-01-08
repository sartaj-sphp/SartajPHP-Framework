<?php

/**
 * Description of textfield
 *
 * @author SARTAJ
 */

namespace Sphp\comp\html{

class TextArea extends \Sphp\tools\Component {

    public $maxLen = '';
    public $minLen = '';
    public $formName = '';
    private $errmsg = '';
    private $msgName = '';
    private $req = false;

    protected function genhelpPropList() {
        parent::genhelpPropList();
        $this->addHelpPropFunList('setForm','Bind with Form JS Event','','$val');
        $this->addHelpPropFunList('setMsgName','Name Display in placeholder and Error','','$val');
        $this->addHelpPropFunList('setRequired','Can not submit Empty','','');
        $this->addHelpPropFunList('setMaxLen','Maximum Accept Length','','$val');
        $this->addHelpPropFunList('setMinLen','Minimum Accept Length','','$val');
    }

    protected function oninit() {
        $this->tagName = "textarea";
        if ($this->issubmit) {
            $this->value = htmlentities($this->value, ENT_COMPAT, "UTF-8");
        }
        if($this->getAttribute("msgname") != ""){
            $this->msgName = $this->getAttribute("msgname");
        }        
    }
    public function setErrMsg($msg){
        $this->errmsg .= '<strong class="alert-danger">' . $msg . '</strong>';
        if(\SphpBase::sphp_request()->isAJAX()){
            \SphpBase::JSServer()->addJSONJSBlock('$("#'. $this->name .'").after("<strong class=\"alert-danger\">' . $msg . '! </strong>");');
        }
        setErr($this->name, $msg);
    }
    
    public function fi_setForm($val) {
        $this->formName = $val;
    }

    public function fu_setMsgName($val) {
        $this->msgName = $val;
        $this->setAttribute('placeholder', $val);
    }

    public function fi_setRequired() {
        if ($this->issubmit) {
            if (strlen($this->value) < 1) {
                $this->setErrMsg( $this->getAttribute("msgname") .' ' . "Can not submit Empty");
            }
        }
        $this->req = true;
    }

    public function fi_setMaxLen($val) {
        $this->maxLen = $val;
        if ($this->issubmit) {
            if (strlen($this->value) > $val) {
                $this->setErrMsg( $this->getAttribute("msgname") .' ' . "Maximum Characters should not be exceed then $val");
            }
        }
    }

    public function getMaxLen() {
        return $this->maxLen;
    }

    public function fi_setMinLen($val) {
        $this->minLen = $val;
        if ($this->issubmit) {
            if (strlen($this->getValue()) < $val) {
                $this->setErrMsg( $this->getAttribute("msgname") .' ' . "Minimum Characters should be $val");
            }
        }
    }

    public function getMinLen() {
        return $this->minLen;
    }

    protected function onjsrender() {
        if ($this->formName != '') {
            if ($this->minLen != '') {
                addHeaderJSFunctionCode("{$this->formName}_submit", "{$this->name}min", "
ctlMins['$this->name']= Array('$this->msgName','TextArea','$this->minLen');");
            }
            if ($this->maxLen != '') {
                addHeaderJSFunctionCode("{$this->formName}_submit", "{$this->name}max", "
ctlMax['$this->name']= Array('$this->msgName','TextArea','$this->maxLen');");
            }
            if ($this->req) {
                addHeaderJSFunctionCode("{$this->formName}_submit", "{$this->name}req", "
ctlReq['$this->name']= Array('$this->msgName','TextArea');");
            }
        }
    }

    protected function onrender() {
        if($this->errmsg!=""){
            $this->setPostTag($this->errmsg);
        }
        if ($this->getAttribute('class') == '') {
            $this->class = "form-control";
        }
        if ($this->value != '') {
            $this->setInnerHTML($this->value);
        }
        if($this->getVisible()){
        $this->setAttributeDefault('rows', '10');
        $this->setAttributeDefault('cols', '20');
                switch($this->styler){
            case 1:{
                $this->setPreTag('<div class="form-floating mb-3">');
                $this->setPostTag('<label for="'. $this->HTMLID .'" class="form-label">'. $this->msgName .'</label></div>');
                break;
            }case 2:{
                $this->setPreTag('<div class="mb-3">
                <label for="'. $this->HTMLID .'" class="form-label">'. $this->msgName .'</label>');
                $this->setPostTag('<div id="'. $this->HTMLID .'Help" class="form-text">'. $this->helptext .'</div></div>');
                break;
            }
        }
        }else{
            $this->element->setAttribute("value", $this->getInnerHTML());
            $this->setInnerHTML('');
        }
    }

// javascript functions used by ajax control and other control
    public function getJSValue() {
        return "document.getElementById('$this->name').value";
    }

    public function setJSValue($exp) {
        return "document.getElementById('$this->name').value = $exp;";
    }

}

}
