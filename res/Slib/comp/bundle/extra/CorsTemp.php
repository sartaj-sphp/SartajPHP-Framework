<?php
/**
 * Description of CorsTemp
 *
 * @author SARTAJ
 */

class CorsTemp extends \Sphp\tools\Control{
    private $url = "";
    
    public function onjsrender(){
        if($this->url == "") $this->url = getEventURL("cfrm" . $this->name);
        \SphpBase::JSServer()->getAJAX();
        addHeaderJSFunctionCode("ready", "cors" . $this->name, 'getURL("'. $this->url .'");');
    }
}

