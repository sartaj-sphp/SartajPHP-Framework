<?php

class MdbCard extends Control{
    
public function onrender(){
    $this->tagName = 'div';
    if($this->title != ""){
          $this->title = '<div class="card-header">
      <h5 class="card-title">'. $this->title .'</h5>
  </div>';

    }
    $this->setPreTag('<div class="card"><hr class="hr">'. $this->title .'
  <div class="card-body card-block scrollbar" style="overflow: auto; white-space: nowrap;">
<div class="block">
         

');
    $this->class = "content"; 
    $this->setPostTag('</div></div></div>');        
    
}

}
