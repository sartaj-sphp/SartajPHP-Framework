<?php

/**
 * Description of EncodeText
 *
 * @author SARTAJ
 */


    class EncodeText extends \Sphp\tools\Control {

        public function onrender() {
            SphpBase::JSServer()->getAJAX();
            $kn = "A8969D2B";
            $this->element->appendAttribute('class', $this->name);
            if($this->element->hasAttribute('key')){
            $kn = $this->getAttribute('key');
            $this->element->removeAttribute('key');
            }
            
            if($this->element->hasAttribute('value')){
                $this->value = $this->getAttribute('value');
                $this->setAttribute('value',SphpBase::sphp_api()->encrypt($this->value,$kn));
                addHeaderJSFunctionCode('ready', 'encodetext1', "function ndecode(t1,key){" 
                . ' var result = ""; var strdata = $("#" + t1).attr("value");
	    if (strdata.length % 2 == 0) {
	        var c = 0;
	        for (var i = 0; i < strdata.length; i += 2) {
	            var hex = strdata.substr(i, 2);
	            var keychar = key.substr((c % key.length) - 1, 1);
	            var chara = String.fromCharCode(parseInt(hex, 16) - keychar.charCodeAt(0));
	            result += chara;
	            c += 1;
	        }
	    }
            $("." + t1).attr("value","kk");
            $("." + t1).attr("href","mailto:" + result);
	    $("." + t1).html(result);'
                ."}");
                addHeaderJSFunctionCode('ready', $this->name, 'ndecode("'. $this->name .'","'. $kn .'");');
            }
        }


    }

