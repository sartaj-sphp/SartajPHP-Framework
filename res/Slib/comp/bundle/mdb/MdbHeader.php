<?php

class MdbHeader extends Control {
    private $bgimg = '';
    private $bgheight = 400;
    private $bgopacity = 0.6;
    
    public function setBG($url,$height=400,$opacity=0.6) {
        $this->bgimg = $url;
        $this->height = $height;
        $this->bgopacity = $opacity;
    }
    public function onrender() {
        $classs = 'p-5 text-center bg-light';
        $this->tagName = 'div';
        if ($this->getInnerHTML() == "") {
            $this->setInnerHTML('<h1 class="mb-3">Heading</h1>
    <h4 class="mb-3">Subheading</h4>
    <a class="btn btn-outline-light btn-rounded btn-lg" href="index.html" role="button">Call to action</a>');
        }
        if($this->bgimg !== ""){
            $this->style = "background-image: url('" . $this->bgimg . "'); height: {$this->height}px;";
            $classs = 'p-5 text-center bg-image';
            $this->setInnerPreTag('<div class="mask" style="background-color: rgba(0, 0, 0, '. $this->bgopacity .');"><div class="d-flex justify-content-center align-items-center h-100">
        <div class="text-white">');
            $this->element->setInnerPostTag('</div></div></div>');
        }
        $this->setAttribute('class', $classs);
    }

}
