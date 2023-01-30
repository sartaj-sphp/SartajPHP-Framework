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
{
foreach  ( array_keys ( $this -> Spaces )  as  $space )
$this -> CallTable [ $space ] []	=  [ 'callback' => [ $this, 'ProcessSpaces' ], 'return' => true ] ;
$this -> CallTables [ "\n" ] []		=  [ 'callback' => [ $this, 'ProcessNewlines' ], 'return' => true ] ;
if  ( $this -> Continuation )
$this -> CallTables [ $this -> Continuation [0] ] []	=  [ 'callback' => [ $this, 'ProcessContinuation' ], 'return' => false ] ;
foreach  ( $this -> SingleLineComments  as  $def )
$this -> CallTable [ $def [ 'value' ] [0] ] []	=  [ 'callback' => [ $this, 'ProcessSingleLineComments' ], 'return' => false ] ;
foreach  ( $this -> MultiLineComments  as  $def )
$this -> CallTable [ $def [ 'start' ] [0] ] []	=  [ 'callback' => [ $this, 'ProcessMultiLineComments' ], 'return' => false ] ;
foreach  ( $this -> QuotedStrings  as  $def )
$this -> CallTable [ $def [ 'left-quote' ] ] []	=  [ 'callback' => [ $this, 'ProcessString' ], 'return' => true ] ;
}
protected function  SetComments ( $single_comments, $multi_comments )
{
$this -> SingleLineComments	=  [] ;
$this -> MultiLineComments	=  [] ;
foreach  ( $single_comments  as  $single_comment )
$this -> SingleLineComments []	=  [ 'value' => $single_comment, 'length' => strlen ( $single_comment ) ] ;
$index	=  0 ;
foreach  ( $multi_comments  as  $comment_def )
{
if  ( ! isset ( $comment_def [ 'start' ] ) )
throw ( new MinifierException ( "Missing 'start' entry for multiline comment definition #$index." ) ) ;
if  ( ! isset ( $comment_def [ 'end' ] ) )
throw ( new MinifierException ( "Missing 'end' entry for multiline comment definition #$index." ) ) ;
if  ( ! isset ( $comment_def [ 'nested' ] )  ||  ! $comment_def [ 'nested' ] )
$comment_def [ 'nested' ]	=  false ;
$comment_def [ 'start-length' ]	=  strlen ( $comment_def [ 'start' ] ) ;
$comment_def [ 'end-length' ]	=  strlen ( $comment_def [ 'end' ] ) ;
$this -> MultiLineComments []	=  $comment_def ;
$index ++ ;
}
}
protected function  SetQuotedStrings ( $strings )
{
$index	=  0 ;
$this -> QuotedStrings	=  [] ;
foreach  ( $strings  as  $quoted_def )
{
if  ( ! isset ( $quoted_def [ 'quote' ] )  &&  ! isset ( $quoted_def [ 'left-quote' ] ) )
throw ( new MinifierException ( "Either the 'quote' or 'left-quote' entry is required for string definition #$index." ) ) ;
if  ( ! isset ( $quoted_def [ 'left-quote' ] ) )
$quoted_def [ 'left-quote' ]	=  $quoted_def [ 'quote' ] ;
if (  ! isset ( $quoted_def [ 'right-quote' ] ) )
$quoted_def [ 'right-quote' ]	=  $quoted_def [ 'left-quote' ] ;
if  ( ! isset ( $quoted_def [ 'escape' ] )  ||  ! $quoted_def [ 'escape' ] )
$quoted_def [ 'escape' ]	=  false ;
if  ( ! isset ( $quoted_def [ 'continuation' ] )  ||  ! $quoted_def [ 'continuation' ] )
$quoted_def [ 'continuation' ]	=  false ;
$quoted_def [ 'left-quote-length' ]	=  strlen ( $quoted_def [ 'left-quote' ] ) ;
$quoted_def [ 'right-quote-length' ]	=  strlen ( $quoted_def [ 'right-quote' ] ) ;
$quoted_def [ 'escape-length' ]		=  ( $quoted_def [ 'escape' ] ) ?  strlen ( $quoted_def [ 'escape' ] ) : 0 ;
$this -> QuotedStrings []	=  $quoted_def ;
$index ++ ;
}
}
protected function  SetContinuation ( $string )
{
$this -> Continuation		=  $string ;
$this -> ContinuationLength	=  strlen ( $string ) ;
}
protected function  SetSpaces ( $spaces )
{
$length		=  strlen ( $spaces ) ;
$this -> Spaces =  [] ;
for  ( $i = 0 ; $i  <  $length ; $i ++ )
$this -> Spaces [ $spaces [$i] ]	=  $spaces [$i] ;
}
protected function  SetIdentifierRegex ( $re )
{
$new_re		=  '/(?P<capture> (?P<name> ' . $re . ') [ \t\r\n]*)/ix' ;
$this -> IdentifierRegex	= $new_re ;
}
protected function  SetTokens ( $tokens ) 
{
$this -> Tokens		=  [] ;
foreach  ( $tokens  as  $token )
{
$ch	=  $token [0] ;
$this -> Tokens [ $ch ] []	=  [ 'value' => $token, 'length' => strlen ( $token ) ] ;
}
}
protected function  Reset ( $data = null )
{
$this -> Content	=  $data ;
$this -> ContentLength	=  strlen ( $data ) ;
$this -> CurrentLine	=  0 ;
$this -> LastToken	=  '' ;
$this -> LastTokenType	=  self::TOKEN_NONE ;
}
abstract protected function	MinifyData ( ) ;
public function  Minify ( $contents )
{}
public function  MinifyFrom ( $input )
{}
public function  MinifyTo ( $output, $contents ) 
{}
public function  MinifyFileTo ( $output, $input )
{}
protected function  GetNextToken ( &$offset, &$token, &$token_type )
{
$contents	=  $this -> Content ;
$length		=  $this -> ContentLength ;
$token		=  null ;
$this -> LastToken	=  $token ;
$this -> LastTokenType  =  $token_type ;
ShootAgain :
if  ( ! isset ( $contents [ $offset ] ) )
return ( false ) ;
$ch	=  $contents [ $offset ] ;
if  ( isset ( $this -> CallTable [ $ch ] ) )
{
foreach  ( $this -> CallTable [ $ch ]  as  $entry )
{
$callback	=  $entry [ 'callback' ] ;
$return_result	=  $entry [ 'return' ] ;
$status		=  $callback ( $contents, $length, $offset, $token, $token_type ) ;
if  ( $status )
{
if  ( $return_result )
return ( true ) ;
else 
goto  ShootAgain ;
}
}
}
return ( $this -> ProcessToken ( $contents, $length, $offset, $token, $token_type ) ) ;
}
protected function  ProcessContinuation ( $contents, $length, &$offset, $continuation )
{
if  ( $continuation )
{
$continuation_length	=  $this -> ContinuationLength ;
if  ( ! substr_compare ( $contents, "$continuation\r\n", $offset, $continuation_length + 2 ) )
{
$offset		+=  $continuation_length + 2 ;
$this-> CurrentLine ++ ;
return ( true ) ;
}
else if  ( ! substr_compare ( $contents, "$continuation\n", $offset, $continuation_length + 2 ) )
{
$offset		+=  $continuation_length + 1 ;
$this-> CurrentLine ++ ;
return ( true ) ;
}
}
return ( false ) ;
}
protected function  ProcessSingleLineComments ( $contents, $length, &$offset )
{
foreach  ( $this -> SingleLineComments  as  $def )
{
if  ( ! substr_compare ( $contents, $def [ 'value' ], $offset, $def [ 'length' ] ) )
{
$nlpos	=  strpos ( $contents, "\n", $offset ) ;
if  ( $nlpos  !==  false )
{
$this -> CurrentLine ++ ;
$offset		=  $nlpos + 1 ;
$this -> EatSpaces ( $contents, $length, $offset ) ;
}
else
$offset		=  $length ;
return ( true ) ;
}
}
return ( false ) ;
}
protected function  ProcessSpaces ( $contents, $length, &$offset, &$token, &$token_type )
{
$found_space	=  false ;
while  ( isset ( $contents [ $offset ] )  &&  isset ( $this -> Spaces [ $contents [ $offset ] ] ) )
{
$found_space	=  true ;
$token		=  ' ' ;
$token_type	=  self::TOKEN_SPACE ;
$offset ++ ;
}
return ( $found_space ) ;
}	
protected function  EatSpaces ( $contents, $length, &$offset )
{
$count 		=  0 ;
while  ( isset ( $contents [ $offset ] )  &&  ( isset ( $this -> Spaces [ $contents [ $offset ] ] )  ||  $contents [ $offset ]  ==  "\n" ) )
{
if  ( $contents [ $offset ]  ==  "\n" )
$this -> CurrentLine ++ ;
$offset ++ ;
$count ++ ;
}
return ( $count ) ;
}
protected function  ProcessNewlines ( $contents, $length, &$offset, &$token, &$token_type )
{
$found_newline	=  false ;
while  ( isset ( $contents [ $offset ] )  &&  $contents [ $offset ]  ==  "\n" )
{
$found_newline	=  true ;
$token		=  "\n" ;
$token_type	=  self::TOKEN_NEWLINE ;
$offset ++ ;
$this -> CurrentLine ++ ;
}
return ( $found_newline ) ;
}	
protected function  ProcessMultiLineComments ( $contents, $length, &$offset )
{
foreach  ( $this -> MultiLineComments  as  $def )
{
$comment_start		=  $def [ 'start' ] ;
$comment_end		=  $def [ 'end' ] ;
$nested			=  $def [ 'nested' ] ;
$comment_start_length	=  $def [ 'start-length' ] ;
$comment_end_length	=  $def [ 'end-length' ] ;
if  ( ! substr_compare ( $contents, $comment_start, $offset, $comment_start_length ) )
{
$found_end_comment	=  false ;
if  ( $nested )
{
$offset		       +=  $comment_start_length ;
$nesting_level		=  1 ;
while  ( $nesting_level  &&  isset ( $contents [ $offset ] ) )
{
if  ( ! substr_compare ( $contents, $comment_start, $offset, $comment_start_length ) )
{
$nesting_level ++ ;
$offset		+=  $comment_start_length ;
}
else if  ( ! substr_compare ( $contents, $comment_end, $offset, $comment_end_length ) )
{
$nesting_level -- ;
$offset		+=  $comment_end_length ;
}
}
if  ( ! $nesting_level )
$found_end_comment	=  true ;
}
else
{
$endpos		=  strpos ( $contents, $comment_end, $offset ) ;
if  ( $endpos  !==  false )
{
$this -> CurrentLine	+=  substr_count ( $contents, "\n", $offset, $endpos - $offset ) ;
$offset			 =  $endpos + $comment_end_length ;
$found_end_comment	 =  true ;
$this -> EatSpaces ( $contents, $length, $offset ) ;
}
}
if  ( ! $found_end_comment )
throw ( new MinifierException ( "Unterminated comment started at line #{$this -> CurrentLine}." ) ) ;
return ( true ) ;
}
}
return ( false ) ;
}
protected function  ProcessString ( $contents, $length, &$offset, &$token, &$token_type )
{
foreach ( $this -> QuotedStrings  as  $def )
{
$left			=  $def [ 'left-quote' ] ;
$right			=  $def [ 'right-quote' ] ;
$escape			=  $def [ 'escape' ] ;
$continuation		=  $def [ 'continuation' ] ;
$left_length		=  $def [ 'left-quote-length' ] ;
$right_length		=  $def [ 'right-quote-length' ] ;
$escape_length		=  $def [ 'escape-length' ] ;
if  ( $contents [ $offset ]  ==  $left [0]  &&  ! substr_compare ( $contents, $left, $offset, $left_length ) )
{
$offset		+=  $left_length ;
$found_eos	 =  false ;
$token		 =  $left ;
while  ( isset ( $contents [ $offset ] ) )
{
if  ( $this -> Continuation  &&  $this -> Continuation [0]  ==  $contents [ $offset ]  &&
$this -> ProcessContinuation ( $contents, $length, $offset, $continuation ) )
{
if  ( ! isset ( $contents [ $offset ] ) )
break ;
}
if  ( $escape  &&  ! substr_compare ( $contents, $escape, $offset, $escape_length ) )
{
$token		.=  $escape ;
$offset		+=  $escape_length ;
if  ( ! isset ( $contents [ $offset ] ) )
break ;
$token  .=  $contents [ $offset ++ ] ;
}
else if  ( ! substr_compare ( $contents, $right, $offset, $right_length ) )
{
$token		.=  $right ;
$offset		+=  $right_length ;
$found_eos	 =  true ;
break ;
}
else 
$token		.=  $contents [ $offset ++ ] ;
}
if  ( ! $found_eos )
throw ( new MinifierException ( "Unterminated string started at line #{$this -> CurrentLine}." ) ) ;
$token_type		=  self::TOKEN_STRING ;
$this -> CurrentLine   +=  substr_count ( $token, "\n" ) ;
return ( true ) ;
}
}
return ( false ) ;
}
protected function  ProcessToken ( $contents, $length, &$offset, &$token, &$token_type )
{
$ch	=  $contents [ $offset ] ;
if  ( $ch  <=  '~' )
{
if  ( isset ( $this -> Tokens [ $ch ] ) )
{
foreach  ( $this -> Tokens [ $ch ]  as  $item )
{
$value		=  $item [ 'value' ] ;
$value_length	=  $item [ 'length' ] ;
if  ( ! substr_compare ( $contents, $value, $offset, $value_length ) )
{
$token		 =  $value ;
$token_type	 =  self::TOKEN_ELEMENT ;
$offset		+=  $value_length ;
$this -> EatSpaces ( $contents, $length, $offset ) ;
return ( true ) ;
}
}
}
if  ( $this -> IdentifierRegex  &&  preg_match ( $this -> IdentifierRegex, $contents, $match, PREG_OFFSET_CAPTURE, $offset ) )
{
if  ( $match [ 'name' ] [1]  ==  $offset )
{
$token		 =  $match [ 'name' ] [0] ;
$token_type	 =  self::TOKEN_IDENTIFIER ;
$offset		+=  strlen ( $match [ 'capture' ] [0] ) ;
$this -> CurrentLine	+=  substr_count ( $match [ 'capture' ] [0], "\n" ) ;
return ( true ) ;
}
}
}
$token		=  $contents [ $offset ++ ] ;
$token_type	=  self::TOKEN_ELEMENT ;
return ( true ) ;
}
}
