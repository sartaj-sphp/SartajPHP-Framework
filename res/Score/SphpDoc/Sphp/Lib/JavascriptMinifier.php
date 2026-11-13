<?php
namespace Sphp\Lib{
require_once ( dirname ( __FILE__ ) . "/Minifier.php" ) ;
/**
* JavascriptMinifier class.
*
* Minifier for javascript sources.
*
* Extends the generic Minifier class and adds JavaScript specific handling:
* it recognizes regular expressions in the token stream (based on the
* character immediately before the starting slash) and keeps the required
* whitespace around operators such as '+' / '++' and '-' / '--' so that the
* minified output remains valid JavaScript.
*/
class	JavascriptMinifier	extends  Minifier
{
const	TOKEN_REGEX		=  100 ;
/**
* Constructor.
*
* Initializes the parent minifier class.
*
* Configures the comment styles, quoted strings, continuation character,
* identifier regular expression and the list of tokens used by the
* JavaScript minifier, then delegates to the parent constructor.
*
* @return void
*/
/**
* MinifyData.
*
* Process the input stream.
*
* Iterates over every token of the input stream, removes newlines,
* appends a space after each identifier, detects regular expressions
* and keeps the required whitespace around increment / decrement
* operators, building the minified output.
*
* @return string The minified javascript data.
*/
protected function  MinifyData ( )
{}
/**
* ProcessRegex.
*
* Captures a whole regular expression.
*
* Reads the content from the given offset until the stopping character
* (the closing slash), handling escaped characters, and throws a
* MinifierException when the regular expression is unterminated.
*
* @param string $content The full content being processed.
* @param int $offset The current offset in the content (passed by reference).
* @param string $token The token being built (passed by reference).
* @param string $stopChar The character that stops the regular expression.
* @return void
*/
protected function  ProcessRegex ( $content, &$offset, &$token, $stopChar )
{}
}
}