<?php
namespace Sphp\Lib{
require_once ( dirname ( __FILE__ ) . "/Minifier.php" ) ;
require_once ( dirname ( __FILE__ ) . "/CssMinifier.php" ) ;
require_once ( dirname ( __FILE__ ) . "/JavascriptMinifier.php" ) ;
/**
* HtmlMinifier class.
*
* Minifier for Html sources.
*
* This class extends the abstract Minifier class and minifies HTML source code using DOM functions.
* It is able to minify javascript inside "script" tags, as well as inline CSS styles. It also handles
* the minification of HTML code inside conditional comments, which are preserved (normal comments are
* removed). When multiple identical "style=" attributes are found, a CSS class is created for them to
* further reduce the size of the output html contents.
*/
class	HtmlMinifier	extends  Minifier 
{
public			$StyleTable		=  [] ;
const			TAG_CLASS		=  '__CLASS__' ;
const			TAG_STYLE		=  '__STYLE__' ;
const			TAG_LOCAL_STYLE		=  '__LOCAL_STYLE__' ;
const			TAG_START		=  "\x00" ;
const			TAG_END			=  "\x01" ;
/**
* Constructor.
*
* Initializes the parent minifier class.
*
* @return void
*/
/**
* MinifyData.
*
* Process the input stream.
*
* @return string The minified html contents.
*/
protected function  MinifyData ( )
{}
/**
* __minify_data.
*
* Minifies HTML data specified by $text.
* Since a DOMDocument is created, the $bodyOnly can be set to true for processing only the body contents.
* This is useful when only a HTML string (not a full page) has to be minified. This is the case for example
* for the html code inside conditional comments.
*
* @param string $text The HTML data to minify.
* @param bool $bodyOnly When true, only the body contents are processed.
* @return string The minified HTML contents.
*/
/**
* __process_childNodes.
*
* Processes the specified node and recursively processes its children.
* The minified contents are appended to $contents.
* The $level parameter is currently not used ; it indicates the current nesting level in the DOM tree,
* starting from zero.
*
* @param \DOMNode $node The node to process.
* @param string $contents The minified contents, appended to.
* @param int $level The current nesting level in the DOM tree.
* @return void
*/
/**
* __get_comment.
*
* Comments fall into two cases :
* - Regular comments, which are removed from the output
* - Conditional comments, that contain HTML code that also needs to be minified.
*   Conditional comments are always preserved.
*
* @param \DOMNode $node The comment node.
* @return string The comment string to append to the output (empty for regular comments).
*/
/**
* __get_document_node_as_string.
*
* Returns the HTML string for a <!DOCTYPE> tag.
*
* @param \DOMNode $node The document type node.
* @return string The HTML string for the <!DOCTYPE> tag.
*/
/**
* __get_element_node_as_string.
*
* Returns an HTML element with its attributes as a string.
* This function does not return the closing tag.
*
* @param \DOMNode $node The element node.
* @return string The HTML element with its attributes.
*/
/**
* __process_styles.
*
* Now that the original "class=" and "style=" attributes have been tagged, replace them with either a class name
* or the original "style=" value (in the case it was used only once)
*
* @param string $contents The minified contents to process.
* @return string The processed contents.
*/
/**
* __handle_styleAttribute.
*
* Memorizes the values of the different "style=" attributes encountered so far, together with their occurrence count.
* The style keywords are sorted before being regenerated.
*
* @param string $value The "style=" attribute value.
* @param string $newId The style identifier, set by reference.
* @return void
*/
/**
* __get_next_styleIdentifier.
*
* Given a set of characters ($IdentifierChars) of length $IdentifierCharCount, converts a number
* $NextStyleIdentifier to the base represented by the set of characters.
*
* @return string The next style identifier.
*/
/**
* __get_script_node_as_string.
*
* Minifies the contents of a <script> tag, if any.
*
* @param \DOMNode $node The script node.
* @return string The minified script contents.
*/
/**
* __get_style_node_as_string.
*
* Minifies the contents of an inline <style> tag.
*
* @param \DOMNode $node The style node.
* @return string The minified style contents.
*/
/**
* __get_text_data.
*
* Removes unnecessary spaces from node values.
*
* @param \DOMNode $node The text node.
* @return string The processed text data.
*/
protected function  __get_text_data ( $node )
{}
/**
* __quote_attributeValue.
*
* Quotes an attribute value, using single-quotes if the attribute value contains double-quote(s).
* Otherwise, use double quotes.
*
* @param string $value The attribute value to quote.
* @return string The quoted attribute value.
*/
}
}