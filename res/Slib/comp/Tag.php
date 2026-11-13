<?php
/**
 * Description of tag
 *
 * @author SARTAJ
 */
namespace Sphp\comp{

class Tag extends \Sphp\Tools\Component{

protected function onrender(){
    if($this->tagName != "input"){
        $this->htmlName = "";
        if($this->value!=''){
            $this->setInnerHtml($this->value);
        }
    }else{
        if($this->value!=''){
            $this->setAttribute('value', $this->value);
        }
    }
}

// javascript functions
public function getJsValue(){
return "document.getElementById('$this->name').value" ;
}

public function setJSValue($exp){
return "document.getElementById('$this->name').value = $exp;" ;
}


}
}
