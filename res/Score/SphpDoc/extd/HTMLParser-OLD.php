<?php
namespace Sphp\tools{
/**
* Description of HTMLParser
*
* @author SARTAJ
*/
class HTMLParser2 {
public $parsefirst = 'tagsToObject';
public $parserender = 'convert_tags';
public $curelement = null;
public $curlineno = 0;
public $codebehind = array();
public $blncodebehind = false;
public $tempobj;
public function __construct() {}
public function getTempobj() {}
public function setTempobj($tempobj) {}
public function init() {}
public function setCodebehind($codebehind) {}
public function file_get_html($filepath) {}
public function str_get_html($str, $lowercase = true) {}
public function dump_html_tree($node, $show_attr = true, $deep = 0) {}
public function file_get_dom($filepath) {}
public function str_get_dom($str, $lowercase = true) {}
public function parseHTMLFile($url) {}
public function getHTMLFile($url) {}
public function parseHTML($strData) {}
public function parsefeed($element) {}
public function parseHTMLTagFun($strData, $callbackfun) {}
public function parseHTMLTag($strData, $callbackfun, $obj) {}
public function parseHTMLObj($strData, $obj) {}
public function tagsToObject($element) {}
public function convert_tags($element) {}
public function executeFun($comp, $key, $val) {}
public function executePHPCode($strPHPCode) {}
}
}
