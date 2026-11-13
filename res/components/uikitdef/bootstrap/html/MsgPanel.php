<?php




class MsgPanel extends Sphp\Tools\Component{

    protected function oncreate($element) {
//        $this->fu_unsetRenderTag();
    }
    public function showAlert($type,$msg) {
        $jsServer = SphpBase::jsServer();
        $jsServer->addJsonJsBlock("showAlert('$type','$msg');");
    }
    public function sendSuccess($msg) {
        $jsServer = SphpBase::jsServer();
            $jsServer->addJsonBlock('html','sphpsuccessmsg',$msg);
            $jsServer->addJsonJsBlock('runanierr("success");');        
    }
    public function sendWarning($msg) {
        $jsServer = SphpBase::jsServer();
            $jsServer->addJsonBlock('html','sphpwarningmsg',$msg);
            $jsServer->addJsonJsBlock('runanierr("warning");');        
    }
    public function sendError($errorInner="") {
        $jsServer = SphpBase::jsServer();
            $jsServer->addJsonBlock('html','sphpinfomsg',traceMsg(true));
            $jsServer->addJsonBlock('html','sphperrormsg',traceError(true).$errorInner);
            $jsServer->addJsonJsBlock('runanierr("error");runanierr("info");');
    }
    protected function onjsrender() {
        addHeaderJsFunction("showAlert", 'function showAlert(type,msg){
', '    if(type=="warning"){
            $("#sphpwarningmsg").html(msg);
            runanierr(type);
    }else if(type=="error"){
            $("#sphperrormsg").html(msg);
    
    }else if(type=="info"){
            $("#sphpinfomsg").html(msg);
            runanierr(type);
    
    }else if(type=="success"){
            $("#sphpsuccessmsg").html(msg);
            runanierr(type);
    }
}
', true);
        addHeaderJsCode("runanierr", 'window["runanierr"] = function(type){
    $("#sphp" + type).fadeIn(1);
    $("#sphp" + type).css("display","block");
    $("#sphp" + type).delay(5000).fadeOut("slow", function () { $(this).css("display","none"); });            
                };',true);
    }
protected function onrender(){

    $this->setPreTag('<div style="position: fixed; z-index: 2000;width: 500px;">
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
</div>
');
    
}

}
