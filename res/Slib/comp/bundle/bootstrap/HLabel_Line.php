<?php




class HLabel_Line extends Sphp\tools\Component{
private $label = "";
private $labelfor = "";
private $compsize = "col-md-12";
private $blnReq = false;
private $href = "";

public function fu_setLabel($label,$labelfor) {
    $this->label = $label;
    $this->labelfor = $labelfor;
}
public function fu_setSize($compsize,$f="") {
    $this->compsize = $compsize;
}
public function fu_setHref($val) {
    $this->href = $val;
}
public function fu_setRequired() {
    $this->blnReq = true;
}
protected function onrender(){
    $this->tagName = 'div';
    $this->fu_unsetRenderTag();
    $req = "";
    $hlink = "";
    if($this->blnReq){
    $req = "*";        
    }
    if($this->href!=""){
        $hlink = '<a href="#" onclick="getURLinDialog(\''.$this->href.'\',{}); return false;">'.$this->label.'</a>';        
    }else{
        $hlink = $this->label;
    }
    
    $this->setPreTag('<div class="control-group">
<div class="row"><div class="'.$this->compsize.'"><div class="controls">
        <label class="control-label" for="'.$this->labelfor.'">'. $req . $hlink.'</label>  
');
    
    $this->setPostTag('  </div>
    </div></div>
</div>
');        
    $this->blnReq = false;
    $this->href = "";
    
}

}
?>