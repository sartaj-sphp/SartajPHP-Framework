<?php

namespace Sphp\comp\html{

class DisplayError extends \Sphp\tools\Component {
    private $innerErr = true;
    private $showall = false;
    // by deafult enable
    public function fu_setInnerError() {
        $this->innerErr = true;
    }
    // show all errors
    public function fu_setShowAll() {
        $this->showall = true;
    }
    protected function genhelpPropList() {
        $this->addHelpPropFunList('setInnerError','Display Inner Error','','');
    }
    protected function onrender() {
        $this->tagName = "span";
        $stro = "";
        //<strong class="alert-danger">' . $msg . '</strong>
        if($this->showall){
            $msg = traceMsg(true);
            $emsg = traceError(true);
            if($this->innerErr) $emsg .= traceErrorInner(true);            
        }else{
            $msg = getMsg($this->name);
            $emsg = getErrMsg($this->name);
            if($this->innerErr) $emsg .= getErrMsgInner($this->name);
        }        
        if($msg != ""){
             $stro .= '<strong class="alert alert-info">' . $msg . '</strong>';
        }
        if($emsg != ""){
             $stro .= '<strong class="alert alert-danger">' . $emsg . '</strong>';
        }
        $this->setInnerHTML($stro);
    }
}
}