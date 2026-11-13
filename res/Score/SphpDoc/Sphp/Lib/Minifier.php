<?php
namespace Sphp\Lib{
/**
* Exception thrown by the Minifier class when a minification error occurs
* (for example an unterminated comment or string, or a missing comment/string
* definition entry).
*/
class	MinifierException	extends \RuntimeException	{} ;
/**
* Abstract base class for code minifiers.
*
* A source file is considered as a flow of comments (either single- or multi-line), strings enquoted by
* some sequence(s), spaces, newlines and tokens.
*
* By default, the minifier base class treats single characters as tokens. If the derived class wants to
* perform more detailed syntax analysis, it will have to override the ProcessToken() method.
*
* Derived classes must call the SetComments(), SetQuotedStrings(), SetContinuation(), SetSpaces(),
* SetIdentifierRegex() and SetTokens() methods BEFORE calling the Minifier constructor, and call
* Finalize() again if any of those SetXXX methods are called afterwards.
*/
abstract class  Minifier		
{
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
/**
* Instanciates a Minifier class.
*
* The constructor must be called by derived classes AFTER any call to the SetXXX functions.
*
* @return void
*/
/**
* Finalizes the object instance, by rebuilding the call table that is used by the GetNextToken() method.
*
* This function MUST be called if one or more of the Setxxx methods have been called after the class
* constructor.
*
* @return void
*/
protected function  Finalize ( )
{}
/**
* Defines the comment style for the derived class.
*
* @param array $singleComments An array specifying the sequences starting single-line comments.
* @param array $multiComments Array of multiline comment definitions ('start', 'end', 'nested' entries).
* @return void
*/
protected function  SetComments ( $singleComments, $multiComments )
{}
/**
* Defines the string style for the derived class.
*
* @param array $strings Arrays of string definitions ('quote', 'left-quote', 'right-quote', 'escape', 'continuation' entries).
* @return void
*/
protected function  SetQuotedStrings ( $strings )
{}
/**
* Defines the continuation line construct, which must be foollowed either by crlf or lf.
*
* @param string $string Continuation line sequence.
* @return void
*/
protected function  SetContinuation ( $string )
{}
/**
* Defines the space characters recognized by the minifier.
*
* @param string $spaces String of characters to be considered as spaces.
* @return void
*/
protected function  SetSpaces ( $spaces )
{}
/**
* Sets the regex to be used for identifier matching.
*
* @param string $re Regular expression to be used for matching an identifier (without any delimiter).
* @return void
*/
protected function  SetIdentifierRegex ( $re )
{}
/**
* Sets the tokens around which spaces are to be eaten up ; this is the case for example for the
* relational operators, parentheses, etc.
*
* @param array $tokens Tokens around which spaces should be eaten.
* @return void
*/
protected function  SetTokens ( $tokens ) 
{}
/**
* Resets this instance so that a new file can be minified.
*
* @param string $data Optional data to be minified.
* @return void
*/
protected function  Reset ( $data = '' )
{}
/**
* To be implemented by derived classes for minifying data.
*
* @return string The minified data.
*/
abstract protected function	MinifyData ( ) ;
/**
* Minifies a string.
*
* @param string $contents Contents to be minified.
* @return string The minified contents.
*/
public function Minify ( $contents )
{}
/**
* Minifies the contents of a file.
*
* @param string $input Path of the file to be minified.
* @return string The minified file contents.
*/
public function MinifyFrom ( $input )
{}
/**
* Minifies a string and writes the result to a file.
*
* @param string $output Path of the output file.
* @param string $contents Contents to be minified.
* @return void
*/
public function MinifyTo ( $output, $contents ) 
{}
/**
* Minifies the contents of an input file and writes the result to an output file.
*
* @param string $output Path of the output file.
* @param string $input Path of the file to be minified.
* @return void
*/
public function MinifyFileTo ( $output, $input )
{}
/**
* Retrieves the next token, either a newline, a string or a token returned by the ProcessToken() method.
*
* @param int $offset Offset of the current position in the contents (by reference).
* @param mixed $token The found token (by reference).
* @param int $tokenType The type of the found token (by reference).
* @return bool True if a token was found, false if no more tokens are available.
*/
protected function  GetNextToken ( &$offset, &$token, &$tokenType )
{}
/**
* Checks if the current position specifies a continuation line (ie, a continuation sequence followed by
* "\r\n" or "\n").
*
* @param string $contents Contents being minified.
* @param int $length Length of the contents.
* @param int $offset Offset of the current position (by reference).
* @param string $continuation Continuation sequence.
* @return bool True if a continuation line was found, false otherwise.
*/
protected function  ProcessContinuation ( $contents, $length, &$offset, $continuation )
{}
/**
* Checks if the current position starts a single-line comment.
*
* @param string $contents Contents being minified.
* @param int $length Length of the contents.
* @param int $offset Offset of the current position (by reference).
* @return bool True if a single-line comment was found, false otherwise.
*/
protected function  ProcessSingleLineComments ( $contents, $length, &$offset )
{}
/**
* Checks if the current position starts a sequence of spaces.
*
* @param string $contents Contents being minified.
* @param int $length Length of the contents.
* @param int $offset Offset of the current position (by reference).
* @param mixed $token The found token (by reference).
* @param int $tokenType The type of the found token (by reference).
* @return bool True if a sequence of spaces was found, false otherwise.
*/
protected function  ProcessSpaces ( $contents, $length, &$offset, &$token, &$tokenType )
{}	
/**
* Eats up spaces and newlines starting at the given offset.
*
* @param string $contents Contents being minified.
* @param int $length Length of the contents.
* @param int $offset Offset of the current position (by reference).
* @return int Number of characters eaten.
*/
protected function  EatSpaces ( $contents, $length, &$offset )
{}
/**
* Checks if the current position starts a sequence of newlines.
*
* @param string $contents Contents being minified.
* @param int $length Length of the contents.
* @param int $offset Offset of the current position (by reference).
* @param mixed $token The found token (by reference).
* @param int $tokenType The type of the found token (by reference).
* @return bool True if a sequence of newlines was found, false otherwise.
*/
protected function  ProcessNewlines ( $contents, $length, &$offset, &$token, &$tokenType )
{}	
/**
* Checks if the current position starts a multi-line comment.
*
* @param string $contents Contents being minified.
* @param int $length Length of the contents.
* @param int $offset Offset of the current position (by reference).
* @return bool True if a multi-line comment was found, false otherwise.
*/
protected function  ProcessMultiLineComments ( $contents, $length, &$offset )
{}
/**
* Checks if the current position starts a string.
*
* @param string $contents Contents being minified.
* @param int $length Length of the contents.
* @param int $offset Offset of the current position (by reference).
* @param mixed $token The found string (by reference).
* @param int $tokenType The type of the found token (by reference).
* @return bool True if a string was found, false otherwise.
*/
protected function  ProcessString ( $contents, $length, &$offset, &$token, &$tokenType )
{}
/**
* Processes the next token that is neither a string, a comment, a group of spaces or a newline.
* The default implementation processes one character at a time.
*
* @param string $contents Contents being minified.
* @param int $length Length of the contents.
* @param int $offset Offset of the current position (by reference).
* @param mixed $token The found token (by reference).
* @param int $tokenType The type of the found token (by reference).
* @return bool True if a token was found.
*/
protected function  ProcessToken ( $contents, $length, &$offset, &$token, &$tokenType )
{}
}
}