<?php

/**
 * Description of Frame
 *
 * @author SARTAJ
 */

namespace Sphp\Comp\Form{

class Frame extends \Sphp\tools\Component {
    private $recID = 'txtid2';
    private $txtid2 = '';

    protected function oninit() {
        $this->tagName = "div";
        $this->HTMLName = "";  
        $this->recID = $this->HTMLName . 're';        
        if (\SphpBase::sphp_request()->request($this->recID) !== "") {
            $this->txtid2 = urldecode(\SphpBase::sphp_request()->request($this->recID));
            if(isSecureVal($this->txtid2)){
                $this->txtid2 = secure2Val($this->txtid2);
                if($this->txtid2 == "") setErr("App", "Invalid Form Data");
            }
        }        
    }

    public function getRecID() {
        return $this->txtid2;
    }

    public function setRecID($v) {
        $this->txtid2 = $v;
    }

    protected function onrender() {
        if($this->txtid2 != ""){
            $this->txtid2 = urlencode(val2Secure($this->txtid2));
        }
        $hdn = "<input type=\"hidden\" name=\"" . $this->recID . "\" value=\"" . $this->txtid2 . "\" />";
        $this->appendHTML($hdn);
        $this->element->appendAttribute("class", "px-4 py-4");
    }

}

}
