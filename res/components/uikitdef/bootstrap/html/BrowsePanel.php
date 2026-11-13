<?php




class BrowsePanel extends Sphp\Tools\Component{
private $label = "Browse";

public function fu_setLabel($label) {
    $this->label = $label;
}
protected function onrender(){
    $this->tagName = 'div';
    $this->setPreTag('<div class="card card-primary">
  <div class="card-header">
      <h4 class="card-title">
          <span class="pull-left hidden-xs showopacity fa fa-globe"></span> 
          &nbsp;'.  $this->label .'&nbsp;
          <a href="<?php echo getEventUrl(\'print\', \'\', \''. SphpBase::sphpRouter()->getCurrentRequest() .'\'); ?>" target="__blank" title="Print">
              <span class="pull-right hidden-xs showopacity fa fa-print"></span></a>
      </h4>
  </div>
  <div class="card-block scrollbar" style="overflow: auto; white-space: nowrap;">
<div class="block">
         

');
    $this->class = "content px-4 py-4"; 
    $this->setPostTag('</div></div></div>');        
    
}

}
