<?php

/**
 * Description of CheckBox
 *
 * @author SARTAJ
 */

namespace Sphp\comp\html {

    class CheckBox extends \Sphp\tools\Component {

        private $formName = '';
        private $msgName = '';
        private $errmsg = '';
        private $req = false;
        private $label = "";

        protected function oninit() {
            $Client = \SphpBase::sphp_request();
            $this->tagName = "input";
            $this->setAttribute('type', 'checkbox');
            if ($this->issubmit) {
                $this->setAttribute('checked', 'checked');
            } else if ($Client->request('chktxt' . $this->name) == '1') {
                $this->value = '0';
                $this->setDataBound();
            }
            if ($this->getAttribute("msgname") != "") {
                $this->msgName = $this->getAttribute("msgname");
                $this->label = $this->msgName;
            }else  if ($this->getAttribute("placeholder") != "") {
                $this->msgName = $this->getAttribute("placeholder");
                $this->label = $this->msgName;
            }
        }

        public function fu_setLabel($param) {
            $this->label = $param;
        }

        public function setErrMsg($msg) {
            $this->errmsg .= '<strong class="alert-danger">' . $msg . '</strong>';
            if(\SphpBase::sphp_request()->isAJAX()){
                \SphpBase::JSServer()->addJSONJSBlock('$("#'. $this->name .'").after("<strong class=\"alert-danger\">' . $msg . '! </strong>");');
            }
            setErr($this->name, $msg);
        }

        protected function genhelpPropList() {
            $this->addHelpPropFunList('setForm', 'Bind with Form JS Event', '', '$val');
            $this->addHelpPropFunList('setMsgName', 'Name Display in placeholder and Error', '', '$val');
            $this->addHelpPropFunList('setRequired', 'Can not submit Empty', '', '');
        }

        public function fi_setForm($val) {
            $this->formName = $val;
        }

        public function fu_setMsgName($val) {
            $this->msgName = $val;
            $this->label = $this->msgName;
            $this->setAttribute('placeholder', $val);
        }

        public function fi_setRequired() {
            if ($this->issubmit) {
                if (strlen($this->value) < 1) {
                    $this->setErrMsg($this->getAttribute("msgname") . ' ' . "Can not submit Empty");
                }
            }
            $this->req = true;
        }

        protected function onprejsrender() {
            if ($this->formName != '' && $this->req) {
                $jscode = "if(blnSubmit==true && " . $this->getJSValue() . "==false){
    blnSubmit = false ;
alert('Please Accept " . $this->msgName . "');
document.getElementById('$this->name').focus();
}";
                addHeaderJSFunctionCode("{$this->formName}_submit", "$this->name", $jscode);
            }
        }

        protected function onrender() {
            if ($this->errmsg != "") {
                $this->setPostTag($this->errmsg);
            }
            //if ($this->getAttribute('class') == '') {
                $this->class .= " form-check-input";
            //}
            $this->setPostTag('<input type="hidden" name="chktxt' . $this->name . '" value="1" />');
            
            if ($this->value != '1') {
                $this->setAttribute('value', '1');
            } else {
                $this->setAttribute('value', '1');
                $this->setAttribute('checked', 'checked');
            }
            
             switch($this->styler){
            case 1:{
                $this->setPreTag($this->getPreTag() . '<div class="form-floating mb-3 form-check">');
                $this->setPostTag('<label for="'. $this->HTMLID .'" class="form-check-label">'. $this->msgName .'</label></div>' . $this->getPostTag());
                break;
            }case 2:{
                $this->setPreTag($this->getPreTag() .'<div class="mb-3 form-check">
                <label for="'. $this->HTMLID .'" class="form-check-label">'. $this->msgName .'</label>');
                $this->setPostTag('<div id="'. $this->HTMLID .'Help" class="form-text">'. $this->helptext .'</div></div>'. $this->getPostTag());
                break;
            }case 3:{
                $this->element->getParent()->setAttribute("class","input-group mb-3");
                $this->setPreTag($this->getPreTag() .'<div class="input-group-text">
                <label for="'. $this->HTMLID .'" class="form-check-label">'. $this->msgName .' </label>');
                $this->setPostTag('<div id="'. $this->HTMLID .'Help" class="form-text">'. $this->helptext .'</div></div>'. $this->getPostTag());
                break; 
            }
            default:{
                if ($this->label != "") {
                    $this->setPreTag($this->getPreTag() . '<div class="mb-3 form-check">');
                    $this->setPostTag('<label class="form-check-label" for="' . $this->HTMLID . '">' . $this->label . '</label></div>' . $this->getPostTag());
                }            
                break;
            }
        }
        
    }

// javascript functions
        public function getJSValue() {
            return "document.getElementById('$this->name').checked";
        }

        public function setJSValue($exp) {
            $jsOut = "document.getElementById('$this->name').checked = $exp;";
            writeGlobal("jsOut", $jsOut);
        }

    }

}
