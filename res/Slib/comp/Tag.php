<?php
/**
 * Description of tag
 *
 * @author SARTAJ
 */
namespace Sphp\comp{

class Tag extends \Sphp\tools\Control{

public function onrender(){
    if($this->tagName == "div"){
        $this->HTMLName = "";
    }
if($this->value!=''){
$this->setAttribute('value', $this->value);
}
}

// javascript functions
public function getJSValue(){
return "document.getElementById('$this->name').value" ;
}

public function setJSValue($exp){
return "document.getElementById('$this->name').value = $exp;" ;
}


}
}
