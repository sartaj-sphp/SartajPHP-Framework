<?php

class SearchPanel extends Control{
private $label = "";

public function setLabel($label) {
    $this->label = $label;
}
public function onrender(){
    $this->tagName = 'div';
    $pre1 = '<div class="card-group dpanel" id="accordion">
        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">';
    if(SphpJsM::getJSLibVersion("bootstrap") == 5){
        $pre1 .= '<a data-bs-toggle="collapse" data-parent="#accordion" href="#collapseOne">';      
    }else{
        $pre1 .= '<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">';
    }
    $pre1 .= '<span class="pull-left hidden-xs showopacity fa fa-search"></span> &nbsp;<span id="listheading">'.$this->label.'</span>
                    </a>
                </h4>
            </div>
            <div  id="collapseOne" class="card-collapse collapse in">
            <div class="card-block">
            <div class="block">
            <div class="content">
';
    $this->setPreTag($pre1);
    $this->class = "col-md-12"; 
    $this->setPostTag('<br></div></div></div></div></div></div>');        
    
}

}
