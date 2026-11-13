<?php
namespace Sphp\Lib{
require_once ( dirname ( __FILE__ ) . "/Minifier.php" ) ;
class	PhpMinifier	extends  Minifier 
{
/**
* Constructor.
* Initializes the parent minifier class.
* @return void
*/
/**
* MinifyData.
* Process the input stream.
* Since the php_strip_whitespace() function only accepts the name of an existing file, we have to write
* the contents to a frontorary file, whatever the origin of the contents (even if they come from an 
* existing file).
* This is a dirty solution but it wil always be faster than parsing the php source by ourselves...
* @return string The minified PHP source code with whitespace stripped.
*/
protected function  MinifyData ( )
{}
}
}