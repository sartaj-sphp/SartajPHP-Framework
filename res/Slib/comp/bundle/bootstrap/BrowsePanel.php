<?php




class BrowsePanel extends Control{
private $label = "";

public function setLabel($label) {
    $this->label = $label;
}
public function onrender(){
global $ctrl;
    $this->tagName = 'div';
    $this->setPreTag('<div class="card card-primary">
  <div class="card-header">
      <h3 class="card-title">
          <span style="font-size:22px;" class="pull-left hidden-xs showopacity fa fa-globe"></span> 
          &nbsp;Browse&nbsp;
          <a href="<?php echo getEventPath(\'print\', \'\', \''.$ctrl->ctrl.'\'); ?>" target="__blank" title="Print">
              <span style="font-size:22px;" class="pull-right hidden-xs showopacity fa fa-print"></span></a>
      </h3>
  </div>
  <div class="card-block scrollbar" style="overflow: auto; white-space: nowrap;">
<div class="block">
         

');
    $this->class = "content"; 
    $this->setPostTag('</div></div></div>');        
    
}

}
