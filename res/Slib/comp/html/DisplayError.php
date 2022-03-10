<?php

namespace Sphp\comp\html{

class DisplayError extends \Sphp\tools\Control {
    private $innerErr = false;
    
    public function setInnerError() {
        $this->innerErr = true;
    }
    protected function genhelpPropList() {
        $this->addHelpPropFunList('setInnerError','Display Inner Error','','');
    }
    public function onrender() {
        $this->tagName = "span";
        $stro = "";
        //<strong class="alert-danger">' . $msg . '</strong>
        $msg = getMsg($this->name);
        if($msg != ""){
             $stro .= '<strong class="alert-info">' . $msg . '</strong>';
        }
        $emsg = getErrMsg($this->name);
        $emsg .= getErrMsgInner($this->name);
        if($emsg != ""){
             $stro .= '<strong class="alert-danger">' . $emsg . '</strong>';
        }
        $this->setInnerHTML($stro);
    }
}
}