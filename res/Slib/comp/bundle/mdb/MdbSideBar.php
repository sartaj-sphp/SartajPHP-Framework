<?php

class MdbSideBar extends Control{
    private $bg = "bg-dark";
    
    public function setBG($param) {
        $this->bg = $param;
    }
    public function onholder($obj) {
        if($obj->getAttribute("data-sphp-colid") == 1){
            $obj->setPreTag('<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 '. $this->bg .'">');
            $obj->setAttribute("class","d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100");
            $obj->setInnerPreTag('<a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">'. $this->title .'</span>
                </a>');
            $obj->setPostTag('</div>');
        }else if($obj->getAttribute("data-sphp-colid") == 2){
            $obj->setPreTag('<div class="col py-3">');
            $obj->setPostTag('</div>');
        }else{
            $obj->setPreTag('<div class="col py-3">');
            $obj->setPostTag('</div>');            
        }
    }
public function onrender(){
    $this->tagName = 'div';
    $this->class .= "row flex-nowrap"; 
    
}

}
