<?php
/**
 *  $("#model1").modal("hide");
 *  $("#model1").modal("show");
 */
class ModalB extends Sphp\tools\Component{
private $url = "";
private $btn1 = ""; 

public function  fu_showButton($param) {
    $this->btn1 = $this->getButton($param);
}
public function  fu_getURL($url) {
    //$this->name.show();
    $this->url = $url;
}

protected function onrender(){
    if($this->url != ""){
        addHeaderJSFunctionCode('ready',$this->name, "$('#$this->name').on('shown.bs.modal', function () {getAJAX('$this->url',{},true,function(r){"
            . " }); } );");
    }

    $this->tagName = 'div';
    $this->setPreTag('<div class="modal fade" id="'. $this->name .'" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">'. $this->title .'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>');
    $this->class = "modal-body"; 
    $this->HTMLID = 'b' . $this->name;
    $this->HTMLName = 'b' . $this->name;
    $this->setPostTag('<br/>
    </div>
  </div>
</div>' . $this->btn1);        
    //addHeaderJSFunctionCode('ready', $this->name, ' window["'. $this->name .'"] = bootstrap.Modal.getOrCreateInstance(document.getElementById("'. $this->name .'")); ',true); 
    addHeaderJSFunctionCode('ready', $this->name, ' window["'. $this->name .'"] = new bootstrap.Modal(document.getElementById("'. $this->name .'")); ',true); 
}
public function getButton($param) {
    return '<button type="button" class="btn btn-primary" ldata-toggle="modal" ldata-target="#'. $this->name .'" onclick="$(\'#'. $this->name .'\').modal(\'show\')">
  '. $param .'
</button>';
}

}
