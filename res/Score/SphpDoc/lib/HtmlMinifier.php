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
public function  __construct ( )
{}
protected function  MinifyData ( )
{}
protected function  __get_text_data ( $node )
{}
}