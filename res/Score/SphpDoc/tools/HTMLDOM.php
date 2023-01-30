<?php
namespace Sphp\tools{
class HTMLDOM {
public $root = null;
public $nodes = array();
public $callback = null;
public $lowercase = false;
public $pos;
protected $doc;
protected $chara;
protected $size;
public $cursor;
protected $parent;
protected $noise = array();
protected $token_blank = "";
protected $token_slash = "";
protected $token_equal = ' =/>';
protected $token_attr = ' >';
protected $self_closing_tags = array('img'=>1, 'br'=>1, 'input'=>1, 'meta'=>1, 'link'=>1, 'hr'=>1, 'base'=>1, 'embed'=>1, 'spacer'=>1);
protected $block_tags = array('root'=>1, 'body'=>1, 'form'=>1, 'div'=>1, 'span'=>1, 'table'=>1);
protected $optional_closing_tags = array();
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
public function load($str, $lowercase=true) {}
public function load_file($filepath) {}
public function load_file_str($filepath) {}
public function set_callback($function_name,$obj) {}
public function remove_callback() {}
public function save($filepath='') {}
public function find($selector, $idx=null) {}
public function clear() {}
public function dump($show_attr=true) {}
public function countLines($pos1) {}
protected function prepare($str, $strlowercase=true) {
$this->doc = $str;
$this->pos = 0;
$this->cursor = 1;
$this->noise = array();
$this->nodes = array();
$this->lowercase = $strlowercase;
$this->root = new HTMLDOMNode($this);
$this->root->setTag('root');
$this->root->setA(self::HDOM_INFO_BEGIN, -1);
$this->root->setNodetype(self::HDOM_TYPE_ROOT);
$this->parent = $this->root;
$this->size = strlen($str);
if ($this->size>0){
$this->chara = $this->doc[0];
}
}
protected function parse() {
if (($s = $this->copy_until_char('<'))===''){
return $this->read_tag();
}
$node = new HTMLDOMNode($this);
++$this->cursor;
$node->setA(self::HDOM_INFO_TEXT,$s);
$this->link_nodes($node, false);
return true;
}
protected function read_tag() {
try{
if ($this->chara!=='<') {
$this->root->setA(self::HDOM_INFO_END, $this->cursor);
return false;
}
$begin_tag_pos = $this->pos;
$this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null; 
if ($this->chara==='/') {
$this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null;             $this->skip($this->token_blank);
$tag = $this->copy_until_char('>');
if (($pos = strpos($tag, ' '))!==false)
$tag = substr($tag, 0, $pos);
$parent_lower = strtolower($this->parent->getTag());
$tag_lower = strtolower($tag);
if ($parent_lower!==$tag_lower) {
if (isset($this->optional_closing_tags[$parent_lower]) && isset($this->block_tags[$tag_lower])) {
$this->parent->setA(self::HDOM_INFO_END, 0);
$org_parent = $this->parent;
while (($this->parent->parent) && strtolower($this->parent->getTag())!==$tag_lower)
$this->parent = $this->parent->parent;
if (strtolower($this->parent->getTag())!==$tag_lower) {
$this->parent = $org_parent;                         if ($this->parent->parent) $this->parent = $this->parent->parent;
$this->parent->setA(self::HDOM_INFO_END, $this->cursor);
return $this->as_text_node($tag);
}
}
else if (($this->parent->parent) && isset($this->block_tags[$tag_lower])) {
$this->parent->setA(self::HDOM_INFO_END, 0);
$org_parent = $this->parent;
while (($this->parent->parent) && strtolower($this->parent->getTag())!==$tag_lower)
$this->parent = $this->parent->parent;
if (strtolower($this->parent->getTag())!==$tag_lower) {
$this->parent = $org_parent;                         $this->parent->setA(self::HDOM_INFO_END, $this->cursor);
return $this->as_text_node($tag);
}
}
else if (($this->parent->parent) && strtolower($this->parent->parent->tag)===$tag_lower) {
$this->parent->setA(self::HDOM_INFO_END, 0);
$this->parent = $this->parent->parent;
}
else
return $this->as_text_node($tag);
}
$this->parent->setA(self::HDOM_INFO_END,$this->cursor);
if ($this->parent->parent) $this->parent = $this->parent->parent;
$this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null;             return true;
}
$node = new HTMLDOMNode($this);
$node->setA(self::HDOM_INFO_BEGIN, $this->cursor);
++$this->cursor;
$tag = $this->copy_until($this->token_slash);
if (isset($tag[0]) && $tag[0]==='!') {
$node->setA(self::HDOM_INFO_TEXT, '<' . $tag . $this->copy_until_char('>'));
if (isset($tag[2]) && $tag[1]==='-' && $tag[2]==='-') {
$node->nodetype = self::HDOM_TYPE_COMMENT;
$node->tag = 'comment';
} else {
$node->nodetype = self::HDOM_TYPE_UNKNOWN;
$node->tag = 'unknown';
}
if ($this->chara==='>') $node->setAppendA(self::HDOM_INFO_TEXT,'>');
$this->link_nodes($node, true);
$this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null;             return true;
}
if ($pos=strpos($tag, '<')!==false) {
$tag = '<' . substr($tag, 0, -1);
$node->setA(self::HDOM_INFO_TEXT, $tag);
$this->link_nodes($node, false);
$this->pos--;
$pos1 = $this->pos;
$this->chara = $this->doc[$pos1];             return true;
}
if (!preg_match("/^[\w\-:]+$/", $tag)) {
$node->setA(self::HDOM_INFO_TEXT, '<' . $tag . $this->copy_until('<>'));
if ($this->chara==='<') {
$this->link_nodes($node, false);
return true;
}
if ($this->chara==='>') $node->setAppendA(self::HDOM_INFO_TEXT,'>');
$this->link_nodes($node, false);
$this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null;             return true;
}
$node->nodetype = self::HDOM_TYPE_ELEMENT;
$tag_lower = strtolower($tag);
$node->tag = ($this->lowercase) ? $tag_lower : $tag;
if (isset($this->optional_closing_tags[$tag_lower]) ) {
$parenttag = strtolower($this->parent->getTag());
while (isset($this->optional_closing_tags[$tag_lower][$parenttag])) {
$this->parent->setA(self::HDOM_INFO_END,0);
$this->parent = $this->parent->parent;
}
$node->parent = $this->parent;
}
$guard = 0;         $space = array($this->copy_skip($this->token_blank), '', '');
do {
if ($this->chara!==null && $space[0]==='') break;
$name = $this->copy_until($this->token_equal);
if($guard===$this->pos) {
$this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null;                 continue;
}
$guard = $this->pos;
if($this->pos>=$this->size-1 && $this->chara!=='>') {
$node->nodetype = self::HDOM_TYPE_TEXT;
$node->setA(self::HDOM_INFO_END, 0);
$node->setA(self::HDOM_INFO_TEXT, '<' . $tag . $space[0] . $name);
$node->tag = 'text';
$this->link_nodes($node, false);
return true;
}
if($this->doc[$this->pos-1]=='<') {
$node->nodetype = self::HDOM_TYPE_TEXT;
$node->tag = 'text';
$node->attr = array();
$node->setA(self::HDOM_INFO_END, 0);
$node->setA(self::HDOM_INFO_TEXT, substr($this->doc, $begin_tag_pos, $this->pos-$begin_tag_pos-1));
$this->pos -= 2;
$this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null;                 $this->link_nodes($node, false);
return true;
}
if ($name!=='/' && $name!=='') {
$space[1] = $this->copy_skip($this->token_blank);
$name = $this->restore_noise($name);
if ($this->lowercase) $name = strtolower($name);
if ($this->chara==='=') {
$this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null;                     $this->parse_attr($node, $name, $space);
}
else {
$node->setAA(self::HDOM_INFO_QUOTE, self::HDOM_QUOTE_NO);
$node->attr[$name] = true;
if ($this->chara!='>'){
$this->pos--;
$pos1 = $this->pos;
$this->chara = $this->doc[$pos1];                     }
}
$node->setAA(self::HDOM_INFO_SPACE, $space);
$space = array($this->copy_skip($this->token_blank), '', '');
}
else{
break;
}
} while($this->chara!=='>' && $this->chara!=='/');
$this->link_nodes($node, true);
$node->setA(self::HDOM_INFO_ENDSPACE, $space[0]);
if ($this->copy_until_char_escape('>')==='/') {
$node->setAppendA(self::HDOM_INFO_ENDSPACE, '/');
$node->setA(self::HDOM_INFO_END, 0);
}
else {
$nodelc = strtolower($node->tag);
if (!isset($this->self_closing_tags[$nodelc])) $this->parent = $node;
}
$this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null;         return true;
}catch(\Sphp\core\Exception $e){
$e1 = new \Sphp\core\Exception("HTML Parser Error:- Tag: ". $node->tag . " CharPos: " . $this->pos ." " . $e->getMessage());
throw $e1;
}
}
protected function parse_attr($node, $name, $space) {
$space[2] = $this->copy_skip($this->token_blank);
switch($this->chara) {
case '"':
$node->setAA(self::HDOM_INFO_QUOTE, self::HDOM_QUOTE_DOUBLE);
$this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null;                 $node->attr[$name] = $this->restore_noise($this->copy_until_char_escape('"'));
$this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null;                 break;
case '\'':
$node->setAA(self::HDOM_INFO_QUOTE, self::HDOM_QUOTE_SINGLE);
$this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null;                 $node->attr[$name] = $this->restore_noise($this->copy_until_char_escape('\''));
$this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null;                 break;
default:
$node->setAA(self::HDOM_INFO_QUOTE, self::HDOM_QUOTE_NO);
$node->attr[$name] = $this->restore_noise($this->copy_until($this->token_attr));
}
}
protected function link_nodes($node, $is_child) {
$node->parent = $this->parent;
$this->parent->addNode($node);
if ($is_child)
$this->parent->addChild($node);
}
protected function as_text_node($tag) {
$node = new HTMLDOMNode($this);
++$this->cursor;
$node->setA(self::HDOM_INFO_TEXT, '</' . $tag . '>');
$this->link_nodes($node, false);
$this->chara = (++$this->pos<$this->size) ? $this->doc[$this->pos] : null;         return true;
}
protected function skip($chars) {
$this->pos += strspn($this->doc, $chars, $this->pos);
$this->chara = ($this->pos<$this->size) ? $this->doc[$this->pos] : null;     }
protected function copy_skip($chars) {
$pos = $this->pos;
$len = strspn($this->doc, $chars, $pos);
$this->pos += $len;
$this->chara = ($this->pos<$this->size) ? $this->doc[$this->pos] : null;         if ($len===0) return '';
return substr($this->doc, $pos, $len);
}
protected function copy_until($chars) {
$pos = $this->pos;
$len = strcspn($this->doc, $chars, $pos);
$this->pos += $len;
$this->chara = ($this->pos<$this->size) ? $this->doc[$this->pos] : null;         return substr($this->doc, $pos, $len);
}
protected function copy_until_char($chara) {
if ($this->chara===null) return '';
if (($pos = strpos($this->doc, $chara, $this->pos))===false) {
$ret = substr($this->doc, $this->pos, $this->size-$this->pos);
$this->chara = null;
$this->pos = $this->size;
return $ret;
}
if ($pos===$this->pos) return '';
$pos_old = $this->pos;
$this->chara = $this->doc[$pos];
$this->pos = $pos;
return substr($this->doc, $pos_old, $pos-$pos_old);
}
protected function copy_until_char_escape($chara) {
if ($this->chara===null) return '';
$start = $this->pos;
while(1) {
if (($pos = strpos($this->doc, $chara, $start))===false) {
$ret = substr($this->doc, $this->pos, $this->size-$this->pos);
$this->chara = null;
$this->pos = $this->size;
return $ret;
}
if ($pos===$this->pos) return '';
if ($this->doc[$pos-1]==='\\') {
$start = $pos+1;
continue;
}
$pos_old = $this->pos;
$this->chara = $this->doc[$pos];
$this->pos = $pos;
return substr($this->doc, $pos_old, $pos-$pos_old);
}
}
protected function remove_noise($pattern, $remove_tag=false) {
$matches = array();
$count = preg_match_all($pattern, $this->doc, $matches, PREG_SET_ORDER|PREG_OFFSET_CAPTURE);
for ($i=$count-1; $i>-1; --$i) {
$key = '___noise___'. sprintf('% 3d', count($this->noise)+100);
$idx = ($remove_tag) ? 0 : 1;
$this->noise[$key] = $matches[$i][$idx][0];
$this->doc = substr_replace($this->doc, $key, $matches[$i][$idx][1], strlen($matches[$i][$idx][0]));
}
$this->size = strlen($this->doc);
if ($this->size>0) $this->chara = $this->doc[0];
}
public function restore_noise($text) {}
public function childNodes($idx=-1) {}
public function firstChild() {}
public function lastChild() {}
public function getElementById($id) {}
public function getElementsById($id, $idx=null) {}
public function getElementByTagName($name) {}
public function getElementsByTagName($name, $idx=-1) {}
public function loadFile() {}
}
}
