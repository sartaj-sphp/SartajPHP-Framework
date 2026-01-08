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

public function __construct($width,$height,$mime="image/jpeg"){
$this->width = intval($width);
$this->height = intval($height);
$this->data = imagecreatetruecolor($this->width, $this->height);
 $this->mime = $mime;
 $this->fontcolor = imagecolorallocate($this->data, 255, 255, 255);
 $this->font = '';
 }

public function setAspectRatio(){
    $this->maintainAspect = true;
}
public function setFont($fontFile){
 $this->font = imageloadfont($fontFile);
}
public function setFontSize($fontSize){
 $this->fontsize = $fontSize;
}
public function setFontColor($red,$green,$blue,$alpha=0){
 $this->fontcolor = imagecolorallocatealpha($this->data, $red, $green, $blue,$alpha);
}
public function drawImage($image,$x,$y,$width,$height){
// Resample the original image into the resized canvas we set up earlier
//		imagealphablending($this->data, true);
//		imagesavealpha($this->data, true);
if($this->maintainAspect){
$wr = $width / $height;
$this->height = intval($this->width / $wr);
$this->data = imagecreatetruecolor($this->width, $this->height);
}


imagecopyresampled($this->data, $image, 0, 0, $x, $y, $this->width, $this->height, $width, $height);
}
public function drawImageOver($image,$dst_x,$dst_y,$x,$y,$dst_width,$dst_height,$width,$height){
if($this->maintainAspect){
$wr = $width / $height;
$dst_height =  intval($dst_width / $wr);
}
imagecopyresampled($this->data, $image, $dst_x, $dst_y, $x, $y, $dst_width, $dst_height, $width, $height);
}
public function drawString($x,$y,$string){
imagestring($this->data, $this->fontsize, $x, $y, $string, $this->fontcolor);
}

public function saveImage($path){
    $outputFunction = $this->getOutputFunction();
$outputFunction($this->data, $path, $this->quality);
}

public function getImageDataStreem(){
// Put the data of the resized image into a variable
    $outputFunction = $this->getOutputFunction();
ob_start();
$outputFunction($this->data, null, $this->quality);
$data	= ob_get_contents();
ob_end_clean();
return $data;
}

function getOutputFunction(){
    switch ($this->mime)
{
	case 'image/gif':
		$outputFunction		= 'imagepng';
		$this->mime				= 'image/png'; // We need to convert GIFs to PNGs
		$this->doSharpen			= FALSE;
		$this->quality			= round(10 - ($this->quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
	break;

	case 'image/x-png':
	case 'image/png':
		$outputFunction		= 'imagepng';
		$this->doSharpen			= FALSE;
		$this->quality			= round(10 - ($this->quality / 10)); // PNG needs a compression level of 0 (no compression) through 9
	break;

	default:
		$outputFunction	 	= 'imagejpeg';
		$this->doSharpen			= TRUE;
	break;
}
return $outputFunction;
}


}

}
