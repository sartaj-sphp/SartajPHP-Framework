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
protected function seek($selector, $ret) {
list($tag, $key, $val, $exp, $no_key) = $selector;
if ($tag && $key && is_numeric($key)) {
$count = 0;
foreach ($this->children as $c) {
if ($tag === '*' || $tag === $c->tag) {
if (++$count == $key) {
$ret[$c->_a[self::HDOM_INFO_BEGIN]] = 1;
return;
}
}
}
return;
}
$end = (!empty($this->_a[self::HDOM_INFO_END])) ? $this->_a[self::HDOM_INFO_END] : 0;
if ($end == 0) {
$parent = $this->parent;
while (!isset($parent->_a[self::HDOM_INFO_END]) && $parent !== null) {
$end -= 1;
$parent = $parent->parent;
}
$end += $parent->_a[self::HDOM_INFO_END];
}
for ($i = $this->_a[self::HDOM_INFO_BEGIN] + 1; $i < $end; ++$i) {
$node = $this->dom->nodes[$i];
$pass = true;
if ($tag === '*' && !$key) {
if (in_array($node, $this->children, true)){
$ret[$i] = 1;
}
continue;
}
if ($tag && $tag != $node->tag && $tag !== '*') {
$pass = false;
}
if ($pass && $key) {
if ($no_key) {
if (isset($node->attr[$key])){
$pass = false;
}
}else if (!isset($node->attr[$key])){
$pass = false;
}
}
if ($pass && $key && $val && $val !== '*') {
$check = $this->match($exp, $val, $node->attr[$key]);
if (!$check && strcasecmp($key, 'class') === 0) {
foreach (explode(' ', $node->attr[$key]) as $k) {
$check = $this->match($exp, $val, $k);
if ($check){
break;
}
}
}
if (!$check){
$pass = false;
}
}
if ($pass){
$ret[$i] = 1;
}
unset($node);
}
}
protected function match($exp, $pattern, $value) {
switch ($exp) {
case '=':
return ($value === $pattern);
case '!=':
return ($value !== $pattern);
case '^=':
return preg_match("/^" . preg_quote($pattern, '/') . "/", $value);
case '$=':
return preg_match("/" . preg_quote($pattern, '/') . "$/", $value);
case '*=':
if ($pattern[0] == '/')
return preg_match($pattern, $value);
return preg_match("/" . $pattern . "/i", $value);
}
return false;
}
protected function parse_selector($selector_string) {
$matches = array();
$pattern = "/([\w-:\*]*)(?:\#([\w-]+)|\.([\w-]+))?(?:\[@?(!?[\w-]+)(?:([!*^$]?=)[\"']?(.*?)[\"']?)?\])?([\/, ]+)/is";
preg_match_all($pattern, trim($selector_string) . ' ', $matches, PREG_SET_ORDER);
$selectors = array();
$result = array();
foreach ($matches as $m) {
$m[0] = trim($m[0]);
if ($m[0] === '' || $m[0] === '/' || $m[0] === '//'){
continue;
}
if ($m[1] === 'tbody'){
continue;
}
$arp = array($m[1], null, null, '=', false);
list($tag, $key, $val, $exp, $no_key) = $arp;
if (!empty($m[2])) {
$key = 'id';
$val = $m[2];
}
if (!empty($m[3])) {
$key = 'class';
$val = $m[3];
}
if (!empty($m[4])) {
$key = $m[4];
}
if (!empty($m[5])) {
$exp = $m[5];
}
if (!empty($m[6])) {
$val = $m[6];
}
if ($this->dom->lowercase) {
$tag = strtolower($tag);
$key = strtolower($key);
}
if (isset($key[0]) && $key[0] === '!') {
$key = substr($key, 1);
$no_key = true;
}
$result[] = array($tag, $key, $val, $exp, $no_key);
if (trim($m[7]) === ',') {
$selectors[] = $result;
$result = array();
}
}
if (count($result) > 0){
$selectors[] = $result;
}
return $selectors;
}
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
