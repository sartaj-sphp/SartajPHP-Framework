<?php
namespace Sphp\tools{
/**
 * Description of DHTMLElement
 *
 * @author Sartaj
 */
class DHTMLElement extends \DOMElement {
    public $comp = null;
    
    public function appendElement($name) { 
      return $this->appendChild(new HTMLElement($name));
    }
    public function setComponent($component) {
        $this->comp = $component;
    }
    public function getComponent() {
        return $this->comp ;
    }
    public function getInnerHTML(){ 
        $innerHTML = ""; 
        $children  = $this->childNodes;
        foreach ($children as $child) 
        { 
            $innerHTML .= $this->ownerDocument->saveXML($child);
        }

        return $innerHTML; 
    } 
    public function setInnerHTML($content) {
        $children  = $this->childNodes;
        $arr = array();
        foreach ($children as $child){
            $arr[] = $child;
        }
        foreach($arr as $child2){
            $this->removeChild($child2);   
        }
        if($content!=""){
        $DOMInnerHTML = new \DOMDocument();
        $DOMInnerHTML->loadHTML($content);
        $contentNode = $DOMInnerHTML->getElementsByTagName('body')->item(0)->firstChild;
        $this->appendChild($this->ownerDocument->importNode($contentNode, true));
        }
    }
    public function getOuterHTML(){ 
        $innerHTML = ""; 
            $innerHTML .= $this->ownerDocument->saveXML($this);
        return $innerHTML; 
    } 
    public function setOuterHTML($content){  
        if($content!=""){
        $DOMInnerHTML = new \DOMDocument();
        $DOMInnerHTML->loadHTML($content);
        $contentNode = $DOMInnerHTML->getElementsByTagName('body')->item(0)->firstChild;
        $newele = $this->ownerDocument->importNode($contentNode, true);
        $this->parentNode->replaceChild($newele,$this);
        }else{
        $this->parentNode->removeChild($this);            
        }
    }
    public function setPreTag($tagdata) {
        $frontlate = $this->ownerDocument->createDocumentFragment();
        $frontlate->appendXML(html_entity_decode($tagdata,ENT_COMPAT, 'UTF-8'));
        // Insert the new element 
        $this->parentNode->insertBefore($frontlate, $this); 
    }
    public function setInnerPreTag($tagdata) {
        $frontlate = $this->ownerDocument->createDocumentFragment();
        $frontlate->appendXML(html_entity_decode($tagdata,ENT_COMPAT, 'UTF-8'));
        if($this->hasChildNodes()){
            $this->insertBefore($frontlate, $this->firstChild); 
        }else{
            $this->appendChild($frontlate);
        }
    }
    public function setPostTag($tagdata) {
        $frontlate = $this->ownerDocument->createDocumentFragment();
        $frontlate->appendXML(html_entity_decode($tagdata,ENT_COMPAT, 'UTF-8'));
        // Insert the new element 
        $this->parentNode->insertBefore($frontlate, $this->nextSibling); 
    }
    public function setTagName($tagname) { 
        $childnodes = array();
    foreach ($this->childNodes as $child){
        $childnodes[] = $child;
    }
        $newnode = $this->ownerDocument->createElement($tagname);
    foreach ($childnodes as $child){
        $child2 = $this->ownerDocument->importNode($child, true);
        $newnode->appendChild($child2);
    }
    foreach ($this->attributes as $attr) {
        $newnode->setAttribute($attr->nodeName, $attr->nodeValue);
    }
    if($this->comp!=null){
    $newnode->comp = $this->comp;
    $this->comp->element = $newnode;
    }
    $this->parentNode->replaceChild($newnode, $this);
    }
    public function getAttributes() {
        $attr = array();
        foreach ($this->attributes as $attrb) { 
            $attr[$attrb->nodeName] = $attrb->nodeValue;
        }
        return $attr;
    }
    public function appendHTML($html) {
        $tmpDoc = new \DOMDocument();
        $tmpDoc->loadHTML($html);
        foreach ($tmpDoc->getElementsByTagName('body')->item(0)->childNodes as $node) {
        $this->appendChild($this->ownerDocument->importNode($node, true));
        }
    }
    public function wrapTag($tagname) {
        $frontlate = $this->ownerDocument->createElement($tagname);
        $this->parentNode->replaceChild($frontlate, $this);
        $frontlate->appendChild($this);
        return $frontlate;
    }
    public function wrapInnerTags($tagname) {
        $frontlate = $this->ownerDocument->createElement($tagname);
        while ($this->childNodes->length > 0) {
            $child = $this->childNodes->item(0);
            $this->removeChild($child);
            $frontlate->appendChild($child);
        }        
        $this->appendChild($frontlate);
        return $frontlate;
    }

}
}
