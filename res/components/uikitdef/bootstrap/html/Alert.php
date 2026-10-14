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
        $msg1 = '<div style="position: fixed; z-index: 2000;width: 500px;">
    <div id="sphpwarning" class="alert alert-warning" style="display: none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Warning!</strong> <span id="sphpwarningmsg"></span>
    </div>
    <div id="sphperror" class="alert alert-danger" style="display: none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Error!</strong> <span id="sphperrormsg"></span>
    </div>
    <div id="sphpsuccess" class="alert alert-success" style="display: none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> <span id="sphpsuccessmsg"></span>
    </div>
    <div id="sphpinfo" class="alert alert-info" style="display: none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Note!</strong> <span id="sphpinfomsg"></span>
    </div>
</div><div id="srvmsg"></div>';
        if(\SphpBase::sphp_api()->getProp("alert") == false){
            $this->setPreTag($msg1);
            \SphpBase::sphp_api()->addProp("alert",true);
            addHeaderJSCode('alert', "window['runanierr'] = function(type){
    $(\"#sphp\" + type).fadeIn(1);
    $(\"#sphp\" + type).css(\"display\",\"block\");
    $(\"#sphp\" + type).delay(5000).fadeOut(\"slow\", function () { $(this).css(\"display\",\"none\"); });            
};"
);
        }
        
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