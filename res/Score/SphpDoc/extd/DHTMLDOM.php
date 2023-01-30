<?php
namespace Sphp\tools{
use Sphp\tools\DHTMLElement;
class DHTMLDOM {
public $callback = null;
public $doc = null;
public $dhtmlparser = null;
public $doctree = array();
public function __construct($dhtmlparser) {}
public function __destruct() {}
public function load($str) {}
public function load_file($filepath) {}
public function load_file_str($filepath) {}
public function set_callback($function_name,$obj) {}
public function setCallback($callbackm) {}
public function getCallback() {}
public function remove_callback() {}
protected function init($str) {} 
public function showDOMNode(\DOMNode $domNode,$sp="  ") {}
public function parseobj() {}
public function renderobj() {}
public function parse() {}
public function save() {}
public function __toString() {}
}
}
