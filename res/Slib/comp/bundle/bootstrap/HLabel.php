<?php

class HLabel extends Control{
private $label = "";
private $labelfor = "";
private $lblsize = "col-md-4";
private $compsize = "col-md-8";
private $blnReq = false;

public function setLabel($label,$labelfor) {
    $this->label = $label;
    $this->labelfor = $labelfor;
}
public function setSize($lblsize,$compsize) {
    $this->lblsize = $lblsize;
    $this->compsize = $compsize;
}
public function setRequired() {
    $this->blnReq = true;
}
public function onprerender(){
        $this->class = "controls";
}
public function onrender(){
    $this->tagName = 'div';
    $this->setHTMLID("");
    $this->setHTMLName("");
//    $this->unsetRenderTag();
    $req = "";
    if($this->blnReq){
    $req = "<span class='text-danger'>*</span>";        
    }
    $this->setPreTag('<div class="control-group">
<div class="row"><div class="'.$this->lblsize.' align-right">
        <label class="control-label" for="'.$this->labelfor.'">'. $req . $this->label.'</label>
    </div><div class="'.$this->compsize.'">
');
    
    $this->setPostTag(' 
    </div></div>
</div>
');        
    $this->blnReq = false;    
}

}
