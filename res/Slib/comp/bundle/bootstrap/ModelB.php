<?php




class ModelB extends Control{
private $label = "";

public function onrender(){
    $this->tagName = 'div';
    $this->setPreTag('<div class="modal fade" id="'. $this->name .'" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">'. $this->title .'</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>');
    $this->class = "modal-body"; 
    $this->HTMLID = 'b' . $this->name;
    $this->HTMLName = 'b' . $this->name;
    $this->setPostTag('<br/>
    </div>
  </div>
</div>');        
    addHeaderJSFunctionCode('ready', $this->name, ' window["'. $this->name .'"] = bootstrap.Modal.getOrCreateInstance(document.getElementById("'. $this->name .'")); ',true); 
}
public function getButton($param) {
    return '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#'. $this->name .'">
  '. $param .'
</button>';
}

}
