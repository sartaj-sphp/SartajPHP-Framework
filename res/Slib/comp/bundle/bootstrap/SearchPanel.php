<?php




class SearchPanel extends Control{
private $label = "";

public function setLabel($label) {
    $this->label = $label;
}
public function onrender(){
    $this->tagName = 'div';
    $this->setPreTag('<div class="card-group dpanel" id="accordion">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <span style="font-size:22px;" class="pull-left hidden-xs showopacity fa fa-search"></span> &nbsp;<span id="listheading">'.$this->label.'</span>
                    </a>
                </h3>
            </div>
            <div  id="collapseOne" class="card-collapse collapse in">
            <div class="card-block">
            <div class="block">
            <div class="content">
');
    $this->class = "col-md-12"; 
    $this->setPostTag('<br></div></div></div></div></div></div>');        
    
}

}
