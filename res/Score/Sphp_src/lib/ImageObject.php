<?php
class ImageObject{
public $width = 0;
public $height = 0;
public $mime = "image/jpeg";
public $data;

public function __construct($path=''){
if($path!=''){
$size	= getimagesize($path);
 $this->width = $size[0];
 $this->height = $size[1];
 $this->mime = $size['mime'];
 $this->data = $this->createImage($path);
}
 }

public function loadFile($path){
 $size	= getimagesize($path);
 $this->width = $size[0];
 $this->height = $size[1];
 $this->mime = $size['mime'];
 $this->data = $this->createImage($path);
 }

public function setImageData($val){
 $this->data = $val;
    }
public function getImageData(){
return $this->data;
    }

public function isValidType(){
if (substr($this->mime, 0, 6) != 'image/')
{
return false;
}else{
return true;
}
}

private function createImage($path){
switch ($this->mime)
{
	case 'image/gif':
		$creationFunction	= 'Imagecreatefromgif';
	break;

	case 'image/x-png':
	case 'image/png':
		$creationFunction	= 'imageCreatefrompng';
	break;

	default:
		$creationFunction	= 'imagecreatefromjpeg';
	break;
}

// Read in the original image
return $creationFunction($path);

}



}
?>
