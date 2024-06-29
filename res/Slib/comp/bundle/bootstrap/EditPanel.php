<?php




class EditPanel extends Control{
private $label = "";

public function setLabel($label) {
    $this->label = $label;
}
public function onrender(){
    $this->tagName = 'div';
    $this->setPreTag('<div class="card card-primary">
  <div class="card-header">
      <h3 class="card-title"><span style="font-size:16px;" class="pull-left hidden-xs showopacity fa fa-user"></span> &nbsp;<span id="editheading">'.$this->label.'</span></h3>
  </div>
  <div class="card-block">
    <div class="block">
  
');
    $this->class = "content px-4 py-4"; 
    $this->setPostTag('</div></div></div>');        
    
}

}
