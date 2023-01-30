<?php
require_once ( dirname ( __FILE__ ) . "/Minifier.php" ) ;
require_once ( dirname ( __FILE__ ) . "/CssMinifier.php" ) ;
require_once ( dirname ( __FILE__ ) . "/JavascriptMinifier.php" ) ;
class	HtmlMinifier	extends  Minifier 
{
public			$StyleTable		=  [] ;
const			TAG_CLASS		=  '__CLASS__' ;
const			TAG_STYLE		=  '__STYLE__' ;
const			TAG_LOCAL_STYLE		=  '__LOCAL_STYLE__' ;
const			TAG_START		=  "\x00" ;
const			TAG_END			=  "\x01" ;
protected function  MinifyData ( )
{
return ( $this -> __minify_data ( $this -> Content ) ) ;
}
protected function  __get_text_data ( $node )
{
$parent		=  strtolower ( $node -> parentNode -> nodeName ) ;
if  ( isset  ( self::$PreserveSpacesInTags [ $parent ] ) )
$result		=  $node -> nodeValue ;
else
$result		=  preg_replace ( '/\s+/ms', ' ', $node -> nodeValue ) ;
$result		=  htmlentities ( $result ) ;
return ( $result ) ;
}
}