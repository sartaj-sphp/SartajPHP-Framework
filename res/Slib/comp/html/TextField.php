<?php

/**
 * Description of textfield
 *
 * @author SARTAJ
 */

namespace Sphp\comp\html{

class TextField extends \Sphp\tools\Control {

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

    protected function genhelpPropList() {
        parent::genhelpPropList();
        $this->addHelpPropFunList('setForm','Bind with Form JS Event','','$val');
        $this->addHelpPropFunList('setMsgName','Name Display in placeholder and Error','','$val');
        $this->addHelpPropFunList('setNumeric','Only Accept Numeric Value','','');
        $this->addHelpPropFunList('setRequired','Can not submit Empty','','');
        $this->addHelpPropFunList('setEmail','Only Accept Email','','');
        $this->addHelpPropFunList('setMaxLen','Maximum Accept Length','','$val');
        $this->addHelpPropFunList('setMinLen','Minimum Accept Length','','$val');
        $this->addHelpPropFunList('setPassword','Mask as Pasword Char','','');
        $this->addHelpPropFunList('setReadOnly','Set as Read Only','','');
    }
    public function oninit() {
        $this->tagName = "input";
        if($this->getAttribute("type") == ""){
            $this->setAttribute('type', 'text');
        }
        if($this->getAttribute("msgname") != ""){
            $this->msgName = $this->getAttribute("msgname");
        }        
//        $this->unsetEndTag();
    }

    public function setForm($val) {
        $this->formName = $val;
    }

    public function setMsgName($val) {
        $this->msgName = $val;
        $this->setAttribute('placeholder', $val);
    }
    public function setErrMsg($msg){
        $this->errmsg .= '<strong class="alert-danger">' . $msg . '! </strong>';
        setErr($this->name, $msg);
    }
    public function setNumeric() {
        if ($this->issubmit) {
            if (!is_valid_num($this->value, $this->dataType)) {
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

    public function setRequired() { 
        if ($this->issubmit) {
            if (strlen($this->value) < 1) {
                $this->setErrMsg( $this->getAttribute("msgname") .' ' . "Can not submit Empty"); 
            }
        }
        $this->req = true;
    }

    public function setEmail() {
        if ($this->issubmit) {
            if (strlen($this->value) > 0 && !is_valid_email($this->value)) {
                $this->setErrMsg( $this->getAttribute("msgname") .' ' . "Please Fill correct Email Address");
            }
        }
        $this->email = true;
    }

    public function setMaxLen($val) {
        $this->maxLen = $val;
        if ($this->issubmit) {
            if (strlen($this->getValue()) > $val) {
                $this->setErrMsg( $this->getAttribute("msgname") .' ' . "Maximum Characters should not be exceed then $val");
            }
        }
    }

    public function getMaxLen() {
        return $this->maxLen;
    }

    public function setMinLen($val) {
        $this->minLen = $val;
        if ($this->issubmit) {
            if ($this->getValue() != '' && strlen($this->getValue()) < $val) {
                $this->setErrMsg( $this->getAttribute("msgname") .' ' . "Minimum Characters should be $val");
            }
        }
    }

    public function getMinLen() {
        return $this->minLen;
    }

    public function setPassword() {
        $this->password = true;
    }

    public function unsetPassword() {
        $this->password = false;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setReadOnly() {
        $this->readOnly = true;
    }

    public function unsetReadOnly() {
        $this->readOnly = false;
    }

    public function getReadOnly() {
        return $this->readOnly;
    }

    public function onjsrender() {
        if ($this->formName != '') {
            if ($this->minLen != '') {
                addFooterJSFunctionCode("{$this->formName}_submit", "{$this->name}min", "
ctlMins['$this->name']= Array('$this->msgName','TextField','$this->minLen');");
            }
            if ($this->numeric) {
                addFooterJSFunctionCode("{$this->formName}_submit", "{$this->name}num", "
ctlNums['$this->name']= Array('$this->msgName','TextField');");
            }
            if ($this->email) {
                addFooterJSFunctionCode("{$this->formName}_submit", "{$this->name}email", "
ctlEmail['$this->name']= Array('$this->msgName','TextField');");
            }
            if ($this->req) {
                addFooterJSFunctionCode("{$this->formName}_submit", "{$this->name}req", "
ctlReq['$this->name']= Array('$this->msgName','TextField');");
            }
        }
    }

    public function onrender() {
        if($this->errmsg!=""){
            $this->setPostTag($this->errmsg);
        }
        if ($this->getAttribute("class") == "") {
            $this->setAttribute("class","form-control");
        }
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
        if ($this->value != "") {
            $this->setAttribute('value', htmlentities($this->value, ENT_COMPAT, "UTF-8"));
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
