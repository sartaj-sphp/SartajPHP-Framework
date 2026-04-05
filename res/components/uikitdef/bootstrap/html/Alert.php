<?php

namespace Sphp\Comp\Html{

class Alert extends \Sphp\tools\Component {
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
        $this->tagName = "div";
        $stro = "";
        //<strong class="alert-danger">' . $msg . '</strong>
        if($this->showall){
            $msg = traceMsg(true);
            $emsg = traceError(true);
            if($this->innerErr) $emsg .= traceErrorInner(true);            
        }else{
            $msg = $emsg = "";
            $v1 = getMsg($this->name);
            foreach($v1 as $k1=>$v2){
                $msg .= $v2 . '</ br>';                    
            }
            $v1 = getErrMsg($this->name);
            foreach($v1 as $k1=>$v2){
                $emsg .= $v2 . '</ br>';                    
            }
            if($this->innerErr){
                $v1 = getErrMsgInner($this->name);
                foreach($v1 as $k1=>$v2){
                    $emsg .= $v2 . '</ br>';                    
                }
            }
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