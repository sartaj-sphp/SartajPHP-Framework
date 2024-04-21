<?php
namespace Sphp\tools{
/**
* Description of NodeTag
*
* @author Sartaj
*/
class NodeTag extends \Sphp\tools\SNode{
public $tagName = "";
public $type = "element";
public $attributes = array();
public $_a = array();
public $charpos = 0;
public $dyna_attr_marker = array();
public $blnselfclose = false;
public $blnclose = false;
public $parentNode = null;
public $comp = null;
public $refcomptag = false;
public $refcomptagelement = null;
public $runat = false;
public $blnrenderTag = true;
public $blnrender = true;
public $pretag = "";
public $posttag = "";
public $innerpretag = "";
public $innerposttag = "";
public $myclass = "Sphp\\tools\\NodeTag";
public function init($strtag){}
public function setRefComp($compobj) {}
public function checkSelfClose(){}
public function isSelfClose(){}
public function setParent($parent){}
public function getParent(){}
public function setLineNo($num){}
public function getLineNo(){}
public function closeTag(){}
public function setComponent($component) {}
public function getComponent() {}
public function fetchAttributes($strdata){}
public function fetchAttributes3($strdata){}
public function fetchAttributes2($strdata){}
public function getAttributesHTML(){}
public function getAttributesCat($prefix){}
public function createElement($taghtml) {}
public function render(){}
public function hasAttribute($name){}
public function setDefaultAttribute($name,$val){}
public function getAttribute($name){}
public function removeAttribute($name){}
public function setAttribute($name,$val){}
public function appendAttribute($name,$val){}
public function hasAttributeValue($name,$val){}
public function setAttributeDyna($name,$runonce=false){}
public function isDynaAttrRun($name){}
public function getAttributes() {}
/** Over write or remove html tag
*  This can also Remove element
* @param type $html
*/
public function setOuterHTML($html){}
/**
* Set Inner HTML as text. It will not parse HTML nodes.
* If you want parse then use parseChildren method.
* Parse children will append nodes and modify original document for further processing.
* @param string $html
*/
public function setInnerHTML($html){}
public function getInnerHTML(){} 
public function getOuterHTML(){}
public function setPreTag($tagdata) {}
public function setPostTag($tagdata) {}
public function setInnerPreTag($tagdata) {}
public function setInnerPostTag($tagdata) {}
public function appendPreTag($tagdata) {}
public function appendPostTag($tagdata) {}
public function appendInnerPreTag($tagdata) {}
public function appendInnerPostTag($tagdata) {}
public function setTagName($tagname) {}
public function wrapTag($taghtml) {}
public function wrapInnerTags($taghtml) {}
public function appendHTML($html){}
}
}
