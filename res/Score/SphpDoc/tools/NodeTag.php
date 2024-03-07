<?php
namespace Sphp\tools{
/**
* Description of NodeTag
*
* @author Sartaj
*/
class NodeTag {
public $tagName = "";
public $type = "element";
public $attributes = array();
public $_a = array();
public $charpos = 0;
public $dyna_attr_marker = array();
public $children = array();
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
public function replaceChild($newnode,$oldnode) {}
public function createElement($taghtml) {}
public function appendChild($node) {}
public function getChildren() {}
public function hasChildren() {}
public function render(){}
public function hasAttribute($name){}
public function getAttribute($name){}
public function removeAttribute($name){}
public function setAttribute($name,$val){}
public function appendAttribute($name,$val){}
public function hasAttributeValue($name,$val){}
public function setAttributeDyna($name,$runonce=false){}
public function isDynaAttrRun($name){}
public function getAttributes() {}
public function removeChildren() {}
public function setOuterHTML($html){}
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
