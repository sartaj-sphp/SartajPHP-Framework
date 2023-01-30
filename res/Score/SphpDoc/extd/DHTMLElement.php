<?php
namespace Sphp\tools{
/**
* Description of DHTMLElement
*
* @author Sartaj
*/
class DHTMLElement extends \DOMElement {
public $comp = null;
public function appendElement($name) {}
public function setComponent($component) {}
public function getComponent() {}
public function getInnerHTML(){} 
public function setInnerHTML($content) {}
public function getOuterHTML(){} 
public function setOuterHTML($content){}
public function setPreTag($tagdata) {}
public function setInnerPreTag($tagdata) {}
public function setPostTag($tagdata) {}
public function setTagName($tagname) {}
public function getAttributes() {}
public function appendHTML($html) {}
public function wrapTag($tagname) {}
public function wrapInnerTags($tagname) {}
}
}
