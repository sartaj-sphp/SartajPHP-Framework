<?php
namespace Sphp\tools{
/**
 * Description of HTMLElement
 *
 * @author Sartaj
 */
class HTMLElement extends \DOMElement {

    public function outertext(){ 
        $innerHTML = ""; 
            $innerHTML .= $this->ownerDocument->saveXML($this);
        return $innerHTML; 
    } 
    public function getAttributes() {
        $attr = array();
        foreach ($this->attributes as $attrb) { 
            $attr[$attrb->nodeName] = htmlspecialchars_decode($attrb->nodeValue);
        }
        return $attr;
    }

}
}
