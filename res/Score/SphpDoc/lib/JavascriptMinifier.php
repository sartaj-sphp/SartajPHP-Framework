<?php
require_once ( dirname ( __FILE__ ) . "/Minifier.php" ) ;
class	JavascriptMinifier	extends  Minifier
{
const	TOKEN_REGEX		=  100 ;
private static	$SymbolsBeforeRegex	=  [ '(', '=', ';', '!', '>', '<', ':', '' ] ;
private static  $ForceNewlineBefore	=  [] ;
public function  __construct ( )
{}
protected function  MinifyData ( )
{}
protected function  ProcessRegex ( $content, &$offset, &$token, $stop_char )
{}
}