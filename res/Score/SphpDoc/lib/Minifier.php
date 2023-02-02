<?php
class	MinifierException	extends \RuntimeException	{} ;
abstract class  Minifier		   {
const		TOKEN_NONE			=  0 ;
const		TOKEN_SPACE			=  1 ;
const		TOKEN_NEWLINE			=  2 ;
const		TOKEN_STRING			=  3 ;
const		TOKEN_ELEMENT			=  4 ;
const		TOKEN_IDENTIFIER		=  5 ;
protected	$SingleLineComments		=  [] ;
protected	$MultiLineComments		=  [] ;
protected	$QuotedStrings			=  [] ;
protected	$Continuation			=  false ;
protected	$Spaces				=  [ " " => " ", "\t" => "\t", "\v" => "\v", "\r" => "\r", "\xA0" => "\xA0" ] ;
protected	$IdentifierRegex		=  false ;
protected	$Tokens				=  [] ;
protected	$Content ;
protected	$ContentLength ;
protected	$CurrentLine ;
protected	$LastToken ;
protected	$LastTokenType ;
protected function  Finalize ( )
{}
protected function  SetComments ( $single_comments, $multi_comments )
{}
protected function  SetQuotedStrings ( $strings )
{}
protected function  SetContinuation ( $string )
{}
protected function  SetSpaces ( $spaces )
{}
protected function  SetIdentifierRegex ( $re )
{}
protected function  SetTokens ( $tokens ) 
{}
protected function  Reset ( $data = null )
{}
abstract protected function	MinifyData ( ) ;
/*--------------------------------------------------------------------------------------------------------------
Minify, MinifyFile -	 
Minifies a string/file.
*-------------------------------------------------------------------------------------------------------------*/
public function  Minify ( $contents )
{}
public function  MinifyFrom ( $input )
{}
public function  MinifyTo ( $output, $contents ) 
{}
public function  MinifyFileTo ( $output, $input )
{}
protected function  GetNextToken ( &$offset, &$token, &$token_type )
{}
protected function  ProcessContinuation ( $contents, $length, &$offset, $continuation )
{}
protected function  ProcessSingleLineComments ( $contents, $length, &$offset )
{}
protected function  ProcessSpaces ( $contents, $length, &$offset, &$token, &$token_type )
{}	
protected function  EatSpaces ( $contents, $length, &$offset )
{}
protected function  ProcessNewlines ( $contents, $length, &$offset, &$token, &$token_type )
{}	
protected function  ProcessMultiLineComments ( $contents, $length, &$offset )
{}
protected function  ProcessString ( $contents, $length, &$offset, &$token, &$token_type )
{}
protected function  ProcessToken ( $contents, $length, &$offset, &$token, &$token_type )
{}
}
