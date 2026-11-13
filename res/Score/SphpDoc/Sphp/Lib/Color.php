<?php
namespace Sphp\Lib{
/**
* Description of Color
*
* @author Sartaj
*
* Utility class for converting colors between HTML hex notation and RGB
* component values.
*/
class Color {
/**
* Convert a hex color string to an array of RGB components.
*
* @param string $color Hex color string, optionally prefixed with '#'.
* @return array|false Array of [r, g, b] integer values, or false on invalid input.
*/
public function html2rgb($color)
{}
/**
* Convert RGB component values to a hex color string.
*
* @param int|array $r Red component (0-255), or an array of [r, g, b] values.
* @param int $g Green component (0-255), default -1.
* @param int $b Blue component (0-255), default -1.
* @return string Hex color string prefixed with '#'.
*/
function rgb2html($r, $g=-1, $b=-1)
{}
}
}