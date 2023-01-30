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
public function setAspectRatio(){}
public function setFont($fontFile){}
public function setFontSize($fontSize){}
public function setFontColor($red,$green,$blue,$alpha=0){}
public function drawImage($image,$x,$y,$width,$height){}
public function drawImageOver($image,$dst_x,$dst_y,$x,$y,$dst_width,$dst_height,$width,$height){}
public function drawString($x,$y,$string){}
public function saveImage($path){}
public function getImageDataStreem(){}
function getOutputFunction(){
switch ($this->mime)
{
case 'image/gif':
$outputFunction		= 'imagepng';
$this->mime				= 'image/png'; 		$this->doSharpen			= FALSE;
$this->quality			= round(10 - ($this->quality / 10)); 	break;
case 'image/x-png':
case 'image/png':
$outputFunction		= 'imagepng';
$this->doSharpen			= FALSE;
$this->quality			= round(10 - ($this->quality / 10)); 	break;
default:
$outputFunction	 	= 'imagejpeg';
$this->doSharpen			= TRUE;
break;
}
return $outputFunction;
}
}
}
