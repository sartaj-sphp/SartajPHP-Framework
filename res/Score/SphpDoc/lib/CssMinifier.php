<?php
require_once ( dirname ( __FILE__ ) . "/Minifier.php" ) ;
class	CssMinifier	extends  Minifier 
{
protected function  MinifyData ( )
{
$data		=  '' ;
$offset		=  0 ;
$token		=  null ;
$token_type	=  self::TOKEN_NONE ;
while ( $this -> GetNextToken ( $offset, $token, $token_type ) )
{
switch ( $token )
{
case	"\n" :
break ;
default :
if  ( $token_type  ==  self::TOKEN_IDENTIFIER ) 
$token	.=  ' ' ;
else if  ( $token_type  ==  self::TOKEN_ELEMENT )
$data    =  rtrim ( $data ) ;
$data	.=  $token ;
}
}
return ( $data ) ;
}
}