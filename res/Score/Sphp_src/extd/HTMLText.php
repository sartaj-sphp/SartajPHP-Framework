<?php
namespace Sphp\tools{
/**
 * Description of HTMLText
 *
 * @author Sartaj
 */
class HTMLText extends \DOMText {
    public $tagName = "";
        
    public function outertext(){ 
        $innerHTML = ""; 
        $innerHTML .= $this->ownerDocument->saveXML($this);
        return $innerHTML;
    } 

}
}
