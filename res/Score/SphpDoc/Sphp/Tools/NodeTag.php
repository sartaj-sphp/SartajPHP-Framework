<?php
namespace Sphp\Tools{
/**
* NodeTag represents an HTML/XML element node in the Sphp DOM tree.
*
* It extends SNode and provides full support for tag attributes,
* self-closing detection, dynamic attribute markers, component
* references, inner/outer HTML manipulation, and rendering of the
* element along with its children.
*
* Key features:
*  - Attribute management (get, set, remove, append, default, dynamic)
*  - Self-closing tag detection for void elements (input, img, br, etc.)
*  - Component reference binding via _setRefComp
*  - Inner/outer HTML get/set with optional child parsing
*  - Pre/post tag wrapping for custom rendering
*  - Magic __get/__set for innertext, outertext, and attribute access
*
* @author Sartaj
*/
class NodeTag extends \Sphp\Tools\SNode{
/** @var string The type of tag (e.g. "element", "text"). */
/** @var int The line number where this tag appears in the source. */
public $linenum = -1;
/** @var string The name of the HTML tag (e.g. "div", "span"). */
public $tagName = "";
/** @var string The node type, default "element". */
public $type = "element";
/** @var array Associative array of tag attributes (name => value). */
public $attributes = array();
/** @var array Internal attribute storage. */
public $_a = array();
/** @var int Character position of the tag in the source. */
public $charpos = 0;
/** @var array Markers for dynamic attributes: name => array(bool, bool). */
public $dynaAttrMarker = array();
/** @var bool Whether the tag is self-closing (e.g. <br />). */
public $blnselfclose = false;
/** @var bool Whether the tag has been explicitly closed. */
public $blnclose = false;
/** @var SNode|null Reference to the parent node. */
public $parentNode = null;
/** @var object|null The component object associated with this tag. */
public $comp = null;
/** @var bool True if this tag references a component created by another tag. */
public $refcomptag = false;
/** @var NodeTag|null The element of the referenced component. */
public $refcomptagelement = null;
/** @var bool Whether the tag has a runat attribute. */
public $runat = false;
/** @var bool Whether to render the tag wrapper (true) or only inner content. */
public $blnrenderTag = true;
/** @var bool Whether this node should be rendered at all. */
public $blnrender = true;
/** @var string Content prepended before the tag when rendering. */
public $pretag = "";
/** @var string Content appended after the tag when rendering. */
public $posttag = "";
/** @var string Content prepended inside the tag, before children. */
public $innerpretag = "";
/** @var string Content appended inside the tag, after children. */
public $innerposttag = "";
/** @var string The class identifier for this node. */
public $myclass = "Sphp\\tools\\NodeTag";
/** @var object|null The front-end object associated with this tag. */
public $frontobj = null;
/**
* Constructor for NodeTag.
*
* @param object|null $frontobj1 Optional front-end object to associate with this tag.
* @return void
*/
/**
* Initialize the tag from a raw tag string.
*
* Parses the tag name and attributes from the given string.
*
* @param string $strtag The raw tag string (e.g. "div class='box'").
* @return void
*/
public function init($strtag){}
/**
* Bind this tag to a component object, copying its element properties.
*
* Sets the tag name, self-close/close flags, merges attributes and
* dynamic attribute markers from the component's element, and marks
* this tag as a component reference.
*
* @param object $compobj The component object to reference.
* @return void
*/
/**
* Check whether the current tag is a self-closing (void) element.
*
* Sets blnselfclose to true if the tag name matches a known void
* element such as input, img, br, meta, link, hr, base, embed, spacer.
*
* @return bool True if the tag is self-closing, false otherwise.
*/
public function checkSelfClose(){}
/**
* Get whether the tag is self-closing.
*
* @return bool True if the tag is self-closing.
*/
public function isSelfClose(){}
/**
* Set the parent node of this tag.
*
* @param SNode $parent The parent node.
* @return void
*/
/**
* Get the parent node of this tag.
*
* @return SNode|null The parent node, or null if none.
*/
public function getParent(){}
/**
* Set the line number where this tag appears in the source.
*
* @param int $num The line number.
* @return void
*/
/**
* Get the line number where this tag appears in the source.
*
* @return int The line number.
*/
public function getLineNo(){}
/**
* Mark this tag as closed.
*
* @return void
*/
public function closeTag(){}
/**
* Set the component object associated with this tag.
*
* @param object $component The component object.
* @return void
*/
/**
* Get the component object associated with this tag.
*
* @return object|null The component object, or null if none.
*/
public function getComponent() {}
/**
* Parse and store attributes from a raw attribute string.
*
* Uses a regex to match name=value pairs, handling quoted and
* unquoted values.
*
* @param string $strdata The raw attribute string.
* @return void
*/
/**
* Parse and store attributes from a raw attribute string (variant 3).
*
* Splits on "=" and stores attribute names with empty values.
*
* @param string $strdata The raw attribute string.
* @return void
*/
/**
* Parse and store attributes from a raw attribute string (variant 2).
*
* Uses copyUntil to extract attribute names and values sequentially.
*
* @param string $strdata The raw attribute string.
* @return void
*/
/**
* Generate the HTML string for all non-dynamic attributes.
*
* Iterates over the attributes array and builds a string of
* name="value" pairs, skipping dynamic attributes.
*
* @return string The HTML attribute string.
*/
public function getAttributesHtml(){}
/**
* Get attributes that start with a given prefix, with the prefix stripped.
*
* @param string $prefix The attribute name prefix to match.
* @return array Associative array of attributes with the prefix removed.
*/
public function getAttributesCat($prefix){}
/**
* Create a new NodeTag element from a raw tag HTML string.
*
* @param string $taghtml The raw tag HTML string.
* @return NodeTag The newly created NodeTag instance.
*/
public function createElement($taghtml) {}
/**
* Render this tag and all its children to an HTML string.
*
* If blnrender is false, returns an empty string. Otherwise,
* concatenates innerpretag, rendered children, and innerposttag,
* then wraps with the tag if blnrenderTag is true and tagName is set.
*
* @return string The rendered HTML string.
*/
public function render(){}
/**
* Generate the full HTML tag string including opening/closing tags.
*
* Handles both self-closing and normal tags, incorporating
* pretag, attributes, inner data, and posttag.
*
* @param string $strData The inner content HTML.
* @return string The complete HTML tag string.
*/
/**
* Check whether the tag has a specific attribute.
*
* @param string $name The attribute name.
* @return bool True if the attribute exists.
*/
public function hasAttribute($name){}
/**
* Set an attribute only if it does not already exist.
*
* @param string $name The attribute name.
* @param string $val The attribute value.
* @return void
*/
public function setDefaultAttribute($name,$val){}
/**
* Get the value of a specific attribute.
*
* @param string $name The attribute name.
* @return string The attribute value, or empty string if not set.
*/
public function getAttribute($name){}
/**
* Remove a specific attribute from the tag.
*
* @param string $name The attribute name to remove.
* @return void
*/
public function removeAttribute($name){}
/**
* Set the value of a specific attribute.
*
* @param string $name The attribute name.
* @param string $val The attribute value.
* @return void
*/
public function setAttribute($name,$val){}
/**
* Append a value to an existing attribute.
*
* @param string $name The attribute name.
* @param string $val The value to append.
* @return void
*/
public function appendAttribute($name,$val){}
/**
* Check whether an attribute value contains a given substring.
*
* @param string $name The attribute name.
* @param string $val The substring to search for.
* @return bool True if the attribute value contains the substring.
*/
public function hasAttributeValue($name,$val){}
/**
* Mark an attribute as dynamic.
*
* @param string $name The attribute name.
* @param bool $runonce Whether the dynamic attribute runs only once.
* @return void
*/
public function setAttributeDyna($name,$runonce=false){}
/**
* Check whether a dynamic attribute has already run.
*
* Checks both this tag's and the referenced component element's
* dynamic attribute markers.
*
* @param string $name The attribute name.
* @return bool True if the dynamic attribute has run.
*/
public function isDynaAttrRun($name){}
/**
* Get all attributes of the tag.
*
* @return array Associative array of all attributes.
*/
public function getAttributes() {}
/** Over write or remove html tag
*  This can also Remove element
* @param type $html
*/
/**
* Replace this tag's outer HTML with the given text.
*
* Removes children, creates a NodeText with the given HTML, and
* replaces this tag in the parent with the text node. Sets
* blnrenderTag to false so the tag wrapper is not rendered.
*
* @param string $html The replacement HTML text.
* @return void
*/
public function setOuterHtml($html){}
/**
* Set Inner HTML as text. It will not parse HTML nodes.
* If you want parse then use parseChildren method.
* Parse children will append nodes and modify original document for further processing.
* @param string $html
*/
/**
* Set the inner HTML of this tag as plain text.
*
* Removes existing children and appends a single NodeText with
* the given HTML string. Does not parse the HTML into nodes.
*
* @param string $html The HTML text to set as inner content.
* @return void
*/
public function setInnerHtml($html){}
/**
* Get the inner HTML of this tag by rendering all children.
*
* @return string The rendered inner HTML string.
*/
public function getInnerHtml(){}
/**
* Get the outer HTML of this tag by rendering the full tag.
*
* @return string The rendered outer HTML string.
*/
public function getOuterHtml(){}
/**
* Set the content prepended before the tag when rendering.
*
* @param string $tagdata The pre-tag content.
* @return void
*/
public function setPreTag($tagdata) {}
/**
* Set the content appended after the tag when rendering.
*
* @param string $tagdata The post-tag content.
* @return void
*/
public function setPostTag($tagdata) {}
/**
* Set the content prepended inside the tag, before children.
*
* @param string $tagdata The inner pre-tag content.
* @return void
*/
public function setInnerPreTag($tagdata) {}
/**
* Set the content appended inside the tag, after children.
*
* @param string $tagdata The inner post-tag content.
* @return void
*/
public function setInnerPostTag($tagdata) {}
/**
* Append content to the pre-tag string.
*
* @param string $tagdata The content to append.
* @return void
*/
public function appendPreTag($tagdata) {}
/**
* Append content to the post-tag string.
*
* @param string $tagdata The content to append.
* @return void
*/
public function appendPostTag($tagdata) {}
/**
* Append content to the inner pre-tag string.
*
* @param string $tagdata The content to append.
* @return void
*/
public function appendInnerPreTag($tagdata) {}
/**
* Append content to the inner post-tag string.
*
* @param string $tagdata The content to append.
* @return void
*/
public function appendInnerPostTag($tagdata) {}
/**
* Set the tag name of this element.
*
* @param string $tagname The new tag name.
* @return void
*/
public function setTagName($tagname) {}
/**
* Wrap this tag inside a new parent tag.
*
* Creates a new NodeTag from the given HTML, moves this tag inside
* it, and replaces this tag in the parent with the new wrapper.
*
* @param string $taghtml The raw tag HTML for the wrapper.
* @return NodeTag The new wrapper tag.
*/
public function wrapTag($taghtml) {}
/**
* Wrap the children of this tag inside a new inner tag.
*
* Creates a new NodeTag from the given HTML, moves this tag's
* children into it, and appends the new tag as a child.
*
* @param string $taghtml The raw tag HTML for the inner wrapper.
* @return NodeTag The new inner wrapper tag.
*/
public function wrapInnerTags($taghtml) {}
/**
* Append HTML text as a child text node.
*
* @param string $html The HTML text to append.
* @return void
*/
public function appendHtml($html){}
/**
* Magic getter for property access.
*
* Supports "innertext" (returns inner HTML), "outertext" (returns
* outer HTML), and falls back to getAttribute for other names.
*
* @param string $name The property name.
* @return mixed The property or attribute value.
*/
/**
* Magic setter for property assignment.
*
* Supports "innertext" (sets inner HTML), "outertext" (sets outer
* HTML), and falls back to setAttribute for other names.
*
* @param string $name The property name.
* @param mixed $value The value to set.
* @return void
*/
/**
* Magic isset check for property existence.
*
* Checks whether the given attribute exists on this tag.
*
* @param string $name The property/attribute name.
* @return bool True if the attribute exists.
*/
/**
* Magic unset for property removal.
*
* Removes the given attribute from this tag.
*
* @param string $name The property/attribute name to remove.
* @return void
*/
}
}
