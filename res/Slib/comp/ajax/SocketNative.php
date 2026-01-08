<?php

/**
 * Description of SocketNative
 * Socket work with native app to process as outsider from web server environment.
 * @author SARTAJ
 */
class SocketNative extends \Sphp\tools\Component {

    private $url = '';

    public function fu_setURL($param) {
        $this->url = $param;
    }

    protected function onjsrender() {
        $this->fu_unsetRender();
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
