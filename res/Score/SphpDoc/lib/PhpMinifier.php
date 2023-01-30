<?php
require_once ( dirname ( __FILE__ ) . "/Minifier.php" ) ;
class	PhpMinifier	extends  Minifier 
{
protected function  MinifyData ( )
{
$fp		=  tmpfile ( ) ;
fwrite ( $fp, $this -> Content ) ;
$info		=  stream_get_meta_data ( $fp ) ;
$path		=  $info [ 'uri' ] ;
$contents	=  php_strip_whitespace ( $path ) ;
fclose ( $fp ) ;	
return ( $contents ) ;
}
}