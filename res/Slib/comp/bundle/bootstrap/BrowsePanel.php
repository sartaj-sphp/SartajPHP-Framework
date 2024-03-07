<?php




class BrowsePanel extends Control{
private $label = "Browse";

public function setLabel($label) {
    $this->label = $label;
}
public function onrender(){
    $this->tagName = 'div';
    $this->setPreTag('<div class="card card-primary">
  <div class="card-header">
      <h4 class="card-title">
          <span class="pull-left hidden-xs showopacity fa fa-globe"></span> 
          &nbsp;'.  $this->label .'&nbsp;
          <a href="<?php echo getEventURL(\'print\', \'\', \''. SphpBase::sphp_router()->getCurrentRequest() .'\'); ?>" target="__blank" title="Print">
              <span class="pull-right hidden-xs showopacity fa fa-print"></span></a>
      </h3>
  </div>
  <div class="card-block scrollbar" style="overflow: auto; white-space: nowrap;">
<div class="block">
         

');
    $this->class = "content"; 
    $this->setPostTag('</div></div></div>');        
    
}

}
