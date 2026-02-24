<?php

/**
 * Description of SocketOutput
 * Socket work with native app to process as outsider from web server environment. This component 
 * create socket and 
 * display data send by native app.
 * Front File code:-
 * <div id="div1" runat="server" path="libpath/comp/ajax/SocketOutput.php"></div>
 * Then call js function:-
 * Params = $gate,$evt,$evtp,$data
 * callNativeGate('shell','ls','-l',{});
 * @author SARTAJ
 */
class SocketOutput extends \Sphp\tools\Component {

    private $url = '';

    public function fu_setURL($param) {
        $this->url = $param;
    }

    protected function onjsrender() {
        $protocol = "ws";
        $this->setAttributeDefault('style', 'style="overflow-y: scroll; height: 500px; max-height: 500px;');
        $this->setAttributeDefault('class', 'text-wrap');
        addHeaderJSCode($this->name , 'window["'. $this->name .'"] = {wsobj: null, onopen: function(){}}; window["callNativeGate"] = function (gate,evt="",evtp="",data={}){
        $("#'. $this->name .'").html(\'\');
        window["'. $this->name .'"]["wsobj"].callProcessNativeGate(gate,evt,evtp,data);
    };
');
        if (\SphpBase::sphp_request()->server('HTTPS') == 1) $protocol = "wss";
        if ($this->url == '')
           // $this->url = $protocol . '://' . SphpBase::sphp_request()->server('HTTP_HOST') . '/sphp.ws';
            $this->url = SphpBase::sphp_request()->server('HTTP_HOST') ;
        addHeaderJSFunctionCode("ready", "socketnative", 'frontobj.websockethost = "'. $this->url .'"; frontobj.getSphpSocket(function(wsobj1){
        window["'. $this->name . '"]["wsobj"] = wsobj1;
        window["'. $this->name . '"]["onopen"]();
        frontobj.onwsmsg = function(msg){ 
            $("#'. $this->name .'").append(\'<p>\' + msg +  \'</p>\').scrollTop($("#'. $this->name .'").prop(\'scrollHeight\'));
        };
    });');
    }

}
