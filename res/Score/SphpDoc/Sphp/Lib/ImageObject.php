<?php
namespace Sphp\Lib{
/**
* ImageObject
*
* Represents an image file loaded from disk. It stores the image's width,
* height, MIME type and raw image data, and can create the underlying
* GD image resource from the file path based on the detected MIME type.
*/
class ImageObject{
public $width = 0;
public $height = 0;
public $mime = "image/jpeg";
public $data;
/**
* __construct
*
* Creates a new ImageObject. If a path is provided, the image is loaded
* from that file immediately.
*
* @param string $path Optional path to the image file to load.
* @return void
*/
/**
* loadFile
*
* Loads an image file from the given path, updating the width, height,
* MIME type and image data of this object.
*
* @param string $path Path to the image file to load.
* @return void
*/
public function loadFile($path){}
/**
* setImageData
*
* Sets the raw image data of this object.
*
* @param mixed $val The image data to store.
* @return void
*/
public function setImageData($val){}
/**
* getImageData
*
* Returns the raw image data of this object.
*
* @return mixed The stored image data.
*/
public function getImageData(){}
/**
* isValidType
*
* Checks whether the stored MIME type is a valid image type (starts with
* 'image/').
*
* @return bool True if the MIME type is an image type, false otherwise.
*/
public function isValidType(){}
/**
* createImage
*
* Creates the GD image resource for the given file path based on the
* stored MIME type (GIF, PNG or JPEG).
*
* @param string $path Path to the image file.
* @return resource|false The created GD image resource, or false on failure.
*/
}
}
