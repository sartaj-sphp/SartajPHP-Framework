<?php

class SearchPanel extends Sphp\tools\Component{
private $label = "";
private $bs = 5;

public function fu_setLabel($label) {
    $this->label = $label;
}
public function fu_setBS($param) {
    SphpJsM::setJSLibVersion("bootstrap", $param);
    $this->bs = SphpJsM::getJSLibVersion("bootstrap");
}
protected function onrender(){
    $this->tagName = 'div';
    $pre1 = '<div class="card-group dpanel pb-2" id="accordion">
        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">';
    if($this->bs == 5){
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
            <div class="content px-4 py-4">
';
    $this->setPreTag($pre1);
    $this->class = "col-md-12"; 
    $this->setPostTag('<br></div></div></div></div></div></div>');        
    
}

}
