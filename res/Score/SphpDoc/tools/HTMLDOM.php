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
public function getDoc() {}
public function dump($show_attr=true) {}
public function countLines($pos1) {}
protected function prepare($str, $strlowercase=true) {}
protected function parse() {}
protected function read_tag() {}
protected function parse_attr($node, $name, $space) {}
protected function link_nodes($node, $is_child) {}
protected function as_text_node($tag) {}
protected function skip($chars) {}
protected function copy_skip($chars) {}
protected function copy_until($chars) {}
protected function copy_until_char($chara) {}
protected function copy_until_char_escape($chara) {}
protected function remove_noise($pattern, $remove_tag=false) {}
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
