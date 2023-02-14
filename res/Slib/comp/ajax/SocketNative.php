<?php

/**
 * Description of SocketNative
 * Socket work with native app to process as outsider from web server environment.
 * @author SARTAJ
 */
class SocketNative extends \Sphp\tools\Control {

    private $url = '';

    public function setURL($param) {
        $this->url = $param;
    }

    public function onjsrender() {
        $this->unsetRender();
        $protocol = "ws";
        //event handler
        addHeaderJSFunction('js_event_' . $this->name . '_msg', 'function js_event_' . $this->name . '_msg(evtp){', '}');
        $this->addAsJSVar();
        if (\SphpBase::sphp_request()->server('HTTPS') == 1)
            $protocol = "wss";
        if ($this->url == '')
            $this->url = $protocol . '://' . SphpBase::sphp_request()->server('HTTP_HOST') . '/sphp.ws';
        addHeaderJSFunctionCode("ready", "socketnative", $this->setAsJSVar("new sphp_wsocket('$this->url',js_event_{$this->name}_msg)"));
    }

}
