<?php
namespace Sphp\Lib{
/**
* Canvas
*
* A GD-based canvas helper that creates a true-color image buffer and provides
* methods to configure aspect-ratio handling, fonts, and colors, to draw
* resampled images and text onto the canvas, and to save the result to a file
* or retrieve it as a data stream.
*/
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
/**
* __construct
*
* Creates the canvas image buffer at the given dimensions and initializes the
* mime type, font color, and font.
*
* @param int $width The canvas width in pixels.
* @param int $height The canvas height in pixels.
* @param string $mime The mime type of the output image (default "image/jpeg").
* @return void
*/
/**
* setAspectRatio
*
* Enables aspect-ratio maintenance so that drawn images keep their original
* proportions.
*
* @return void
*/
public function setAspectRatio(){}
/**
* setFont
*
* Loads a GD font file and assigns it as the canvas font.
*
* @param string $fontFile The path to the font file to load.
* @return void
*/
public function setFont($fontFile){}
/**
* setFontSize
*
* Sets the font size used when drawing strings.
*
* @param int $fontSize The font size to use.
* @return void
*/
public function setFontSize($fontSize){}
/**
* setFontColor
*
* Sets the font color used when drawing strings, with an optional alpha value.
*
* @param int $red The red component (0-255).
* @param int $green The green component (0-255).
* @param int $blue The blue component (0-255).
* @param int $alpha The alpha component (0-127, default 0).
* @return void
*/
public function setFontColor($red,$green,$blue,$alpha=0){}
/**
* drawImage
*
* Resamples the given source image onto the canvas, optionally adjusting the
* canvas height to maintain the aspect ratio.
*
* @param resource $image The source image resource.
* @param int $x The source x offset.
* @param int $y The source y offset.
* @param int $width The source width.
* @param int $height The source height.
* @return void
*/
public function drawImage($image,$x,$y,$width,$height){}
/**
* drawImageOver
*
* Resamples the given source image onto the canvas at a specific destination
* position and size, optionally adjusting the destination height to maintain
* the aspect ratio.
*
* @param resource $image The source image resource.
* @param int $dstX The destination x offset.
* @param int $dstY The destination y offset.
* @param int $x The source x offset.
* @param int $y The source y offset.
* @param int $dstWidth The destination width.
* @param int $dstHeight The destination height.
* @param int $width The source width.
* @param int $height The source height.
* @return void
*/
public function drawImageOver($image,$dstX,$dstY,$x,$y,$dstWidth,$dstHeight,$width,$height){}
/**
* drawString
*
* Draws a string onto the canvas at the given position using the current font,
* font size, and font color.
*
* @param int $x The x position to draw the string.
* @param int $y The y position to draw the string.
* @param string $string The string to draw.
* @return void
*/
public function drawString($x,$y,$string){}
/**
* saveImage
*
* Saves the canvas image to the given file path using the configured mime type
* and quality.
*
* @param string $path The file path to save the image to.
* @return void
*/
public function saveImage($path){}
/**
* getImageDataStreem
*
* Returns the canvas image data as a string in the configured mime format.
*
* @return string The image data as a string.
*/
public function getImageDataStreem(){}
/**
* getOutputFunction
*
* Determines and returns the GD output function name (e.g. "imagepng",
* "imagejpeg") based on the configured mime type, adjusting the mime type,
* sharpening flag, and quality as needed for the conversion.
*
* @return string The name of the GD output function to use.
*/
function getOutputFunction(){}
}
}
