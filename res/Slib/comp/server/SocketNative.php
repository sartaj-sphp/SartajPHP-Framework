<?php

/**
 * Description of SocketNative
 * Socket work with native app to process as outsider from web server environment.
 * @author SARTAJ
 */
class SocketNative extends \Sphp\Tools\Component {

    private $url = '';

    public function fu_setURL($param) {
        $this->url = $param;
    }

    protected function onjsrender() {
        $this->fu_unsetRender();
        $protocol = "ws";
        //event handler
        addHeaderJsFunction('js_event_' . $this->name . '_msg', 'function js_event_' . $this->name . '_msg(evtp){', '}');
        $this->addAsJsVar();
        if (\SphpBase::sphpRequest()->server('HTTPS') == 1)
            $protocol = "wss";
        if ($this->url == '')
            $this->url = $protocol . '://' . SphpBase::sphpRequest()->server('HTTP_HOST') . '/sphp.ws';
        addHeaderJsFunctionCode("ready", "socketnative", $this->setAsJsVar("new sphp_wsocket('$this->url',js_event_{$this->name}_msg)"));
    }

}
