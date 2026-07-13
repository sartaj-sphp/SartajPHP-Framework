<?php
namespace Sphp\tools {
/**
* HTMLDOMNode - Represents a single node in the DOM tree
*
* @package HTMLDOM
* @version 4.0
*
* Changes in v4.0
* ───────────────
* • <comment> tag support: nodetype=TYPE_TEXT, INFO_TEXT='', both
*   innertext() and outertext() return '' so the block is invisible in output.
* • TYPE_SILENT constant added for <comment> nodes (nodetype stays TYPE_TEXT
*   so existing code that checks nodetype is unaffected; tag property = 'comment').
* • outertext() / innertext() TEXT-node result cached in INFO_OUTER so
*   repeated calls on the same text node are O(1).
* • All v3 optimisations retained.
*/
class HTMLDOMNode
{
const TYPE_ELEMENT = 1;
const TYPE_COMMENT = 2;
const TYPE_TEXT    = 3;
const TYPE_ROOT    = 5;
const INFO_BEGIN    = 0;
const INFO_END      = 1;
const INFO_TEXT     = 4;
const INFO_INNER    = 5;
const INFO_OUTER    = 6;
const INFO_ENDSPACE = 7;
public $nodetype = self::TYPE_TEXT;
public $tag      = 'text';
public $attr     = [];
public $children = [];
public $nodes    = [];
public $parent   = null;
public $info     = [];
public $line     = 1;
public $charpos  = 0;
public function setInfo($key, $value)
{}
public function appendInfo($key, $value)
{}
public function isSelfClose()
{}
public function innertext()
{}
public function outertext()
{}
public function clear()
{}
public function getAttribute($name) {}
public function setAttribute($name, $value) {}
public function hasAttribute($name) {}
}
}