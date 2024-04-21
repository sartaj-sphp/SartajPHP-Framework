<?php
namespace Sphp\tools{
/**
* Description of SNode
* Parent Class of NodeTag
* @author Sartaj
*/
class SNode {
public $children = array();
public function getChildren() {}
public function isChildren() {}
/**
*  Iterate through Children. Return Callback true to exit soon.
* Callback($event,$child);
* $event = true or false mean in and out
* @param function $callback
*/
public function iterateChildren($callback) {}
/**
* Append children from string of html
* @param string $html
*/
public function appendChildren($html) {}
/**
*  parse html and Replace children from html text. 
*  It will not allow  runas=holder type attributes.
* Use only for html tags, control tags will not work. for controls use tempfile object.
* @param string $html
*/
public function replaceChildren($html) {}
public function parseObjectLoop($domNode,$parent = null) {}
public function replaceChild($newnode,$oldnode) {}
public function appendChild($node) {}
public function setChildren($children) {}
public function removeChildren() {}
public function hasChildren() {}
}
/**
* Description of NodeText
*
* @author Sartaj
*/
class NodeText  extends \Sphp\tools\SNode{
public $type = "text";
public $tagName = "";
public $myclass = "Sphp\\tools\\NodeText";
public function init($val){}
public function render(){}
}
}
