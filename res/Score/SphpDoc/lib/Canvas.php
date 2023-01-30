<?php
namespace{
class Canvas{
public $width = 0;
public $height = 0;
public $mime = "image/jpeg";
public $data;
public $quality = 90;
public $doSharpen = true;
public $maintainAspect = false;
public $font;
public $fontcolor;
public $fontsize=5;
public function __construct($width,$height,$mime="image/jpeg"){}
public function setAspectRatio(){}
public function setFont($fontFile){}
public function setFontSize($fontSize){}
public function setFontColor($red,$green,$blue,$alpha=0){}
public function drawImage($image,$x,$y,$width,$height){}
public function drawImageOver($image,$dst_x,$dst_y,$x,$y,$dst_width,$dst_height,$width,$height){}
public function drawString($x,$y,$string){}
public function saveImage($path){}
public function getImageDataStreem(){}
function getOutputFunction(){}
}
}
