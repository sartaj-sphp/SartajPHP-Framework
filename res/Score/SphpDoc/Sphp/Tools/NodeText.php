<?php
namespace Sphp\Tools{
/**
* Description of SNode
* Parent Class of NodeTag
*
* Base node class for the Sphp DOM tree. Represents a generic node that can
* hold a list of child nodes. It provides utilities to iterate, append,
* replace and remove children, and to parse an HTML string (via HtmlDom) into
* a tree of NodeTag and NodeText objects.
*
* @author Sartaj
*/
class SNode {
public $children = array();
/**
* Get the list of child nodes of this node.
* @return array List of child node objects.
*/
public function getChildren() {}
/**
* Check whether this node has any children.
* @return bool True if the node has children, false otherwise.
*/
public function isChildren() {}
/**
*  Iterate through Children. Return Callback true to exit soon.
* Callback($event,$child);
* $event = true or false mean in and out
* @param function $callback
* @return void
*/
public function iterateChildren($callback) {}
/**
* Append children from string of html
* @param string $html
* @return void
*/
public function appendChildren($html) {}
/**
*  parse html and Replace children from html text.
*  It will not allow  runas=holder type attributes.
* Use only for html tags, Component tags will not work. for Components use frontfile object.
* @param string $html
* @return void
*/
public function replaceChildren($html) {}
/**
* Recursively parse a list of DOM nodes and append them as children.
* Text nodes (nodetype 3) become NodeText objects, element nodes
* (nodetype 1) become NodeTag objects. The runas=holder attribute is
* stripped to stop holder processing.
* @param array $domNode List of DOM nodes to parse.
* @param object|null $parent Parent node to append to (defaults to $this).
* @return void
*/
public function parseObjectLoop($domNode,$parent = null) {}
/**
* Replace an existing child node with a new node.
* @param object $newnode The new node to insert.
* @param object $oldnode The existing node to replace.
* @return void
*/
public function replaceChild($newnode,$oldnode) {}
/**
* Append a node to the end of the children list.
* @param object $node The node to append.
* @return void
*/
public function appendChild($node) {}
/**
* Set the children list of this node.
* @param array $children The new list of child nodes.
* @return void
*/
public function setChildren($children) {}
/**
* Remove all children from this node.
* @return void
*/
public function removeChildren() {}
/**
* Check whether this node has any children.
* @return bool True if the node has children, false otherwise.
*/
public function hasChildren() {}
}
/**
* Description of NodeText
*
* Represents a text node in the Sphp DOM tree. Holds a plain text value and
* renders it back as-is. Used for text content parsed from HTML.
*
* @author Sartaj
*/
class NodeText  extends \Sphp\Tools\SNode{
public $type = "text";
public $tagName = "";
public $myclass = "Sphp\\tools\\NodeText";
/**
* Initialize the text node with a value.
* @param string $val The text value of the node.
* @return void
*/
public function init($val){}
/**
* Render the text node.
* @return string The text value of the node.
*/
public function render(){}
}
}
