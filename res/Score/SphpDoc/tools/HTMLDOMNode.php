<?php
namespace Sphp\tools{
class HTMLDOMNode {
public $nodetype = 3;
public $tag = 'text';
public $attr = array();
public $children = array();
public $nodes = array();
public $parent = null;
public $_a = array();
public $charpos = 0;
const HDOM_TYPE_ELEMENT = 1;
const HDOM_TYPE_COMMENT = 2;
const HDOM_TYPE_TEXT = 3;
const HDOM_TYPE_ENDTAG = 4;
const HDOM_TYPE_ROOT = 5;
const HDOM_TYPE_UNKNOWN = 6;
const HDOM_QUOTE_DOUBLE = 0;
const HDOM_QUOTE_SINGLE = 1;
const HDOM_QUOTE_NO = 3;
const HDOM_INFO_BEGIN = 0;
const HDOM_INFO_END = 1;
const HDOM_INFO_QUOTE = 2;
const HDOM_INFO_SPACE = 3;
const HDOM_INFO_TEXT = 4;
const HDOM_INFO_INNER = 5;
const HDOM_INFO_OUTER = 6;
const HDOM_INFO_ENDSPACE = 7;
public function getNodetype() {}
public function getTag() {}
public function getAttr() {}
public function getChildren() {}
public function addChild($node) {}
public function getNodes() {}
public function addNode($node) {}
public function getParent() {}
public function setNodetype($nodetype) {}
public function setTag($tag) {}
public function setAttr($attr) {}
public function setChildren($children) {}
public function setNodes($nodes) {}
public function setParent($parent) {}
public function isEndTag() {}
public function isSelfClose() {}
public function clear() {}
public function dump($show_attr = true) {}
public function parent() {}
public function children($idx = -1) {}
public function first_child() {}
public function last_child() {}
public function next_sibling() {}
public function prev_sibling() {}
public function setA($key,$val) {}
public function setAppendA($key,$val) {}
public function setAA($key,$val) {}
public function innertext() {}
public function outertext() {}
public function outertext2() {}
public function text() {}
public function xmltext() {}
public function makeup() {}
public function find($selector, $idx = null) {}
protected function seek($selector, $ret) {}
protected function match($exp, $pattern, $value) {}
protected function parse_selector($selector_string) {}
public function getAllAttributes() {}
public function getAttribute($name) {}
public function setAttribute($name, $value) {}
public function hasAttribute($name) {}
public function removeAttribute($name) {}
public function getElementById($id) {}
public function getElementsById($id, $idx = null) {}
public function getElementByTagName($name) {}
public function getElementsByTagName($name, $idx = null) {}
public function parentNode() {}
public function childNodes($idx = -1) {}
public function firstChild() {}
public function lastChild() {}
public function nextSibling() {}
public function previousSibling() {}
}
}
